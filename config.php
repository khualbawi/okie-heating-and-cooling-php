<?php
/**
 * Okie Heating & Cooling — site configuration.
 *
 * Secrets live in a `.env` file next to this file (never commit it).
 * See `.env.example` for all supported keys.
 */

declare(strict_types=1);

define('SITE_ROOT', __DIR__);

// ---------------------------------------------------------------------------
// .env loader (tiny, dependency-free)
// ---------------------------------------------------------------------------
(function (): void {
    $envFile = SITE_ROOT . '/.env';
    if (!is_readable($envFile)) {
        return;
    }
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#' || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = explode('=', $line, 2);
        $key   = trim($key);
        $value = trim($value);
        if (strlen($value) >= 2 && ($value[0] === '"' || $value[0] === "'") && $value[0] === substr($value, -1)) {
            $value = substr($value, 1, -1);
        }
        if (getenv($key) === false) {
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
})();

function env(string $key, ?string $default = null): ?string
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        return $default;
    }
    return $value;
}

// ---------------------------------------------------------------------------
// Site constants
// ---------------------------------------------------------------------------
define('SITE_URL', rtrim(env('SITE_URL', 'https://okieheatingandcooling.com'), '/'));
define('BRAND_NAME', 'Okie Heating & Cooling');
define('BRAND_LEGAL', 'Okie Heating and Cooling');

define('PHONE_NUMBER', '(918) 896-1978');
define('PHONE_HREF', 'tel:+19188961978');
define('OFFICE_PHONE_NUMBER', PHONE_NUMBER);
define('OFFICE_PHONE_HREF', PHONE_HREF);
define('EMERGENCY_PHONE_NUMBER', PHONE_NUMBER);
define('EMERGENCY_PHONE_HREF', PHONE_HREF);
define('EMAIL', 'info@okieheatingandcooling.com');
define('ADDRESS', 'Serving Tulsa, OK & surrounding areas');
define('LICENSE_NUMBER', 'OK LIC 00195102');

const HOURS = [
    'weekday'   => '9:00 AM – 8:00 PM',
    'saturday'  => 'Emergency Only',
    'sunday'    => 'Emergency Only',
    'emergency' => '24/7 Emergency Service',
];

// Email / notifications
define('ADMIN_EMAIL', env('ADMIN_EMAIL', 'info@okieheatingandcooling.com'));
define('SENDER_EMAIL', env('SENDER_EMAIL', 'email@okieheatingandcooling.com'));
define('BCC_EMAIL', env('BCC_EMAIL', ''));          // optional copy address
define('BREVO_API_KEY', env('BREVO_API_KEY', ''));  // if empty -> falls back to PHP mail()

// Database (optional). If DB_HOST is empty, requests are appended to storage/requests.jsonl
define('DB_HOST', env('DB_HOST', ''));
define('DB_NAME', env('DB_NAME', ''));
define('DB_USER', env('DB_USER', ''));
define('DB_PASS', env('DB_PASS', ''));

// Token for the read-only /api/requests JSON feed (external portals). Empty = endpoint disabled.
define('PORTAL_API_TOKEN', env('PORTAL_API_TOKEN', ''));

// Simple admin page protection (admin/requests.php). Leave empty to disable the page.
define('ADMIN_PASSWORD', env('ADMIN_PASSWORD', ''));

// Google Analytics 4 measurement ID (empty = tag not rendered)
define('GA_MEASUREMENT_ID', env('GA_MEASUREMENT_ID', 'G-JJHZYP8C4G'));

define('APP_ENV', env('APP_ENV', 'production'));
define('IS_LOCAL_ENV', APP_ENV === 'local'
    || in_array(explode(':', $_SERVER['HTTP_HOST'] ?? '')[0], ['localhost', '127.0.0.1'], true));

// Cloudflare Turnstile. Missing keys fall back to Cloudflare's always-pass test keys
// ONLY in a local env — anywhere else, forms fail closed (see TURNSTILE_CONFIGURED).
$turnstileSiteKey = env('TURNSTILE_SITE_KEY', '');
$turnstileSecretKey = env('TURNSTILE_SECRET_KEY', '');
if ($turnstileSiteKey === '' || $turnstileSecretKey === '') {
    if (IS_LOCAL_ENV) {
        error_log('Turnstile: TURNSTILE_SITE_KEY/TURNSTILE_SECRET_KEY not set — using Cloudflare test keys (always pass). Set real keys before production.');
        $turnstileSiteKey = '1x00000000000000000000AA';
        $turnstileSecretKey = '1x0000000000000000000000000000000AA';
    } else {
        error_log('TURNSTILE KEYS MISSING — forms disabled');
    }
}
define('TURNSTILE_SITE_KEY', $turnstileSiteKey);
define('TURNSTILE_SECRET_KEY', $turnstileSecretKey);
define('TURNSTILE_CONFIGURED', $turnstileSiteKey !== '' && $turnstileSecretKey !== '');

// Telemetry (page views) — only stored when a database is configured.
define('TRACK_PAGE_VIEWS', env('TRACK_PAGE_VIEWS', '1') === '1');

// Display errors only when APP_DEBUG=1
if (env('APP_DEBUG', '0') === '1') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
}

date_default_timezone_set('America/Chicago');

// ---------------------------------------------------------------------------
// Deploy guardrail: catches config drift (a stray duplicate config file, or a
// deploy that landed without a .env) before it causes a silent split-brain
// config. error_log only — never shown to visitors, safe in production.
// ---------------------------------------------------------------------------
(function (): void {
    $configFiles = glob(SITE_ROOT . '/config*.php') ?: [];
    if (count($configFiles) > 1) {
        error_log('DEPLOY GUARDRAIL: multiple config files found on disk (' . implode(', ', array_map('basename', $configFiles)) . ') — only config.php should exist. A stray duplicate can silently diverge from the real one; delete it.');
    }
    if (!is_readable(SITE_ROOT . '/.env')) {
        error_log('DEPLOY GUARDRAIL: .env is missing — every setting is running on its code default (see the separate Turnstile log line above for that specific gap).');
    }
})();
