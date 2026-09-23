<?php
$seo = [
    'title' => 'Accessibility Statement | Okie Heating & Cooling',
    'description' => 'Okie Heating and Cooling is committed to WCAG 2.1 AA accessibility. Learn how to report an accessibility issue on our website.',
    'path' => '/accessibility',
];
$lastUpdated = 'September 23, 2026';
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <h1 class="h1">Accessibility Statement</h1>
    <p class="page-hero-sub">Last updated: <?= e($lastUpdated) ?></p>
  </div>
</section>

<section class="section">
  <div class="container-md legal-content reveal">
    <p class="legal-draft-notice"><strong>DRAFT — pending owner/attorney review.</strong></p>

    <h2>Our commitment</h2>
    <p><?= e(BRAND_LEGAL) ?> is committed to making this website accessible to everyone, including people with disabilities. We aim to meet the Web Content Accessibility Guidelines (WCAG) 2.1 Level AA.</p>

    <h2>Known limitations</h2>
    <p>We are not currently aware of any accessibility barriers on this site. If you encounter one, we want to hear about it — see "Report an issue" below.</p>

    <h2>Report an issue</h2>
    <p>If you have trouble accessing any part of this website, please contact us at <a href="<?= OFFICE_PHONE_HREF ?>"><?= e(OFFICE_PHONE_NUMBER) ?></a> or <a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a> and we'll do our best to help and to fix the issue.</p>
  </div>
</section>

<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
