<?php
/**
 * Hub/map data for the Service Areas pages: ZIP coverage, map pin position,
 * nearby-city cross-links, and facts not yet supplied by the owner (eta,
 * neighborhoods, review, recent job — null/empty until filled in, never
 * invented). This complements includes/data.php's SERVICE_AREAS (name,
 * description, highlights, intro, faqs) rather than duplicating it —
 * area_hub() merges both into one array per city.
 */
declare(strict_types=1);

const AREA_ZIPS = [
    'tulsa' => ['74103', '74104', '74105', '74106', '74107', '74108', '74110', '74112', '74114', '74115', '74116', '74119', '74120', '74126', '74127', '74128', '74129', '74130', '74132', '74133', '74134', '74135', '74136', '74137', '74145', '74146'],
    'broken-arrow' => ['74011', '74012', '74014'],
    'owasso' => ['74055'],
    'bixby' => ['74008'],
    'jenks' => ['74037'],
    'sand-springs' => ['74063'],
    'sapulpa' => ['74066'],
    'glenpool' => ['74033'],
];

/** viewBox is 0 0 560 460. label_anchor/dx/dy position the text next to the dot. */
const AREA_MAP_COORDS = [
    'tulsa'        => ['x' => 275, 'y' => 225, 'label_anchor' => 'start', 'label_dx' => 12, 'label_dy' => 4],
    'owasso'       => ['x' => 345, 'y' => 95,  'label_anchor' => 'start', 'label_dx' => 12, 'label_dy' => 4],
    'broken-arrow' => ['x' => 405, 'y' => 255, 'label_anchor' => 'start', 'label_dx' => 12, 'label_dy' => 4],
    'bixby'        => ['x' => 335, 'y' => 330, 'label_anchor' => 'start', 'label_dx' => 12, 'label_dy' => 4],
    'jenks'        => ['x' => 265, 'y' => 305, 'label_anchor' => 'end',   'label_dx' => -12, 'label_dy' => 4],
    'glenpool'     => ['x' => 240, 'y' => 385, 'label_anchor' => 'end',   'label_dx' => -12, 'label_dy' => 4],
    'sapulpa'      => ['x' => 150, 'y' => 315, 'label_anchor' => 'end',   'label_dx' => -12, 'label_dy' => 4],
    'sand-springs' => ['x' => 140, 'y' => 190, 'label_anchor' => 'end',   'label_dx' => -12, 'label_dy' => 4],
];

const AREA_NEARBY = [
    'tulsa'        => ['sand-springs', 'jenks', 'broken-arrow', 'owasso'],
    'broken-arrow' => ['tulsa', 'bixby', 'owasso'],
    'owasso'       => ['tulsa', 'broken-arrow'],
    'bixby'        => ['jenks', 'broken-arrow', 'glenpool'],
    'jenks'        => ['bixby', 'glenpool', 'tulsa'],
    'glenpool'     => ['jenks', 'sapulpa', 'bixby'],
    'sapulpa'      => ['glenpool', 'sand-springs', 'tulsa'],
    'sand-springs' => ['tulsa', 'sapulpa'],
];

/**
 * Not yet supplied by the owner. null/[] hides the dependent element —
 * never render a placeholder. Fill in here once known, no template change
 * needed. eta: string like "15-20 min". review: ['quote','name','stars'].
 * recent_job: ['title','summary','photo'].
 */
const AREA_ETA = [
    'tulsa' => null, 'broken-arrow' => null, 'owasso' => null, 'bixby' => null,
    'jenks' => null, 'sand-springs' => null, 'sapulpa' => null, 'glenpool' => null,
];
const AREA_NEIGHBORHOODS = [
    'tulsa' => [], 'broken-arrow' => [], 'owasso' => [], 'bixby' => [],
    'jenks' => [], 'sand-springs' => [], 'sapulpa' => [], 'glenpool' => [],
];
const AREA_REVIEW = [
    'tulsa' => null, 'broken-arrow' => null, 'owasso' => null, 'bixby' => null,
    'jenks' => null, 'sand-springs' => null, 'sapulpa' => null, 'glenpool' => null,
];
const AREA_RECENT_JOB = [
    'tulsa' => null, 'broken-arrow' => null, 'owasso' => null, 'bixby' => null,
    'jenks' => null, 'sand-springs' => null, 'sapulpa' => null, 'glenpool' => null,
];

/** Town names outside the 8 primary areas. Empty until the owner supplies them. */
const ALSO_SERVING = [];

/**
 * One merged record per city: everything from data.php's SERVICE_AREAS
 * (slug, name, description, highlights, intro, faqs, ...) plus the hub/map
 * fields above. Returns null for an unknown slug.
 */
function area_hub(string $slug): ?array
{
    $area = get_area_by_slug($slug);
    if ($area === null) {
        return null;
    }
    return $area + [
        'zips' => AREA_ZIPS[$slug] ?? [],
        'map' => AREA_MAP_COORDS[$slug] ?? null,
        'nearby' => AREA_NEARBY[$slug] ?? [],
        'eta' => AREA_ETA[$slug] ?? null,
        'neighborhoods' => AREA_NEIGHBORHOODS[$slug] ?? [],
        'review' => AREA_REVIEW[$slug] ?? null,
        'recent_job' => AREA_RECENT_JOB[$slug] ?? null,
    ];
}

/** @return array<string, array{slug:string,name:string}> every ZIP -> its area, for the ZIP checker. */
function zip_lookup(): array
{
    $map = [];
    foreach (AREA_ZIPS as $slug => $zips) {
        $area = get_area_by_slug($slug);
        foreach ($zips as $z) {
            $map[$z] = ['slug' => $slug, 'name' => $area['name'] ?? $slug];
        }
    }
    return $map;
}
