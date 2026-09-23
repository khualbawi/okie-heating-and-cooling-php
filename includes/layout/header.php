<?php
/**
 * Expects $seo = ['title'=>..,'description'=>..,'path'=>..,'noindex'=>bool,'jsonLd'=>array|null,'extraJsonLd'=>array|null]
 */
$seo = array_merge([
    'title' => null,
    'description' => "Tulsa's trusted HVAC company. Same-day AC repair, heating repair, furnace installation & 24/7 emergency service. Licensed & locally owned. Call (918) 896-1978!",
    'path' => current_path(),
    'noindex' => false,
    'jsonLd' => null,
    'extraJsonLd' => null,
    'image' => abs_url('assets/img/okie-logo-hero.png'),
], $seo ?? []);

$cssVer  = deploy_version();

$pageTitle = build_title($seo['title']);
$canonical = abs_url($seo['path']);
$jsonLd    = $seo['jsonLd'] ?? local_business_jsonld();
$isActive  = fn(string $p) => current_path() === $p || ($p !== '/' && str_starts_with(current_path(), $p));

// Mega-menu columns are built from SERVICES, never hardcoded, so a new/renamed
// service shows up here automatically. Emergency HVAC gets its own red card
// instead of a spot in a column.
$svcByCategory = ['cooling' => [], 'heating' => [], 'more' => []];
foreach (SERVICES as $svc) {
    if ($svc['slug'] === 'emergency-hvac') {
        continue;
    }
    $bucket = in_array($svc['category'], ['cooling', 'heating'], true) ? $svc['category'] : 'more';
    $svcByCategory[$bucket][] = $svc;
}
$emergencyService = get_service_by_slug('emergency-hvac');

$simpleNavLinks = [
    ['label' => 'Financing', 'path' => '/financing'],
    ['label' => 'About', 'path' => '/about'],
    ['label' => 'Reviews', 'path' => '/reviews'],
    ['label' => 'Contact', 'path' => '/contact'],
];

// Safety net for a raw {{PLACEHOLDER}} that slips past template logic — closed
// and filtered in footer.php via strip_raw_placeholders().
ob_start();
?>
<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if (GA_MEASUREMENT_ID !== ''): ?>
  <script>
    /* gtag queue is available immediately; the 100 KB library itself is fetched
       after load (or on first interaction) so it never competes with LCP. */
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?= e(GA_MEASUREMENT_ID) ?>');
  </script>
<?php endif; ?>
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e($seo['description']) ?>">
  <meta name="robots" content="<?= $seo['noindex'] ? 'noindex, nofollow' : 'index, follow' ?>">
  <link rel="canonical" href="<?= e($canonical) ?>">
  <meta name="theme-color" content="#0d2847">

  <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon-32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon-16.png">
  <link rel="icon" type="image/png" sizes="192x192" href="/assets/img/favicon-192.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/apple-touch-icon.png">

  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?= e(BRAND_NAME) ?>">
  <meta property="og:title" content="<?= e($pageTitle) ?>">
  <meta property="og:description" content="<?= e($seo['description']) ?>">
  <meta property="og:url" content="<?= e($canonical) ?>">
  <meta property="og:image" content="<?= e($seo['image']) ?>">
  <meta property="og:image:alt" content="Okie Heating & Cooling logo">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= e($pageTitle) ?>">
  <meta name="twitter:description" content="<?= e($seo['description']) ?>">
  <meta name="twitter:image" content="<?= e($seo['image']) ?>">

  <link rel="preload" as="style" href="/assets/css/styles.css?v=<?= $cssVer ?>">
  <link rel="stylesheet" href="/assets/css/styles.css?v=<?= $cssVer ?>">
  <link rel="preload" as="font" type="font/woff2" href="/assets/fonts/inter-latin-var.woff2" crossorigin>
  <link rel="preload" as="font" type="font/woff2" href="/assets/fonts/jakarta-latin-var.woff2" crossorigin>

  <?php // JSON_HEX_TAG stops a "</script>" inside any interpolated string (an area
        // name, FAQ text, a future admin-editable field) from closing this tag early. ?>
  <script type="application/ld+json"><?= json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
<?php if (!empty($seo['extraJsonLd'])): ?>
  <script type="application/ld+json"><?= json_encode($seo['extraJsonLd'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
<?php endif; ?>
</head>
<body>
<a href="#main-content" class="skip-link">Skip to content</a>

<div class="emergency-strip">
  <span class="sm-hidden">🔥 24/7 — </span>
  <span class="sm-only">🔥 24/7 Emergency HVAC Service Available — </span>
  <a href="<?= PHONE_HREF ?>" aria-label="Call <?= e(PHONE_NUMBER) ?> for emergency HVAC service">Call <?= e(PHONE_NUMBER) ?></a>
  <span class="sm-only"> for immediate help</span>
</div>

<header class="site-header" id="site-header">
  <div class="container header-inner">
    <a href="/" class="logo-link" aria-label="Okie Heating and Cooling home">
      <img src="/assets/img/okie-logo-nav-260.webp" srcset="/assets/img/okie-logo-nav-260.webp 260w, /assets/img/okie-logo-nav-400.webp 400w" sizes="(max-width: 768px) 160px, 250px" alt="Okie Heating and Cooling" class="logo-img" width="500" height="200" fetchpriority="high" decoding="async">
    </a>

    <nav class="desktop-nav" aria-label="Primary">
      <div class="nav-item has-megamenu">
        <a href="/services" class="nav-link<?= $isActive('/services') ? ' is-active' : '' ?>"<?= $isActive('/services') ? ' aria-current="page"' : '' ?>>Services</a>
        <button type="button" class="nav-caret" aria-haspopup="true" aria-expanded="false" aria-controls="services-megamenu" aria-label="Show services menu"><?= icon('chevron-down', 'icon-sm') ?></button>
        <div class="megamenu" id="services-megamenu" role="menu" aria-label="Services menu">
          <div class="megamenu-col">
            <p class="megamenu-heading">Cooling</p>
            <?php foreach ($svcByCategory['cooling'] as $svc): ?>
              <a href="/services/<?= e($svc['slug']) ?>" role="menuitem" class="dropdown-link"><?= e($svc['title']) ?></a>
            <?php endforeach; ?>
          </div>
          <div class="megamenu-col">
            <p class="megamenu-heading">Heating</p>
            <?php foreach ($svcByCategory['heating'] as $svc): ?>
              <a href="/services/<?= e($svc['slug']) ?>" role="menuitem" class="dropdown-link"><?= e($svc['title']) ?></a>
            <?php endforeach; ?>
          </div>
          <div class="megamenu-col">
            <p class="megamenu-heading">More</p>
            <?php foreach ($svcByCategory['more'] as $svc): ?>
              <a href="/services/<?= e($svc['slug']) ?>" role="menuitem" class="dropdown-link"><?= e($svc['title']) ?></a>
            <?php endforeach; ?>
          </div>
          <div class="megamenu-col megamenu-emergency">
            <?php if ($emergencyService): ?>
              <a href="/services/emergency-hvac" role="menuitem" class="megamenu-emergency-card">
                <?= icon('alert-triangle', 'icon-sm') ?>
                <span>24/7 Emergency</span>
                <small><?= e(PHONE_NUMBER) ?></small>
              </a>
            <?php endif; ?>
            <a href="/services" role="menuitem" class="dropdown-link dropdown-link-accent">View all services →</a>
          </div>
        </div>
      </div>

      <div class="nav-item has-dropdown">
        <a href="/service-areas" class="nav-link<?= $isActive('/service-areas') ? ' is-active' : '' ?>"<?= $isActive('/service-areas') ? ' aria-current="page"' : '' ?>>Service Areas</a>
        <button type="button" class="nav-caret" aria-haspopup="true" aria-expanded="false" aria-controls="areas-dropdown" aria-label="Show service areas menu"><?= icon('chevron-down', 'icon-sm') ?></button>
        <div class="dropdown" id="areas-dropdown" role="menu" aria-label="Service areas menu">
          <?php foreach (SERVICE_AREAS as $area): ?>
            <a href="/service-areas/<?= e($area['slug']) ?>" role="menuitem" class="dropdown-link"><?= e($area['name']) ?></a>
          <?php endforeach; ?>
          <a href="/service-areas#zip" role="menuitem" class="dropdown-link dropdown-link-accent">Check your ZIP →</a>
        </div>
      </div>

      <?php foreach ($simpleNavLinks as $link): ?>
        <a href="<?= e($link['path']) ?>" class="nav-link<?= current_path() === $link['path'] ? ' is-active' : '' ?>"<?= current_path() === $link['path'] ? ' aria-current="page"' : '' ?>><?= e($link['label']) ?></a>
      <?php endforeach; ?>
    </nav>

    <div class="header-actions">
      <a href="<?= OFFICE_PHONE_HREF ?>" class="btn btn-outline btn-sm header-phone">
        <?= icon('phone', 'icon-sm') ?>
        <span class="xl-only"><?= e(OFFICE_PHONE_NUMBER) ?></span>
        <span class="xl-hidden">Call Now</span>
      </a>
      <a href="/book" class="btn btn-accent btn-sm">Book Service</a>
      <button type="button" class="btn btn-ghost btn-icon mobile-menu-btn" id="mobile-menu-btn" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
        <?= icon('menu', 'icon') ?>
      </button>
    </div>
  </div>
</header>

<div class="mobile-menu-backdrop" id="mobile-menu-backdrop" hidden></div>
<aside class="mobile-menu" id="mobile-menu" aria-label="Mobile menu" aria-hidden="true">
  <div class="mobile-menu-inner">
    <div class="mobile-menu-top">
      <img src="/assets/img/okie-logo-nav-260.webp" alt="Okie Heating and Cooling" class="logo-img-sm" width="500" height="200" loading="lazy" decoding="async">
      <button type="button" class="btn btn-ghost btn-icon" id="mobile-menu-close" aria-label="Close menu"><?= icon('x', 'icon') ?></button>
    </div>
    <a href="<?= PHONE_HREF ?>" class="btn btn-accent btn-lg btn-block mobile-menu-call"><?= icon('phone', 'icon-sm') ?> Call 24/7 — <?= e(PHONE_NUMBER) ?></a>

    <nav class="mobile-nav">
      <details class="mobile-accordion">
        <summary class="mobile-nav-link<?= $isActive('/services') ? ' is-active' : '' ?>">Services</summary>
        <div class="mobile-subnav">
          <p class="mobile-subnav-heading">Cooling</p>
          <?php foreach ($svcByCategory['cooling'] as $svc): ?>
            <a href="/services/<?= e($svc['slug']) ?>" class="mobile-subnav-link"><?= e($svc['title']) ?></a>
          <?php endforeach; ?>
          <p class="mobile-subnav-heading">Heating</p>
          <?php foreach ($svcByCategory['heating'] as $svc): ?>
            <a href="/services/<?= e($svc['slug']) ?>" class="mobile-subnav-link"><?= e($svc['title']) ?></a>
          <?php endforeach; ?>
          <p class="mobile-subnav-heading">More</p>
          <?php foreach ($svcByCategory['more'] as $svc): ?>
            <a href="/services/<?= e($svc['slug']) ?>" class="mobile-subnav-link"><?= e($svc['title']) ?></a>
          <?php endforeach; ?>
          <a href="/services" class="mobile-subnav-link mobile-subnav-link-accent">View all services →</a>
        </div>
      </details>

      <details class="mobile-accordion">
        <summary class="mobile-nav-link<?= $isActive('/service-areas') ? ' is-active' : '' ?>">Service Areas</summary>
        <div class="mobile-subnav">
          <?php foreach (SERVICE_AREAS as $area): ?>
            <a href="/service-areas/<?= e($area['slug']) ?>" class="mobile-subnav-link"><?= e($area['name']) ?></a>
          <?php endforeach; ?>
          <a href="/service-areas#zip" class="mobile-subnav-link mobile-subnav-link-accent">Check your ZIP →</a>
        </div>
      </details>

      <?php foreach ($simpleNavLinks as $link): ?>
        <a href="<?= e($link['path']) ?>" class="mobile-nav-link<?= current_path() === $link['path'] ? ' is-active' : '' ?>"><?= e($link['label']) ?></a>
      <?php endforeach; ?>
    </nav>
    <div class="mobile-menu-ctas">
      <a href="/book" class="btn btn-outline btn-block">Book Service</a>
    </div>
  </div>
</aside>

<main id="main-content" tabindex="-1">
