<?php
/**
 * The header for the theme.
 *
 * Renders two rows, both driven by Theme Options (ACF options page):
 * 1. Top banner  — top_banner group (content, link, background_image)
 * 2. Main header — main_menu group (enable_logo, menu, button)
 */

$top_banner   = function_exists( 'get_field' ) ? get_field( 'top_banner', 'option' ) : null;
$main_menu    = function_exists( 'get_field' ) ? get_field( 'main_menu', 'option' ) : null;
$site_logo    = function_exists( 'get_field' ) ? get_field( 'site_logo', 'option' ) : null;
$social_links = function_exists( 'get_field' ) ? get_field( 'social_links', 'option' ) : null;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header" class="site-header">

	<?php if ( ! empty( $top_banner['content'] ) ) : ?>
		<div class="top-banner"
			<?php if ( ! empty( $top_banner['background_image']['url'] ) ) : ?>
				style="background-image: url('<?php echo esc_url( $top_banner['background_image']['url'] ); ?>');"
			<?php endif; ?>
		>
			<div class="container top-banner__inner">
				<span class="top-banner__content"><?php echo esc_html( $top_banner['content'] ); ?></span>

				<?php if ( ! empty( $top_banner['link']['url'] ) ) : ?>
					<a class="top-banner__link"
						href="<?php echo esc_url( $top_banner['link']['url'] ); ?>"
						<?php echo ! empty( $top_banner['link']['target'] ) ? ' target="' . esc_attr( $top_banner['link']['target'] ) . '" rel="noopener"' : ''; ?>
					>
						<?php echo esc_html( $top_banner['link']['title'] ); ?>
					</a>
				<?php endif; ?>
			</div>
			<button type="button" class="top-banner__close" aria-label="<?php esc_attr_e( 'Close', 'estatein' ); ?>"><img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/close-button.png' ); ?>" alt=""></button>
		</div>
	<?php endif; ?>

	<div class="main-header">
		<div class="container main-header__inner">
			<div class="site-branding">
				<?php if ( ! empty( $main_menu['enable_logo'] ) ) : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
						<?php if ( ! empty( $site_logo['url'] ) ) : ?>
							<img src="<?php echo esc_url( $site_logo['url'] ); ?>" alt="<?php echo esc_attr( $site_logo['alt'] ?: get_bloginfo( 'name' ) ); ?>">
						<?php else : ?>
							<span><?php bloginfo( 'name' ); ?></span>
						<?php endif; ?>
					</a>
				<?php endif; ?>
			</div>

			<nav class="main-nav" aria-label="<?php esc_attr_e( 'Primary', 'estatein' ); ?>">
				<?php
				if ( ! empty( $main_menu['menu'] ) ) {
					wp_nav_menu( array(
						'menu'           => $main_menu['menu'],
						'container'      => false,
						'fallback_cb'    => false,
					) );
				} else {
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'container'      => false,
						'fallback_cb'    => false,
					) );
				}
				?>
			</nav>

			<div class="header-actions">
				<?php
				if ( ! empty( $main_menu['button']['url'] ) ) {
					estatein_button(
						$main_menu['button']['url'],
						$main_menu['button']['title'],
						'secondary',
						$main_menu['button']['target']
					);
				}
				?>

				<button type="button" class="hamburger" aria-label="<?php esc_attr_e( 'Menu', 'estatein' ); ?>" aria-expanded="false" aria-controls="mobile-nav">
					<span class="hamburger__bar"></span>
					<span class="hamburger__bar"></span>
					<span class="hamburger__bar"></span>
				</button>
			</div>
		</div>
	</div>

</header>

<div class="mobile-nav-overlay"></div>

<div class="mobile-nav" id="mobile-nav">
	<div class="mobile-nav__inner">

		<div class="mobile-nav__header">
			<div class="mobile-nav__logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if ( ! empty( $site_logo['url'] ) ) : ?>
						<img src="<?php echo esc_url( $site_logo['url'] ); ?>" alt="<?php echo esc_attr( $site_logo['alt'] ?: get_bloginfo( 'name' ) ); ?>">
					<?php else : ?>
						<span><?php bloginfo( 'name' ); ?></span>
					<?php endif; ?>
				</a>
			</div>

			<button type="button" class="mobile-nav__close" aria-label="<?php esc_attr_e( 'Close', 'estatein' ); ?>">
				<img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/close-button.png' ); ?>" alt="">
			</button>
		</div>

		<nav class="mobile-nav__menu" aria-label="<?php esc_attr_e( 'Mobile', 'estatein' ); ?>">
			<?php
			if ( ! empty( $main_menu['menu'] ) ) {
				wp_nav_menu( array(
					'menu'        => $main_menu['menu'],
					'container'   => false,
					'fallback_cb' => false,
				) );
			} else {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'fallback_cb'    => false,
				) );
			}
			?>
		</nav>

		<?php if ( ! empty( $main_menu['button']['url'] ) ) : ?>
			<div class="mobile-nav__button">
				<?php
				estatein_button(
					$main_menu['button']['url'],
					$main_menu['button']['title'],
					'secondary',
					$main_menu['button']['target']
				);
				?>
			</div>
		<?php endif; ?>

		<?php estatein_social_links( $social_links ); ?>

	</div>
</div>
