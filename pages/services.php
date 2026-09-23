<?php
$seo = [
    'title' => 'All HVAC Services We Offer',
    'description' => 'Explore AC repair, heating repair, installation, maintenance, indoor air quality, ductwork, commercial HVAC, and emergency service across the Tulsa metro.',
    'path' => '/services',
];
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <p class="eyebrow">Our Services</p>
    <h1 class="h1">Every HVAC Service We Offer</h1>
    <p class="page-hero-sub">Complete heating, cooling, and air quality solutions for Tulsa homes and businesses. Expert service, honest pricing.</p>
  </div>
</section>

<?php foreach (SERVICE_CATEGORIES as $key => $label):
    $cat = array_values(array_filter(SERVICES, fn($s) => $s['category'] === $key));
    if (!$cat) continue; ?>
  <section class="section-sm">
    <div class="container">
      <h2 class="h2 mb-8 reveal"><?= e($label) ?></h2>
      <div class="grid-3 gap-6">
        <?php foreach ($cat as $i => $svc): ?>
          <div class="reveal" data-delay="<?= $i ?>"><?php component('service-card', ['service' => $svc]); ?></div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endforeach; ?>

<?php component('cta-banner', ['variant' => 'dark']); ?>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
