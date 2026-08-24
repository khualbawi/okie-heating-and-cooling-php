</main>

<footer class="site-footer">
  <div class="container footer-grid">
    <div class="footer-brand">
      <div class="footer-logo-wrap">
        <img src="/assets/img/okie-logo-nav-260.webp" alt="Okie Heating and Cooling" class="footer-logo" width="500" height="200" loading="lazy" decoding="async">
      </div>
      <p class="footer-tagline">Tulsa's trusted HVAC professionals. Keeping homes and businesses comfortable year-round with honest, quality service.</p>
      <div class="footer-contact">
        <div class="footer-contact-row"><?= icon('phone', 'icon-sm') ?><div><div class="footer-contact-label">Office</div><a href="<?= OFFICE_PHONE_HREF ?>"><?= e(OFFICE_PHONE_NUMBER) ?></a></div></div>
        <div class="footer-contact-row"><?= icon('phone', 'icon-sm') ?><div><div class="footer-contact-label">Emergency (24/7)</div><a href="<?= EMERGENCY_PHONE_HREF ?>"><?= e(EMERGENCY_PHONE_NUMBER) ?></a></div></div>
        <a href="mailto:<?= e(EMAIL) ?>" class="footer-contact-row"><?= icon('mail', 'icon-sm') ?> <?= e(EMAIL) ?></a>
        <div class="footer-contact-row"><?= icon('map-pin', 'icon-sm') ?> <?= e(ADDRESS) ?></div>
        <div class="footer-contact-row align-start"><?= icon('clock', 'icon-sm') ?><div><p>Mon–Fri: <?= e(HOURS['weekday']) ?></p><p>Sat–Sun: Emergency Only</p></div></div>
      </div>
    </div>

    <div>
      <h4 class="footer-heading">Our Services</h4>
      <nav class="footer-links">
        <?php foreach (array_slice(SERVICES, 0, 8) as $svc): ?>
          <a href="/services/<?= e($svc['slug']) ?>"><?= e($svc['title']) ?></a>
        <?php endforeach; ?>
        <a href="/services" class="footer-link-accent">View All Services →</a>
      </nav>
    </div>

    <div>
      <h4 class="footer-heading">Service Areas</h4>
      <nav class="footer-links">
        <?php foreach (SERVICE_AREAS as $area): ?>
          <a href="/service-areas/<?= e($area['slug']) ?>"><?= e($area['name']) ?>, OK</a>
        <?php endforeach; ?>
      </nav>
    </div>

    <div>
      <h4 class="footer-heading">Quick Links</h4>
      <nav class="footer-links">
        <a href="/book">Book Service</a>
        <a href="/contact">Contact Us</a>
        <a href="/about">About Us</a>
        <a href="/reviews">Reviews</a>
        <a href="/financing">Financing</a>
        <a href="/maintenance-plan">Maintenance Plan</a>
      </nav>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container footer-bottom-inner">
      <p>© <?= date('Y') ?> Okie Heating and Cooling. All rights reserved. Licensed &amp; Insured.</p>
      <div class="footer-bottom-meta"><span>Tulsa, Oklahoma</span><span><?= e(LICENSE_NUMBER) ?></span></div>
    </div>
  </div>
</footer>

<div class="mobile-cta">
  <a href="<?= PHONE_HREF ?>" class="mobile-cta-call"><?= icon('phone', 'icon-sm') ?> Call Now</a>
  <a href="/book" class="mobile-cta-book"><?= icon('calendar', 'icon-sm') ?> Book Service</a>
</div>
<div class="mobile-cta-spacer"></div>

<script src="/assets/js/main.js?v=<?= @filemtime(SITE_ROOT . '/assets/js/main.js') ?: '1' ?>" defer></script>
<?php if (GA_MEASUREMENT_ID !== ''): ?>
<script>
  /* Load gtag.js once the page is interactive — or sooner if the visitor acts.
     Events fired before this land in dataLayer and replay on load. */
  (function () {
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
