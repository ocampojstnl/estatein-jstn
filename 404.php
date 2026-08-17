<?php
/**
 * The template for displaying 404 pages (not found).
 */

get_header();
?>

<main id="primary" class="error-404">
	<div class="container error-404__inner">
		<span class="error-404__code">404</span>
		<h1 class="error-404__title"><?php esc_html_e( 'Page Not Found', 'estatein' ); ?></h1>
		<p class="error-404__text"><?php esc_html_e( "The page you're looking for doesn't exist or may have been moved.", 'estatein' ); ?></p>
		<?php estatein_button( home_url( '/' ), __( 'Back to Home', 'estatein' ), 'primary' ); ?>
	</div>
</main>

<?php
get_footer();
