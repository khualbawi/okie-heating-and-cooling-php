<?php
/**
 * POST /api/submit-request
 * Accepts form-encoded or JSON. Stores request (MySQL or JSONL), sends emails.
 * Returns JSON for XHR/fetch, redirects for plain form posts.
 */
declare(strict_types=1);

if (!defined('SITE_ROOT')) {
    require dirname(__DIR__) . '/config.php';
    require SITE_ROOT . '/includes/helpers.php';
    require SITE_ROOT . '/includes/data.php';
}
require SITE_ROOT . '/includes/mailer.php';
require SITE_ROOT . '/includes/turnstile.php';

$isJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json')
    || ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch'
    || str_contains($_SERVER['CONTENT_TYPE'] ?? '', 'application/json');

$respond = function (bool $ok, string $message, array $extra = [], int $status = 200) use ($isJson): never {
    if ($isJson) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode(['success' => $ok, 'message' => $message] + $extra);
        exit;
    }
    $redirect = $_POST['redirect'] ?? '/book';
    if (!str_starts_with($redirect, '/') || str_starts_with($redirect, '//')) $redirect = '/book';
    $q = $ok ? ['submitted' => '1'] : ['error' => $message];
    if ($ok && !empty($extra['name'])) $q['name'] = $extra['name'];
    header('Location: ' . $redirect . '?' . http_build_query($q) . ($ok ? '#main-content' : ''), true, 303);
    exit;
};

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    $respond(false, 'Method not allowed', [], 405);
}

// --- CSRF: reject cross-origin posts (stateless, cache-safe — no session needed) ---
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$sourceHost = parse_url($origin !== '' ? $origin : $referer, PHP_URL_HOST);
if ($sourceHost !== null && $sourceHost !== parse_url(SITE_URL, PHP_URL_HOST)) {
    $respond(false, 'Request rejected.', [], 403);
}

// Accept JSON bodies too
if (str_contains($_SERVER['CONTENT_TYPE'] ?? '', 'application/json')) {
    $json = json_decode(file_get_contents('php://input') ?: '', true);
    if (is_array($json)) $_POST = $json + $_POST;
}

$in = fn(string $k, int $max = 500) => mb_substr(trim((string) ($_POST[$k] ?? '')), 0, $max);

// --- Spam checks ------------------------------------------------------------
if ($in('website') !== '') {                       // honeypot filled -> pretend success
    $respond(true, 'Request submitted', ['name' => $in('name', 80)]);
}
$ts = (int) ($_POST['_ts'] ?? 0);
if ($ts > 0 && (time() - $ts) < 3) {               // submitted in < 3s
    $respond(false, 'Please take a moment and try again.', [], 422);
}
if (!verify_turnstile($in('cf-turnstile-response', 2000), $_SERVER['REMOTE_ADDR'] ?? '')) {
    $respond(false, 'Please complete the verification and try again.', [], 422);
}

// --- Validate ----------------------------------------------------------------
$validServices = array_merge(array_column(SERVICES, 'formValue'), ['maintenance_plan', 'other']);
$sr = [
    'name' => $in('name', 120),
    'phone' => $in('phone', 40),
    'email' => mb_strtolower($in('email', 160)),
    'address' => $in('address', 200),
    'city' => $in('city', 100),
    'service_type' => $in('service_type', 50),
    'issue_description' => $in('issue_description', 4000),
    'preferred_date' => $in('preferred_date', 20),
    'preferred_time' => $in('preferred_time', 20),
    'urgency' => $in('urgency', 20) ?: 'routine',
    'customer_type' => $in('customer_type', 20) ?: 'new',
    'form_source' => $in('form_source', 60) ?: 'website',
    'utm_source' => $in('utm_source', 100),
    'utm_medium' => $in('utm_medium', 100),
    'utm_campaign' => $in('utm_campaign', 100),
    'consent' => !empty($_POST['consent']) ? 1 : 0,
    'status' => 'new',
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
    'user_agent' => mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
    'created_at' => date('Y-m-d H:i:s'),
];

$errors = [];
if ($sr['name'] === '') $errors['name'] = 'Please enter your name.';
if ($sr['phone'] === '' || strlen(preg_replace('/\D/', '', $sr['phone'])) < 7) $errors['phone'] = 'Please enter a valid phone number.';
if ($sr['email'] !== '' && !filter_var($sr['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Please enter a valid email address.';
if (!in_array($sr['service_type'], $validServices, true)) $errors['service_type'] = 'Please select a service.';
if (!in_array($sr['urgency'], ['routine', 'soon', 'urgent', 'emergency'], true)) $sr['urgency'] = 'routine';
if (!in_array($sr['customer_type'], ['new', 'existing'], true)) $sr['customer_type'] = 'new';
if (!in_array($sr['preferred_time'], ['', 'morning', 'afternoon', 'evening', 'asap'], true)) $sr['preferred_time'] = '';
if ($sr['preferred_date'] !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $sr['preferred_date'])) $sr['preferred_date'] = '';

if ($errors) {
    $respond(false, reset($errors), ['errors' => $errors], 422);
}

// --- Persist -----------------------------------------------------------------
$id = null;
$stored = false;
if ($pdo = db()) {
    try {
        $cols = ['name','phone','email','address','city','service_type','issue_description','preferred_date','preferred_time','urgency','customer_type','form_source','utm_source','utm_medium','utm_campaign','consent','status','ip','user_agent','created_at'];
        $sql = 'INSERT INTO service_requests (' . implode(',', $cols) . ') VALUES (' . implode(',', array_map(fn($c) => ":$c", $cols)) . ')';
        $stmt = $pdo->prepare($sql);
        foreach ($cols as $c) $stmt->bindValue(":$c", $sr[$c]);
        $stmt->execute();
        $id = (int) $pdo->lastInsertId();
        $stored = true;
    } catch (Throwable $e) {
        error_log('service_requests insert failed: ' . $e->getMessage());
    }
}
if (!$stored) {
    $dir = SITE_ROOT . '/storage';
    if (!is_dir($dir)) @mkdir($dir, 0750, true);
    $id = $id ?: uniqid('sr_', true);
    $line = json_encode(['id' => $id] + $sr, JSON_UNESCAPED_UNICODE) . "\n";
    $stored = (bool) @file_put_contents($dir . '/requests.jsonl', $line, FILE_APPEND | LOCK_EX);
    if (!$stored) error_log('Could not write storage/requests.jsonl');
}

// --- Emails ------------------------------------------------------------------
[$customerSent, $internalSent] = send_request_emails($sr);
if ($pdo && is_int($id)) {
    try {
        $pdo->prepare('UPDATE service_requests SET email_sent = :s WHERE id = :id')->execute([':s' => $internalSent ? 1 : 0, ':id' => $id]);
    } catch (Throwable $e) { /* ignore */ }
}

// --- Telemetry ---------------------------------------------------------------
if ($pdo && TRACK_PAGE_VIEWS) {
    try {
        $pdo->prepare('INSERT INTO site_events (event_name, path, form_source, service_type, utm_source, utm_medium, utm_campaign, properties, ip, created_at) VALUES (?,?,?,?,?,?,?,?,?,NOW())')
            ->execute(['service_request_submitted', $_POST['redirect'] ?? '', $sr['form_source'], $sr['service_type'], $sr['utm_source'], $sr['utm_medium'], $sr['utm_campaign'], json_encode(['urgency' => $sr['urgency']]), $sr['ip']]);
    } catch (Throwable $e) { /* ignore */ }
}

if (!$stored && !$internalSent) {
    $respond(false, 'We could not submit your request right now. Please call us at ' . PHONE_NUMBER . '.', [], 500);
}

$respond(true, 'Request submitted', ['id' => $id, 'name' => $sr['name']]);
