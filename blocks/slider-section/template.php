<?php
/**
 * Block: Slider Section
 *
 * Same header/footer/nav skeleton regardless of source — only the slide
 * markup changes, rendered via the estatein_render_{source}_card() helpers
 * in inc/slider-render.php.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty).
 * @param bool   $is_preview True during backend preview render.
 * @param int    $post_id    The post ID the block is rendered on.
 */

$title   = get_field( 'title' );
$content = get_field( 'content' );
$source  = get_field( 'source' ) ?: 'property';

// Base skeleton CSS is auto-enqueued via style.css (see functions.php block scanner);
// only the CSS for the selected card type gets loaded on top of it.
wp_enqueue_style(
	'estatein-slider-section-' . $source,
	ESTATEIN_URI . "/blocks/slider-section/style-{$source}.css",
	array(),
	estatein_asset_version( "/blocks/slider-section/style-{$source}.css" )
);

$id = 'slider-section-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
	$id = $block['anchor'];
}

$class_name = 'slider-section slider-section--' . $source;
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}

$labels = array(
	'property'    => __( 'View All Properties', 'estatein' ),
	'testimonial' => __( 'View All Testimonials', 'estatein' ),
	'faq'         => __( "View All FAQ's", 'estatein' ),
);

$archive_link = get_post_type_archive_link( $source );

$query = new WP_Query( array(
	'post_type'      => $source,
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

$total = $query->found_posts;
?>

<section id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class_name ); ?>" data-slider-source="<?php echo esc_attr( $source ); ?>">
	<div class="container">

		<div class="slider-section__header">
			<div class="slider-section__heading reveal">
				<div class="slider-section__eyebrow" aria-hidden="true">
					<img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/abstract-design.svg' ); ?>" alt="">
				</div>

				<?php if ( $title ) : ?>
					<h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>

				<?php if ( $content ) : ?>
					<div class="slider-section__text"><?php echo wp_kses_post( $content ); ?></div>
				<?php endif; ?>
			</div>

			<?php if ( $archive_link ) : ?>
				<div class="slider-section__cta">
					<?php estatein_button( $archive_link, $labels[ $source ], 'secondary' ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( $query->have_posts() ) : ?>
			<div class="slider-section__viewport">
				<div class="slider-section__track" data-slider-track>
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();
						?>
						<div class="slider-section__slide reveal">
							<?php
							switch ( $source ) {
								case 'testimonial':
									estatein_render_testimonial_card( get_the_ID() );
									break;
								case 'faq':
									estatein_render_faq_card( get_the_ID() );
									break;
								default:
									estatein_render_property_card( get_the_ID() );
							}
							?>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>

			<div class="slider-section__footer">
				<span class="slider-section__counter" data-slider-counter>
					<span class="slider-section__counter-current" data-slider-counter-current><?php echo esc_html( sprintf( '%02d', 1 ) ); ?></span>
					<?php echo esc_html( ' ' . __( 'of', 'estatein' ) . ' ' . $total ); ?>
				</span>
				<div class="slider-section__nav">
					<button type="button" class="slider-section__nav-btn" data-slider-prev aria-label="<?php esc_attr_e( 'Previous slide', 'estatein' ); ?>">
						<img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/arrow-left.svg' ); ?>" alt="">
					</button>
					<button type="button" class="slider-section__nav-btn" data-slider-next aria-label="<?php esc_attr_e( 'Next slide', 'estatein' ); ?>">
						<img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/arrow-right.svg' ); ?>" alt="">
					</button>
				</div>
			</div>
		<?php endif; ?>

	</div>
</section>
