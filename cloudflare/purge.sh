#!/usr/bin/env bash
# Purge the Cloudflare edge cache. Run after deploying content changes.
#
#   ./cloudflare/purge.sh            # everything
#   ./cloudflare/purge.sh home services   # only those page tags
#
# Page tags come from the origin's Cache-Tag header (includes/cache.php):
# "home", "services", "services_ac-repair", "service-areas_jenks", ... plus "asset".
set -euo pipefail

: "${CF_API_TOKEN:?set CF_API_TOKEN}"
: "${CF_ZONE_ID:?set CF_ZONE_ID}"

API="https://api.cloudflare.com/client/v4/zones/$CF_ZONE_ID/purge_cache"

if [ "$#" -eq 0 ]; then
  BODY='{"purge_everything":true}'
else
  BODY=$(python3 -c 'import json,sys; print(json.dumps({"tags": sys.argv[1:]}))' "$@")
fi

curl -sS -X POST "$API" \
  -H "Authorization: Bearer $CF_API_TOKEN" \
  -H "Content-Type: application/json" \
  --data "$BODY" |
  python3 -c 'import json,sys; d=json.load(sys.stdin); print("✓ purged" if d.get("success") else "✗ "+json.dumps(d.get("errors")))'
