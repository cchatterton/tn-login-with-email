# Manual tests

Run these checks on supported WordPress and PHP versions before deploying to production.

## Single site

1. Activate TN Login with Email from the site Plugins screen.
2. Register `person@example.com` and confirm the stored `user_login` is unchanged.
3. Register `person+label@example.com` and confirm the plus sign remains in `user_login`.
4. Confirm an ordinary username such as `person` still registers normally.
5. Confirm `person+label` is rejected because it is not a valid email address.
6. Confirm duplicate username and duplicate account-email errors still appear.

## Multisite, network active

1. Network-activate the plugin.
2. Complete the native `wp-signup.php` flow with `person@example.com` as the username.
3. Repeat with `person+label@example.com` and activate the account.
4. Confirm the activated account retains the exact username.
5. Confirm reserved, duplicate, pending-signup, length, and network email-domain errors remain enforced.

## Multisite, site active

1. Activate the plugin on the network main site only and repeat the native signup tests.
2. Activate it on an individual subsite and test a registration flow executed by that subsite.
3. Confirm the plugin remains available for activation in both site and Network Admin.

## Updates

1. Install a version older than the latest public GitHub release.
2. Select **Check for updates** in the plugin row.
3. Confirm WordPress displays its native update notice and **update now** action.
4. Open **View details** and confirm the release notes and requirements are shown.
5. Install the update and confirm the plugin remains in the same folder and active scope.

