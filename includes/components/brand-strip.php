<?php /** No logo files on hand yet — text badges, grayscale->color on hover. */ ?>
<section class="section-sm brand-strip-section">
  <div class="container">
    <p class="brand-strip-label">Brands We Service</p>
    <div class="brand-strip">
      <?php foreach (BRANDS_SERVICED as $brand): ?>
        <span class="brand-badge"><?= e($brand) ?></span>
      <?php endforeach; ?>
    </div>
  </div>
</section>
