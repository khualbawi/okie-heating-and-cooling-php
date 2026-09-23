<?php
$seo = [
    'title' => 'Terms of Use | Okie Heating & Cooling',
    'description' => 'Terms of use for the Okie Heating and Cooling website, covering estimates, scheduling, liability, and governing law in Oklahoma.',
    'path' => '/terms',
];
$lastUpdated = 'September 23, 2026';
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <h1 class="h1">Terms of Use</h1>
    <p class="page-hero-sub">Last updated: <?= e($lastUpdated) ?></p>
  </div>
</section>

<section class="section">
  <div class="container-md legal-content reveal">
    <p class="legal-draft-notice"><strong>DRAFT — pending owner/attorney review.</strong> These terms have not yet been reviewed by an attorney. Warranty terms for completed work are governed by your actual service contract, not this page.</p>

    <h2>Website use</h2>
    <p>This website is provided by <?= e(BRAND_LEGAL) ?> to share information about our services and let you request an appointment. By using this site, you agree to use it only for lawful purposes.</p>

    <h2>Estimates and quotes</h2>
    <p>Any estimate or quote shown or discussed through this website is not binding until confirmed in writing by <?= e(BRAND_LEGAL) ?>.</p>

    <h2>Scheduling</h2>
    <p>Appointment requests submitted through this site are requests only, subject to availability. We'll contact you to confirm your appointment.</p>

    <h2>No warranty on website information</h2>
    <p>We try to keep the information on this site accurate and current, but we make no warranty that it is complete, accurate, or error-free.</p>

    <h2>Limitation of liability</h2>
    <p>To the fullest extent permitted by law, <?= e(BRAND_LEGAL) ?> is not liable for any indirect, incidental, or consequential damages arising from your use of this website.</p>

    <h2>Governing law</h2>
    <p>These terms are governed by the laws of the State of Oklahoma, without regard to conflict-of-law principles.</p>

    <h2>Contact us</h2>
    <p>Questions about these terms? Reach us at <a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a> or <a href="<?= OFFICE_PHONE_HREF ?>"><?= e(OFFICE_PHONE_NUMBER) ?></a>.</p>
  </div>
</section>

<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
