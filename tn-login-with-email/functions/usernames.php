<?php
/**
 * Email username sanitisation and registration validation.
 *
 * @package TN_Login_With_Email
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'sanitize_user', 'tlwe_preserve_plus_in_strict_username', 10, 3 );
add_filter( 'registration_errors', 'tlwe_validate_single_site_registration', 10, 3 );
add_filter( 'wpmu_validate_user_signup', 'tlwe_validate_multisite_signup', 20 );

/**
 * Preserve plus signs during strict username sanitisation.
 *
 * WordPress runs a login through strict sanitisation when it validates and
 * creates a user. Rebuilding the strict result here keeps the core character
 * set unchanged while adding the plus sign used by email sub-addresses.
 *
 * @param string $username     Sanitised username.
 * @param string $raw_username Username before sanitisation.
 * @param bool   $strict       Whether strict sanitisation is enabled.
 * @return string
 */
function tlwe_preserve_plus_in_strict_username( $username, $raw_username, $strict ) {
	if ( ! $strict || false === strpos( $raw_username, '+' ) ) {
		return $username;
	}

	$username = wp_strip_all_tags( $raw_username );
	$username = remove_accents( $username );
	$username = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '', $username );
	$username = preg_replace( '/&.+?;/', '', $username );
	$username = preg_replace( '|[^a-z0-9 +_.\-@]|i', '', $username );
	$username = trim( $username );

	return preg_replace( '|\s+|', ' ', $username );
}

/**
 * Prevent the added plus character from broadening ordinary usernames.
 *
 * @param WP_Error $errors               Registration errors.
 * @param string   $sanitized_user_login Sanitised login.
 * @param string   $user_email           Registration email.
 * @return WP_Error
 */
function tlwe_validate_single_site_registration( $errors, $sanitized_user_login, $user_email ) {
	unset( $user_email );

	if ( false !== strpos( $sanitized_user_login, '+' ) && ! is_email( $sanitized_user_login ) ) {
		$errors->add(
			'invalid_username',
			__( '<strong>Error:</strong> A plus sign may only be used when the username is a valid email address.', 'tn-login-with-email' )
		);
	}

	return $errors;
}

/**
 * Allow valid email addresses through Multisite's alphanumeric-only check.
 *
 * Other username errors, including duplicates, reserved names, and length
 * limits, remain intact.
 *
 * @param array $result Multisite signup validation result.
 * @return array
 */
function tlwe_validate_multisite_signup( $result ) {
	if ( empty( $result['errors'] ) || ! is_wp_error( $result['errors'] ) ) {
		return $result;
	}

	$original_username = isset( $result['orig_username'] ) ? (string) $result['orig_username'] : '';

	if ( ! tlwe_is_valid_email_username( $original_username ) ) {
		return $result;
	}

	$restriction_message = __( 'Usernames can only contain lowercase letters (a-z) and numbers.' );
	$user_name_messages   = $result['errors']->get_error_messages( 'user_name' );

	if ( ! in_array( $restriction_message, $user_name_messages, true ) ) {
		return $result;
	}

	$remaining_messages = array_values(
		array_filter(
			$user_name_messages,
			static function ( $message ) use ( $restriction_message ) {
				return $restriction_message !== $message;
			}
		)
	);

	$result['errors']->remove( 'user_name' );

	foreach ( $remaining_messages as $message ) {
		$result['errors']->add( 'user_name', $message );
	}

	$result['user_name'] = $original_username;

	return $result;
}

/**
 * Determine whether a username is a safe email login supported by WordPress.
 *
 * @param string $username Proposed username.
 * @return bool
 */
function tlwe_is_valid_email_username( $username ) {
	if ( '' === $username || $username !== trim( $username ) ) {
		return false;
	}

	if ( $username !== sanitize_user( $username, true ) ) {
		return false;
	}

	return false !== is_email( $username );
}

