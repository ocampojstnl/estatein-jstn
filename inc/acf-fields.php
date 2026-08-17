<?php
/**
 * ACF dynamic field choices: Google Fonts + registered nav menus.
 * The Theme Options field group itself lives in /acf-json (local JSON).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Curated list of Google Fonts used to populate the Heading/Paragraph font selects.
 * Kept as a plain name list — the value and label are the same font family name.
 */
function estatein_google_fonts() {
	return array(
		'Inter', 'Roboto', 'Open Sans', 'Lato', 'Montserrat', 'Poppins', 'Nunito',
		'Raleway', 'Playfair Display', 'Merriweather', 'Oswald', 'Source Sans Pro',
		'Work Sans', 'Rubik', 'DM Sans', 'Urbanist', 'Manrope', 'Outfit',
		'Plus Jakarta Sans', 'Space Grotesk', 'Karla', 'Mulish', 'Quicksand',
		'Barlow', 'Cabin', 'Josefin Sans', 'Lora', 'PT Sans', 'PT Serif',
		'Noto Sans', 'Noto Serif', 'Fira Sans', 'Heebo', 'Hind', 'Inconsolata',
		'Jost', 'Libre Baskerville', 'Libre Franklin', 'Maven Pro', 'Merriweather Sans',
		'Mukta', 'Nunito Sans', 'Overpass', 'Archivo', 'Bitter', 'Cormorant',
		'Crimson Text', 'DM Serif Display', 'EB Garamond', 'Exo 2', 'IBM Plex Sans',
		'IBM Plex Serif', 'Josefin Slab', 'Kanit', 'Lexend', 'Sora', 'Syne',
		'Teko', 'Titillium Web', 'Ubuntu', 'Zilla Slab',
	);
}

/**
 * Turn the flat font list into ACF choices (value => label).
 */
function estatein_google_fonts_choices() {
	$fonts   = estatein_google_fonts();
	$choices = array();

	foreach ( $fonts as $font ) {
		$choices[ $font ] = $font;
	}

	return $choices;
}

/**
 * Populate the Heading Font / Paragraph Font select fields with the Google Fonts list.
 */
function estatein_load_font_field_choices( $field ) {
	$field['choices'] = estatein_google_fonts_choices();
	return $field;
}
add_filter( 'acf/load_field/key=field_estatein_heading_font', 'estatein_load_font_field_choices' );
add_filter( 'acf/load_field/key=field_estatein_paragraph_font', 'estatein_load_font_field_choices' );

/**
 * Populate the Main Menu "Menu" select field with the site's registered nav menus.
 */
function estatein_load_menu_field_choices( $field ) {
	$menus   = wp_get_nav_menus();
	$choices = array();

	foreach ( $menus as $menu ) {
		$choices[ $menu->slug ] = $menu->name;
	}

	$field['choices'] = $choices;

	return $field;
}
add_filter( 'acf/load_field/key=field_estatein_main_menu_menu', 'estatein_load_menu_field_choices' );

/**
 * Enqueue the selected Heading/Paragraph Google Fonts and expose them as CSS custom
 * properties (--font-heading / --font-body) so assets/style.css can consume them.
 */
function estatein_enqueue_google_fonts() {
	if ( ! function_exists( 'get_field' ) ) {
		return;
	}

	$heading_font = get_field( 'heading_font', 'option' ) ?: 'Urbanist';
	$body_font    = get_field( 'paragraph_font', 'option' ) ?: 'Urbanist';

	$families = array_unique( array_filter( array( $heading_font, $body_font ) ) );
	$families = array_map( function ( $font ) {
		return str_replace( ' ', '+', $font ) . ':wght@400;500;600;700';
	}, $families );

	$fonts_url = add_query_arg(
		array(
			'family'  => implode( '&family=', $families ),
			'display' => 'swap',
		),
		'https://fonts.googleapis.com/css2'
	);

	wp_enqueue_style( 'estatein-google-fonts', $fonts_url, array(), null );

	$inline_css = ':root{';
	if ( $heading_font ) {
		$inline_css .= '--font-heading:' . "'" . esc_attr( $heading_font ) . "', sans-serif;";
	}
	if ( $body_font ) {
		$inline_css .= '--font-body:' . "'" . esc_attr( $body_font ) . "', sans-serif;";
	}
	$inline_css .= '}';

	wp_add_inline_style( 'estatein-style', $inline_css );
}
add_action( 'wp_enqueue_scripts', 'estatein_enqueue_google_fonts', 20 );
