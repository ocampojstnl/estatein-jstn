<?php
/**
 * The template for displaying single posts.
 */

get_header();
?>

<main id="primary">
	<?php
	while ( have_posts() ) :
		the_post();
		the_title( '<h1>', '</h1>' );
		the_content();
	endwhile;
	?>
</main>

<?php
get_sidebar();
get_footer();
