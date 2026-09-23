<?php
/**
 * Daily retention job (run from a Hostinger cron — see README "Retention cron").
 * Deletes service_requests older than RETENTION_YEARS (config.php, default 3)
 * and site_events older than 14 months. No-op if no database is configured.
 * Logs row counts only — never which rows.
 *
 * Usage: php scripts/retention.php [--dry-run]
 */
declare(strict_types=1);

require dirname(__DIR__) . '/config.php';
require SITE_ROOT . '/includes/helpers.php';

$dryRun = in_array('--dry-run', $argv ?? [], true);

$pdo = db();
if (!$pdo) {
    fwrite(STDOUT, "retention: no database configured, nothing to do\n");
    exit(0);
}

$requestsCutoff = date('Y-m-d H:i:s', strtotime('-' . RETENTION_YEARS . ' years'));
$eventsCutoff = date('Y-m-d H:i:s', strtotime('-14 months'));

$countRequests = $pdo->prepare('SELECT COUNT(*) FROM service_requests WHERE created_at < ?');
$countRequests->execute([$requestsCutoff]);
$requestsDue = (int) $countRequests->fetchColumn();

$countEvents = $pdo->prepare('SELECT COUNT(*) FROM site_events WHERE created_at < ?');
$countEvents->execute([$eventsCutoff]);
$eventsDue = (int) $countEvents->fetchColumn();

if ($dryRun) {
    fwrite(STDOUT, "retention (dry-run): would delete $requestsDue service_requests older than $requestsCutoff, $eventsDue site_events older than $eventsCutoff\n");
    exit(0);
}

$deletedRequests = 0;
$deletedEvents = 0;
try {
    $stmt = $pdo->prepare('DELETE FROM service_requests WHERE created_at < ?');
    $stmt->execute([$requestsCutoff]);
    $deletedRequests = $stmt->rowCount();
} catch (Throwable $e) {
    error_log('retention: service_requests delete failed: ' . $e->getMessage());
}
try {
    $stmt = $pdo->prepare('DELETE FROM site_events WHERE created_at < ?');
    $stmt->execute([$eventsCutoff]);
    $deletedEvents = $stmt->rowCount();
} catch (Throwable $e) {
    error_log('retention: site_events delete failed: ' . $e->getMessage());
}

$msg = "retention: deleted $deletedRequests service_requests older than $requestsCutoff, $deletedEvents site_events older than $eventsCutoff";
fwrite(STDOUT, $msg . "\n");
error_log($msg);
