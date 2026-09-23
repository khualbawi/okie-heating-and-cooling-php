<?php
/**
 * Minimal lead inbox: /admin/requests.php
 * Protected with HTTP Basic auth (user: admin, password: ADMIN_PASSWORD from .env).
 * Reads from MySQL if configured, else storage/requests.jsonl. Also offers CSV export (?csv=1).
 */
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';
require SITE_ROOT . '/includes/helpers.php';
require SITE_ROOT . '/includes/data.php';

if (ADMIN_PASSWORD === '') {
    http_response_code(404);
    exit('Not found');
}

// --- Failed-auth throttle: max 5 bad attempts per IP per 15 minutes ----------
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$throttleFile = SITE_ROOT . '/storage/admin-auth-fails.json';
$fails = is_readable($throttleFile) ? (json_decode((string) file_get_contents($throttleFile), true) ?: []) : [];
$now = time();
$fails = array_values(array_filter($fails, fn($t) => is_array($t) && ($t['ts'] ?? 0) > $now - 900));
if (count(array_filter($fails, fn($t) => ($t['ip'] ?? '') === $ip)) >= 5) {
    http_response_code(429);
    header('Retry-After: 900');
    exit('Too many attempts. Try again later.');
}

$user = $_SERVER['PHP_AUTH_USER'] ?? '';
$pass = $_SERVER['PHP_AUTH_PW'] ?? '';
if ($user !== 'admin' || !hash_equals(ADMIN_PASSWORD, $pass)) {
    $fails[] = ['ip' => $ip, 'ts' => $now];
    @file_put_contents($throttleFile, json_encode($fails), LOCK_EX);
    header('WWW-Authenticate: Basic realm="Okie Admin"');
    http_response_code(401);
    exit('Authentication required');
}
header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');

// --- Load rows ---------------------------------------------------------------
$rows = [];
$source = 'jsonl';
if ($pdo = db()) {
    $source = 'mysql';
    if (isset($_POST['id'], $_POST['status']) && in_array($_POST['status'], ['new','contacted','scheduled','completed','cancelled'], true)) {
        $pdo->prepare('UPDATE service_requests SET status = ? WHERE id = ?')->execute([$_POST['status'], (int) $_POST['id']]);
        header('Location: /admin/requests.php', true, 303);
        exit;
    }
    $rows = $pdo->query('SELECT * FROM service_requests ORDER BY created_at DESC LIMIT 500')->fetchAll();
} else {
    $file = SITE_ROOT . '/storage/requests.jsonl';
    if (is_readable($file)) {
        foreach (array_reverse(file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)) as $line) {
            $r = json_decode($line, true);
            if (is_array($r)) $rows[] = $r;
        }
    }
}

// --- CSV export --------------------------------------------------------------
if (isset($_GET['csv'])) {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="service-requests-' . date('Y-m-d') . '.csv"');
    $out = fopen('php://output', 'w');
    $cols = ['id','created_at','status','name','phone','email','service_type','urgency','address','city','preferred_date','preferred_time','customer_type','form_source','utm_source','utm_medium','utm_campaign','consent','issue_description'];
    fputcsv($out, $cols);
    foreach ($rows as $r) fputcsv($out, array_map(fn($c) => $r[$c] ?? '', $cols));
    fclose($out);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Service Requests — Okie Admin</title>
<style>
body{font-family:system-ui,sans-serif;background:#f5f7f9;color:#0c1a31;margin:0;padding:1.5rem}
h1{font-size:1.25rem;margin:0 0 1rem}
.bar{display:flex;gap:1rem;align-items:center;margin-bottom:1rem;flex-wrap:wrap}
.bar a{color:#0f2b5c;font-weight:600}
table{width:100%;border-collapse:collapse;background:#fff;border:1px solid #dbdfe6;border-radius:.5rem;overflow:hidden;font-size:.8125rem}
th,td{padding:.5rem .625rem;border-bottom:1px solid #eaedf1;text-align:left;vertical-align:top}
th{background:#0f2b5c;color:#fff;font-weight:600;white-space:nowrap}
tr:hover td{background:#f8fafc}
.tag{display:inline-block;padding:.125rem .5rem;border-radius:9999px;font-size:.6875rem;font-weight:600;background:#eaedf1}
.tag.emergency{background:#fee2e2;color:#991b1b}.tag.urgent{background:#ffedd5;color:#9a3412}
.tag.new{background:#dbeafe;color:#1e40af}.tag.completed{background:#dcfce7;color:#166534}
.desc{max-width:24rem;white-space:pre-wrap}
select{font:inherit;padding:.125rem}
.wrap{overflow-x:auto}
.muted{color:#5b677b}
</style></head><body>
<h1>Service Requests <span class="muted">(<?= count($rows) ?>, source: <?= $source ?>)</span></h1>
<div class="bar">
  <a href="?csv=1">⬇ Export CSV</a>
  <a href="/">← Back to site</a>
</div>
<div class="wrap">
<table>
<thead><tr><th>Date</th><th>Status</th><th>Name</th><th>Phone</th><th>Email</th><th>Service</th><th>Urgency</th><th>Address</th><th>Preferred</th><th>Source</th><th>Description</th></tr></thead>
<tbody>
<?php if (!$rows): ?><tr><td colspan="11" class="muted">No requests yet.</td></tr><?php endif; ?>
<?php foreach ($rows as $r): ?>
<tr>
  <td><?= e($r['created_at'] ?? '') ?></td>
  <td>
    <?php if ($source === 'mysql'): ?>
      <form method="post"><input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
        <select name="status" onchange="this.form.submit()">
          <?php foreach (['new','contacted','scheduled','completed','cancelled'] as $s): ?>
            <option value="<?= $s ?>"<?= ($r['status'] ?? 'new') === $s ? ' selected' : '' ?>><?= $s ?></option>
          <?php endforeach; ?>
        </select></form>
    <?php else: ?><span class="tag <?= e($r['status'] ?? 'new') ?>"><?= e($r['status'] ?? 'new') ?></span><?php endif; ?>
  </td>
  <td><?= e($r['name'] ?? '') ?><?= !empty($r['customer_type']) && $r['customer_type'] === 'existing' ? ' <span class="tag">existing</span>' : '' ?></td>
  <td><a href="tel:<?= e(preg_replace('/\D/', '', $r['phone'] ?? '')) ?>"><?= e($r['phone'] ?? '') ?></a></td>
  <td><?= !empty($r['email']) ? '<a href="mailto:' . e($r['email']) . '">' . e($r['email']) . '</a>' : '<span class="muted">—</span>' ?></td>
  <td><?= e(service_type_label($r['service_type'] ?? '')) ?></td>
  <td><span class="tag <?= e($r['urgency'] ?? '') ?>"><?= e($r['urgency'] ?? 'routine') ?></span></td>
  <td><?= e(trim(($r['address'] ?? '') . ' ' . ($r['city'] ?? ''))) ?: '<span class="muted">—</span>' ?></td>
  <td><?= e(trim(($r['preferred_date'] ?? '') . ' ' . ($r['preferred_time'] ?? ''))) ?: '<span class="muted">—</span>' ?></td>
  <td><?= e($r['form_source'] ?? '') ?><?= !empty($r['utm_source']) ? '<br><span class="muted">' . e($r['utm_source']) . '</span>' : '' ?></td>
  <td class="desc"><?= e($r['issue_description'] ?? '') ?></td>
</tr>
<?php endforeach; ?>
</tbody></table></div>
</body></html>
