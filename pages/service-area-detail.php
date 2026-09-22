<?php
/** @var array $area */
$seo = [
    'title' => 'HVAC Services in ' . $area['name'] . ', OK',
    'description' => $area['seoText'] ?: $area['description'],
    'path' => '/service-areas/' . $area['slug'],
    'jsonLd' => area_business_jsonld($area),
];
$areaToken = strtoupper(str_replace([' ', '-'], '_', $area['name']));
$areaReview = null;
foreach (HOME_TESTIMONIALS as $t) {
    if (str_starts_with($t['location'] ?? '', $area['name'] . ',')) { $areaReview = $t; break; }
}
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <div class="hero-crumb">
      <?= icon('map-pin', 'icon-sm accent') ?>
      <a href="/service-areas" class="hero-crumb-link">← All Service Areas</a>
    </div>
    <h1 class="h1">HVAC Services in <?= e($area['name']) ?>, Oklahoma</h1>
    <p class="page-hero-sub mb-8"><?= e($area['description']) ?></p>
    <div class="btn-row">
      <a href="/book" class="btn btn-accent btn-lg">Book Service in <?= e($area['name']) ?> <?= icon('arrow-right', 'icon-sm') ?></a>
      <a href="<?= PHONE_HREF ?>" class="btn btn-secondary btn-lg"><?= icon('phone', 'icon-sm') ?> <?= e(PHONE_NUMBER) ?></a>
    </div>
  </div>
</section>

<section class="trust-bar"><div class="container"><?php component('trust-badges'); ?></div></section>

<section class="section">
  <div class="container-md reveal">
    <h2 class="h2 text-center mb-8">Why <?= e($area['name']) ?> Chooses Okie Heating and Cooling</h2>
    <div class="grid-3 gap-6">
      <?php foreach ($area['highlights'] as $h): ?>
        <div class="highlight-card"><?= icon('check-circle', 'icon-sm accent') ?><span><?= e($h) ?></span></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section bg-muted-50">
  <div class="container">
    <div class="section-head reveal">
      <h2 class="h2">Services Available in <?= e($area['name']) ?></h2>
      <p class="lead muted">Full range of heating and cooling services for <?= e($area['name']) ?> homes and businesses.</p>
    </div>
    <div class="grid-3 gap-6">
      <?php foreach (array_slice(SERVICES, 0, 6) as $i => $svc): ?>
        <div class="reveal" data-delay="<?= $i ?>"><?php component('service-card', ['service' => $svc]); ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container-md reveal">
    <div class="grid-2 gap-6">
      <div class="card">
        <h3 class="h5 mb-3">Neighborhoods We Serve in <?= e($area['name']) ?></h3>
        <p class="muted">{{<?= e($areaToken) ?>_NEIGHBORHOODS}}</p>
      </div>
      <div class="card">
        <h3 class="h5 mb-3">Recent Job in <?= e($area['name']) ?></h3>
        <p class="muted">{{<?= e($areaToken) ?>_RECENT_JOB}}</p>
      </div>
    </div>
    <?php if ($areaReview): ?>
      <div class="mt-6"><?php component('testimonial-card', ['t' => $areaReview]); ?></div>
    <?php endif; ?>
  </div>
</section>

<section class="seo-block"><div class="container-sm"><p class="small muted leading-relaxed"><?= e($area['seoText']) ?></p></div></section>

<?php component('cta-banner', ['variant' => 'dark', 'headline' => 'Ready for HVAC Service in ' . $area['name'] . '?', 'subheadline' => 'Book online or call us for fast, reliable heating and cooling service in ' . $area['name'] . ', Oklahoma.']); ?>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
