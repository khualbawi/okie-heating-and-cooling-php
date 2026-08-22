<?php
$seo = [
    'title' => 'Book HVAC Service',
    'description' => 'Schedule your HVAC service in minutes. Submit a request online and our team will confirm your appointment quickly.',
    'path' => '/book',
];
$preSelected = preg_replace('/[^a-z_]/', '', (string) ($_GET['service'] ?? ''));
$steps = [
    ['Submit Your Request', 'Fill out the form with your details and preferred schedule.'],
    ['We Confirm', 'Our team will call or email to confirm your appointment within a few hours.'],
    ['Technician Arrives', 'A certified technician shows up on time, ready to help.'],
    ['Problem Solved', 'We diagnose, quote, and fix the issue — guaranteed.'],
];
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero page-hero-sm">
  <div class="container reveal">
    <p class="eyebrow">Book Service</p>
    <h1 class="h1">Schedule Your HVAC Service</h1>
    <p class="page-hero-sub">Book online in minutes. We'll confirm your appointment and get your comfort restored fast.</p>
  </div>
</section>

<section class="section">
  <div class="container grid-5 gap-12">
    <div class="col-span-2 stack-6">
      <div class="reveal">
        <h2 class="h3 mb-4">What to Expect</h2>
        <div class="stack-4">
          <?php foreach ($steps as $i => [$t, $d]): ?>
            <div class="step-row">
              <div class="step-num"><?= $i + 1 ?></div>
              <div><p class="step-title"><?= e($t) ?></p><p class="xs muted"><?= e($d) ?></p></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="info-box reveal" data-delay="1">
        <div class="inline-icon small"><?= icon('clock', 'icon-xs accent') ?> <span class="fw-500">Same-day service available</span></div>
        <div class="inline-icon small"><?= icon('shield-check', 'icon-xs accent') ?> <span class="fw-500">Licensed &amp; insured technicians</span></div>
        <div class="inline-icon small"><?= icon('star', 'icon-xs accent') ?> <span class="fw-500">5-star rated service</span></div>
      </div>
      <div class="reveal" data-delay="2">
        <p class="small muted mb-2">Prefer to call?</p>
        <a href="<?= PHONE_HREF ?>" class="phone-link-lg"><?= e(PHONE_NUMBER) ?></a>
        <p class="small muted mt-4">Just have a question? <a href="/contact" class="link-accent fw-600">Send an inquiry</a>.</p>
      </div>
    </div>
    <div class="col-span-3">
      <div class="card reveal" data-delay="1">
        <h2 class="h3 mb-2">Service Request</h2>
        <p class="small muted mb-6">Tell us what you need and we'll get back to you quickly.</p>
        <?php component('service-request-form', ['source' => 'book_page', 'defaultService' => $preSelected]); ?>
      </div>
    </div>
  </div>
</section>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
