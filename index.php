<?php
/**
 * Front controller — all non-file requests are rewritten here by .htaccess.
 */
declare(strict_types=1);

require __DIR__ . '/config.php';
require __DIR__ . '/includes/helpers.php';
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/cache.php';

$path = current_path();

// Full-page cache: serves a stored copy and exits on a hit, buffers on a miss.
if ($path !== '/api/submit-request' && $path !== '/api/track') {
    page_cache_start();
}

// --- API endpoints -----------------------------------------------------------
if ($path === '/api/submit-request') {
    require SITE_ROOT . '/api/submit-request.php';
    exit;
}
if ($path === '/api/track') {
    require SITE_ROOT . '/api/track.php';
    exit;
}
if ($path === '/sitemap.xml') {
    require SITE_ROOT . '/sitemap.php';
    exit;
}

// --- Page routing -------------------------------------------------------------
$page   = null;   // file in /pages
$params = [];

$static = [
    '/'                 => 'home',
    '/services'         => 'services',
    '/service-areas'    => 'service-areas',
    '/about'            => 'about',
    '/contact'          => 'contact',
    '/book'             => 'book',
    '/reviews'          => 'reviews',
    '/financing'        => 'financing',
    '/maintenance-plan' => 'maintenance-plan',
];

if (isset($static[$path])) {
    $page = $static[$path];
} elseif (preg_match('#^/services/([a-z0-9-]+)$#', $path, $m)) {
    $service = get_service_by_slug($m[1]);
    if ($service) {
        $page = 'service-detail';
        $params['service'] = $service;
    }
} elseif (preg_match('#^/service-areas/([a-z0-9-]+)$#', $path, $m)) {
    $area = get_area_by_slug($m[1]);
    if ($area) {
        $page = 'service-area-detail';
        $params['area'] = $area;
    }
}

if ($page === null) {
    http_response_code(404);
    $page = '404';
}

// Each page sets $seo (title, description, path, noindex, jsonLd) then includes layout.
extract($params, EXTR_SKIP);
require SITE_ROOT . "/pages/$page.php";
