<?php /** @var array $service */ ?>
<a href="/services/<?= e($service['slug']) ?>" class="service-card">
  <div class="service-card-icon"><?= icon($service['icon'], 'icon') ?></div>
  <h3 class="service-card-title"><?= e($service['title']) ?></h3>
  <p class="service-card-desc"><?= e(mb_substr($service['description'], 0, 120)) ?>...</p>
  <span class="learn-more">Learn More <?= icon('arrow-right', 'icon-xs') ?></span>
</a>
