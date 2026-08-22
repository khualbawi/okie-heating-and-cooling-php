<?php
/** @var array $faqs @var string $title @var string|null $subtitle */
if (empty($faqs)) return;
$title    = $title    ?? 'Frequently Asked Questions';
$subtitle = $subtitle ?? null;
?>
<section class="section">
  <div class="container-xs">
    <div class="section-head reveal">
      <h2 class="h2"><?= e($title) ?></h2>
      <?php if ($subtitle): ?><p class="lead muted"><?= e($subtitle) ?></p><?php endif; ?>
    </div>
    <div class="accordion reveal" data-accordion>
      <?php foreach ($faqs as $i => $faq): ?>
        <div class="accordion-item">
          <h3 class="accordion-heading">
            <button type="button" class="accordion-trigger" aria-expanded="false" aria-controls="faq-panel-<?= $i ?>" id="faq-trigger-<?= $i ?>">
              <span><?= e($faq['q']) ?></span>
              <?= icon('chevron-down', 'icon-sm accordion-chevron') ?>
            </button>
          </h3>
          <div class="accordion-panel" id="faq-panel-<?= $i ?>" role="region" aria-labelledby="faq-trigger-<?= $i ?>" hidden>
            <div class="accordion-content"><?= e($faq['a']) ?></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
