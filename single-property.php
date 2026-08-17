<?php
/**
 * Single template for the "property" post type.
 */

get_header();

while ( have_posts() ) :
	the_post();

	$description = get_field( 'description' );
	$bedrooms    = get_field( 'bedrooms' );
	$bathrooms   = get_field( 'bathrooms' );
	$type        = get_field( 'property_type' );
	$price       = get_field( 'price' );
	?>

	<main id="primary" class="cpt-single cpt-single--property">
		<div class="container">
			<h1 class="cpt-single__title"><?php the_title(); ?></h1>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="cpt-single__image">
					<?php the_post_thumbnail( 'large' ); ?>
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

			<?php if ( $price ) : ?>
				<p class="property-card__price-value"><?php echo esc_html( $price ); ?></p>
			<?php endif; ?>

			<?php if ( $description ) : ?>
				<div class="cpt-single__content"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
			<?php endif; ?>
		</div>
	</main>

	<?php
endwhile;

get_footer();
