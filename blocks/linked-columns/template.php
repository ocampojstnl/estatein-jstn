<?php
/**
 * Block: Linked Columns Section
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during backend preview render.
 * @param int    $post_id    The post ID the block is rendered on.
 */

$columns = get_field( 'columns' );

$id = 'linked-columns-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor']; 
}

$class_name = 'linked-columns';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="inner-wrapper">
		<?php if ( $columns ) : ?>
			<div class="linked-columns__list">
				<?php foreach ( $columns as $column ) :
					$title = $column['title'];
					$icon  = $column['icon'];
					$link  = $column['link'];
					$tag   = ! empty( $link['url'] ) ? 'a' : 'div';
					?>
					<<?php echo $tag; ?> class="linked-columns__item reveal"
						<?php if ( 'a' === $tag ) : ?>
							href="<?php echo esc_url( $link['url'] ); ?>"
							<?php echo ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener"' : ''; ?>
						<?php endif; ?>
					>
						<span class="linked-columns__arrow">
							<img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/diagonal-arrow.png' ); ?>" alt="">
						</span>

						<?php if ( ! empty( $icon['url'] ) ) : ?>
							<div class="img-wrapper">
								<img src="<?php echo esc_url( $icon['url'] ); ?>" alt="<?php echo esc_attr( $icon['alt'] ); ?>">
							</div>
						<?php endif; ?>

						<?php if ( $title ) : ?>
							<span class="linked-columns__title"><?php echo esc_html( $title ); ?></span>
						<?php endif; ?>
					</<?php echo $tag; ?>>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
