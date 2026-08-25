<?php
$seo = [
    'title' => 'Contact & Inquiries',
    'description' => 'Have a question or need a quote? Send an inquiry to Okie Heating & Cooling. For scheduling service, use our Book Service page.',
    'path' => '/contact',
];
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <p class="eyebrow">Contact Us</p>
    <h1 class="h1">Questions? Send an Inquiry.</h1>
    <p class="page-hero-sub">Need a quote or have a quick question? Send us a message. If you're ready to schedule service, book online in minutes.</p>
    <div class="btn-row mt-6">
      <a href="<?= PHONE_HREF ?>" class="btn btn-secondary btn-lg"><?= icon('phone', 'icon-sm') ?> Call <?= e(PHONE_NUMBER) ?></a>
      <a href="/book" class="btn btn-accent btn-lg">Book Service</a>
    </div>
  </div>
</section>

<section class="section">
  <div class="container grid-5 gap-12">
    <div class="col-span-2 stack-8">
      <div class="reveal">
        <h2 class="h3 mb-6">Contact Information</h2>
        <div class="contact-list">
          <a href="<?= PHONE_HREF ?>" class="contact-row">
            <div class="contact-icon accent-bg"><?= icon('phone', 'icon-sm accent') ?></div>
            <div><p class="contact-label">Phone</p><p class="contact-value accent-text-strong"><?= e(PHONE_NUMBER) ?></p></div>
          </a>
          <a href="mailto:<?= e(EMAIL) ?>" class="contact-row">
            <div class="contact-icon"><?= icon('mail', 'icon-sm primary') ?></div>
            <div><p class="contact-label">Email</p><p class="contact-value muted"><?= e(EMAIL) ?></p></div>
          </a>
          <div class="contact-row">
            <div class="contact-icon"><?= icon('map-pin', 'icon-sm primary') ?></div>
            <div><p class="contact-label">Location</p><p class="contact-value muted"><?= e(ADDRESS) ?></p></div>
          </div>
          <div class="contact-row">
            <div class="contact-icon"><?= icon('clock', 'icon-sm primary') ?></div>
            <div>
              <p class="contact-label">Hours</p>
              <div class="small muted">
                <p>Mon-Fri: <?= e(HOURS['weekday']) ?></p>
                <p>Saturday: <?= e(HOURS['saturday']) ?></p>
                <p>Sunday: <?= e(HOURS['sunday']) ?></p>
                <p class="accent-text-strong"><?= e(HOURS['emergency']) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="emergency-box reveal" data-delay="1">
        <div class="emergency-box-head"><?= icon('alert-triangle', 'icon-sm') ?><h3 class="h5">HVAC Emergency?</h3></div>
        <p class="small mb-4">For after-hours emergencies, call our 24/7 emergency line immediately.</p>
        <a href="<?= PHONE_HREF ?>" class="btn btn-danger btn-block"><?= icon('phone', 'icon-sm') ?> Emergency: <?= e(PHONE_NUMBER) ?></a>
      </div>
    </div>
    <div class="col-span-3">
      <div class="card reveal" data-delay="1">
        <h2 class="h3 mb-2">Inquiry Form</h2>
        <p class="small muted mb-6">Share a few details and we'll respond as soon as possible. For emergencies, please call.</p>
        <?php component('service-request-form', [
            'source' => 'contact_page', 'compact' => true, 'defaultService' => 'other',
            'serviceLabel' => 'Topic *', 'servicePlaceholder' => 'General question',
            'messageLabel' => 'Message', 'messagePlaceholder' => 'What can we help with? Include your address if you want an estimate.',
        ]); ?>
      </div>
    </div>
  </div>
</section>

<section class="section bg-muted-50">
  <div class="container reveal">
    <div class="map-card">
      <div class="map-frame">
        <iframe title="Map of Tulsa, Oklahoma" src="https://www.google.com/maps?q=Tulsa,+OK&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
      <div class="map-foot">
        <div class="small muted inline-icon"><?= icon('map-pin', 'icon-xs') ?><span>Serving Tulsa and surrounding communities.</span></div>
        <a href="https://www.google.com/maps/search/?api=1&query=Tulsa%2C%20OK" target="_blank" rel="noopener noreferrer" class="link-accent small">Open in Google Maps</a>
      </div>
    </div>
  </div>
</section>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
