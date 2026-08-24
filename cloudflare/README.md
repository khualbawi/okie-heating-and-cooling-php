# Cloudflare CDN setup

The origin (Hostinger + LiteSpeed) already emits everything Cloudflare needs. This
directory holds the zone-side config.

## What gets cached where

| Path | Cloudflare edge | Browser | Why |
|---|---|---|---|
| `/`, `/services/*`, `/service-areas/*`, `/about`, `/contact`, `/reviews`, `/financing`, `/maintenance-plan` | 1 day | 10 min | static marketing content |
| `/assets/*` (css, js, fonts, webp) | 1 year, immutable | 1 year | versioned filenames + `?v=<mtime>` |
| **`/book`** | **never** | **never** | **live booking data** |
| `/api/*`, `/admin/*`, any non-GET | never | never | form posts, telemetry, lead inbox |
| `/sitemap.xml`, 404s, 5xx | never | never | generated / error responses |

The origin drives this with two headers (`includes/cache.php`):

- `Cache-Control: public, max-age=600, stale-while-revalidate=86400` — browsers.
- `CDN-Cache-Control: public, max-age=86400, stale-while-revalidate=86400, stale-if-error=604800` —
  Cloudflare only. It is read *ahead of* `Cache-Control`, so the edge holds pages for a
  day, serves stale while refreshing, and keeps serving stale for a week if Hostinger
  is down.

Bypassed paths send `CDN-Cache-Control: no-store`, which forces a Cloudflare `BYPASS`
even if a rule would otherwise make them eligible. `/book` is therefore protected in
three independent places: the origin header, the `.htaccess` LiteSpeed rules, and the
cache rule below. Any one of them alone is enough.

## Apply the cache rules

```bash
export CF_API_TOKEN=...   # Zone > Cache Rules > Edit
export CF_ZONE_ID=...     # dashboard > Overview > Zone ID
./cloudflare/apply.sh     # prints existing rules, asks before replacing
```

`apply.sh` **replaces** the zone's `http_request_cache_settings` ruleset, so review
what it prints first. The same three rules can be created by hand in
**Caching → Cache Rules**; `cache-rules.json` is the source of truth for their order
(last match wins, which is why the bypass rule is last).

## Zone settings to switch on

Dashboard toggles that are not part of the ruleset:

- **DNS** — the record for the domain must be **proxied** (orange cloud). Cache rules
  do nothing on a grey-cloud record.
- **Speed → Optimization**: Brotli, Early Hints, HTTP/3, 0-RTT.
- **Caching → Tiered Cache**: Smart Tiered Cache Topology — upper tiers absorb misses
  so Hostinger sees far less traffic.
- **Caching → Configuration**: Always Online.
- **SSL/TLS**: Full (strict).
- Leave **Auto Minify** alone — it is retired, and the assets are already minified in
  effect (Brotli does the rest).
- Do **not** enable Rocket Loader. It defers scripts in a way that fights the
  hand-tuned loading order in `header.php` / `footer.php`.

## Purging

The origin tags every page response: `Cache-Tag: page,<slug>,build-<id>`, and static
assets carry `Cache-Tag: asset`. Purge by tag is available on every plan.

```bash
./cloudflare/purge.sh                 # everything
./cloudflare/purge.sh home services   # just those pages
```

The origin's own file cache purges itself on deploy (mtime-derived build id) and can
be cleared at `/admin/requests.php?purge=1`. That does **not** clear Cloudflare — run
`purge.sh` too after a content change, or wait out the 1-day edge TTL.

## Verifying

```bash
curl -sSI https://okieheatingandcooling.com/ | grep -i 'cf-cache-status\|cache-control\|age'
curl -sSI https://okieheatingandcooling.com/book | grep -i 'cf-cache-status\|cache-control'
```

Expect `cf-cache-status: HIT` on `/` (second request onward) and `BYPASS` or `DYNAMIC`
on `/book`. `X-Page-Cache: HIT|MISS` shows what the origin's own cache did underneath.

## Note on query strings

The HTML rule keeps Cloudflare's default cache key, so `?utm_source=...` variants are
cached separately — correct, just slightly less efficient. Narrowing that key needs a
custom **Cache Key → Query String** setting: *Ignore query string* is available on
pay-as-you-go plans, while *All query string parameters except* (to drop only `utm_*`,
`gclid`, `fbclid`) is Enterprise-only. Left out here so the ruleset applies cleanly on
any plan.
