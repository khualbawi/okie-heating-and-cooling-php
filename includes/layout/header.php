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

$navLinks = [
    ['label' => 'Home', 'path' => '/'],
    ['label' => 'Services', 'path' => '/services', 'children' => [
        ['label' => 'AC Repair', 'path' => '/services/ac-repair'],
        ['label' => 'AC Installation', 'path' => '/services/ac-installation'],
        ['label' => 'Heating Repair', 'path' => '/services/heating-repair'],
        ['label' => 'Furnace Repair', 'path' => '/services/furnace-repair'],
        ['label' => 'Emergency HVAC', 'path' => '/services/emergency-hvac'],
        ['label' => 'View All Services', 'path' => '/services'],
    ]],
    ['label' => 'Service Areas', 'path' => '/service-areas'],
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
      <?php foreach ($navLinks as $link): ?>
        <?php if (!empty($link['children'])): ?>
          <div class="nav-item has-dropdown">
            <a href="<?= e($link['path']) ?>" class="nav-link<?= $isActive($link['path']) ? ' is-active' : '' ?>" aria-haspopup="true" aria-expanded="false">
              <?= e($link['label']) ?> <?= icon('chevron-down', 'icon-sm') ?>
            </a>
            <div class="dropdown" role="menu" aria-label="<?= e($link['label']) ?> menu">
              <?php foreach ($link['children'] as $child): ?>
                <a href="<?= e($child['path']) ?>" role="menuitem" class="dropdown-link"><?= e($child['label']) ?></a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php else: ?>
          <a href="<?= e($link['path']) ?>" class="nav-link<?= current_path() === $link['path'] ? ' is-active' : '' ?>"<?= current_path() === $link['path'] ? ' aria-current="page"' : '' ?>><?= e($link['label']) ?></a>
        <?php endif; ?>
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
    <nav class="mobile-nav">
      <?php foreach ($navLinks as $link): ?>
        <a href="<?= e($link['path']) ?>" class="mobile-nav-link<?= current_path() === $link['path'] ? ' is-active' : '' ?>"><?= e($link['label']) ?></a>
        <?php if (!empty($link['children'])): ?>
          <div class="mobile-subnav">
            <?php foreach ($link['children'] as $child): if ($child['path'] === $link['path']) continue; ?>
              <a href="<?= e($child['path']) ?>" class="mobile-subnav-link"><?= e($child['label']) ?></a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </nav>
    <div class="mobile-menu-ctas">
      <a href="<?= PHONE_HREF ?>" class="btn btn-outline btn-block"><?= icon('phone', 'icon-sm') ?> <?= e(PHONE_NUMBER) ?></a>
      <a href="/book" class="btn btn-accent btn-block">Book Service</a>
    </div>
  </div>
</aside>

<main id="main-content" tabindex="-1">
