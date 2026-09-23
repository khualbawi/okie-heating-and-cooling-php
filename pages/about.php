<?php
$seo = [
    'title' => 'About Okie Heating & Cooling',
    'description' => 'Locally owned HVAC company serving Tulsa, OK with honest pricing, background-checked technicians, and reliable heating and cooling repair service.',
    'path' => '/about',
];
$values = [
    ['heart', 'Customer First', "Every decision we make starts with what's best for you. Your comfort and trust drive everything we do."],
    ['shield-check', 'Honest Work', "We'll never upsell you on a service you don't need. Transparent pricing, clear communication, every time."],
    ['map-pin', 'Locally Invested', 'We live here, we work here, and we care about our Tulsa community. Supporting local is in our DNA.'],
    ['award', 'Expert Technicians', 'Our team is certified, trained, and background-checked. We hire people who take pride in their craft.'],
    ['wrench', 'Quality Workmanship', 'We fix it right the first time. Every repair and installation is backed by our satisfaction guarantee.'],
    ['users', 'Family Values', 'We treat your home like our own — with respect, care, and attention to detail.'],
];
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <p class="eyebrow">About Us</p>
    <h1 class="h1">Tulsa's Trusted HVAC Team</h1>
    <p class="page-hero-sub">Locally owned and operated, Okie Heating and Cooling was built on a simple idea: provide honest, high-quality HVAC service that puts customers first.</p>
  </div>
</section>

<section class="section">
  <div class="container-sm reveal">
    <h2 class="h2 mb-6">Our Story</h2>
    <div class="prose muted">
      <p>Okie Heating and Cooling started with a belief that Tulsa homeowners and businesses deserve better HVAC service — service that's reliable, fairly priced, and delivered by people who genuinely care about their community.</p>
      <p>Too many HVAC companies cut corners, overcharge, or leave customers waiting. We set out to be different. From day one, our approach has been simple: show up on time, diagnose the problem honestly, give a fair price, and do excellent work. That's it. No gimmicks, no high-pressure sales.</p>
      <p>Today, we're proud to serve Tulsa and the surrounding metro area with a full range of heating and cooling services. Whether it's a routine AC tune-up, a complete heating system installation, or a midnight emergency call, we bring the same level of professionalism and care to every single job.</p>
      <p>We're not the biggest HVAC company in Tulsa — but we're working hard to be the most trusted. Every five-star review, every repeat customer, and every referral tells us we're on the right track.</p>
    </div>
  </div>
</section>

<?php if (has_content('OWNER_STORY')): ?>
<section class="section">
  <div class="container-sm reveal">
    <div class="card card-xl">
      <div class="owner-grid">
        <div class="owner-photo-wrap">
          <?php if (has_content('OWNER_PHOTO')): ?>
            <img src="<?= e(content('OWNER_PHOTO')) ?>" alt="Khai<?= has_content('OWNER_LAST_NAME') ? ' ' . e(content('OWNER_LAST_NAME')) : '' ?>, owner of Okie Heating and Cooling" width="200" height="200" loading="lazy" decoding="async">
          <?php else: ?>
            <div class="owner-photo-fallback" aria-hidden="true">K</div>
          <?php endif; ?>
        </div>
        <div>
          <p class="eyebrow">Meet the Owner</p>
          <h2 class="h3 mb-1">Khai<?= has_content('OWNER_LAST_NAME') ? ' ' . e(content('OWNER_LAST_NAME')) : '' ?></h2>
          <?php $ownerMeta = array_filter([
              has_content('YEAR_FOUNDED') ? 'Founder &amp; Owner, est. ' . e(content('YEAR_FOUNDED')) : (has_content('OWNER_CERTS') ? 'Founder &amp; Owner' : null),
              has_content('OWNER_CERTS') ? e(content('OWNER_CERTS')) : null,
          ]); ?>
          <?php if ($ownerMeta): ?><p class="small muted mb-4"><?= implode(' &middot; ', $ownerMeta) ?></p><?php endif; ?>
          <p class="muted"><?= e(content('OWNER_STORY')) ?></p>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section bg-muted-50">
  <div class="container-md text-center reveal">
    <p class="eyebrow">Our Mission</p>
    <h2 class="h2 mb-6">Keeping Tulsa comfortable with honest, expert HVAC service — one home at a time.</h2>
    <p class="lead muted">We measure our success not by the number of jobs we complete, but by the number of customers who call us back and recommend us to their neighbors.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head reveal"><h2 class="h2">What We Stand For</h2></div>
    <div class="grid-3 gap-6">
      <?php foreach ($values as $i => [$ic, $title, $desc]): ?>
        <div class="feature-card reveal" data-delay="<?= $i ?>">
          <div class="feature-icon"><?= icon($ic, 'icon-sm') ?></div>
          <h3 class="feature-title"><?= e($title) ?></h3>
          <p class="feature-desc"><?= e($desc) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section bg-muted-50">
  <div class="container-md text-center reveal">
    <h2 class="h2 mb-4">Licensed, Insured &amp; Certified</h2>
    <p class="muted">Our technicians hold industry certifications including EPA Section 608, NATE, and manufacturer-specific credentials. We're fully licensed and insured for your protection and peace of mind.</p>
    <p class="small muted mt-2">Oklahoma Mechanical License <?= e(LICENSE_NUMBER) ?></p>
  </div>
</section>

<?php component('cta-banner', ['variant' => 'dark', 'headline' => "Ready to Work With Tulsa's Best?", 'subheadline' => 'Experience the Okie difference. Book your HVAC service today.']); ?>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
