</main>

<footer class="site-footer">
  <div class="container footer-grid">
    <div class="footer-brand">
      <div class="footer-logo-wrap">
        <img src="/assets/img/okie-logo-nav-260.webp" alt="Okie Heating and Cooling" class="footer-logo" width="500" height="200" loading="lazy" decoding="async">
      </div>
      <p class="footer-tagline">Tulsa's trusted HVAC professionals. Keeping homes and businesses comfortable year-round with honest, quality service.</p>

      <div class="footer-contact tablet-up">
        <div class="footer-contact-row"><?= icon('phone', 'icon-sm') ?><div><div class="footer-contact-label">Office &amp; 24/7 Emergency</div><a href="<?= OFFICE_PHONE_HREF ?>"><?= e(OFFICE_PHONE_NUMBER) ?></a></div></div>
        <a href="mailto:<?= e(EMAIL) ?>" class="footer-contact-row"><?= icon('mail', 'icon-sm') ?> <?= e(EMAIL) ?></a>
        <div class="footer-contact-row"><?= icon('map-pin', 'icon-sm') ?> <?= e(ADDRESS) ?></div>
        <div class="footer-contact-row align-start"><?= icon('clock', 'icon-sm') ?><div><p>Mon–Fri: <?= e(HOURS['weekday']) ?></p><p>Sat–Sun: Emergency Only</p></div></div>
      </div>

      <div class="footer-contact-mobile mobile-only">
        <div class="footer-contact-btns">
          <a href="<?= OFFICE_PHONE_HREF ?>" class="footer-contact-btn"><?= icon('phone', 'icon-sm') ?> Call</a>
          <a href="mailto:<?= e(EMAIL) ?>" class="footer-contact-btn"><?= icon('mail', 'icon-sm') ?> Email</a>
        </div>
        <p class="footer-hours-line"><?= icon('clock', 'icon-xs') ?> Mon–Fri <?= e(HOURS['weekday']) ?> &middot; Weekends: emergency only</p>
      </div>
    </div>

    <?php
    // Captured once, rendered twice below (plain column on desktop, native
    // <details> accordion on mobile) — native details/summary collapse in
    // current Chrome clips its content via an internal box that a CSS
    // `display` override on the content can't reach, so forcing one closed
    // <details> to *look* open on desktop isn't reliable. Two small wrappers
    // around one captured block sidesteps that instead of fighting it.
    ob_start(); ?>
      <nav class="footer-links">
        <?php foreach (array_slice(SERVICES, 0, 8) as $svc): ?>
          <a href="/services/<?= e($svc['slug']) ?>"><?= e($svc['title']) ?></a>
        <?php endforeach; ?>
        <a href="/services" class="footer-link-accent">View All Services →</a>
      </nav>
    <?php $footerServicesNav = ob_get_clean();

    ob_start(); ?>
      <nav class="footer-links">
        <?php foreach (SERVICE_AREAS as $area): ?>
          <a href="/service-areas/<?= e($area['slug']) ?>"><?= e($area['name']) ?>, OK</a>
        <?php endforeach; ?>
      </nav>
    <?php $footerAreasNav = ob_get_clean();

    ob_start(); ?>
      <nav class="footer-links">
        <a href="/book">Book Service</a>
        <a href="/contact">Contact Us</a>
        <a href="/about">About Us</a>
        <a href="/reviews">Reviews</a>
        <?php if (has_content('GOOGLE_REVIEW_WRITE_URL')): ?>
          <a href="<?= e(content('GOOGLE_REVIEW_WRITE_URL')) ?>" target="_blank" rel="noopener noreferrer">Leave Us a Review</a>
        <?php endif; ?>
        <a href="/financing">Financing</a>
        <a href="/maintenance-plan">Maintenance Plan</a>
      </nav>
    <?php $footerQuickNav = ob_get_clean();

    $footerCols = ['Our Services' => $footerServicesNav, 'Service Areas' => $footerAreasNav, 'Quick Links' => $footerQuickNav];
    foreach ($footerCols as $label => $nav): ?>
      <div class="tablet-up">
        <h4 class="footer-heading"><?= e($label) ?></h4>
        <?= $nav ?>
      </div>
      <details class="footer-accordion mobile-only">
        <summary class="footer-heading"><?= e($label) ?></summary>
        <?= $nav ?>
      </details>
    <?php endforeach; ?>
  </div>
  <div class="footer-bottom">
    <div class="container footer-bottom-inner">
      <p>© <?= date('Y') ?> Okie Heating and Cooling. All rights reserved. Oklahoma Mechanical License <?= e(LICENSE_NUMBER) ?> · Licensed &amp; Insured.</p>
      <nav class="footer-legal-links" aria-label="Legal">
        <a href="/privacy">Privacy Policy</a>
        <a href="/terms">Terms of Use</a>
        <a href="/accessibility">Accessibility</a>
      </nav>
      <div class="footer-bottom-meta tablet-up"><span>Tulsa, Oklahoma</span></div>
      <p class="footer-credit">Powered by <a href="https://khual.net/?utm_source=okieheatingandcooling&amp;utm_medium=referral&amp;utm_campaign=powered_by" target="_blank" rel="noopener" aria-label="KhualWS (opens in a new tab)">KhualWS</a></p>
    </div>
  </div>
</footer>

<?php $onAreasHub = current_path() === '/service-areas'; ?>
<?php if ($onAreasHub): ?><div class="mobile-cta-note">🔥 24/7 emergency service in every area</div><?php endif; ?>
<div class="mobile-cta">
  <a href="<?= PHONE_HREF ?>" class="mobile-cta-call"><?= icon('phone', 'icon-sm') ?> Call Now</a>
  <a href="/book" class="mobile-cta-book"><?= icon('calendar', 'icon-sm') ?> Book Service</a>
</div>
<div class="mobile-cta-spacer<?= $onAreasHub ? ' has-note' : '' ?>"></div>

<script src="/assets/js/main.js?v=<?= deploy_version() ?>" defer></script>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<?php if (GA_MEASUREMENT_ID !== ''): ?>
<script>
  /* Load gtag.js once the page is interactive — or sooner if the visitor acts.
     Events fired before this land in dataLayer and replay on load. */
  (function () {
    if (window.__gaBlocked) return; // Global Privacy Control — never load gtag.js
    var loaded = false;
    function loadGa() {
      if (loaded) return;
      loaded = true;
      var s = document.createElement('script');
      s.async = true;
      s.src = 'https://www.googletagmanager.com/gtag/js?id=<?= e(GA_MEASUREMENT_ID) ?>';
      document.head.appendChild(s);
    }
    ['pointerdown', 'keydown', 'touchstart', 'scroll'].forEach(function (ev) {
      window.addEventListener(ev, loadGa, { once: true, passive: true });
    });
    if (document.readyState === 'complete') setTimeout(loadGa, 1500);
    else window.addEventListener('load', function () { setTimeout(loadGa, 1500); });
  })();
</script>
<?php endif; ?>
</body>
</html>
<!-- v:<?= e(deploy_version()) ?> -->
<?php echo strip_raw_placeholders(ob_get_clean()); ?>
