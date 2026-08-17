<?php
/**
 * Block: Hero Section
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during backend preview render.
 * @param int    $post_id    The post ID the block is rendered on.
 */

$title         = get_field( 'title' );
$content       = get_field( 'content' );
$links         = get_field( 'links' );
$columns       = get_field( 'columns' );
$featured      = get_field( 'featured_image' );
$spinning_text = get_field( 'spinning_text' );
$bg_image      = get_field( 'featured_bg_image' );
$bg_color      = get_field( 'featured_bg_color' );

$id = 'hero-section-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

$class_name = 'hero';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

$featured_style = '';
if ( ! empty( $bg_color ) ) {
	$featured_style .= 'background-color: var(--color-' . esc_attr( $bg_color ) . ');';
}
if ( ! empty( $bg_image['url'] ) ) {
	$featured_style .= 'background-image: url(' . esc_url( $bg_image['url'] ) . ');';
}
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class_name ); ?>">
	<div class="hero__inner">

		<div class="hero__content reveal">
			<div class="hero-content-inner">
				<?php if ( $title ) : ?>
					<h1 class="hero__title"><?php echo esc_html( $title ); ?></h1>
				<?php endif; ?>

				<?php if ( $content ) : ?>
					<div class="hero__text"><?php echo wp_kses_post( $content ); ?></div>
				<?php endif; ?>

				<?php if ( $links ) : ?>
					<div class="hero__links">
						<?php
						foreach ( $links as $row ) {
							$link = $row['link'];
							if ( empty( $link['url'] ) ) {
								continue;
							}
							estatein_button( $link['url'], $link['title'], $row['style'], $link['target'] );
						}
						?>
					</div>
				<?php endif; ?>

				<?php if ( $columns ) : ?>
					<div class="hero__columns">
						<?php foreach ( $columns as $column ) : ?>
							<div class="hero__column">
								<?php if ( ! empty( $column['column_title'] ) ) : ?>
									<span class="hero__column-title"><?php echo esc_html( $column['column_title'] ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $column['column_text'] ) ) : ?>
									<span class="hero__column-text"><?php echo esc_html( $column['column_text'] ); ?></span>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<div class="hero__featured reveal reveal-delay-2"<?php echo $featured_style ? ' style="' . esc_attr( $featured_style ) . '"' : ''; ?>>
			<?php if ( ! empty( $featured['url'] ) ) : ?>
				<img class="hero__featured-image" src="<?php echo esc_url( $featured['url'] ); ?>" alt="<?php echo esc_attr( $featured['alt'] ); ?>">
			<?php endif; ?>

			<?php if ( $spinning_text ) : ?>
				<div class="hero__spinner" aria-hidden="true">
					<svg class="hero__spinner-ring" viewBox="0 0 175 175">
						<defs>
							<path id="<?php echo esc_attr( $id ); ?>-path" d="M 87.5,87.5 m -60,0 a 60,60 0 1,1 120,0 a 60,60 0 1,1 -120,0" fill="none"></path>
						</defs>
						<text>
							<textPath href="#<?php echo esc_attr( $id ); ?>-path">
								<?php echo esc_html( $spinning_text ); ?>
							</textPath>
						</text>
					</svg>
					<span class="hero__spinner-arrow">
						<!-- <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg> -->
						 <img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/diagonal-arrow.png' ); ?>" alt="" class="arrow-spinner">
					</span>
				</div>
			<?php endif; ?>
		</div>

	</div>
</section>
