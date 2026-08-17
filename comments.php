<?php
/**
 * The template for displaying comments.
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments">
	<?php
	if ( have_comments() ) :
		echo '<h2>' . esc_html( get_comments_number() ) . ' comments</h2>';
		wp_list_comments();
		the_comments_navigation();
	endif;

	if ( comments_open() ) :
		comment_form();
	endif;
	?>
</div>
