<?php
declare(strict_types=1);

/** HTML-escape. */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Absolute URL for a site path. */
function abs_url(string $path): string
{
    return SITE_URL . '/' . ltrim($path, '/');
}

/** Current request path (no query string), normalised. */
function current_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $path = '/' . trim($path, '/');
    return $path === '//' ? '/' : $path;
}

/** Page title builder (mirrors old buildTitle). */
function build_title(?string $pageTitle): string
{
    $base = BRAND_NAME;
    if (!$pageTitle) {
        return 'Okie Heating & Cooling | #1 HVAC Repair & AC Service in Tulsa, OK';
    }
    if (str_contains($pageTitle, $base)) {
        return $pageTitle;
    }
    return "$pageTitle | $base";
}

/** Render a component/partial with scoped variables. */
function component(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    include SITE_ROOT . "/includes/components/$name.php";
}

/** Inline Lucide-style SVG icon. */
function icon(string $name, string $class = 'icon'): string
{
    static $icons = null;
    if ($icons === null) {
        $icons = require SITE_ROOT . '/includes/icons.php';
    }
    $body = $icons[$name] ?? $icons['circle'];
    return '<svg class="' . e($class) . '" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $body . '</svg>';
}

/** Pre-select a form value helper. */
function selected(string $a, string $b): string
{
    return $a === $b ? ' selected' : '';
}

/** Service-type machine value -> human label (used by emails + admin). */
function service_type_label(string $value): string
{
    static $labels = [
        'ac_repair' => 'AC Repair',
        'ac_installation' => 'AC Installation',
        'ac_maintenance' => 'AC Maintenance',
        'heating_repair' => 'Heating Repair',
        'heating_installation' => 'Heating Installation',
        'heating_maintenance' => 'Heating Maintenance',
        'furnace_repair' => 'Furnace Repair',
        'furnace_installation' => 'Furnace Installation',
        'indoor_air_quality' => 'Indoor Air Quality',
        'thermostat_installation' => 'Thermostat Installation',
        'ductwork' => 'Ductwork Services',
        'emergency' => 'Emergency HVAC Service',
        'commercial' => 'Commercial HVAC',
        'maintenance_plan' => 'Maintenance Plan',
        'other' => 'General Inquiry',
    ];
    return $labels[$value] ?? $value;
}

/** Local business JSON-LD (mirrors old buildLocalBusinessJsonLd). */
function local_business_jsonld(): array
{
    $cities = array_values(array_unique(array_merge(['Tulsa'], array_column(SERVICE_AREAS, 'name'))));
    return [
        '@context' => 'https://schema.org',
        '@type' => 'HVACBusiness',
        'name' => BRAND_NAME,
        'url' => SITE_URL,
        'image' => abs_url('assets/img/okie-logo-hero.png'),
        'logo' => abs_url('assets/img/okie-logo-nav.png'),
        'telephone' => PHONE_NUMBER,
        'email' => EMAIL,
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Tulsa',
            'addressRegion' => 'OK',
            'addressCountry' => 'US',
        ],
        'areaServed' => array_map(fn($n) => ['@type' => 'City', 'name' => $n], $cities),
        'knowsAbout' => array_column(SERVICES, 'title'),
        'openingHoursSpecification' => [[
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'opens' => '09:00',
            'closes' => '20:00',
        ]],
        'aggregateRating' => [
            '@type' => 'AggregateRating',
            'ratingValue' => '5',
            'reviewCount' => '18',
            'bestRating' => '5',
            'worstRating' => '1',
        ],
        'priceRange' => '$$',
        'paymentAccepted' => 'Cash, Credit Card, Financing',
    ];
}

function service_jsonld(string $serviceName, string $url, string $description): array
{
    $provider = local_business_jsonld();
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $serviceName,
        'description' => $description,
        'provider' => $provider,
        'areaServed' => $provider['areaServed'],
        'url' => $url,
    ];
}

function faq_jsonld(array $faqs): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => array_map(fn($f) => [
            '@type' => 'Question',
            'name' => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $faqs),
    ];
}

/** Shared DB connection (null when not configured / unavailable). */
function db(): ?PDO
{
    static $pdo = false;
    if ($pdo !== false) {
        return $pdo;
    }
    if (DB_HOST === '' || DB_NAME === '') {
        return $pdo = null;
    }
    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    } catch (Throwable $e) {
        error_log('DB connect failed: ' . $e->getMessage());
        $pdo = null;
    }
    return $pdo;
}
