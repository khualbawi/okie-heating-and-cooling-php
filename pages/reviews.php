<?php
$seo = [
    'title' => 'Customer Reviews',
    'description' => 'Read real Google reviews from Tulsa-area homeowners and businesses. See why Okie Heating and Cooling is trusted for honest, reliable HVAC service.',
    'path' => '/reviews',
];
$reviewCount = count(REVIEWS);
$avg = $reviewCount ? array_sum(array_column(REVIEWS, 'rating')) / $reviewCount : 5;
require SITE_ROOT . '/includes/layout/header.php';
$stars5 = str_repeat(icon('star', 'icon-sm star-on'), 5);
?>
<section class="page-hero">
  <div class="container reveal">
    <p class="eyebrow">Reviews</p>
    <h1 class="h1">What Our Customers Say</h1>
    <p class="page-hero-sub">Real reviews from real Tulsa homeowners. We're proud of the trust our community places in us.</p>
  </div>
</section>

<section class="stats-bar">
  <div class="container-md stats-row">
    <div class="stat"><div class="stars center"><?= $stars5 ?></div><p class="stat-value"><?= number_format($avg, 1) ?></p><p class="stat-label">Average Rating</p></div>
    <div class="stat"><p class="stat-value"><?= $reviewCount ?></p><p class="stat-label">Featured Reviews</p></div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="grid-2 gap-6">
      <?php foreach (REVIEWS as $i => $r): ?>
        <div class="reveal" data-delay="<?= min($i, 6) ?>"><?php component('testimonial-card', ['t' => $r]); ?></div>
      <?php endforeach; ?>
    </div>
    <div class="google-box reveal">
      <div class="stars center mb-3"><?= $stars5 ?></div>
      <?php if (has_content('GOOGLE_RATING') && has_content('GOOGLE_REVIEW_COUNT')): ?>
        <p class="h5 mb-1"><?= e(content('GOOGLE_RATING') . ' · ' . content('GOOGLE_REVIEW_COUNT') . ' reviews on Google') ?></p>
      <?php endif; ?>
      <p class="small muted mb-4">See all our reviews on Google Maps</p>
      <div class="btn-row center">
        <a href="https://www.google.com/maps/search/Okie+Heating+and+Cooling+Jenks+OK" target="_blank" rel="noopener noreferrer" class="btn btn-primary">View on Google Maps</a>
        <?php if (has_content('GOOGLE_REVIEW_WRITE_URL')): ?>
          <a href="<?= e(content('GOOGLE_REVIEW_WRITE_URL')) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline">Leave Us a Review</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php component('cta-banner', ['variant' => 'dark', 'headline' => 'Join Our Happy Customers', 'subheadline' => 'Experience the 5-star service Tulsa homeowners trust. Book today.']); ?>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
