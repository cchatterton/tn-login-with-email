<?php

require_once __DIR__ . '/bootstrap.php';

$failures = array();

function tlwe_test_assert_same( $expected, $actual, $label ) {
	global $failures;

	if ( $expected !== $actual ) {
		$failures[] = $label . ': expected ' . var_export( $expected, true ) . ', received ' . var_export( $actual, true );
	}
}

tlwe_test_assert_same(
	'person+label@example.com',
	sanitize_user( 'person+label@example.com', true ),
	'Plus-address survives strict sanitisation'
);

tlwe_test_assert_same(
	'person@example.com',
	sanitize_user( 'person<script>@example.com', true ),
	'Unsafe markup is removed'
);

tlwe_test_assert_same( true, tlwe_is_valid_email_username( 'person@example.com' ), 'Standard email is valid' );
tlwe_test_assert_same( true, tlwe_is_valid_email_username( 'person+label@example.com' ), 'Plus-address is valid' );
tlwe_test_assert_same( false, tlwe_is_valid_email_username( 'person+label' ), 'Non-email plus username is invalid' );
tlwe_test_assert_same( false, tlwe_is_valid_email_username( ' person@example.com ' ), 'Whitespace is invalid' );

$errors = new WP_Error();
$errors->add( 'user_name', 'Usernames can only contain lowercase letters (a-z) and numbers.' );
$errors->add( 'user_name', 'Sorry, that username already exists!' );

$result = tlwe_validate_multisite_signup(
	array(
		'user_name'     => 'person@example.com',
		'orig_username' => 'person@example.com',
		'user_email'    => 'contact@example.com',
		'errors'        => $errors,
	)
);

tlwe_test_assert_same(
	array( 'Sorry, that username already exists!' ),
	$result['errors']->get_error_messages( 'user_name' ),
	'Multisite keeps unrelated username errors'
);

$errors = new WP_Error();
$errors->add( 'user_name', 'Usernames can only contain lowercase letters (a-z) and numbers.' );

$result = tlwe_validate_multisite_signup(
	array(
		'user_name'     => 'person+label',
		'orig_username' => 'person+label',
		'user_email'    => 'contact@example.com',
		'errors'        => $errors,
	)
);

tlwe_test_assert_same(
	array( 'Usernames can only contain lowercase letters (a-z) and numbers.' ),
	$result['errors']->get_error_messages( 'user_name' ),
	'Multisite rejects a non-email plus username'
);

if ( $failures ) {
	fwrite( STDERR, implode( PHP_EOL, $failures ) . PHP_EOL );
	exit( 1 );
}

echo "All username tests passed.\n";

