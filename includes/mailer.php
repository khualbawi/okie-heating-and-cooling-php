<?php
/**
 * Email rendering + sending (ported from base44/functions/sendBrevoEmails).
 * Uses Brevo API when BREVO_API_KEY is set, otherwise PHP mail().
 */
declare(strict_types=1);

const MAIL_COLORS = [
    'navy' => '#0d2847', 'navy2' => '#0b223d', 'white' => '#ffffff', 'pageBg' => '#f3f6fb',
    'text' => '#0f172a', 'muted' => '#475569', 'border' => '#e2e8f0', 'soft' => '#f1f5f9',
    'success' => '#16a34a', 'danger' => '#dc2626', 'orange' => '#e88c1e', 'orangeSoft' => '#fff7ed',
    'orangeBorder' => '#fed7aa', 'orangeText' => '#9a3412',
];

function mail_shell(string $preheader, ?string $headerTitle, ?string $bannerText, ?string $bannerBg, string $bodyHtml, ?string $footerNote = null): string
{
    $c = MAIL_COLORS;
    $year = date('Y');
    $logo = abs_url('assets/img/okie-logo-nav.png');
    $brand = e(BRAND_NAME);
    $banner = $bannerText ? '
            <tr><td bgcolor="' . ($bannerBg ?: $c['success']) . '" style="background-color:' . ($bannerBg ?: $c['success']) . '; padding:12px 20px; text-align:center;">
              <div style="font-family: Arial, sans-serif; font-size:14px; font-weight:700; color:' . $c['white'] . ';">' . e($bannerText) . '</div></td></tr>' : '';
    $hdr = $headerTitle ? '<div style="font-family: Arial, sans-serif; font-size:13px; letter-spacing:0.4px; color:#e2e8f0; text-transform:uppercase; margin-top:8px;">' . e($headerTitle) . '</div>' : '';
    $foot = $footerNote ? e($footerNote) . ' | ' : '';
    return <<<HTML
<!doctype html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><meta name="color-scheme" content="light"><title>{$brand}</title></head>
<body style="margin:0; padding:0; background-color:{$c['pageBg']}; color:{$c['text']};">
<div style="display:none; font-size:1px; line-height:1px; max-height:0; max-width:0; opacity:0; overflow:hidden;">{$preheader}</div>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="{$c['pageBg']}" style="background-color:{$c['pageBg']};"><tr><td align="center" style="padding:24px 12px;">
<table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" bgcolor="{$c['white']}" style="width:600px; max-width:600px; background-color:{$c['white']}; border:1px solid {$c['border']}; border-radius:14px; overflow:hidden;">
<tr><td bgcolor="{$c['navy']}" style="background-color:{$c['navy']}; padding:26px 24px; text-align:center;">
  <div style="display:inline-block; background-color:{$c['white']}; border:1px solid {$c['border']}; border-radius:14px; padding:10px 14px;"><img src="{$logo}" alt="{$brand}" height="44" style="display:block; height:44px; width:auto; margin:0 auto;"></div>{$hdr}
</td></tr>{$banner}
<tr><td bgcolor="{$c['white']}" style="background-color:{$c['white']}; padding:28px 26px; font-family: Arial, sans-serif; color:{$c['text']};">{$bodyHtml}</td></tr>
<tr><td bgcolor="{$c['navy2']}" style="background-color:{$c['navy2']}; padding:18px 24px; text-align:center;">
  <div style="font-family: Arial, sans-serif; font-size:12px; line-height:1.6; color:#e2e8f0;">Okie Heating &amp; Cooling | Tulsa, OK | Licensed &amp; Insured</div>
  <div style="font-family: Arial, sans-serif; font-size:11px; line-height:1.6; color:#cbd5e1; margin-top:6px;">{$foot}&copy; {$year} Okie Heating &amp; Cooling. All rights reserved.</div>
</td></tr></table></td></tr></table></body></html>
HTML;
}

function mail_kv_rows(array $rows): string
{
    $c = MAIL_COLORS;
    $out = '';
    foreach ($rows as [$label, $value]) {
        if (trim((string) $value) === '') continue;
        $out .= '<tr><td style="padding:8px 0; font-size:13px; color:#64748b; width:160px;">' . e($label) . '</td><td style="padding:8px 0; font-size:13px; color:' . $c['text'] . '; font-weight:600;">' . e((string) $value) . '</td></tr>';
    }
    return $out;
}

function build_customer_email(array $sr): string
{
    $c = MAIL_COLORS;
    $label = service_type_label($sr['service_type']);
    $name = e($sr['name']);
    $desc = $sr['issue_description'] !== '' ? '<div style="margin-top:10px; padding-top:10px; border-top:1px solid ' . $c['border'] . ';"><div style="font-size:12px; color:#64748b; margin:0 0 4px 0;">Description</div><div style="font-size:13px; line-height:1.6; color:' . $c['text'] . ';">' . nl2br(e($sr['issue_description'])) . '</div></div>' : '';
    $rows = mail_kv_rows([
        ['Service', $label],
        ['Preferred date', $sr['preferred_date']],
        ['Preferred time', $sr['preferred_time']],
        ['Urgency', $sr['urgency'] !== '' ? ucfirst($sr['urgency']) : ''],
    ]);
    $step = fn(int $n, string $t) => '<tr><td style="padding:6px 0; font-size:14px; color:' . $c['muted'] . '; line-height:1.6;"><span style="background-color:' . $c['navy'] . '; color:' . $c['white'] . '; border-radius:999px; display:inline-block; font-size:12px; font-weight:700; width:22px; height:22px; line-height:22px; text-align:center; margin-right:10px;">' . $n . '</span>' . $t . '</td></tr>';
    $phone = e(PHONE_NUMBER);
    $body = <<<HTML
<div style="font-size:16px; font-weight:700; margin:0 0 8px 0; color:{$c['text']};">Hi {$name},</div>
<div style="font-size:14px; line-height:1.7; margin:0 0 18px 0; color:{$c['muted']};">Thanks for contacting <strong>Okie Heating &amp; Cooling</strong>. We received your request and we'll reach out shortly to confirm your appointment.</div>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="{$c['soft']}" style="background-color:{$c['soft']}; border:1px solid {$c['border']}; border-left:4px solid {$c['navy']}; border-radius:12px; overflow:hidden; margin:0 0 18px 0;"><tr><td style="padding:16px 16px 10px 16px; font-family: Arial, sans-serif;">
  <div style="font-size:14px; font-weight:700; color:{$c['navy']}; margin:0 0 8px 0;">Your Request Summary</div>
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;">{$rows}</table>{$desc}
</td></tr></table>
<div style="font-size:14px; font-weight:700; color:{$c['navy']}; margin:0 0 10px 0;">What happens next</div>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; margin:0 0 18px 0;">
{$step(1, "We'll call or email to confirm your appointment")}
{$step(2, 'A certified technician arrives at the scheduled time')}
{$step(3, 'We diagnose and provide an upfront quote before any work begins')}
</table>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="{$c['orangeSoft']}" style="background-color:{$c['orangeSoft']}; border:1px solid {$c['orangeBorder']}; border-radius:12px; overflow:hidden;"><tr><td style="padding:14px 16px; text-align:center; font-family: Arial, sans-serif;">
  <div style="font-size:13px; color:{$c['orangeText']}; margin:0 0 12px 0;">Need immediate help? We're available <strong>24/7 for emergencies.</strong></div>
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center"><tr><td bgcolor="{$c['orange']}" style="background-color:{$c['orange']}; border-radius:10px;"><a href="tel:+19188961978" style="display:inline-block; padding:12px 22px; font-family: Arial, sans-serif; font-size:14px; font-weight:700; color:{$c['white']}; text-decoration:none;">Call {$phone}</a></td></tr></table>
</td></tr></table>
HTML;
    return mail_shell("We received your request for {$label}. We'll contact you shortly to confirm.", 'Service Request Confirmed', "We've received your service request", $c['success'], $body, 'Questions? Reply to this email or call us.');
}

function build_internal_email(array $sr): string
{
    $c = MAIL_COLORS;
    $label = service_type_label($sr['service_type']);
    $isEmergency = $sr['urgency'] === 'emergency';
    $address = $sr['address'] !== '' ? $sr['address'] . ($sr['city'] !== '' ? ', ' . $sr['city'] : '') : 'Not provided';
    $rows = mail_kv_rows([
        ['Name', $sr['name']], ['Phone', $sr['phone']], ['Email', $sr['email'] ?: 'Not provided'],
        ['Service', $label], ['Urgency', strtoupper($sr['urgency'] ?: 'routine')], ['Address', $address],
        ['Preferred date', $sr['preferred_date'] ?: 'Not specified'], ['Preferred time', $sr['preferred_time'] ?: 'Not specified'],
        ['Customer type', $sr['customer_type'] ?: 'new'], ['Consent', $sr['consent'] ? 'Yes' : 'No'],
        ['UTM source', $sr['utm_source']], ['UTM medium', $sr['utm_medium']], ['UTM campaign', $sr['utm_campaign']],
        ['IP', $sr['ip'] ?? ''], ['Submitted', $sr['created_at'] ?? ''],
    ]);
    $desc = $sr['issue_description'] !== '' ? '<div style="margin-top:12px; padding-top:12px; border-top:1px solid ' . $c['border'] . ';"><div style="font-size:12px; color:#64748b; margin:0 0 4px 0;">Issue description</div><div style="font-size:13px; line-height:1.6; color:' . $c['text'] . ';">' . nl2br(e($sr['issue_description'])) . '</div></div>' : '';
    $title = e($label) . ' - ' . e($sr['name']);
    $src = e($sr['form_source'] ?: 'website');
    $body = <<<HTML
<div style="font-size:16px; font-weight:700; margin:0 0 8px 0; color:{$c['text']};">{$title}</div>
<div style="font-size:14px; line-height:1.6; margin:0 0 18px 0; color:{$c['muted']};">Submitted from: <strong>{$src}</strong></div>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse; border:1px solid {$c['border']}; border-radius:12px; overflow:hidden;"><tr><td bgcolor="{$c['white']}" style="background-color:{$c['white']}; padding:16px 16px 6px 16px; font-family: Arial, sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse:collapse;">{$rows}</table>{$desc}
</td></tr></table>
<div style="margin-top:16px; font-size:12px; color:#64748b; line-height:1.6;">Tip: reply to the customer or call them back ASAP if urgency is <strong>EMERGENCY</strong>.</div>
HTML;
    return mail_shell(($isEmergency ? 'EMERGENCY' : 'New') . " service request: {$label} - {$sr['name']}",
        $isEmergency ? 'Emergency Service Request' : 'New Service Request',
        $isEmergency ? 'Urgent: respond ASAP' : 'New lead received',
        $isEmergency ? $c['danger'] : $c['navy'], $body);
}

/**
 * Send one email. Returns true on success.
 * $to = ['email'=>..,'name'=>..]; $replyTo optional.
 */
function send_email(array $to, string $subject, string $html, array $tags = [], ?array $replyTo = null): bool
{
    if (BREVO_API_KEY !== '') {
        $payload = [
            'sender' => ['name' => BRAND_NAME, 'email' => SENDER_EMAIL],
            'to' => [array_filter($to)],
            'subject' => $subject,
            'htmlContent' => $html,
            'tags' => array_values(array_filter($tags)),
        ];
        if (BCC_EMAIL !== '') $payload['bcc'] = [['email' => BCC_EMAIL]];
        if ($replyTo) $payload['replyTo'] = array_filter($replyTo);

        $ch = curl_init('https://api.brevo.com/v3/smtp/email');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_HTTPHEADER => ['api-key: ' . BREVO_API_KEY, 'Content-Type: application/json', 'Accept: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
        ]);
        $res = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        if ($code >= 200 && $code < 300) return true;
        error_log("Brevo send failed ($code): " . ($err ?: (string) $res));
        // fall through to mail()
    }

    $headers = [
        'MIME-Version: 1.0',
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . mb_encode_mimeheader(BRAND_NAME) . ' <' . SENDER_EMAIL . '>',
    ];
    if ($replyTo && !empty($replyTo['email'])) $headers[] = 'Reply-To: ' . $replyTo['email'];
    if (BCC_EMAIL !== '') $headers[] = 'Bcc: ' . BCC_EMAIL;
    $ok = @mail($to['email'], mb_encode_mimeheader($subject), $html, implode("\r\n", $headers));
    if (!$ok) error_log('mail() failed for ' . $to['email']);
    return $ok;
}

/** Send both customer confirmation + internal notification. Returns [customerSent, internalSent]. */
function send_request_emails(array $sr): array
{
    $label = service_type_label($sr['service_type']);
    $isEmergency = $sr['urgency'] === 'emergency';
    $customerSent = false;
    if ($sr['email'] !== '') {
        $customerSent = send_email(
            ['email' => $sr['email'], 'name' => $sr['name']],
            "Service Request Confirmed - {$label}",
            build_customer_email($sr),
            [$sr['service_type'], $sr['form_source'] ?: 'website'],
            ['email' => ADMIN_EMAIL, 'name' => BRAND_NAME]
        );
    }
    $internalSent = send_email(
        ['email' => ADMIN_EMAIL],
        ($isEmergency ? 'EMERGENCY REQUEST: ' : 'New Service Request: ') . "{$label} - {$sr['name']}",
        build_internal_email($sr),
        ['internal-notification', $sr['service_type'], $isEmergency ? 'emergency' : 'standard'],
        $sr['email'] !== '' ? ['email' => $sr['email'], 'name' => $sr['name']] : null
    );
    return [$customerSent, $internalSent];
}
