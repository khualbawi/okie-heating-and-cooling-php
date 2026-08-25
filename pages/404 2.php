<?php
$seo = ['title' => 'Page Not Found', 'noindex' => true, 'path' => current_path()];
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="section-lg text-center">
  <div class="container-xs">
    <div class="notfound-badge">404</div>
    <h1 class="h3 mb-3">Page Not Found</h1>
    <p class="muted mb-8">The page you're looking for doesn't exist or has been moved. Let's get you back on track.</p>
    <div class="btn-row center">
      <a href="/" class="btn btn-accent"><?= icon('home', 'icon-sm') ?> Go Home</a>
      <a href="/services" class="btn btn-outline"><?= icon('arrow-left', 'icon-sm') ?> View Services</a>
    </div>
  </div>
</section>
<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
