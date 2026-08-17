<?php
/**
 * Card renderers for the Slider Section block — one per source post type.
 * Kept separate from the block's template.php so the same cards could be
 * reused by an archive template later without duplicating markup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Property card: image, title, trimmed description + Read More, meta pills, price + button.
 */
function estatein_render_property_card( $post_id ) {
	$title       = get_the_title( $post_id );
	$permalink   = get_permalink( $post_id );
	$description = get_field( 'description', $post_id );
	$bedrooms    = get_field( 'bedrooms', $post_id );
	$bathrooms   = get_field( 'bathrooms', $post_id );
	$type        = get_field( 'property_type', $post_id );
	$price       = get_field( 'price', $post_id );
	?>
	<article class="property-card">
		<?php if ( has_post_thumbnail( $post_id ) ) : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="property-card__image">
				<?php echo get_the_post_thumbnail( $post_id, 'large' ); ?>
			</a>
		<?php endif; ?>

		<h3 class="property-card__title"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a></h3>

		<?php if ( $description ) : ?>
			<div class="property-card__description-wrap">
				<p class="property-card__description"><?php echo esc_html( wp_trim_words( $description, 12, '…' ) ); ?></p>
				<a href="<?php echo esc_url( $permalink ); ?>" class="property-card__readmore"><?php esc_html_e( 'Read More', 'estatein' ); ?></a>
			</div>
		<?php endif; ?>

		<?php if ( $bedrooms || $bathrooms || $type ) : ?>
			<div class="property-card__meta">
				<?php if ( $bedrooms ) : ?>
					<span class="property-card__pill"><img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/bedroom.svg' ); ?>" alt=""><?php echo esc_html( $bedrooms . '-' . __( 'Bedroom', 'estatein' ) ); ?></span>
				<?php endif; ?>
				<?php if ( $bathrooms ) : ?>
					<span class="property-card__pill"><img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/bathroom.svg' ); ?>" alt=""><?php echo esc_html( $bathrooms . '-' . __( 'Bathroom', 'estatein' ) ); ?></span>
				<?php endif; ?>
				<?php if ( $type ) : ?>
					<span class="property-card__pill"><img src="<?php echo esc_url( ESTATEIN_URI . '/assets/images/villa.svg' ); ?>" alt=""><?php echo esc_html( $type ); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<div class="property-card__footer">
			<?php if ( $price ) : ?>
				<span class="property-card__price">
					<span class="property-card__price-label"><?php esc_html_e( 'Price', 'estatein' ); ?></span>
					<span class="property-card__price-value"><?php echo esc_html( $price ); ?></span>
				</span>
			<?php endif; ?>
			<?php estatein_button( $permalink, __( 'View Property Details', 'estatein' ), 'primary' ); ?>
		</div>
	</article>
	<?php
}

/**
 * Testimonial card: stars, title, description, author (headshot/name/location).
 */
function estatein_render_testimonial_card( $post_id ) {
	$title       = get_the_title( $post_id );
	$description = get_field( 'description', $post_id );
	$stars       = (int) get_field( 'stars', $post_id );
	$author      = get_field( 'author', $post_id );
	?>
	<article class="testimonial-card">
		<?php if ( $stars ) : ?>
			<div class="testimonial-card__stars">
				<?php for ( $i = 0; $i < $stars; $i++ ) : ?>
					<?php echo estatein_ui_icon( 'star' ); ?>
				<?php endfor; ?>
			</div>
		<?php endif; ?>

		<?php if ( $title ) : ?>
			<h3 class="testimonial-card__title"><?php echo esc_html( $title ); ?></h3>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<p class="testimonial-card__description"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $author['name'] ) ) : ?>
			<div class="testimonial-card__author">
				<?php if ( ! empty( $author['headshot']['url'] ) ) : ?>
					<img class="testimonial-card__headshot" src="<?php echo esc_url( $author['headshot']['url'] ); ?>" alt="<?php echo esc_attr( $author['headshot']['alt'] ?: $author['name'] ); ?>">
				<?php endif; ?>
				<span class="testimonial-card__author-info">
					<span class="testimonial-card__author-name"><?php echo esc_html( $author['name'] ); ?></span>
					<?php if ( ! empty( $author['location'] ) ) : ?>
						<span class="testimonial-card__author-location"><?php echo esc_html( $author['location'] ); ?></span>
					<?php endif; ?>
				</span>
			</div>
		<?php endif; ?>
	</article>
	<?php
}

/**
 * FAQ card: title, trimmed description + Read More button that opens the shared
 * FAQ modal (markup in footer.php). Full content is stashed in a <template> so
 * the modal script can clone it without an extra request.
 */
function estatein_render_faq_card( $post_id ) {
	$title       = get_the_title( $post_id );
	$description = get_field( 'description', $post_id );
	$plain_text  = $description ? wp_strip_all_tags( $description ) : '';
	?>
	<article class="faq-card">
		<?php if ( $title ) : ?>
			<h3 class="faq-card__title"><?php echo esc_html( $title ); ?></h3>
		<?php endif; ?>

		<?php if ( $plain_text ) : ?>
			<p class="faq-card__description">
				<?php echo esc_html( wp_trim_words( $plain_text, 16, '…' ) ); ?>
				<button type="button" class="faq-card__readmore" data-faq-trigger><?php esc_html_e( 'Read More', 'estatein' ); ?></button>
			</p>
		<?php endif; ?>

		<?php if ( $description ) : ?>
			<template class="faq-card__full">
				<h3><?php echo esc_html( $title ); ?></h3>
				<?php echo wp_kses_post( $description ); ?>
			</template>
			<?php $GLOBALS['estatein_needs_faq_modal'] = true; ?>
		<?php endif; ?>
	</article>
	<?php
}
