<?php
/**
 * Estatein theme functions and definitions.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ESTATEIN_VERSION', '1.0.0' );
define( 'ESTATEIN_DIR', get_template_directory() );
define( 'ESTATEIN_URI', get_template_directory_uri() );

/**
 * Cache-busting version for a theme asset: the file's last-modified time.
 * Falls back to ESTATEIN_VERSION if the file can't be found (e.g. bad path).
 * Using filemtime() instead of a static version means every CSS/JS edit is
 * picked up immediately, no manual version bump or hard-refresh needed.
 */
function estatein_asset_version( $relative_path ) {
	$file = ESTATEIN_DIR . $relative_path;
	return file_exists( $file ) ? filemtime( $file ) : ESTATEIN_VERSION;
}

/**
 * Theme setup.
 */
function estatein_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/style.css' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'estatein' ),
		'footer'  => __( 'Footer Menu', 'estatein' ),
	) );
}
add_action( 'after_setup_theme', 'estatein_setup' );

/**
 * Enqueue global styles and scripts.
 */
function estatein_enqueue_assets() {
	wp_enqueue_style( 'estatein-style', ESTATEIN_URI . '/assets/style.css', array(), estatein_asset_version( '/assets/style.css' ) );
	wp_enqueue_script( 'estatein-app', ESTATEIN_URI . '/assets/app.js', array(), estatein_asset_version( '/assets/app.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'estatein_enqueue_assets' );

/**
 * The property/testimonial/faq card styles live in blocks/slider-section/style-{source}.css,
 * on top of the shared .cpt-archive/.cpt-single skeleton in style.css. ACF's
 * `enqueue_style` only fires when the Slider Section block itself is on the page,
 * so archive/single templates for those post types need it enqueued explicitly —
 * and only the partial matching the current post type, not all three.
 */
function estatein_enqueue_cpt_card_styles() {
	$post_type = null;

	if ( is_singular( 'property' ) ) {
		$post_type = 'property';
	} elseif ( is_post_type_archive( array( 'property', 'testimonial', 'faq' ) ) ) {
		$post_type = get_query_var( 'post_type' );
	}

	if ( ! $post_type ) {
		return;
	}

	wp_enqueue_style( 'estatein-slider-section-skeleton', ESTATEIN_URI . '/blocks/slider-section/style.css', array( 'estatein-style' ), estatein_asset_version( '/blocks/slider-section/style.css' ) );
	wp_enqueue_style( 'estatein-slider-section-' . $post_type, ESTATEIN_URI . "/blocks/slider-section/style-{$post_type}.css", array( 'estatein-slider-section-skeleton' ), estatein_asset_version( "/blocks/slider-section/style-{$post_type}.css" ) );
}
add_action( 'wp_enqueue_scripts', 'estatein_enqueue_cpt_card_styles' );

/**
 * Register a dedicated block category for theme blocks.
 */
function estatein_block_category( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'estatein',
				'title' => __( 'Estatein', 'estatein' ),
				'icon'  => null,
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'estatein_block_category' );

/**
 * Auto-register ACF blocks from /blocks/{block-name}/ folders.
 * Each block folder must contain template.php (render) and style.css (styling).
 * style.css is only enqueued on pages/posts where the block is actually used.
 */
function estatein_register_acf_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	$blocks_dir = ESTATEIN_DIR . '/blocks';

	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	foreach ( glob( $blocks_dir . '/*', GLOB_ONLYDIR ) as $block_path ) {
		$block_slug     = basename( $block_path );
		$template_file  = $block_path . '/template.php';
		$style_file     = $block_path . '/style.css';

		if ( ! file_exists( $template_file ) ) {
			continue;
		}

		acf_register_block_type( array(
			'name'            => $block_slug,
			'title'           => ucwords( str_replace( array( '-', '_' ), ' ', $block_slug ) ),
			'render_template' => "blocks/{$block_slug}/template.php",
			'category'        => 'estatein',
			'icon'            => 'layout',
			'keywords'        => array( $block_slug ),
			'enqueue_style'   => file_exists( $style_file ) ? ESTATEIN_URI . "/blocks/{$block_slug}/style.css?ver=" . estatein_asset_version( "/blocks/{$block_slug}/style.css" ) : false,
			'supports'        => array(
				'align' => true,
				'mode'  => true,
			),
		) );
	}
}
add_action( 'acf/init', 'estatein_register_acf_blocks' );

/**
 * Register ACF options page (if ACF Pro is active).
 */
function estatein_acf_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( array(
			'page_title' => __( 'Theme Settings', 'estatein' ),
			'menu_title' => __( 'Theme Settings', 'estatein' ),
			'menu_slug'  => 'theme-settings',
			'capability' => 'edit_posts',
		) );
	}
}
add_action( 'acf/init', 'estatein_acf_options_page' );

/**
 * Point ACF's local JSON save/load to /acf-json for field group version control.
 */
function estatein_acf_json_save_point( $path ) {
	return ESTATEIN_DIR . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'estatein_acf_json_save_point' );

function estatein_acf_json_load_point( $paths ) {
	unset( $paths[0] );
	$paths[] = ESTATEIN_DIR . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'estatein_acf_json_load_point' );

/**
 * Theme includes.
 */
require_once ESTATEIN_DIR . '/inc/setup.php';
require_once ESTATEIN_DIR . '/inc/template-tags.php';
require_once ESTATEIN_DIR . '/inc/acf-fields.php';
require_once ESTATEIN_DIR . '/inc/post-types.php';
require_once ESTATEIN_DIR . '/inc/slider-render.php';
