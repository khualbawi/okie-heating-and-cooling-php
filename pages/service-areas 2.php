<?php
$seo = [
    'title' => 'HVAC Service Areas',
    'description' => 'Okie Heating & Cooling serves Tulsa and nearby communities including Broken Arrow, Owasso, Bixby, Jenks, Sand Springs, Sapulpa, and Glenpool.',
    'path' => '/service-areas',
];
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <p class="eyebrow">Service Areas</p>
    <h1 class="h1">Areas We Serve</h1>
    <p class="page-hero-sub">Okie Heating and Cooling proudly serves the Tulsa metro and surrounding communities with expert HVAC service.</p>
  </div>
</section>
<section class="section">
  <div class="container grid-4 gap-6">
    <?php foreach (SERVICE_AREAS as $i => $area): ?>
      <a href="/service-areas/<?= e($area['slug']) ?>" class="service-card reveal" data-delay="<?= $i ?>">
        <div class="service-card-icon"><?= icon('map-pin', 'icon-sm') ?></div>
        <h2 class="service-card-title"><?= e($area['name']) ?>, OK</h2>
        <p class="service-card-desc clamp-3"><?= e($area['description']) ?></p>
        <span class="learn-more">View Area <?= icon('arrow-right', 'icon-xs') ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</section>
<?php component('cta-banner', ['variant' => 'dark', 'headline' => 'Need HVAC Service in Your Area?', 'subheadline' => 'We serve the entire Tulsa metro area. Book online or call us today.']); ?>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
