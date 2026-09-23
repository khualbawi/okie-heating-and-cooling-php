# Okie Heating & Cooling — PHP website

Static-first HTML + PHP port of [okieheatingandcooling.com](https://okieheatingandcooling.com), migrated off Base44 for Hostinger shared hosting. No build step, no Composer, no Node.

## Structure

```
index.php               front controller / router (all clean URLs)
.htaccess               rewrites, HTTPS+non-www redirect, caching, hardening
config.php              constants + .env loader
.env.example            copy to .env and fill in
includes/
  data.php              services, service areas, reviews, FAQs (content lives here)
  helpers.php           e(), icon(), JSON-LD builders, db()
  icons.php             inline Lucide SVG set
  mailer.php            Brevo API / mail() + email templates
  layout/               header.php, footer.php
  components/           cta-banner, faq-section, service-card, testimonial-card,
                        trust-badges, service-request-form
pages/                  one file per route (home, services, service-detail, …, 404)
api/
  submit-request.php    POST handler: validate → store (MySQL or JSONL) → email
  track.php             page-view / event logger (DB only)
admin/requests.php      lead inbox + status update + CSV export (Basic-auth, needs ADMIN_PASSWORD)
assets/css|js|img       styles.css, main.js, logos/favicons
sql/schema.sql          MySQL tables (optional)
storage/                JSONL fallback storage (web-blocked)
sitemap.php, robots.txt
```

## Routes

`/`, `/services`, `/services/{slug}`, `/service-areas`, `/service-areas/{slug}`, `/about`,
`/contact`, `/book[?service=ac_repair]`, `/reviews`, `/financing`, `/maintenance-plan`,
`/sitemap.xml`, `/api/submit-request` (POST), `/api/track` (POST), `/admin/requests.php`.

## Deploy to Hostinger

1. **Upload** everything in this folder to `public_html/` (File Manager, FTP, or
   hPanel → Git → connect this repo with deploy path `public_html`).
2. **Create `.env`** in `public_html/` from `.env.example`:
   - `SITE_URL=https://okieheatingandcooling.com`
   - `ADMIN_EMAIL` – where leads are sent.
   - `SENDER_EMAIL` – create this mailbox in hPanel → Emails (e.g. `email@okieheatingandcooling.com`) so mail isn't rejected.
   - `BREVO_API_KEY` – optional. If empty, PHP `mail()` is used (works on Hostinger but check spam folder; Brevo is more reliable).
   - `ADMIN_PASSWORD` – enables `/admin/requests.php` (login `admin`).
3. **Database (optional but recommended)**: hPanel → Databases → create DB + user, then
   import `sql/schema.sql` in phpMyAdmin and fill `DB_HOST/DB_NAME/DB_USER/DB_PASS`.
   Without a DB, leads are appended to `storage/requests.jsonl` (still emailed).
4. **PHP version**: hPanel → Advanced → PHP Configuration → PHP 8.1+ (8.2 recommended).
   Extensions needed: `curl`, `mbstring`, `pdo_mysql`, `json` (all default on Hostinger).
5. **Permissions**: make sure `storage/` is writable (755 dir is fine on Hostinger).
6. **DNS**: point the domain at Hostinger, enable free SSL in hPanel. The `.htaccess`
   forces HTTPS + non-www — if Hostinger's own redirect is on, you can remove that block.
7. **Search Console**: resubmit `https://okieheatingandcooling.com/sitemap.xml`.
8. **Deploy**: push to `main`; caches self-invalidate on the first request (see
   "Performance / caching" below — no manual purge step). If Cloudflare sits in
   front, `cloudflare/purge.sh` is available as an optional manual tool for the
   rare case you need the edge cleared before the next visitor hits it.

## Local dev

```bash
cp .env.example .env
php -S localhost:8080 router-dev.php
```

## What changed vs. the Base44 app

| Base44 | Now |
|---|---|
| React + Vite SPA | Server-rendered PHP pages (faster first paint, fully crawlable) |
| `ServiceRequest` entity | `service_requests` table or `storage/requests.jsonl` |
| `SiteEvent` entity | `site_events` table (only when DB configured) |
| `sendBrevoEmails` function | `includes/mailer.php` (same templates; Brevo or `mail()`) |
| `onServiceRequestCreated` automation | Emails sent inline on submit |
| Admin → Integrations (ServiceFusion OAuth) | Not ported — ServiceFusion sync was Base44-specific. `/admin/requests.php` + CSV export instead |
| `weeklyReport` function | Not ported (can be recreated as a cron PHP script reading `site_events`) |
| Google-hosted images on media.base44.com | Copied to `assets/img/` |

## Performance / caching

The site is tuned to render fast on mobile connections. What is in place:

**Full-page caching (two layers)**

1. **LiteSpeed** — `.htaccess` sends `CacheLookup on` plus per-request `Cache-Control`
   env vars, and `includes/cache.php` emits `X-LiteSpeed-Cache-Control: public,max-age=86400`.
   On a hit LiteSpeed answers from RAM and PHP never runs.
   *Enable "LiteSpeed Cache" for the domain in hPanel — without that the rules are inert.*
2. **PHP file cache** (`includes/cache.php`) — a fallback for LiteSpeed misses: rendered
   HTML lands in `storage/cache/` and is replayed with `readfile()`. Also sends
   `ETag` / `Last-Modified` so repeat visits get a 304.

Not cached anywhere — origin, LiteSpeed or CDN: `POST`, `/book` (live booking data),
`/api/*`, `/admin/*`, authenticated requests, `sitemap.xml`, any non-200 response, and
**any page that rendered the request form** (home, `/contact`, `/maintenance-plan`, or
any future page using `component('service-request-form', ...)`). That last one is
detected automatically — `component()` flags the response the moment the form
component runs, so no page needs a hardcoded bypass list — because the form embeds a
`_ts` freshness token that must not go stale in a cached copy. Those responses carry
`Cache-Control: private, no-store` plus `CDN-Cache-Control: no-store` and
`X-LiteSpeed-Cache-Control: no-cache`.

**Invalidation** — fully automatic, no admin step. The cache key includes the deploy
version: the short hash of the currently checked-out git commit (`deploy_version()`
in `includes/cache.php`, read straight from `.git/HEAD` — falls back to a `VERSION`
file for non-git deploys, then `'dev'`). A `git push` to `main` means the very next
request runs against a new version, gets a guaranteed cache miss, and — exactly
once, file-locked so concurrent requests don't race — deletes the previous version's
cache files and sends `X-LiteSpeed-Purge: *` to drop the LiteSpeed edge too.
Cloudflare respects the origin's `CDN-Cache-Control`, so it naturally serves the new
version once its own TTL expires (or immediately for any page marked `no-store`);
`cloudflare/purge.sh` is there if you want it gone from the edge sooner.
Kill switch: `PAGE_CACHE=0` in `.env`. Response header `X-Page-Cache: HIT|MISS` shows
what happened.

Local dev iterating on templates: since the cache key is now the git commit (not
file mtimes), an uncommitted edit won't bust the local cache. Set `PAGE_CACHE=0` in
your local `.env` while actively editing, or just commit as you go.

**Front-end**

- Fonts are self-hosted variable woff2 (`assets/fonts/`) — no `fonts.googleapis.com`
  round-trip. Latin files are preloaded; latin-ext loads only if the text needs it.
- `gtag.js` loads after `load` (or on first interaction); the `gtag()` queue exists
  immediately so no events are lost.
- Logos are WebP with `srcset`; the home hero is preloaded with `fetchpriority=high`.
- Hero content is painted at full opacity with a CSS-only entrance animation, so LCP
  never waits on `main.js`. Only below-the-fold `.reveal` blocks use IntersectionObserver.
- Below-the-fold sections use `content-visibility: auto` with an intrinsic size.
- Page-view telemetry fires on `requestIdleCallback`.
- Static assets: `Cache-Control: immutable`, 1 year; CSS/JS are cache-busted with
  `?v=<deploy-version>` (same git-commit hash as the page cache — see below).
- Brotli (falling back to gzip) for all text responses.

**Cloudflare CDN** — see `cloudflare/README.md`. Cacheable pages send
`CDN-Cache-Control` (1 day at the edge, independent of the 10-minute browser TTL) and
`Cache-Tag` for targeted purges; `cloudflare/cache-rules.json` + `apply.sh` deploy the
matching zone rules, `purge.sh` clears the edge after a deploy.
