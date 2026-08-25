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
admin/requests.php      lead inbox + CSV export (Basic-auth, needs ADMIN_PASSWORD)
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
