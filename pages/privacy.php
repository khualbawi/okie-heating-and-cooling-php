<?php
$seo = [
    'title' => 'Privacy Policy | Okie Heating & Cooling',
    'description' => 'How Okie Heating and Cooling collects, uses, and protects your information, including SMS and Google Analytics cookie details.',
    'path' => '/privacy',
];
$lastUpdated = 'September 23, 2026';
require SITE_ROOT . '/includes/layout/header.php';
?>
<section class="page-hero">
  <div class="container reveal">
    <h1 class="h1">Privacy Policy</h1>
    <p class="page-hero-sub">Last updated: <?= e($lastUpdated) ?></p>
  </div>
</section>

<section class="section">
  <div class="container-md legal-content reveal">
    <p class="legal-draft-notice"><strong>DRAFT — pending owner/attorney review.</strong> This page is written in plain English to describe our actual data practices, but has not yet been reviewed by an attorney.</p>

    <h2>Who we are</h2>
    <p><?= e(BRAND_LEGAL) ?> provides HVAC repair, installation, and maintenance services in Tulsa, Oklahoma and the surrounding area. You can reach us at <a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a> or <a href="<?= OFFICE_PHONE_HREF ?>"><?= e(OFFICE_PHONE_NUMBER) ?></a>.</p>

    <h2>What we collect</h2>
    <p>When you submit a form on this site, we collect the information you provide: your name, phone number, email, service address, a description of your issue, and scheduling preferences.</p>
    <p>We also collect technical data automatically, including your IP address, browser type, and the pages you visit, via Google Analytics cookies. Forms on this site are protected by Cloudflare Turnstile, a bot-detection check.</p>

    <h2>Why we collect it</h2>
    <p>We use this information to respond to your request, schedule and confirm service, send you appointment and service-related communications, improve this website, and prevent spam and fraudulent submissions.</p>

    <h2>Sharing</h2>
    <p>We share information only with the service providers who help us run this site and our business: our hosting provider (Hostinger), Cloudflare, Google Analytics, and our email provider. We never sell your information.</p>

    <h2>SMS messaging</h2>
    <p>If you opt in, we may text you about your service request. Message frequency varies. Message and data rates may apply. Reply STOP to opt out at any time, or HELP for help. Your mobile opt-in information and consent are not shared with any third party for marketing purposes.</p>

    <h2>Cookies</h2>
    <p>This site uses Google Analytics cookies to understand how visitors use the site. You can opt out of Google Analytics tracking through your browser's cookie settings or by installing <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer">Google's Analytics opt-out browser add-on</a>.</p>

    <h2>Retention</h2>
    <p>We keep service request information for as long as needed to provide service and meet our business and legal obligations.</p>

    <h2>Security</h2>
    <p>We take reasonable steps to protect the information you share with us, but no method of transmission or storage is 100% secure.</p>

    <h2>Children</h2>
    <p>This website is not directed to children under 13, and we do not knowingly collect information from children.</p>

    <h2>Your choices</h2>
    <p>You can ask us to access or delete the information we have about you by contacting us at <a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a>.</p>

    <h2>Changes to this policy</h2>
    <p>We may update this policy from time to time. The "Last updated" date at the top of this page reflects the most recent revision.</p>

    <h2>Contact us</h2>
    <p>Questions about this policy? Reach us at <a href="mailto:<?= e(EMAIL) ?>"><?= e(EMAIL) ?></a> or <a href="<?= OFFICE_PHONE_HREF ?>"><?= e(OFFICE_PHONE_NUMBER) ?></a>.</p>
  </div>
</section>

<?php require SITE_ROOT . '/includes/layout/footer.php'; ?>
