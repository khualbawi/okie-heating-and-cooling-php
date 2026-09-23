<?php
/** @var array $area */
$hub = area_hub($area['slug']);
$areaTitleFull = $area['name'] . ' HVAC Repair & Installation | ' . BRAND_NAME;
$seo = [
    'title' => strlen($areaTitleFull) <= 60 ? $areaTitleFull : $area['name'] . ' HVAC Repair | ' . BRAND_NAME,
    'description' => meta_trim($area['seoText'] ?: $area['description']),
    'path' => '/service-areas/' . $area['slug'],
    'jsonLd' => area_business_jsonld($area),
    'extraJsonLd' => !empty($area['faqs']) ? faq_jsonld($area['faqs']) : null,
];
$areaToken = strtoupper(str_replace([' ', '-'], '_', $area['name']));
$areaIntro = fill_content($area['intro'], $area['introTokens'] ?? []) ?? $area['introFallback'];
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <div class="hero-crumb">
      <?= icon('map-pin', 'icon-sm accent') ?>
      <a href="/service-areas" class="hero-crumb-link">← All Service Areas</a>
    </div>
    <h1 class="h1">HVAC Repair &amp; Installation in <?= e($area['name']) ?>, OK</h1>
    <?php if (!empty($hub['eta'])): ?><span class="badge-eta badge-eta-lg"><?= e($hub['eta']) ?></span><?php endif; ?>
    <p class="page-hero-sub mb-8"><?= e($area['description']) ?></p>
    <div class="btn-row">
      <a href="/book?city=<?= e($area['slug']) ?>" class="btn btn-accent btn-lg">Book Service in <?= e($area['name']) ?> <?= icon('arrow-right', 'icon-sm') ?></a>
      <a href="<?= PHONE_HREF ?>" class="btn btn-secondary btn-lg"><?= icon('phone', 'icon-sm') ?> <?= e(PHONE_NUMBER) ?></a>
    </div>
  </div>
</section>

<section class="section-sm">
  <div class="container-md reveal area-map-inline">
    <?php render_area_map([$hub], $area['slug'], 'sm'); ?>
  </div>
</section>

<section class="section-sm">
  <div class="container-md reveal">
    <p class="lead muted leading-relaxed"><?= e($areaIntro) ?></p>
    <?php if (!empty($hub['neighborhoods'])): ?>
      <div class="area-neighborhoods">
        <h3 class="h6 mb-2">Neighborhoods We Serve in <?= e($area['name']) ?></h3>
        <div class="also-serving-chips">
          <?php foreach ($hub['neighborhoods'] as $n): ?><span class="chip"><?= e($n) ?></span><?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

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

<?php if (!empty($hub['recent_job']) || !empty($hub['review'])): ?>
<section class="section">
  <div class="container-md reveal grid-2 gap-6">
    <?php if (!empty($hub['recent_job'])): ?>
      <div class="card">
        <h3 class="h5 mb-3">Recent Job in <?= e($area['name']) ?></h3>
        <?php if (!empty($hub['recent_job']['photo'])): ?>
          <img src="<?= e($hub['recent_job']['photo']) ?>" alt="<?= e($hub['recent_job']['title']) ?>" width="400" height="260" loading="lazy" class="area-job-photo">
        <?php endif; ?>
        <p class="fw-600 mb-1"><?= e($hub['recent_job']['title']) ?></p>
        <p class="muted"><?= e($hub['recent_job']['summary']) ?></p>
      </div>
    <?php endif; ?>
    <?php if (!empty($hub['review'])): ?>
      <div class="testimonial-card">
        <div class="stars">
          <?php for ($s = 0; $s < 5; $s++): ?><?= icon('star', 'icon-xs ' . ($s < (int) $hub['review']['stars'] ? 'star-on' : 'star-off')) ?><?php endfor; ?>
        </div>
        <p class="testimonial-text">&ldquo;<?= e($hub['review']['quote']) ?>&rdquo;</p>
        <div class="testimonial-meta">
          <div class="avatar"><?= e(mb_substr($hub['review']['name'], 0, 1)) ?></div>
          <div><p class="testimonial-name"><?= e($hub['review']['name']) ?></p><p class="testimonial-loc"><?= e($area['name']) ?>, OK</p></div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<section class="section bg-muted-50">
  <div class="container">
    <div class="section-head reveal">
      <h2 class="h2">Services Available in <?= e($area['name']) ?></h2>
      <p class="lead muted">Full range of heating and cooling services for <?= e($area['name']) ?> homes and businesses.</p>
    </div>
    <div class="grid-3 gap-4">
      <?php foreach (SERVICES as $i => $svc): ?>
        <div class="reveal" data-delay="<?= $i % 6 ?>"><?php component('service-card', ['service' => $svc, 'compact' => true]); ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if (!empty($area['faqs'])): ?>
  <?php component('faq-section', ['faqs' => $area['faqs'], 'title' => 'Questions From ' . $area['name'] . ' Homeowners']); ?>
<?php endif; ?>

<?php if (!empty($hub['nearby'])): ?>
<section class="section-sm">
  <div class="container-md text-center reveal">
    <p class="small muted mb-3">Nearby areas</p>
    <div class="also-serving-chips center">
      <?php foreach ($hub['nearby'] as $slug): ?>
        <?php $n = get_area_by_slug($slug); if (!$n) continue; ?>
        <a href="/service-areas/<?= e($slug) ?>" class="chip chip-link"><?= e($n['name']) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php component('cta-banner', ['variant' => 'dark', 'headline' => 'Ready for HVAC Service in ' . $area['name'] . '?', 'subheadline' => 'Book online or call us for fast, reliable heating and cooling service in ' . $area['name'] . ', Oklahoma.']); ?>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
