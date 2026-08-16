#!/usr/bin/env bash
set -euo pipefail

PLUGIN_SLUG="tn-login-with-email"
DIST_DIR="dist"

rm -rf "$DIST_DIR/$PLUGIN_SLUG"
rm -f "$DIST_DIR/$PLUGIN_SLUG.zip"
rm -f "$PLUGIN_SLUG.zip"
mkdir -p "$DIST_DIR"
cp -R "$PLUGIN_SLUG" "$DIST_DIR/$PLUGIN_SLUG"

find "$DIST_DIR/$PLUGIN_SLUG" -name ".DS_Store" -delete
rm -rf "$DIST_DIR/$PLUGIN_SLUG/node_modules"

(
	cd "$DIST_DIR"
	zip -qr "$PLUGIN_SLUG.zip" "$PLUGIN_SLUG"
)

cp "$DIST_DIR/$PLUGIN_SLUG.zip" "$PLUGIN_SLUG.zip"

