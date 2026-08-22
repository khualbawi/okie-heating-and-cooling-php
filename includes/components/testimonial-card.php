<?php /** @var array $t */ ?>
<div class="testimonial-card">
  <div class="stars">
    <?php for ($i = 0; $i < 5; $i++): ?>
      <?= icon('star', 'icon-xs ' . ($i < (int) $t['rating'] ? 'star-on' : 'star-off')) ?>
    <?php endfor; ?>
  </div>
  <p class="testimonial-text">"<?= e($t['text']) ?>"</p>
  <div class="testimonial-meta">
    <div class="avatar"><?= e(mb_substr($t['customer_name'], 0, 1)) ?></div>
    <div>
      <p class="testimonial-name"><?= e($t['customer_name']) ?></p>
      <p class="testimonial-loc"><?= e($t['location'] ?? 'Tulsa, OK') ?></p>
    </div>
    <?php if (!empty($t['verified'])): ?><span class="badge-verified">Verified</span><?php endif; ?>
  </div>
</div>
