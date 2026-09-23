<?php
/**
 * Full-page cache (works with or without LiteSpeed).
 *
 * LiteSpeed on Hostinger caches the HTML in front of PHP when the
 * `X-LiteSpeed-Cache-Control` header is present (see .htaccess). This file is the
 * second line of defence: a plain file cache so even a LiteSpeed MISS costs one
 * readfile() instead of a full render.
 *
 * Cache key = request path + deploy version (short git commit hash), so a deploy
 * invalidates everything automatically — no manual purge needed. The first request
 * to see a new version also fires an LiteSpeed edge purge, once.
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

/**
 * Deploy version: the short hash of the currently checked-out git commit. Read
 * straight from the .git plumbing (no `exec()` / process spawn per request).
 * Falls back to a VERSION file (for non-git deploys), then 'dev'.
 */
function deploy_version(): string
{
    static $v = null;
    if ($v !== null) return $v;

    $gitDir = SITE_ROOT . '/.git';
    if (is_file($gitDir)) {
        // Worktree checkout: .git is a pointer file, not a directory.
        $ptr = trim((string) @file_get_contents($gitDir));
        $gitDir = str_starts_with($ptr, 'gitdir: ') ? trim(substr($ptr, 8)) : false;
    }
    if ($gitDir && is_dir($gitDir)) {
        $commonDir = $gitDir;
        if (is_file($gitDir . '/commondir')) {
            $real = @realpath($gitDir . '/' . trim((string) @file_get_contents($gitDir . '/commondir')));
            if ($real) $commonDir = $real;
        }
        $head = trim((string) @file_get_contents($gitDir . '/HEAD'));
        $hash = '';
        if (str_starts_with($head, 'ref: ')) {
            $ref = trim(substr($head, 5));
            $hash = trim((string) @file_get_contents($commonDir . '/' . $ref));
            if ($hash === '') {
                $packed = (string) @file_get_contents($commonDir . '/packed-refs');
                if (preg_match('/^([0-9a-f]{40})\s+' . preg_quote($ref, '/') . '$/m', $packed, $m)) {
                    $hash = $m[1];
                }
            }
        } else {
            $hash = $head; // detached HEAD: HEAD itself holds the hash
        }
        if (preg_match('/^[0-9a-f]{7,40}$/', $hash)) {
            return $v = substr($hash, 0, 12);
        }
    }

    $versionFile = SITE_ROOT . '/VERSION';
    $ver = is_readable($versionFile) ? trim((string) @file_get_contents($versionFile)) : '';
    return $v = $ver !== '' ? $ver : 'dev';
}

/** Cache "build id": the deploy version. Kept as its own name since it's what the
 *  cache key, ETag and Cache-Tag headers actually consume. */
function page_cache_build_id(): string
{
    return deploy_version();
}

function page_cache_file(): string
{
    $hash = sha1(current_path());
    return PAGE_CACHE_DIR . '/' . page_cache_build_id() . '/' . substr($hash, 0, 2) . '/' . $hash . '.html';
}

/**
 * Detect a new deploy (git HEAD moved since the last request) and, exactly once,
 * clear other-version cache files and tell LiteSpeed to drop its edge cache.
 * File-locked so only the first concurrent request after a deploy does the work.
 */
function page_cache_bump_version_if_needed(): void
{
    $version = page_cache_build_id();
    $file = SITE_ROOT . '/storage/deploy-version.txt';
    $fp = @fopen($file, 'c+');
    if ($fp === false) return;   // best-effort; a missed purge just means one stale LiteSpeed edge hit

    flock($fp, LOCK_EX);
    $stored = trim((string) fread($fp, 64));
    if ($stored !== $version) {
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, $version);
        fflush($fp);
        page_cache_purge_other_versions();
        if (!headers_sent()) header('X-LiteSpeed-Purge: *');
    } elseif (random_int(1, 100) === 1) {
        page_cache_purge_other_versions();   // self-heal sweep, same version
    }
    flock($fp, LOCK_UN);
    fclose($fp);
}

/** Delete cache files left behind by every version except the current one. */
function page_cache_purge_other_versions(): int
{
    $n = 0;
    $current = page_cache_build_id();
    foreach (glob(PAGE_CACHE_DIR . '/*', GLOB_ONLYDIR) ?: [] as $dir) {
        if (basename($dir) === $current) continue;
        foreach (glob($dir . '/*/*.html') ?: [] as $f) {
            if (@unlink($f)) $n++;
        }
        foreach (glob($dir . '/*', GLOB_ONLYDIR) ?: [] as $sub) @rmdir($sub);
        @rmdir($dir);
    }
    return $n;
}

/**
 * Serve a cached copy if one is fresh, otherwise start buffering so the rendered
 * page gets stored on shutdown. Call once, early, from the front controller.
 */
function page_cache_start(): void
{
    page_cache_bump_version_if_needed();

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
        if ($html === '' || http_response_code() !== 200 || page_cache_is_dynamic()) {
            // 404s, errors, and pages that turned out to carry a live form must not
            // be cached anywhere.
            page_cache_no_store();
            return $html;
        }
        page_cache_write($html);
        return $html;
    });
    page_cache_send_headers(time());
    header('X-Page-Cache: MISS');
}

/**
 * Mark the current response uncacheable after headers were already sent as
 * cacheable. Call this from anywhere a live form renders (e.g. `component()`
 * for 'service-request-form'). Safe to call more than once; output is still
 * buffered at this point, so re-sending headers still wins.
 */
function page_cache_mark_dynamic(): void
{
    $GLOBALS['__page_cache_dynamic'] = true;
    page_cache_no_store();
}

function page_cache_is_dynamic(): bool
{
    return $GLOBALS['__page_cache_dynamic'] ?? false;
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
