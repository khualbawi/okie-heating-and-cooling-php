#!/usr/bin/env bash
# Apply cloudflare/cache-rules.json to the zone's cache ruleset.
#
#   export CF_API_TOKEN=...   # token with Zone > Cache Rules > Edit
#   export CF_ZONE_ID=...     # Cloudflare dashboard > Overview > Zone ID
#   ./cloudflare/apply.sh
#
# This REPLACES the zone's http_request_cache_settings ruleset. Existing cache
# rules in that phase are overwritten — check the dashboard before running.
set -euo pipefail

: "${CF_API_TOKEN:?set CF_API_TOKEN}"
: "${CF_ZONE_ID:?set CF_ZONE_ID}"

API="https://api.cloudflare.com/client/v4/zones/$CF_ZONE_ID"
DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

echo "→ current cache rules:"
curl -sS -X GET "$API/rulesets/phases/http_request_cache_settings/entrypoint" \
  -H "Authorization: Bearer $CF_API_TOKEN" |
  python3 -c 'import json,sys; r=json.load(sys.stdin).get("result",{}).get("rules",[]); print("\n".join("  - "+x.get("description","(no description)") for x in r) or "  (none)")'

read -r -p "Replace them with cache-rules.json? [y/N] " ok
[ "$ok" = "y" ] || { echo "aborted"; exit 1; }

curl -sS -X PUT "$API/rulesets/phases/http_request_cache_settings/entrypoint" \
  -H "Authorization: Bearer $CF_API_TOKEN" \
  -H "Content-Type: application/json" \
  --data @"$DIR/cache-rules.json" |
  python3 -c 'import json,sys; d=json.load(sys.stdin); print("✓ deployed" if d.get("success") else "✗ failed"); print(json.dumps(d.get("errors") or d["result"]["rules"], indent=2))'
