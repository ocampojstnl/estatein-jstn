<?php
/**
 * The sidebar containing the widget area.
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
