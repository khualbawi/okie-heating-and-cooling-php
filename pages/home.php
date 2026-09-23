<?php
$seo = [
    'title' => 'Tulsa HVAC Repair & Installation | Okie Heating & Cooling',
    'description' => 'Okie Heating & Cooling provides trusted HVAC services in Tulsa, OK. AC repair, heating repair, installation, maintenance, and 24/7 emergency service.',
    'path' => '/',
    'extraJsonLd' => faq_jsonld(HOME_FAQS),
];
$whyUs = [
    ['clock', 'Fast Response', "Same-day service and 24/7 emergency availability. We know comfort can't wait."],
    ['shield', 'Licensed & Insured', 'Fully licensed (' . LICENSE_NUMBER . '), insured, and background-checked technicians you can trust in your home.'],
    ['zap', 'Upfront Pricing', 'No surprises. We provide clear, honest pricing before any work begins.'],
    ['users', 'Locally Owned', "We're your Tulsa neighbors. Invested in our community and your comfort."],
    ['star', '5-Star Service', 'Rated 5.0★ on Google by Tulsa homeowners.', content('GOOGLE_REVIEWS_URL')],
    ['check-circle', 'Guaranteed Work', 'We stand behind every repair and installation with a satisfaction guarantee.'],
];
require SITE_ROOT . '/includes/layout/header.php';
?>

<section class="hero hero-home">
  <div class="hero-glow-1"></div><div class="hero-glow-2"></div>
  <img src="/assets/img/okie-mark-watermark.webp" alt="" aria-hidden="true" class="hero-watermark" width="808" height="640" loading="lazy">
  <div class="container hero-inner">
    <img src="/assets/img/okie-logo-hero.webp" srcset="/assets/img/okie-logo-hero-640.webp 640w, /assets/img/okie-logo-hero.webp 1024w" sizes="340px" alt="Okie Heating and Cooling" width="1024" height="409" class="hero-logo-mark hero-area-logo reveal" fetchpriority="high" decoding="async">
    <h1 class="hero-title hero-area-h1 reveal" data-delay="1">Reliable Heating &amp; Cooling<span class="accent-text">for Tulsa, Oklahoma</span></h1>
    <p class="hero-sub hero-area-sub reveal" data-delay="2">Fast HVAC repairs, expert installations, and preventive maintenance you can count on. Keeping Tulsa homes and businesses comfortable year-round.</p>
    <div class="btn-row hero-area-btns reveal" data-delay="3">
      <a href="/book" class="btn btn-accent btn-lg">Book Service <?= icon('arrow-right', 'icon-sm') ?></a>
      <a href="<?= PHONE_HREF ?>" class="btn btn-secondary btn-lg"><?= icon('phone', 'icon-sm') ?> Call <?= e(PHONE_NUMBER) ?></a>
    </div>
    <div class="hero-quote hero-area-form reveal" data-delay="2">
      <div class="hero-quote-card">
        <h2 class="h4">Get a Fast Quote</h2>
        <?php component('service-request-form', [
            'source' => 'homepage_hero', 'compact' => true,
            'serviceLabel' => 'What do you need? *', 'servicePlaceholder' => 'Select an issue',
            'messageLabel' => 'Details (optional)', 'messagePlaceholder' => 'Tell us what\'s going on.',
        ]); ?>
      </div>
    </div>
    <div class="hero-badges hero-area-trust reveal" data-delay="4"><?php component('trust-badges', ['variant' => 'compact', 'exclude' => ['24/7 Emergency', 'Satisfaction Guaranteed']]); ?></div>
  </div>
</section>

<?php
$homeServiceSlugs = ['ac-repair', 'ac-installation', 'ac-maintenance', 'heating-repair', 'heating-installation', 'heating-maintenance', 'furnace-repair', 'furnace-installation', 'emergency-hvac'];
$homeServices = array_filter(SERVICES, fn($s) => in_array($s['slug'], $homeServiceSlugs, true));
?>
<section class="section bg-muted-50">
  <div class="container">
    <div class="section-head reveal">
      <p class="eyebrow">What We Do</p>
      <h2 class="h2">Our Services</h2>
      <p class="lead muted">Full-service heating and cooling care for Tulsa homes and businesses.</p>
    </div>
    <div class="grid-3 gap-6">
      <?php foreach (array_values($homeServices) as $i => $svc): ?>
        <div class="reveal" data-delay="<?= $i % 6 ?>"><?php component('service-card', ['service' => $svc]); ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <p class="eyebrow">Why Okie</p>
      <h2 class="h2">Why Tulsa Trusts Us</h2>
      <p class="lead muted">We're not just another HVAC company. We're your neighbors, committed to honest work and exceptional service.</p>
    </div>
    <div class="grid-3 gap-6">
      <?php foreach ($whyUs as $i => $w): [$ic, $title, $desc] = $w; $link = $w[3] ?? null; ?>
        <div class="feature-card reveal" data-delay="<?= $i ?>">
          <div class="feature-icon"><?= icon($ic, 'icon-sm') ?></div>
          <h3 class="feature-title"><?= e($title) ?></h3>
          <p class="feature-desc">
            <?= e($desc) ?>
            <?php if ($link): ?> <a href="<?= e($link) ?>" target="_blank" rel="noopener noreferrer" class="link-accent">See reviews</a><?php endif; ?>
          </p>
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

<?php component('brand-strip'); ?>

<?php component('faq-section', ['faqs' => HOME_FAQS, 'title' => 'Common Questions', 'subtitle' => 'Quick answers about our HVAC services in Tulsa']); ?>

<?php component('cta-banner', ['variant' => 'dark', 'showPhone' => false]); ?>

<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
