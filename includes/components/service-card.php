<?php
/** @var array $service @var bool $compact (icon + title only, no description — for pages that list every service, like /service-areas/*, to avoid repeating the same description paragraphs page after page) */
$compact = $compact ?? false;
?>
<a href="/services/<?= e($service['slug']) ?>" class="service-card<?= $compact ? ' service-card-compact' : '' ?>">
  <div class="service-card-icon"><?= icon($service['icon'], 'icon') ?></div>
  <h3 class="service-card-title"><?= e($service['title']) ?></h3>
  <?php if (!$compact): ?>
    <p class="service-card-desc"><?= e(mb_substr($service['description'], 0, 120)) ?>...</p>
  <?php endif; ?>
  <span class="learn-more">Learn More <?= icon('arrow-right', 'icon-xs') ?></span>
</a>
