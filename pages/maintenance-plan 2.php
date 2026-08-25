<?php
$seo = [
    'title' => 'HVAC Maintenance Plans',
    'description' => 'Prevent breakdowns and save money with a maintenance membership. Priority scheduling, discounts, and seasonal tune-ups in Tulsa, OK.',
    'path' => '/maintenance-plan',
];
$springItems = ['Clean and flush condensation drain pipe', 'Condenser deep cleaning', 'Test condenser fan & compressor run capacitors (MFD)', 'Check voltage and electrical current to condenser unit', 'Replace filters (up to 2)', 'Remove leaves, twigs, and debris from around condenser', 'Check refrigerant levels if needed', 'Test Delta-T for cooling performance'];
$fallItems = ['Clean high-efficiency furnace condensation drain line', 'Clean flame sensor and check for gas', 'Replace filters (up to 2)', 'Inspect heat exchanger tubing for cracks', 'Test ignition system', 'Test CO levels', 'Check heat exchanger integrity', 'Test Delta-T for heating performance'];
$springSpecial = ['1" Air Filter Replacement', 'Light Cleaning of Outdoor Condenser', 'Check Electrical Components (Capacitor & Amp Draw)', 'Inspect Condenser Unit Condition', 'Measure Temperature Split (Delta-T)', 'Check Refrigeration Performance', 'Flush Condensate Drain Line'];
$benefits = [
    ['shield-check', 'Prevent Breakdowns', 'Catch small issues before they become expensive emergencies.'],
    ['dollar-sign', 'Save Money', 'Well-maintained systems use less energy and need fewer repairs.'],
    ['wrench', 'Extend Lifespan', "Proper maintenance adds years to your HVAC system's life."],
    ['calendar', 'Priority Service', 'Members get priority scheduling year-round.'],
];
$enrolled = ($_GET['submitted'] ?? '') === '1';
$enrollError = $_GET['error'] ?? '';
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="hero hero-center">
  <div class="hero-glow-1"></div><div class="hero-glow-2"></div>
  <div class="container-md hero-inner-center reveal">
    <div class="pill"><?= icon('star', 'icon-xs star-on') ?> Annual Maintenance Membership</div>
    <h1 class="hero-title">Keep Your System<br><span class="accent-text">Running All Year Long</span></h1>
    <p class="hero-sub center">Two seasonal visits — Spring cooling tune-up &amp; Fall heating tune-up — plus exclusive member savings.</p>
  </div>
</section>

<section class="section-sm">
  <div class="container-md">
    <div class="section-head reveal">
      <h2 class="h2">Why Maintenance Matters</h2>
      <p class="muted">Regular maintenance prevents emergencies, saves money, and extends your system's life.</p>
    </div>
    <div class="grid-4-2 gap-4">
      <?php foreach ($benefits as $i => [$ic, $t, $d]): ?>
        <div class="feature-card feature-card-sm text-center reveal" data-delay="<?= $i ?>">
          <div class="feature-icon center"><?= icon($ic, 'icon-sm') ?></div>
          <h3 class="h6"><?= e($t) ?></h3>
          <p class="xs muted"><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section-sm bg-muted-50">
  <div class="container-md">
    <div class="section-head reveal">
      <span class="tag">Annual Plan</span>
      <h2 class="h2">Two Visits Per Year</h2>
    </div>
    <div class="grid-2 gap-6">
      <div class="visit-card reveal" data-delay="1">
        <div class="visit-head visit-head-spring"><div class="visit-icon"><?= icon('snowflake', 'icon-sm') ?></div><div><h3 class="h5">Spring Visit</h3><p class="xs">Cooling System Tune-Up</p></div></div>
        <ul class="check-list check-list-sm">
          <?php foreach ($springItems as $it): ?><li><?= icon('check-circle', 'icon-xs sky') ?><span><?= e($it) ?></span></li><?php endforeach; ?>
        </ul>
      </div>
      <div class="visit-card reveal" data-delay="2">
        <div class="visit-head visit-head-fall"><div class="visit-icon"><?= icon('flame', 'icon-sm') ?></div><div><h3 class="h5">Fall Visit</h3><p class="xs">Heating System Tune-Up</p></div></div>
        <ul class="check-list check-list-sm">
          <?php foreach ($fallItems as $it): ?><li><?= icon('check-circle', 'icon-xs orange') ?><span><?= e($it) ?></span></li><?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="member-box reveal" data-delay="2">
      <h3 class="member-title">Member Benefits Included</h3>
      <div class="grid-3 gap-4 mb-7">
        <?php foreach ([['$0', 'Service Call Fee'], ['$0', 'After-Hours Fee'], ['15% Off', 'All Repairs']] as [$v, $l]): ?>
          <div class="member-stat"><div class="member-stat-value"><?= e($v) ?></div><div class="member-stat-label"><?= e($l) ?></div></div>
        <?php endforeach; ?>
      </div>
      <?php if ($enrolled): ?>
        <div class="member-form text-center">
          <?= icon('check-circle-big', 'icon-xl accent center mb-3') ?>
          <p class="h5 mb-1">Thanks<?= !empty($_GET['name']) ? ', ' . e($_GET['name']) : '' ?>!</p>
          <p class="small member-muted">We'll be in touch shortly to get you enrolled.</p>
        </div>
      <?php else: ?>
        <div class="member-form">
          <p class="h6 text-center mb-4">Sign Up for the Maintenance Plan</p>
          <form method="post" action="/api/submit-request" class="stack-3" data-request-form data-success-message="Thanks! We'll be in touch shortly to get you enrolled." novalidate>
            <input type="hidden" name="form_source" value="maintenance-plan-page">
            <input type="hidden" name="service_type" value="maintenance_plan">
            <input type="hidden" name="issue_description" value="Interested in Annual Maintenance Plan membership.">
            <input type="hidden" name="redirect" value="/maintenance-plan">
            <input type="hidden" name="_ts" value="<?= time() ?>">
            <div class="hp-field" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
            <?php if ($enrollError): ?><div class="form-alert" role="alert"><?= e($enrollError) ?></div><?php endif; ?>
            <div class="form-alert" role="alert" data-form-error hidden></div>
            <input required type="text" name="name" placeholder="Your Name" class="input-plain" aria-label="Your name">
            <input required type="tel" name="phone" placeholder="Phone Number" class="input-plain" aria-label="Phone number">
            <input type="email" name="email" placeholder="Email (optional)" class="input-plain" aria-label="Email">
            <button type="submit" class="btn btn-accent btn-lg btn-block" data-submit-btn>
              <span class="btn-spinner" hidden><?= icon('loader', 'icon-sm spin') ?></span>
              <span class="btn-arrow"><?= icon('send', 'icon-sm') ?></span>
              <span data-submit-label>Request Enrollment</span>
            </button>
          </form>
          <template data-success-template>
            <div class="text-center">
              <?= icon('check-circle-big', 'icon-xl accent center mb-3') ?>
              <p class="h5 mb-1">Thanks!</p>
              <p class="small member-muted">We'll be in touch shortly to get you enrolled.</p>
            </div>
          </template>
          <div class="or-divider"><span>or</span></div>
          <a href="<?= OFFICE_PHONE_HREF ?>" class="member-call"><?= icon('phone', 'icon-sm') ?> Call us: <?= e(OFFICE_PHONE_NUMBER) ?></a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="special-section">
  <div class="container-xs reveal">
    <div class="text-center mb-8">
      <div class="pill pill-green"><?= icon('leaf', 'icon-xs') ?> Limited Time Offer</div>
      <h2 class="h2 green-900">Spring A/C Maintenance Special</h2>
      <p class="small green-700 mt-2">One-Time Service — No Membership Required</p>
    </div>
    <div class="special-card">
      <p class="small text-center mb-5 muted">Keep your system running smooth and ready for the Oklahoma heat!</p>
      <ul class="check-list check-list-sm mb-6">
        <?php foreach ($springSpecial as $it): ?><li><?= icon('check-circle', 'icon-xs green') ?><span><?= e($it) ?></span></li><?php endforeach; ?>
      </ul>
      <div class="note-box"><?= icon('alert-triangle', 'icon-xs amber') ?><p class="small"><strong>Note:</strong> Preventive tune-up only — not a diagnostic or repair service call.</p></div>
      <a href="<?= OFFICE_PHONE_HREF ?>" class="btn btn-green btn-lg btn-block"><?= icon('phone', 'icon-sm') ?> Call or Text: <?= e(OFFICE_PHONE_NUMBER) ?></a>
    </div>
  </div>
</section>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
