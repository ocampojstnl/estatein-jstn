<?php
/**
 * Reusable template tags / markup helpers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Global button component.
 *
 * @param string $url    Button URL.
 * @param string $text   Button label.
 * @param string $style  'primary' (brand purple) or 'secondary' (black).
 * @param string $target Link target, e.g. '_blank' or ''.
 * @param string $class  Extra classes to append.
 */
function estatein_button( $url, $text, $style = 'primary', $target = '', $class = '' ) {
	if ( empty( $url ) || empty( $text ) ) {
		return '';
	}

	$style   = in_array( $style, array( 'primary', 'secondary' ), true ) ? $style : 'primary';
	$classes = trim( 'btn btn-' . $style . ' ' . $class );

	printf(
		'<a href="%1$s" class="%2$s"%3$s>%4$s</a>',
		esc_url( $url ),
		esc_attr( $classes ),
		$target ? ' target="' . esc_attr( $target ) . '" rel="noopener"' : '',
		esc_html( $text )
	);
}

/**
 * Same as estatein_button() but returns the markup instead of echoing it.
 */
function estatein_get_button( $url, $text, $style = 'primary', $target = '', $class = '' ) {
	ob_start();
	estatein_button( $url, $text, $style, $target, $class );
	return ob_get_clean();
}

/**
 * Inline SVG icons for the "Platform" choices on the social_links repeater field.
 * Keeping these inline (instead of an icon font/library) means no extra request
 * and the icon inherits `currentColor` for free theming via CSS.
 */
function estatein_social_icon( $platform ) {
	$icons = array(
		'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12.06C22 6.51 17.52 2 12 2S2 6.51 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.78-1.63 1.57v1.88h2.78l-.44 2.91h-2.34V22c4.78-.76 8.44-4.92 8.44-9.94Z"/></svg>',
		'instagram' => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2c2.72 0 3.06.01 4.12.06 1.06.05 1.79.22 2.43.47.66.26 1.22.6 1.77 1.15.55.55.9 1.11 1.15 1.77.25.64.42 1.37.47 2.43.05 1.06.06 1.4.06 4.12s-.01 3.06-.06 4.12c-.05 1.06-.22 1.79-.47 2.43a4.9 4.9 0 0 1-1.15 1.77 4.9 4.9 0 0 1-1.77 1.15c-.64.25-1.37.42-2.43.47-1.06.05-1.4.06-4.12.06s-3.06-.01-4.12-.06c-1.06-.05-1.79-.22-2.43-.47a4.9 4.9 0 0 1-1.77-1.15 4.9 4.9 0 0 1-1.15-1.77c-.25-.64-.42-1.37-.47-2.43C2.01 15.06 2 14.72 2 12s.01-3.06.06-4.12c.05-1.06.22-1.79.47-2.43.26-.66.6-1.22 1.15-1.77A4.9 4.9 0 0 1 5.45.53c.64-.25 1.37-.42 2.43-.47C8.94 2.01 9.28 2 12 2Zm0 3.24a6.76 6.76 0 1 0 0 13.52 6.76 6.76 0 0 0 0-13.52Zm0 11.14a4.38 4.38 0 1 1 0-8.76 4.38 4.38 0 0 1 0 8.76Zm7.03-11.4a1.58 1.58 0 1 1-3.16 0 1.58 1.58 0 0 1 3.16 0Z"/></svg>',
		'x'         => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.24 2.75h3.3l-7.2 8.23 8.47 11.27h-6.63l-5.2-6.8-5.94 6.8H1.72l7.7-8.8L1.3 2.75h6.8l4.7 6.22 5.44-6.22Zm-1.16 17.52h1.83L7 4.62H5.03l12.05 15.65Z"/></svg>',
		'linkedin'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.34V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28ZM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13ZM7.12 20.45H3.56V9h3.56v11.45Z"/></svg>',
		'youtube'   => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.5 7.19a3.02 3.02 0 0 0-2.12-2.14C19.5 4.5 12 4.5 12 4.5s-7.5 0-9.38.55A3.02 3.02 0 0 0 .5 7.19 31.6 31.6 0 0 0 0 13a31.6 31.6 0 0 0 .5 5.81 3.02 3.02 0 0 0 2.12 2.14c1.88.55 9.38.55 9.38.55s7.5 0 9.38-.55a3.02 3.02 0 0 0 2.12-2.14A31.6 31.6 0 0 0 24 13a31.6 31.6 0 0 0-.5-5.81ZM9.6 16.6V9.4L15.8 13 9.6 16.6Z"/></svg>',
		'tiktok'    => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16.6 2h-3.3v13.3a2.7 2.7 0 1 1-2.7-2.7c.25 0 .5.03.73.1V9.3a6 6 0 1 0 5.27 5.95V8.3a8.3 8.3 0 0 0 4.9 1.58V6.6a5 5 0 0 1-4.9-4.6Z"/></svg>',
	);

	return isset( $icons[ $platform ] ) ? $icons[ $platform ] : '';
}

/**
 * Inline SVG icons for the property meta pills (bedrooms/bathrooms/type) and testimonial stars.
 */
function estatein_ui_icon( $name ) {
	$icons = array(
		'bed'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 18v-7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v7"></path><path d="M3 18v2"></path><path d="M21 18v2"></path><path d="M3 13h18"></path><path d="M7 13V9a1 1 0 0 1 1-1h3"></path></svg>',
		'bath'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16v3a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4v-3Z"></path><path d="M4 12V6a2 2 0 0 1 2-2c1 0 1.5.5 1.5 1.5"></path><path d="M8 19v2"></path><path d="M16 19v2"></path></svg>',
		'building' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 21V5a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v16"></path><path d="M15 21V10a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v11"></path><path d="M4 21h16"></path><path d="M7 7h1"></path><path d="M7 11h1"></path><path d="M7 15h1"></path></svg>',
		'star'     => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.5l2.9 6.34 6.98.7-5.24 4.75 1.5 6.9L12 17.77l-6.14 3.42 1.5-6.9L2.12 9.54l6.98-.7L12 2.5Z"></path></svg>',
	);

	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}

/**
 * Renders the social_links repeater (Theme Options → Header Settings) as an icon list.
 *
 * @param array $links The social_links repeater value from get_field().
 */
function estatein_social_links( $links ) {
	if ( empty( $links ) ) {
		return;
	}

	echo '<ul class="social-links">';

	foreach ( $links as $link ) {
		if ( empty( $link['url'] ) ) {
			continue;
		}

		printf(
			'<li><a href="%1$s" target="_blank" rel="noopener" aria-label="%2$s">%3$s</a></li>',
			esc_url( $link['url'] ),
			esc_attr( ucfirst( $link['platform'] ) ),
			estatein_social_icon( $link['platform'] )
		);
	}

	echo '</ul>';
}
