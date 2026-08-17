<?php
/**
 * Custom-branded login page (dark theme, site logo) for the default
 * wp-login.php. The custom /estatein-admin URL + hiding wp-login.php was
 * removed — it broke logging in/out on hosts where the matching .htaccess
 * rewrite rule wasn't also deployed. wp-login.php works at its normal URL.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function estatein_login_styles() {
	wp_enqueue_style( 'estatein-style', ESTATEIN_URI . '/assets/style.css', array(), estatein_asset_version( '/assets/style.css' ) );
	wp_enqueue_style( 'estatein-login', ESTATEIN_URI . '/assets/login.css', array( 'estatein-style' ), estatein_asset_version( '/assets/login.css' ) );

	$logo = function_exists( 'get_field' ) ? get_field( 'site_logo', 'option' ) : null;

	if ( ! empty( $logo['url'] ) ) {
		printf(
			'<style>#login h1 a { background-image: url(%s); }</style>',
			esc_url( $logo['url'] )
		);
	}
}
add_action( 'login_enqueue_scripts', 'estatein_login_styles' );

function estatein_login_logo_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'estatein_login_logo_url' );

function estatein_login_logo_text() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'estatein_login_logo_text' );
