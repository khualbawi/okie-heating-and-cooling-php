<?php
/**
 * POST /api/track  — lightweight page-view / event logger (replaces base44 SiteEvent).
 * No-op unless a database is configured. Never blocks UX; always returns 204.
 */
declare(strict_types=1);

if (!defined('SITE_ROOT')) {
    require dirname(__DIR__) . '/config.php';
    require SITE_ROOT . '/includes/helpers.php';
    require SITE_ROOT . '/includes/data.php';
}

http_response_code(204);
header('Cache-Control: no-store');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST' || !TRACK_PAGE_VIEWS) exit;
$pdo = db();
if (!$pdo) exit;

$raw = file_get_contents('php://input') ?: '';
$d = json_decode($raw, true);
if (!is_array($d)) $d = $_POST;

$s = fn(string $k, int $max = 200) => mb_substr(trim((string) ($d[$k] ?? '')), 0, $max);
$event = $s('event_name', 60);
if ($event === '' || !preg_match('/^[a-z0-9_]+$/', $event)) exit;

try {
    $pdo->prepare('INSERT INTO site_events (event_name, path, referrer, visitor_id, session_id, form_source, service_type, utm_source, utm_medium, utm_campaign, properties, ip, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())')
        ->execute([
            $event, $s('path', 255), $s('referrer', 500), $s('visitor_id', 64), $s('session_id', 64),
            $s('form_source', 60), $s('service_type', 50), $s('utm_source', 100), $s('utm_medium', 100), $s('utm_campaign', 100),
            json_encode($d['properties'] ?? new stdClass(), JSON_UNESCAPED_UNICODE), $_SERVER['REMOTE_ADDR'] ?? '',
        ]);
} catch (Throwable $e) {
    error_log('track insert failed: ' . $e->getMessage());
}
