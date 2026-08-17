<?php
/**
 * Template Name: Coming Soon
 */

get_header();
?>

<main id="primary" class="coming-soon">
	<div class="container coming-soon__inner">
		<div class="coming-soon__eyebrow" aria-hidden="true">
			<img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/abstract-design.svg' ); ?>" alt="">
		</div>
		<h1 class="coming-soon__title"><?php esc_html_e( "We're Coming Soon", 'estatein' ); ?></h1>
		<p class="coming-soon__text"><?php esc_html_e( "We're working hard behind the scenes to bring you something great. Check back soon.", 'estatein' ); ?></p>
		<?php estatein_button( home_url( '/' ), __( 'Back to Home', 'estatein' ), 'primary' ); ?>
	</div>
</main>

<?php
get_footer();
