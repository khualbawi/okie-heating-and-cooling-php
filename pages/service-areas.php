<?php
$seo = [
    'title' => 'HVAC Service Areas',
    'description' => 'Okie Heating and Cooling serves Tulsa and nearby cities including Broken Arrow, Owasso, Bixby, Jenks, Sand Springs, Sapulpa, and Glenpool, OK.',
    'path' => '/service-areas',
];

$cities = array_values(array_filter(array_map(fn($a) => area_hub($a['slug']), SERVICE_AREAS)));

// Schema: every city we serve, plus any also-serving towns, on the hub itself.
$hubAreaServed = array_map(fn($c) => ['@type' => 'City', 'name' => $c['name'], 'addressRegion' => 'OK'], $cities);
foreach (ALSO_SERVING as $town) {
    $hubAreaServed[] = ['@type' => 'City', 'name' => $town, 'addressRegion' => 'OK'];
}
$seo['jsonLd'] = array_merge(local_business_jsonld(), ['areaServed' => $hubAreaServed]);

// --- ZIP checker: server-side fallback for a no-JS GET submit ---------------
$zipLookup = zip_lookup();
$zipQuery = trim((string) ($_GET['zip'] ?? ''));
$zipResult = null; // ['ok' => bool, 'zip' => string, 'area' => ?array]
if ($zipQuery !== '') {
    $zipDigits = preg_replace('/\D/', '', $zipQuery);
    if (strlen($zipDigits) === 5) {
        $zipResult = ['ok' => isset($zipLookup[$zipDigits]), 'zip' => $zipDigits, 'area' => $zipLookup[$zipDigits] ?? null];
    } else {
        $zipResult = ['ok' => false, 'zip' => $zipDigits !== '' ? $zipDigits : $zipQuery, 'area' => null, 'invalid' => true];
    }
}

require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="hero area-hub-hero">
  <div class="hero-glow-1"></div><div class="hero-glow-2"></div>
  <div class="container area-hub-hero-grid reveal">
    <div>
      <p class="pill tablet-up">Service Areas</p>
      <h1 class="h1 area-hub-h1">HVAC service across the <span class="accent-text">Tulsa metro</span></h1>
      <p class="hero-sub tablet-up">Eight cities, one local team. Check your ZIP to see if we come to you.</p>

      <form class="zip-card" method="get" action="/service-areas" data-zip-form data-phone-href="<?= e(PHONE_HREF) ?>" data-phone="<?= e(PHONE_NUMBER) ?>" novalidate>
        <label for="zip-input">Do we serve your area?</label>
        <div class="zip-row">
          <input id="zip-input" name="zip" type="text" inputmode="numeric" autocomplete="postal-code" maxlength="5" pattern="\d*" placeholder="ZIP code" value="<?= e($zipResult['zip'] ?? '') ?>" data-zip-input>
          <button type="submit" class="btn btn-accent" data-zip-submit>Check</button>
        </div>
        <div class="zip-result" role="status" aria-live="polite" data-zip-result<?php if (!$zipResult): ?> hidden<?php endif; ?>>
          <?php if ($zipResult): ?>
            <?php if (!empty($zipResult['invalid'])): ?>
              <div class="zip-result-box zip-result-invalid">Enter a 5-digit ZIP code.</div>
            <?php elseif ($zipResult['ok']): ?>
              <div class="zip-result-box zip-result-match">
                <p>&#10003; Yes, we serve <?= e($zipResult['zip']) ?> (<?= e($zipResult['area']['name']) ?>)</p>
                <div class="btn-row">
                  <a href="/book?city=<?= e($zipResult['area']['slug']) ?>" class="btn btn-primary btn-sm">Book in <?= e($zipResult['area']['name']) ?></a>
                  <a href="<?= PHONE_HREF ?>" class="btn btn-outline btn-sm"><?= icon('phone', 'icon-xs') ?> Call</a>
                </div>
              </div>
            <?php else: ?>
              <div class="zip-result-box zip-result-miss">
                <p><?= e($zipResult['zip']) ?> is outside our usual area. Call and we'll see what we can do.</p>
                <a href="<?= PHONE_HREF ?>" class="btn btn-outline btn-sm"><?= icon('phone', 'icon-xs') ?> Call <?= e(PHONE_NUMBER) ?></a>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </form>
    </div>
    <div class="area-hub-hero-map tablet-up">
      <?php render_area_map($cities, null, 'lg'); ?>
    </div>
  </div>
</section>

<script type="application/json" id="zip-lookup-data"><?= json_encode($zipLookup, JSON_HEX_TAG) ?></script>

<section class="section">
  <div class="container">
    <div class="section-head reveal">
      <h2 class="h2 tablet-up">Pick your city</h2>
      <h2 class="h2 mobile-only">Our cities</h2>
    </div>

    <div class="area-tabs mobile-only" role="tablist" aria-label="City view">
      <button type="button" class="area-tab is-active" role="tab" aria-selected="true" aria-controls="area-view-list" id="area-tab-list" data-area-tab="list">List</button>
      <button type="button" class="area-tab" role="tab" aria-selected="false" aria-controls="area-view-map" id="area-tab-map" data-area-tab="map">Map</button>
    </div>

    <div id="area-view-list" class="area-row-list mobile-only" role="tabpanel" aria-labelledby="area-tab-list" data-area-panel="list">
      <?php foreach ($cities as $city): ?>
        <a href="/service-areas/<?= e($city['slug']) ?>" class="area-row" data-city="<?= e($city['slug']) ?>">
          <span class="area-row-name"><?= e($city['name']) ?></span>
          <span class="area-row-right">
            <?php if (!empty($city['eta'])): ?><span class="badge-eta"><?= e($city['eta']) ?></span><?php endif; ?>
            <?= icon('chevron-right', 'icon-sm') ?>
          </span>
        </a>
      <?php endforeach; ?>
    </div>

    <div id="area-view-map" class="area-mobile-map-panel mobile-only" role="tabpanel" aria-labelledby="area-tab-map" hidden data-area-panel="map">
      <?php render_area_map($cities, null, 'sm'); ?>
      <p class="small muted text-center mt-3">Tap a city to open its page</p>
    </div>

    <div class="grid-4 gap-6 tablet-up">
      <?php foreach ($cities as $i => $city): ?>
        <a href="/service-areas/<?= e($city['slug']) ?>" class="area-card reveal" data-delay="<?= $i % 4 ?>" data-city="<?= e($city['slug']) ?>">
          <div class="area-card-top">
            <h3 class="area-card-name"><?= e($city['name']) ?></h3>
            <?php if (!empty($city['eta'])): ?><span class="badge-eta"><?= e($city['eta']) ?></span><?php endif; ?>
          </div>
          <?php if (!empty($city['neighborhoods'])): ?>
            <p class="small muted"><?= e(implode(', ', array_slice($city['neighborhoods'], 0, 3))) ?></p>
          <?php endif; ?>
          <?php if (!empty($city['review'])): ?>
            <div class="area-card-review">
              <div class="stars">
                <?php for ($s = 0; $s < 5; $s++): ?><?= icon('star', 'icon-xs ' . ($s < (int) $city['review']['stars'] ? 'star-on' : 'star-off')) ?><?php endfor; ?>
              </div>
              <p class="small muted clamp-2">&ldquo;<?= e($city['review']['quote']) ?>&rdquo;</p>
            </div>
          <?php endif; ?>
          <span class="learn-more">View <?= e($city['name']) ?> HVAC <?= icon('arrow-right', 'icon-xs') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if (!empty(ALSO_SERVING)): ?>
<section class="section-sm bg-muted-50">
  <div class="container-md text-center reveal">
    <p class="also-serving-sentence mobile-only">Also serving <?= e(implode(', ', ALSO_SERVING)) ?>. Not listed? <a href="<?= PHONE_HREF ?>" class="link-accent">Call us</a>.</p>
    <div class="tablet-up">
      <p class="small muted mb-3">Also serving</p>
      <div class="also-serving-chips">
        <?php foreach (ALSO_SERVING as $town): ?><span class="chip"><?= e($town) ?></span><?php endforeach; ?>
      </div>
      <p class="small muted mt-4">Not listed? <a href="<?= PHONE_HREF ?>" class="link-accent">Call us</a>.</p>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="emergency-cta tablet-up">
  <div class="container-md text-center reveal">
    <h2 class="h2">24/7 emergency service in every area we serve</h2>
    <div class="btn-row center">
      <a href="<?= PHONE_HREF ?>" class="btn btn-white btn-lg"><?= icon('phone', 'icon-sm') ?> Call Now: <?= e(PHONE_NUMBER) ?></a>
    </div>
  </div>
</section>

<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
