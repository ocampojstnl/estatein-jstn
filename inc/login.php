<?php
/**
 * Custom-branded login page + moving the visible login URL from
 * /wp-login.php to /estatein-admin.
 *
 * The actual URL rewrite is an Apache rule in the site's root .htaccess
 * (outside WordPress's managed block), which internally routes
 * /estatein-admin to wp-login.php — wp-login.php itself is never touched or
 * re-included from PHP, so there's no risk of double-bootstrapping WordPress.
 * This file only: (1) hides direct /wp-login.php hits behind a 404, and
 * (2) points every WordPress-generated login/logout link at the new slug.
 *
 * If anything ever goes wrong here, comment out the
 * `require_once ESTATEIN_DIR . '/inc/login.php';` line in functions.php via
 * FTP/file manager — wp-login.php keeps working normally either way, since
 * the rewrite rule just makes it reachable under a second URL.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ESTATEIN_LOGIN_SLUG', 'estatein-admin' );

/**
 * Direct hits on the real wp-login.php (i.e. not via the /estatein-admin
 * rewrite) get a 404 instead of the login form.
 */
function estatein_hide_real_login_url() {
	if ( 'wp-login.php' !== $GLOBALS['pagenow'] ) {
		return;
	}

	// With the internal rewrite, REQUEST_URI still shows /estatein-admin.
	// A direct hit on the real file will contain "wp-login.php" here instead.
	if ( false === stripos( $_SERVER['REQUEST_URI'], 'wp-login.php' ) ) {
		return;
	}

	status_header( 404 );
	nocache_headers();
	include get_query_template( '404' );
	die();
}
// Theme functions.php loads after plugins_loaded already fired, so 'init'
// (which fires after the theme has loaded, but still before any page output)
// is the earliest hook this can reliably use.
add_action( 'init', 'estatein_hide_real_login_url', 1 );

/**
 * Point every internally-generated login URL at the custom slug (this is
 * also what core's auth_redirect() uses, so visiting /wp-admin while logged
 * out redirects here too, not to the real wp-login.php).
 */
function estatein_custom_login_url( $login_url, $redirect, $force_reauth ) {
	$url = home_url( '/' . ESTATEIN_LOGIN_SLUG );

	$args = array();
	if ( ! empty( $redirect ) ) {
		$args['redirect_to'] = $redirect;
	}
	if ( $force_reauth ) {
		$args['reauth'] = '1';
	}

	return $args ? add_query_arg( $args, $url ) : $url;
}
add_filter( 'login_url', 'estatein_custom_login_url', 10, 3 );

function estatein_custom_logout_url( $logout_url ) {
	return str_replace( 'wp-login.php', ESTATEIN_LOGIN_SLUG, $logout_url );
}
add_filter( 'logout_url', 'estatein_custom_logout_url' );

/**
 * Where the logout action sends you afterward defaults to the hardcoded
 * string 'wp-login.php?loggedout=true' — never built via site_url()/login_url(),
 * so it bypasses those filters entirely and hits the real (hidden) wp-login.php.
 */
function estatein_custom_logout_redirect( $redirect_to ) {
	return str_replace( 'wp-login.php', ESTATEIN_LOGIN_SLUG, $redirect_to );
}
add_filter( 'logout_redirect', 'estatein_custom_logout_redirect' );

/**
 * The login/lostpassword/register forms build their own `action` attribute
 * via site_url( 'wp-login.php', $context ) directly — not through login_url()
 * — so without this, submitting the form POSTs straight to the real
 * wp-login.php and gets caught by estatein_hide_real_login_url() above.
 */
function estatein_custom_site_url( $url, $path ) {
	if ( 'wp-login.php' === trim( (string) $path, '/' ) ) {
		$url = str_replace( 'wp-login.php', ESTATEIN_LOGIN_SLUG, $url );
	}
	return $url;
}
add_filter( 'site_url', 'estatein_custom_site_url', 10, 2 );

/**
 * Custom login page branding — dark theme matching the rest of the site.
 */
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
