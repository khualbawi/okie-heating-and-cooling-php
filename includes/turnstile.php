<?php
declare(strict_types=1);

/** Verify a Cloudflare Turnstile response token server-side. Fails closed. */
function verify_turnstile(string $token, string $ip): bool
{
    if (!TURNSTILE_CONFIGURED || $token === '') {
        return false;
    }
    $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'secret' => TURNSTILE_SECRET_KEY,
            'response' => $token,
            'remoteip' => $ip,
        ]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 5,
    ]);
    $body = curl_exec($ch);
    $error = curl_errno($ch);
    curl_close($ch);
    if ($error || $body === false) {
        error_log('Turnstile: siteverify request failed (curl errno ' . $error . ')');
        return false;
    }
    $result = json_decode($body, true);
    return is_array($result) && ($result['success'] ?? false) === true;
}
