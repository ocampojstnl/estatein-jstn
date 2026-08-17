<?php
/**
 * Block: Example Block
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during backend preview render.
 * @param int    $post_id    The post ID the block is rendered on.
 */

$id = 'example-block-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

$class_name = 'example-block';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}
?>

<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<?php if ( function_exists( 'the_field' ) ) : ?>
		<?php the_field( 'heading' ); ?>
	<?php endif; ?>
</div>
