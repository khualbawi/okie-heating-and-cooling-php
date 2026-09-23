<?php
/**
 * Inline SVG map of the service area, shared by the /service-areas hub and
 * each city page. No external requests (no tiles, no Google Maps) — a
 * stylized schematic: a coverage circle, the Arkansas River, three
 * highways, and one linked dot per city.
 */
declare(strict_types=1);

/**
 * @param array<int, array{slug:string,name:string,map:?array}> $cities
 * @param string $size 'lg' (hub desktop hero) or 'sm' (hub mobile map view, city pages)
 */
function render_area_map(array $cities, ?string $active = null, string $size = 'lg'): void
{
    $viewBox = $size === 'sm' ? '30 30 520 420' : '0 0 560 460';
    $labelFontSize = $size === 'sm' ? 16 : 13;
    $roadLabelFontSize = $size === 'sm' ? 13 : 11;
    ?>
    <svg class="area-map area-map-<?= e($size) ?>" viewBox="<?= e($viewBox) ?>" role="img" aria-label="Map of the Tulsa metro showing the cities we serve" xmlns="http://www.w3.org/2000/svg">
      <circle class="area-map-coverage" cx="275" cy="225" r="200" />
      <path class="area-map-river" d="M138,178 Q210,198 275,225 Q258,268 265,305 Q296,336 335,330 Q360,326 335,360" />
      <g class="area-map-roads">
        <path d="M95,352 L275,225 L478,118" />
        <text x="360" y="150" text-anchor="middle" font-size="<?= $roadLabelFontSize ?>" transform="rotate(-28 360 150)">I-44</text>
        <path d="M292,48 L275,225 L238,442" />
        <text x="285" y="150" text-anchor="middle" font-size="<?= $roadLabelFontSize ?>">US-75</text>
        <path d="M345,55 L345,95 L410,300" />
        <text x="368" y="180" text-anchor="middle" font-size="<?= $roadLabelFontSize ?>" transform="rotate(58 368 180)">US-169</text>
      </g>
      <?php foreach ($cities as $city): ?>
        <?php
        $slug = $city['slug'];
        $m = $city['map'] ?? null;
        if (!$m) continue;
        $isActive = $active === $slug;
        $anchor = $m['label_anchor'] ?? 'start';
        ?>
        <a href="/service-areas/<?= e($slug) ?>" class="area-dot<?= $isActive ? ' is-active' : '' ?>" data-city="<?= e($slug) ?>" aria-label="<?= e($city['name']) ?>">
          <circle class="area-dot-halo" cx="<?= $m['x'] ?>" cy="<?= $m['y'] ?>" r="<?= $isActive ? 22 : 16 ?>" />
          <circle class="area-dot-pin" cx="<?= $m['x'] ?>" cy="<?= $m['y'] ?>" r="<?= $isActive ? 10 : 7 ?>" />
          <text class="area-dot-label" x="<?= $m['x'] + ($m['label_dx'] ?? 12) ?>" y="<?= $m['y'] + ($m['label_dy'] ?? 4) ?>" text-anchor="<?= e($anchor) ?>" font-size="<?= $labelFontSize ?>"><?= e($city['name']) ?></text>
        </a>
      <?php endforeach; ?>
    </svg>
    <?php
}
