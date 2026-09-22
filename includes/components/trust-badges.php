<?php
$variant = $variant ?? 'default';
$exclude = $exclude ?? [];
$badges = array_filter([
    ['shield-check', 'Licensed & Insured'],
    ['clock', '24/7 Emergency'],
    ['award', '5-Star Rated'],
    ['thumbs-up', 'Satisfaction Guaranteed'],
    ['star', 'Locally Owned'],
], fn($b) => !in_array($b[1], $exclude, true));
?>
<div class="trust-badges<?= $variant === 'compact' ? ' trust-badges-compact' : '' ?>">
  <?php foreach ($badges as [$ic, $label]): ?>
    <div class="trust-badge"><?= icon($ic, 'icon-xs') ?><span><?= e($label) ?></span></div>
  <?php endforeach; ?>
</div>
