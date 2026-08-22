<?php
/** @var string $headline @var string $subheadline @var string $variant */
$headline    = $headline    ?? 'Ready to Get Comfortable?';
$subheadline = $subheadline ?? "Book your HVAC service today or call us for immediate assistance. We're here to help Tulsa stay comfortable.";
$variant     = $variant     ?? 'default';
$dark = $variant === 'dark';
?>
<section class="cta-banner <?= $dark ? 'cta-banner-dark' : 'cta-banner-light' ?>">
  <div class="container-sm text-center reveal">
    <h2 class="h2"><?= e($headline) ?></h2>
    <p class="cta-sub"><?= e($subheadline) ?></p>
    <div class="btn-row center">
      <a href="/book" class="btn btn-accent btn-lg">Book Service <?= icon('arrow-right', 'icon-sm') ?></a>
      <a href="<?= PHONE_HREF ?>" class="btn <?= $dark ? 'btn-secondary' : 'btn-outline' ?> btn-lg"><?= icon('phone', 'icon-sm') ?> <?= e(PHONE_NUMBER) ?></a>
    </div>
  </div>
</section>
