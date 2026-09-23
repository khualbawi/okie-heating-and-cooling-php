<?php
/**
 * Business facts we don't have real values for yet (owner bio, financing
 * partner, review links, per-city drive-time/neighborhoods/recent-job).
 * Null = not supplied. Fill in a value here once it's known — no template
 * change needed. Templates must call has_content()/content() and skip
 * rendering the dependent element/section rather than ever printing a
 * raw {{TOKEN}}.
 */
declare(strict_types=1);

const CONTENT = [
    // About page — "Meet the Owner"
    'OWNER_LAST_NAME' => null,
    'OWNER_PHOTO' => null,
    'YEAR_FOUNDED' => null,
    'OWNER_CERTS' => null,
    'OWNER_STORY' => null,

    // Financing page
    'FINANCING_PARTNER' => null,
    'FINANCING_SAMPLE_PAYMENT' => null,
    'FINANCING_APPLY_URL' => null,

    // Reviews / footer / homepage links
    'GOOGLE_REVIEWS_URL' => null,
    'GOOGLE_REVIEW_WRITE_URL' => null,
    'GOOGLE_RATING' => null,
    'GOOGLE_REVIEW_COUNT' => null,

    // JSON-LD sameAs / geo — omitted from schema until real values are supplied
    'GBP_URL' => null,
    'FACEBOOK_URL' => null,
    'YELP_URL' => null,
    'LAT' => null,
    'LNG' => null,

    // Financing specials (also gated by active_financing_specials()'s date filter)
    'SPECIAL_1_TITLE' => null, 'SPECIAL_1_PRICE' => null, 'SPECIAL_1_EXPIRY' => null,
    'SPECIAL_2_TITLE' => null, 'SPECIAL_2_PRICE' => null, 'SPECIAL_2_EXPIRY' => null,

    // Per-city facts used in /service-areas/* intros, FAQs and "Recent job" cards
    'NEIGHBORHOODS_TULSA' => null, 'RECENT_JOB_TULSA' => null,
    'NEIGHBORHOODS_BROKEN_ARROW' => null, 'DRIVE_TIME_BROKEN_ARROW' => null, 'RECENT_JOB_BROKEN_ARROW' => null,
    'NEIGHBORHOODS_OWASSO' => null, 'DRIVE_TIME_OWASSO' => null, 'RECENT_JOB_OWASSO' => null,
    'NEIGHBORHOODS_BIXBY' => null, 'DRIVE_TIME_BIXBY' => null, 'RECENT_JOB_BIXBY' => null,
    'NEIGHBORHOODS_JENKS' => null, 'DRIVE_TIME_JENKS' => null, 'RECENT_JOB_JENKS' => null,
    'NEIGHBORHOODS_SAND_SPRINGS' => null, 'DRIVE_TIME_SAND_SPRINGS' => null, 'RECENT_JOB_SAND_SPRINGS' => null,
    'NEIGHBORHOODS_SAPULPA' => null, 'DRIVE_TIME_SAPULPA' => null, 'RECENT_JOB_SAPULPA' => null,
    'NEIGHBORHOODS_GLENPOOL' => null, 'DRIVE_TIME_GLENPOOL' => null, 'RECENT_JOB_GLENPOOL' => null,
];

/** A not-yet-supplied business fact, or null if it hasn't been filled in. */
function content(string $key): ?string
{
    if (!array_key_exists($key, CONTENT)) {
        error_log("content(): unknown key '$key' — add it to includes/content.php");
        return null;
    }
    return CONTENT[$key];
}

/** True once a real, non-empty value has been filled in for $key. */
function has_content(string $key): bool
{
    $v = content($key);
    return $v !== null && $v !== '';
}

/**
 * Fill {{KEY}} tokens in $text from CONTENT. Every $keys entry must have a
 * real value — if any is missing, returns null so the caller can fall back
 * to different wording instead of ever printing a raw token.
 */
function fill_content(string $text, array $keys): ?string
{
    foreach ($keys as $key) {
        if (!has_content($key)) {
            return null;
        }
        $text = str_replace('{{' . $key . '}}', content($key), $text);
    }
    return $text;
}

/**
 * Last-resort net around every rendered page (wired in header.php/footer.php):
 * catches a raw {{TOKEN}} that slipped past template logic before it reaches a
 * visitor. Outside a local env, strip it and log loudly (page + token) so it
 * gets fixed. Locally, wrap it in a visible red dashed outline instead of
 * hiding the bug.
 */
function strip_raw_placeholders(string $html): string
{
    if (!str_contains($html, '{{')) {
        return $html;
    }
    return preg_replace_callback('/\{\{[A-Z0-9_]+\}\}/', function (array $m) {
        if (IS_LOCAL_ENV) {
            return '<span style="outline:2px dashed red;background:#fee;color:#900;padding:0 2px" title="missing content: ' . $m[0] . '">' . $m[0] . '</span>';
        }
        error_log('RAW PLACEHOLDER on ' . current_path() . ': ' . $m[0]);
        return '';
    }, $html);
}
