#!/usr/bin/env bash
# Run after every deploy to Hostinger. Clears the app file cache and the LiteSpeed
# edge cache (both via /admin/requests.php?purge=1), then the Cloudflare edge cache
# if CF_API_TOKEN/CF_ZONE_ID are set.
#
#   ADMIN_PASSWORD=... ./scripts/post-deploy-purge.sh https://okieheatingandcooling.com
set -euo pipefail

: "${ADMIN_PASSWORD:?set ADMIN_PASSWORD (same value as .env)}"
SITE="${1:?usage: post-deploy-purge.sh <site-url>}"

curl -fsS -u "admin:$ADMIN_PASSWORD" "$SITE/admin/requests.php?purge=1" -o /dev/null \
  -w "app + LiteSpeed cache: purged (%{http_code})\n"

if [ -n "${CF_API_TOKEN:-}" ] && [ -n "${CF_ZONE_ID:-}" ]; then
  "$(dirname "$0")/../cloudflare/purge.sh"
else
  echo "Cloudflare edge: skipped (CF_API_TOKEN/CF_ZONE_ID not set)"
fi
