# TN Login with Email

TN Login with Email allows valid email addresses to be used as WordPress usernames without changing or migrating existing accounts.

The plugin supports standard single-site registration and Multisite signup validation. It can be activated normally on a single site, activated on an individual Multisite site, or network-activated.

## Installation

Upload `tn-login-with-email.zip` through **Plugins > Add Plugin > Upload Plugin**, then activate it in the required site or network context.

For WordPress Multisite's central `wp-signup.php` flow, activate the plugin on the network main site or network-activate it. WordPress does not load a plugin that is active only on a different subsite during a main-site signup request.

## Release

Build the release ZIP with:

```bash
scripts/build-plugin-zip.sh
```

The ZIP is written to `dist/tn-login-with-email.zip` and copied to the repository root. GitHub releases use a matching `vX.Y.Z` tag and include that ZIP as an asset.


## Controller integration — 1.0.1

Remove independent GitHub update checks and delegate updates to Techn Update Controller. Keep Beta readiness and existing feature settings, package identity and domain restrictions. Previous standalone GitHub update instructions are superseded.
