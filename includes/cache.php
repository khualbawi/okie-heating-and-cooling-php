<?php
/**
 * Full-page cache (works with or without LiteSpeed).
 *
 * LiteSpeed on Hostinger caches the HTML in front of PHP when the
 * `X-LiteSpeed-Cache-Control` header is present (see .htaccess). This file is the
 * second line of defence: a plain file cache so even a LiteSpeed MISS costs one
 * readfile() instead of a full render.
 *
 * Cache key = request path + build id (mtimes of the files that shape output), so a
 * deploy invalidates everything automatically — no manual purge needed.
 */
declare(strict_types=1);

const PAGE_CACHE_TTL = 86400;   // 1 day; build id busts it earlier on deploy
const PAGE_CACHE_DIR = SITE_ROOT . '/storage/cache';

/**
 * Paths that must always hit PHP — never the local cache, never the Cloudflare edge.
 * `/book` is here because it carries live booking data.
 */
const CACHE_BYPASS_PREFIXES = ['/admin', '/api', '/book'];

/** Is this request cacheable at all? */
function page_cache_enabled(): bool
{
    if (env('PAGE_CACHE', '1') !== '1') return false;
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') return false;
    if (!empty($_SERVER['PHP_AUTH_USER'])) return false;          // admin
    $path = current_path();
    foreach (CACHE_BYPASS_PREFIXES as $prefix) {
        if ($path === $prefix || str_starts_with($path, $prefix . '/')) return false;
    }
    // Cached responses are replayed as text/html, so only cache HTML pages.
    return $path !== '/sitemap.xml';
}

/** Build id: changes whenever content or templates change. */
function page_cache_build_id(): string
{
    static $id = null;
    if ($id !== null) return $id;
    $stamp = 0;
    foreach ([
        '/includes/data.php', '/includes/helpers.php', '/includes/icons.php',
        '/includes/layout/header.php', '/includes/layout/footer.php',
        '/assets/css/styles.css', '/assets/js/main.js', '/config.php',
    ] as $f) {
        $stamp = max($stamp, (int) @filemtime(SITE_ROOT . $f));
    }
    // Page templates and components shape output too — a page-only edit must bust the
    // cache just like a shared-include edit does.
    foreach ([...glob(SITE_ROOT . '/pages/*.php') ?: [], ...glob(SITE_ROOT . '/includes/components/*.php') ?: []] as $f) {
        $stamp = max($stamp, (int) @filemtime($f));
    }
    return $id = substr(sha1((string) $stamp . '|' . SITE_URL), 0, 12);
}

function page_cache_file(): string
{
    $key = sha1(page_cache_build_id() . '|' . current_path());
    return PAGE_CACHE_DIR . '/' . substr($key, 0, 2) . '/' . $key . '.html';
}

/**
 * Serve a cached copy if one is fresh, otherwise start buffering so the rendered
 * page gets stored on shutdown. Call once, early, from the front controller.
 */
function page_cache_start(): void
{
    if (!page_cache_enabled()) {
        page_cache_no_store();
        return;
    }

    $file = page_cache_file();
    $mtime = @filemtime($file);

    if ($mtime !== false && (time() - $mtime) < PAGE_CACHE_TTL) {
        page_cache_send_headers($mtime);
        header('X-Page-Cache: HIT');
        if (page_cache_not_modified($mtime)) {
            http_response_code(304);
            exit;
        }
        readfile($file);
        exit;
    }

    ob_start(function (string $html): string {
        if ($html === '' || http_response_code() !== 200) {
            // 404s and errors must not be cached anywhere.
            page_cache_no_store();
            return $html;
        }
        page_cache_write($html);
        return $html;
    });
    page_cache_send_headers(time());
    header('X-Page-Cache: MISS');
}

function page_cache_write(string $html): void
{
    $file = $with = page_cache_file();
    $dir  = dirname($file);
    if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) return;
    $tmp = $file . '.' . getmypid() . '.tmp';
    if (@file_put_contents($tmp, $html, LOCK_EX) !== false) {
        @rename($tmp, $with);   // atomic: readers never see a half-written page
    }
    page_cache_gc();
}

/** Occasionally drop stale files (old build ids leave orphans behind). */
function page_cache_gc(): void
{
    if (random_int(1, 50) !== 1) return;
    $cutoff = time() - (PAGE_CACHE_TTL * 2);
    foreach (glob(PAGE_CACHE_DIR . '/*/*.html') ?: [] as $f) {
        if ((int) @filemtime($f) < $cutoff) @unlink($f);
    }
}

/** Cache headers for browsers, CDNs and LiteSpeed. */
function page_cache_send_headers(int $mtime): void
{
    if (headers_sent()) return;
    $maxAge = 600;              // browser: 10 min
    $shared = PAGE_CACHE_TTL;   // LiteSpeed / Cloudflare: 1 day

    // Browsers get the short TTL; Cloudflare reads CDN-Cache-Control first and
    // holds the page for a day, serving stale while it revalidates in background.
    header("Cache-Control: public, max-age=$maxAge, stale-while-revalidate=86400");
    header("CDN-Cache-Control: public, max-age=$shared, stale-while-revalidate=86400, stale-if-error=604800");
    header('X-LiteSpeed-Cache-Control: public,max-age=' . $shared);

    $tag = page_cache_tag();
    header('X-LiteSpeed-Tag: page,' . $tag);
    header('Cache-Tag: page,' . $tag . ',build-' . page_cache_build_id());  // Cloudflare purge-by-tag
    header('Vary: Accept-Encoding');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $mtime) . ' GMT');
    header('ETag: "' . page_cache_build_id() . '-' . $mtime . '"');
}

function page_cache_not_modified(int $mtime): bool
{
    $etag = '"' . page_cache_build_id() . '-' . $mtime . '"';
    if (trim($_SERVER['HTTP_IF_NONE_MATCH'] ?? '') === $etag) return true;
    $since = $_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '';
    return $since !== '' && strtotime($since) >= $mtime;
}

/** Purge tag for the current page ("home", "services_ac-repair", ...). */
function page_cache_tag(): string
{
    $tag = trim(str_replace('/', '_', current_path()), '_');
    return $tag === '' ? 'home' : $tag;
}

/** Mark the current response uncacheable (404s, errors, live pages). */
function page_cache_no_store(): void
{
    if (headers_sent()) return;
    header('Cache-Control: private, no-cache, no-store, must-revalidate');
    // Cloudflare reads this ahead of Cache-Control; no-store forces a full BYPASS.
    header('CDN-Cache-Control: no-store');
    header('X-LiteSpeed-Cache-Control: no-cache');
    header_remove('Cache-Tag');
    header_remove('X-LiteSpeed-Tag');
    header_remove('ETag');
    header_remove('Last-Modified');
}

/** Delete every cached page (used by admin purge). */
function page_cache_purge(): int
{
    $n = 0;
    foreach (glob(PAGE_CACHE_DIR . '/*/*.html') ?: [] as $f) {
        if (@unlink($f)) $n++;
    }
    return $n;
}
