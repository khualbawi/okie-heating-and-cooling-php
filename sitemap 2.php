<?php
/** Dynamic sitemap.xml (routed from index.php). */
declare(strict_types=1);
if (!defined('SITE_ROOT')) {
    require __DIR__ . '/config.php';
    require SITE_ROOT . '/includes/helpers.php';
    require SITE_ROOT . '/includes/data.php';
}
header('Content-Type: application/xml; charset=UTF-8');
$lastmod = date('Y-m-d', max(filemtime(SITE_ROOT . '/includes/data.php'), filemtime(__FILE__)));
$urls = [
    ['/', 'weekly', '1.0'], ['/services', 'weekly', '0.9'], ['/service-areas', 'monthly', '0.8'],
    ['/book', 'monthly', '0.9'], ['/contact', 'monthly', '0.8'], ['/about', 'monthly', '0.7'],
    ['/reviews', 'weekly', '0.7'], ['/financing', 'monthly', '0.7'], ['/maintenance-plan', 'monthly', '0.7'],
];
$prio = ['ac-repair' => '0.9', 'heating-repair' => '0.9', 'furnace-repair' => '0.9', 'emergency-hvac' => '0.95', 'ac-installation' => '0.85', 'heating-installation' => '0.85', 'furnace-installation' => '0.85', 'ac-maintenance' => '0.8', 'heating-maintenance' => '0.8', 'indoor-air-quality' => '0.75'];
foreach (SERVICES as $s) $urls[] = ['/services/' . $s['slug'], 'monthly', $prio[$s['slug']] ?? '0.7'];
foreach (SERVICE_AREAS as $a) $urls[] = ['/service-areas/' . $a['slug'], 'monthly', $a['slug'] === 'tulsa' ? '0.8' : '0.7'];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as [$path, $freq, $p]) {
    echo "  <url><loc>" . e(abs_url($path)) . "</loc><lastmod>{$lastmod}</lastmod><changefreq>{$freq}</changefreq><priority>{$p}</priority></url>\n";
}
echo "</urlset>\n";
