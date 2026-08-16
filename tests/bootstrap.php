<?php

define( 'ABSPATH', __DIR__ . '/' );

class WP_Error {
	public $errors = array();

	public function add( $code, $message ) {
		$this->errors[ $code ][] = $message;
	}

	public function get_error_messages( $code ) {
		return $this->errors[ $code ] ?? array();
	}

	public function remove( $code ) {
		unset( $this->errors[ $code ] );
	}
}

function add_filter() {}
function is_wp_error( $value ) { return $value instanceof WP_Error; }
function __( $text ) { return $text; }
function wp_strip_all_tags( $value ) { return strip_tags( $value ); }
function remove_accents( $value ) { return $value; }
function is_email( $value ) { return filter_var( $value, FILTER_VALIDATE_EMAIL ) ? $value : false; }

function sanitize_user( $username, $strict = false ) {
	$raw_username = $username;
	$username     = wp_strip_all_tags( $username );
	$username     = remove_accents( $username );
	$username     = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '', $username );
	$username     = preg_replace( '/&.+?;/', '', $username );

	if ( $strict ) {
		$username = preg_replace( '|[^a-z0-9 _.\-@]|i', '', $username );
	}

	$username = trim( $username );
	$username = preg_replace( '|\s+|', ' ', $username );

	return tlwe_preserve_plus_in_strict_username( $username, $raw_username, $strict );
}

require_once dirname( __DIR__ ) . '/tn-login-with-email/functions/usernames.php';

