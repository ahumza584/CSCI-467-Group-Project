IDENT_FILE="/PATH/TO/PUBLIC/KEY"
REMOTE_BASE="~/public_html/se1"
REMOTE_USER="YOUR ZID"
REMOTE_DOMAIN="hopper.cs.niu.edu"
scp -i "$IDENT_FILE" "web/"* "${REMOTE_USER}@${REMOTE_DOMAIN}:${REMOTE_BASE}/"
scp -i "$IDENT_FILE" "sql/"* "${REMOTE_USER}@${REMOTE_DOMAIN}:${REMOTE_BASE}/sql/"
