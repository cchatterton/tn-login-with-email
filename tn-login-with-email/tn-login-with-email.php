<?php
/**
 * Plugin Name: TN Login with Email
 * Description: Allows valid email addresses to be used as usernames in WordPress and Multisite registration.
 * Version: 1.0.1
 * Requires at least: 7.0
 * Requires PHP: 7.4
 * Update URI: https://github.com/cchatterton/tn-login-with-email
 * Author: Techn
 * Author URI: https://techn.com.au
 * Techn Controller API: 1
 * Text Domain: tn-login-with-email
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TLWE_VERSION', '1.0.1' );
define( 'TLWE_PLUGIN_FILE', __FILE__ );
define( 'TLWE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once TLWE_PLUGIN_DIR . 'functions/usernames.php';

require_once __DIR__ . '/functions/controller-client.php';
tnuc_client_register(__FILE__, 'tn-login-with-email');
