<?php
/**
 * Service request form. Progressive enhancement: works without JS (POST + redirect),
 * enhanced by assets/js/main.js (fetch + inline success state).
 *
 * Vars: $source, $defaultService, $defaultUrgency, $compact, $serviceLabel,
 *       $servicePlaceholder, $messageLabel, $messagePlaceholder
 */
$source             = $source             ?? 'general';
$defaultService     = $defaultService     ?? '';
$defaultUrgency     = $defaultUrgency     ?? 'routine';
$compact            = $compact            ?? false;
$serviceLabel       = $serviceLabel       ?? 'Service Needed *';
$servicePlaceholder = $servicePlaceholder ?? 'Select a service';
$messageLabel       = $messageLabel       ?? 'Describe Your Issue or Request';
$messagePlaceholder = $messagePlaceholder ?? "Tell us what's going on — the more detail, the faster we can help.";
$uid = 'f' . substr(md5($source), 0, 6);
$submitted = ($_GET['submitted'] ?? '') === '1';
$formError = $_GET['error'] ?? '';
?>
<?php if ($submitted): ?>
  <div class="form-success">
    <div class="form-success-icon"><?= icon('check-circle', 'icon-lg') ?></div>
    <h3 class="h3">Request Submitted!</h3>
    <p class="muted">Thank you! Our team will contact you shortly to confirm your appointment. For immediate assistance, please call us directly.</p>
  </div>
<?php else: ?>
<form class="request-form" method="post" action="/api/submit-request" data-request-form novalidate>
  <input type="hidden" name="form_source" value="<?= e($source) ?>">
  <input type="hidden" name="redirect" value="<?= e(current_path()) ?>">
  <input type="hidden" name="utm_source" value="<?= e($_GET['utm_source'] ?? '') ?>">
  <input type="hidden" name="utm_medium" value="<?= e($_GET['utm_medium'] ?? '') ?>">
  <input type="hidden" name="utm_campaign" value="<?= e($_GET['utm_campaign'] ?? '') ?>">
  <!-- honeypot -->
  <div class="hp-field" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
  <input type="hidden" name="_ts" value="<?= time() ?>">

  <?php if ($formError): ?><div class="form-alert" role="alert"><?= e($formError) ?></div><?php endif; ?>
  <div class="form-alert" role="alert" data-form-error hidden></div>

  <div class="grid-2">
    <div class="field">
      <label for="<?= $uid ?>-name">Full Name *</label>
      <input id="<?= $uid ?>-name" name="name" type="text" placeholder="John Smith" required autocomplete="name">
    </div>
    <div class="field">
      <label for="<?= $uid ?>-phone">Phone Number *</label>
      <input id="<?= $uid ?>-phone" name="phone" type="tel" placeholder="(918) 555-0000" required autocomplete="tel">
    </div>
  </div>

  <div class="grid-2">
    <div class="field">
      <label for="<?= $uid ?>-email">Email</label>
      <input id="<?= $uid ?>-email" name="email" type="email" placeholder="john@example.com" autocomplete="email">
    </div>
    <div class="field">
      <label for="<?= $uid ?>-service"><?= e($serviceLabel) ?></label>
      <select id="<?= $uid ?>-service" name="service_type" required>
        <option value="" disabled<?= $defaultService === '' ? ' selected' : '' ?>><?= e($servicePlaceholder) ?></option>
        <?php foreach (SERVICES as $s): ?>
          <option value="<?= e($s['formValue']) ?>"<?= selected($defaultService, $s['formValue']) ?>><?= e($s['title']) ?></option>
        <?php endforeach; ?>
        <option value="maintenance_plan"<?= selected($defaultService, 'maintenance_plan') ?>>Maintenance Plan</option>
        <option value="other"<?= selected($defaultService, 'other') ?>>Other</option>
      </select>
    </div>
  </div>

  <?php if (!$compact): ?>
    <div class="grid-2">
      <div class="field">
        <label for="<?= $uid ?>-address">Service Address</label>
        <input id="<?= $uid ?>-address" name="address" type="text" placeholder="123 Main St" autocomplete="street-address">
      </div>
      <div class="field">
        <label for="<?= $uid ?>-city">City</label>
        <input id="<?= $uid ?>-city" name="city" type="text" placeholder="Tulsa" autocomplete="address-level2">
      </div>
    </div>
    <div class="grid-3">
      <div class="field">
        <label for="<?= $uid ?>-date">Preferred Date</label>
        <input id="<?= $uid ?>-date" name="preferred_date" type="date">
      </div>
      <div class="field">
        <label for="<?= $uid ?>-time">Preferred Time</label>
        <select id="<?= $uid ?>-time" name="preferred_time">
          <option value="">Select time</option>
          <option value="morning">Morning (8am–12pm)</option>
          <option value="afternoon">Afternoon (12pm–5pm)</option>
          <option value="evening">Evening (5pm–8pm)</option>
          <option value="asap">ASAP</option>
        </select>
      </div>
      <div class="field">
        <label for="<?= $uid ?>-urgency">Urgency</label>
        <select id="<?= $uid ?>-urgency" name="urgency">
          <option value="routine"<?= selected($defaultUrgency, 'routine') ?>>Routine</option>
          <option value="soon"<?= selected($defaultUrgency, 'soon') ?>>Soon (Within a Few Days)</option>
          <option value="urgent"<?= selected($defaultUrgency, 'urgent') ?>>Urgent (Today/Tomorrow)</option>
          <option value="emergency"<?= selected($defaultUrgency, 'emergency') ?>>Emergency (Right Now)</option>
        </select>
      </div>
    </div>
    <div class="field">
      <label for="<?= $uid ?>-ctype">Customer Type</label>
      <select id="<?= $uid ?>-ctype" name="customer_type">
        <option value="new">New Customer</option>
        <option value="existing">Existing Customer</option>
      </select>
    </div>
  <?php else: ?>
    <input type="hidden" name="urgency" value="<?= e($defaultUrgency) ?>">
    <input type="hidden" name="customer_type" value="new">
  <?php endif; ?>

  <div class="field">
    <label for="<?= $uid ?>-msg"><?= e($messageLabel) ?></label>
    <textarea id="<?= $uid ?>-msg" name="issue_description" rows="<?= $compact ? 3 : 4 ?>" placeholder="<?= e($messagePlaceholder) ?>"></textarea>
  </div>

  <div class="field-check">
    <input id="<?= $uid ?>-consent" name="consent" type="checkbox" value="1">
    <label for="<?= $uid ?>-consent">I consent to receiving communications from Okie Heating and Cooling regarding my service request.</label>
  </div>

  <button type="submit" class="btn btn-accent btn-lg btn-block" data-submit-btn>
    <span class="btn-spinner" hidden><?= icon('loader', 'icon-sm spin') ?></span>
    <span class="btn-arrow"><?= icon('arrow-right', 'icon-sm') ?></span>
    <span data-submit-label>Submit Request</span>
  </button>
</form>
<template data-success-template>
  <div class="form-success">
    <div class="form-success-icon"><?= icon('check-circle', 'icon-lg') ?></div>
    <h3 class="h3">Request Submitted!</h3>
    <p class="muted">Thank you! Our team will contact you shortly to confirm your appointment. For immediate assistance, please call us directly.</p>
  </div>
</template>
<?php endif; ?>
