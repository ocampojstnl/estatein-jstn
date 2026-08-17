<?php
/**
 * Archive template for the "testimonial" post type — destination of the
 * Slider Section block's "View All Testimonials" button.
 */

get_header();
?>

<main id="primary" class="cpt-archive">
	<div class="container">
		<div class="cpt-archive__header">
			<h1 class="cpt-archive__title"><?php post_type_archive_title(); ?></h1>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="cpt-archive__grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="reveal">
						<?php estatein_render_testimonial_card( get_the_ID() ); ?>
					</div>
					<?php
				endwhile;
				?>
			</div>

			<div class="cpt-archive__pagination">
				<?php the_posts_pagination(); ?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'No testimonials found.', 'estatein' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
