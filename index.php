<?php
/**
 * The main template file.
 */

get_header();
?>

<main id="primary">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
	else :
		esc_html_e( 'Nothing found.', 'estatein' );
	endif;
	?>
</main>

<?php
get_sidebar();
get_footer();
