# TN Login with Email

TN Login with Email allows a syntactically valid email address to be used as a WordPress username while retaining WordPress's existing username validation and uniqueness protections.

## Requirements

- WordPress 6.0 or newer
- PHP 8.1 or newer

## Behaviour

- Supports standard single-site registration.
- Supports native WordPress Multisite signup validation.
- Supports email sub-addresses such as `person+label@example.com`.
- Does not migrate or modify existing users.
- Does not require the login username and account contact email to match.
- Leaves duplicate, reserved-name, length, and email-domain restrictions in place.

## Activation scope

The plugin is safe for normal activation, individual-site activation on Multisite, and network activation.

WordPress executes its central Multisite signup page in the network main-site context. To affect that page, activate the plugin on the main site or network-activate it. When active only on a subsite, the plugin applies to registration requests executed in that subsite's context.

## Updates

Updates are delivered through public GitHub releases and appear in WordPress's native Plugins screen. The release must include an asset named `tn-login-with-email.zip`.

## License

GPL-2.0-or-later.

