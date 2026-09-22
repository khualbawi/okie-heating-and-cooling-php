<?php
$seo = [
    'title' => 'HVAC Financing & Specials',
    'description' => 'Flexible HVAC financing options for system replacements and major repairs in Tulsa, OK. Ask about seasonal specials.',
    'path' => '/financing',
];
$benefits = ['Low monthly payments', 'Quick and easy application', 'Competitive interest rates', 'Flexible terms available', 'No prepayment penalties', 'Apply in minutes'];
$options = [
    ['dollar-sign', 'Low Monthly Payments', 'Spread the cost over time with affordable monthly payments that fit your budget.'],
    ['percent', 'Promotional Rates', 'Ask about special promotional financing rates on qualifying equipment.'],
    ['credit-card', 'Easy Application', 'Quick credit check with fast approval. Apply online or with your technician.'],
];
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <p class="eyebrow">Financing &amp; Specials</p>
    <h1 class="h1">Affordable Comfort for Your Home</h1>
    <p class="page-hero-sub">Quality HVAC service shouldn't break the bank. Explore our financing options and current specials.</p>
  </div>
</section>

<section class="section">
  <div class="container-md">
    <div class="section-head reveal">
      <h2 class="h2">HVAC Financing</h2>
      <p class="lead muted">We offer flexible financing to make new system installations and major repairs manageable for any budget.</p>
    </div>
    <div class="grid-3 gap-6 mb-12">
      <?php foreach ($options as $i => [$ic, $t, $d]): ?>
        <div class="feature-card text-center reveal" data-delay="<?= $i ?>">
          <div class="feature-icon feature-icon-lg center"><?= icon($ic, 'icon') ?></div>
          <h3 class="feature-title"><?= e($t) ?></h3>
          <p class="feature-desc"><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="info-box info-box-lg reveal" data-delay="2">
      <h3 class="h4 mb-4">Financing Benefits</h3>
      <div class="grid-2 gap-3">
        <?php foreach ($benefits as $b): ?>
          <div class="inline-icon small"><?= icon('check-circle', 'icon-xs accent') ?> <span><?= e($b) ?></span></div>
        <?php endforeach; ?>
      </div>
      <div class="text-center mt-6">
        <p class="small muted mb-1">Financing through {{FINANCING_PARTNER}}</p>
        <p class="h4 mb-4">As low as ${{FINANCING_SAMPLE_PAYMENT}}/mo<sup class="small muted">*</sup></p>
        <a href="{{FINANCING_APPLY_URL}}" target="_blank" rel="noopener noreferrer" class="btn btn-accent btn-lg">Apply Now <?= icon('arrow-right', 'icon-sm') ?></a>
        <p class="small muted-60 mt-3">*Sample payment for qualifying credit. Terms vary by approval.</p>
      </div>
    </div>
  </div>
</section>

<section class="section bg-muted-50">
  <div class="container-md text-center reveal">
    <h2 class="h2">Current Specials</h2>
    <p class="lead muted mb-8">Check back regularly for seasonal deals and limited-time promotions.</p>
    <?php $specials = active_financing_specials(); ?>
    <?php if ($specials): ?>
      <div class="grid-3 gap-6">
        <?php foreach ($specials as $i => $s): ?>
          <div class="feature-card text-center reveal" data-delay="<?= $i ?>">
            <h3 class="feature-title"><?= e($s['title']) ?></h3>
            <p class="h3 accent mb-2"><?= e($s['price']) ?></p>
            <p class="small muted">Expires <?= e(date('M j, Y', strtotime($s['expires']))) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="card card-xl">
        <p class="muted">Seasonal promotions and special offers coming soon.</p>
        <p class="small muted-60 mt-2">Contact us for current pricing and deals.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<?php component('cta-banner', ['variant' => 'dark', 'headline' => 'Ready to Get Started?', 'subheadline' => 'Book your service or ask about financing options today.']); ?>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
