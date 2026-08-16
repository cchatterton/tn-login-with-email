<?php
/**
 * Plugin Name: TN Login with Email
 * Description: Allows valid email addresses to be used as usernames in WordPress and Multisite registration.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 8.1
 * Update URI: https://github.com/cchatterton/tn-login-with-email
 * Author: Techn
 * Author URI: https://techn.com.au
 * Text Domain: tn-login-with-email
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TLWE_VERSION', '1.0.0' );
define( 'TLWE_PLUGIN_FILE', __FILE__ );
define( 'TLWE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once TLWE_PLUGIN_DIR . 'functions/usernames.php';
require_once TLWE_PLUGIN_DIR . 'functions/github-updater.php';
