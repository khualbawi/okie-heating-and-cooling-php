<?php
/** @var array $service (set by router) */
$pagePath = '/services/' . $service['slug'];
$pageDesc = $service['heroSubheadline'] ?: $service['description'];
$svcTitleWithCity = $service['title'] . ' in Tulsa, OK | ' . BRAND_NAME;
$seo = [
    'title' => strlen($svcTitleWithCity) <= 60 ? $svcTitleWithCity : $service['title'] . ' | ' . BRAND_NAME,
    'description' => meta_trim($service['description']),
    'path' => $pagePath,
    'jsonLd' => service_jsonld($service['title'] . ' in Tulsa, OK', abs_url($pagePath), $pageDesc),
    'extraJsonLd' => faq_jsonld($service['faqs']),
];
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <div class="hero-crumb">
      <div class="hero-crumb-icon"><?= icon($service['icon'], 'icon') ?></div>
      <a href="/services" class="hero-crumb-link">← All Services</a>
    </div>
    <h1 class="h1"><?= e($service['heroHeadline']) ?></h1>
    <p class="page-hero-sub mb-8"><?= e($service['heroSubheadline']) ?></p>
    <div class="btn-row">
      <a href="/book?service=<?= e($service['formValue']) ?>" class="btn btn-accent btn-lg">Book This Service <?= icon('arrow-right', 'icon-sm') ?></a>
      <a href="<?= PHONE_HREF ?>" class="btn btn-secondary btn-lg"><?= icon('phone', 'icon-sm') ?> <?= e(PHONE_NUMBER) ?></a>
    </div>
  </div>
</section>

<section class="trust-bar"><div class="container"><?php component('trust-badges'); ?></div></section>

<section class="section">
  <div class="container grid-2 gap-12">
    <div class="reveal">
      <h2 class="h2 mb-6">What Our <?= e($service['shortTitle']) ?> Service Covers</h2>
      <p class="muted mb-8 leading-relaxed"><?= e($service['description']) ?></p>
      <h3 class="h4 mb-4">Benefits</h3>
      <ul class="check-list">
        <?php foreach ($service['benefits'] as $b): ?>
          <li><?= icon('check-circle', 'icon-sm accent') ?><span><?= e($b) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="reveal" data-delay="1">
      <h3 class="h4 mb-4">Signs You Need <?= e($service['shortTitle']) ?></h3>
      <ul class="check-list">
        <?php foreach ($service['symptoms'] as $s): ?>
          <li><?= icon('alert-circle', 'icon-sm primary-60') ?><span><?= e($s) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<section class="section bg-muted-50">
  <div class="container-md">
    <div class="section-head reveal">
      <h2 class="h2">How It Works</h2>
      <p class="lead muted">Simple, transparent process from start to finish.</p>
    </div>
    <div class="grid-4 gap-6">
      <?php foreach ($service['process'] as $i => $p): ?>
        <div class="process-step reveal" data-delay="<?= $i ?>">
          <div class="process-num"><?= $i + 1 ?></div>
          <h3 class="h5"><?= e($p['step']) ?></h3>
          <p class="small muted"><?= e($p['detail']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container-sm text-center reveal">
    <h2 class="h2">Why Choose Okie for <?= e($service['shortTitle']) ?>?</h2>
    <p class="lead muted mb-8"><?= e($service['whyUs']) ?></p>
    <a href="/book?service=<?= e($service['formValue']) ?>" class="btn btn-accent btn-lg">Book <?= e($service['shortTitle']) ?> Now <?= icon('arrow-right', 'icon-sm') ?></a>
  </div>
</section>

<?php component('brand-strip'); ?>

<?php component('faq-section', ['faqs' => $service['faqs']]); ?>

<?php if (!empty($service['seoText'])): ?>
  <section class="seo-block"><div class="container-sm"><p class="small muted leading-relaxed"><?= e($service['seoText']) ?></p></div></section>
<?php endif; ?>

<?php component('cta-banner', [
    'variant' => 'dark',
    'headline' => 'Need ' . $service['shortTitle'] . ' Today?',
    'subheadline' => 'Book online or call us for fast, reliable ' . mb_strtolower($service['shortTitle']) . ' service in the Tulsa metro.',
]); ?>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
