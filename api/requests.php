<?php
/**
 * GET /api/requests — read-only JSON feed of service requests, for external
 * portals (e.g. KWS portal). Auth: Bearer token or ?token= matching
 * PORTAL_API_TOKEN in .env. Disabled when the token is not configured.
 *
 * Query params:
 *   since=YYYY-MM-DD (or full datetime)  — only requests created after this
 *   limit=1..500 (default 100)
 *   status=new|contacted|scheduled|completed|cancelled (DB mode only)
 */
declare(strict_types=1);

if (!defined('SITE_ROOT')) {
    require dirname(__DIR__) . '/config.php';
    require SITE_ROOT . '/includes/helpers.php';
    require SITE_ROOT . '/includes/data.php';
}

header('Content-Type: application/json');
header('Cache-Control: no-store');
header('X-Robots-Tag: noindex');

if (PORTAL_API_TOKEN === '') {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
    exit;
}
$auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
$given = str_starts_with($auth, 'Bearer ') ? substr($auth, 7) : (string) ($_GET['token'] ?? '');
if ($given === '' || !hash_equals(PORTAL_API_TOKEN, $given)) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$limit = min(500, max(1, (int) ($_GET['limit'] ?? 100)));
$since = trim((string) ($_GET['since'] ?? ''));
if ($since !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}( \d{2}:\d{2}(:\d{2})?)?$/', $since)) $since = '';
$status = (string) ($_GET['status'] ?? '');
if (!in_array($status, ['', 'new', 'contacted', 'scheduled', 'completed', 'cancelled'], true)) $status = '';

$rows = [];
$sourceMode = 'jsonl';
if ($pdo = db()) {
    $sourceMode = 'mysql';
    $sql = 'SELECT id, created_at, status, name, phone, email, address, city, service_type, issue_description,
                   preferred_date, preferred_time, urgency, customer_type, form_source,
                   utm_source, utm_medium, utm_campaign, consent
            FROM service_requests WHERE 1=1';
    $args = [];
    if ($since !== '') { $sql .= ' AND created_at >= ?'; $args[] = $since; }
    if ($status !== '') { $sql .= ' AND status = ?'; $args[] = $status; }
    $sql .= ' ORDER BY created_at DESC LIMIT ' . $limit;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($args);
    $rows = $stmt->fetchAll();
} else {
    $file = SITE_ROOT . '/storage/requests.jsonl';
    if (is_readable($file)) {
        foreach (array_reverse(file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)) as $line) {
            $r = json_decode($line, true);
            if (!is_array($r)) continue;
            if ($since !== '' && ($r['created_at'] ?? '') < $since) continue;
            unset($r['ip'], $r['user_agent']);
            $rows[] = $r;
            if (count($rows) >= $limit) break;
        }
    }
}

foreach ($rows as &$r) {
    $r['service_label'] = service_type_label((string) ($r['service_type'] ?? ''));
}
unset($r);

echo json_encode(['source' => $sourceMode, 'count' => count($rows), 'requests' => $rows], JSON_UNESCAPED_UNICODE);
