<?php
/**
 * The template for displaying search results.
 */

get_header();
?>

<main id="primary">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_title( sprintf( '<h2><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
			the_excerpt();
		endwhile;

		the_posts_navigation();
	else :
		esc_html_e( 'Nothing found.', 'estatein' );
	endif;
	?>
</main>

<?php
get_sidebar();
get_footer();
