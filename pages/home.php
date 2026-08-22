<?php
$seo = [
    'title' => 'Tulsa HVAC Repair, Installation & Maintenance',
    'description' => 'Okie Heating & Cooling provides trusted HVAC services in Tulsa, OK. AC repair, heating repair, installation, maintenance, and 24/7 emergency service.',
    'path' => '/',
    'extraJsonLd' => faq_jsonld(HOME_FAQS),
];
$whyUs = [
    ['clock', 'Fast Response', "Same-day service and 24/7 emergency availability. We know comfort can't wait."],
    ['shield', 'Licensed & Insured', 'Fully licensed, insured, and background-checked technicians you can trust in your home.'],
    ['zap', 'Upfront Pricing', 'No surprises. We provide clear, honest pricing before any work begins.'],
    ['users', 'Locally Owned', "We're your Tulsa neighbors. Invested in our community and your comfort."],
    ['star', '5-Star Service', 'Hundreds of satisfied customers across the Tulsa metro trust us for their HVAC needs.'],
    ['check-circle', 'Guaranteed Work', 'We stand behind every repair and installation with a satisfaction guarantee.'],
];
require SITE_ROOT . '/includes/layout/header.php';
?>

<section class="hero hero-home">
  <div class="hero-glow-1"></div><div class="hero-glow-2"></div>
  <div class="container hero-inner">
    <div class="hero-text">
      <div class="pill reveal"><?= icon('map-pin', 'icon-xs') ?> Serving Tulsa &amp; Surrounding Areas</div>
      <h1 class="hero-title reveal" data-delay="1">Reliable Heating &amp; Cooling<span class="accent-text">for Tulsa, Oklahoma</span></h1>
      <p class="hero-sub reveal" data-delay="2">Fast HVAC repairs, expert installations, and preventive maintenance you can count on. Keeping Tulsa homes and businesses comfortable year-round.</p>
      <div class="btn-row reveal" data-delay="3">
        <a href="/book" class="btn btn-accent btn-lg">Book Service <?= icon('arrow-right', 'icon-sm') ?></a>
        <a href="<?= PHONE_HREF ?>" class="btn btn-secondary btn-lg"><?= icon('phone', 'icon-sm') ?> Call <?= e(PHONE_NUMBER) ?></a>
      </div>
      <div class="hero-badges reveal" data-delay="4"><?php component('trust-badges', ['variant' => 'compact']); ?></div>
    </div>
    <div class="hero-logo reveal" data-delay="2">
      <img src="/assets/img/okie-logo-hero.png" alt="Okie Heating and Cooling" width="1024" height="409">
    </div>
  </div>
</section>

<section class="trust-bar"><div class="container"><?php component('trust-badges'); ?></div></section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <p class="eyebrow">Why Okie</p>
      <h2 class="h2">Why Tulsa Trusts Us</h2>
      <p class="lead muted">We're not just another HVAC company. We're your neighbors, committed to honest work and exceptional service.</p>
    </div>
    <div class="grid-3 gap-6">
      <?php foreach ($whyUs as $i => [$ic, $title, $desc]): ?>
        <div class="feature-card reveal" data-delay="<?= $i ?>">
          <div class="feature-icon"><?= icon($ic, 'icon-sm') ?></div>
          <h3 class="feature-title"><?= e($title) ?></h3>
          <p class="feature-desc"><?= e($desc) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="btn-row center mt-10 reveal">
      <a href="/services" class="btn btn-outline btn-lg">View Our Services <?= icon('arrow-right', 'icon-sm') ?></a>
      <a href="/about" class="btn btn-ghost btn-lg">About Us <?= icon('arrow-right', 'icon-sm') ?></a>
    </div>
  </div>
</section>

<section class="emergency-cta">
  <div class="container-md text-center reveal">
    <h2 class="h2">🔥 HVAC Emergency? We're Available 24/7.</h2>
    <p class="emergency-sub">No heat in winter? AC down in summer? Don't wait — our emergency technicians are standing by right now.</p>
    <div class="btn-row center">
      <a href="<?= PHONE_HREF ?>" class="btn btn-white btn-lg"><?= icon('phone', 'icon-sm') ?> Call Now: <?= e(PHONE_NUMBER) ?></a>
      <a href="/services/emergency-hvac" class="btn btn-outline-white btn-lg">Emergency Service <?= icon('arrow-right', 'icon-sm') ?></a>
    </div>
  </div>
</section>

<section class="section bg-muted-50">
  <div class="container-md">
    <div class="card card-xl text-center reveal">
      <p class="eyebrow">Flexible Options</p>
      <h2 class="h2">Financing &amp; Special Offers</h2>
      <p class="lead muted mb-8">Quality HVAC service shouldn't break the bank. Ask about our financing options and seasonal specials to keep your home comfortable on any budget.</p>
      <div class="btn-row center">
        <a href="/financing" class="btn btn-accent btn-lg">View Offers <?= icon('arrow-right', 'icon-sm') ?></a>
        <a href="/maintenance-plan" class="btn btn-outline btn-lg">Maintenance Plans <?= icon('arrow-right', 'icon-sm') ?></a>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <p class="eyebrow">Reviews</p>
      <h2 class="h2">What Our Customers Say</h2>
      <p class="lead muted">Don't just take our word for it — hear from Tulsa homeowners who trust Okie Heating and Cooling.</p>
    </div>
    <div class="grid-2 gap-6">
      <?php foreach (HOME_TESTIMONIALS as $i => $t): ?>
        <div class="reveal" data-delay="<?= $i ?>"><?php component('testimonial-card', ['t' => $t]); ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php component('faq-section', ['faqs' => HOME_FAQS, 'title' => 'Common Questions', 'subtitle' => 'Quick answers about our HVAC services in Tulsa']); ?>

<?php component('cta-banner', ['variant' => 'dark']); ?>

<section class="seo-block">
  <div class="container-sm prose">
    <h3>Your Trusted HVAC Company in Tulsa, Oklahoma</h3>
    <p>Okie Heating and Cooling is a locally owned and operated HVAC company proudly serving Tulsa, Oklahoma and the surrounding communities including Broken Arrow, Owasso, Bixby, Jenks, Sand Springs, Sapulpa, and Glenpool. We specialize in residential and commercial heating and cooling services including AC repair, heating repair, furnace installation, air conditioning installation, indoor air quality solutions, and 24/7 emergency HVAC service.</p>
    <p>Whether you need a quick AC repair on a hot Tulsa summer day or a complete heating system installation before winter, our certified technicians deliver fast, reliable service with upfront pricing and a satisfaction guarantee. We service all major HVAC brands and are committed to keeping Tulsa homes and businesses comfortable year-round.</p>
  </div>
</section>

<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
