<?php
/**
 * Default template for the [sb1_services] shortcode.
 *
 * Override by placing this file at {theme}/sb1-services/services-grid.php.
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="sb1-services-grid sb1-services-columns-<?php echo esc_attr( $columns ); ?>">
	<?php while ( $services->have_posts() ) : $services->the_post(); ?>
		<?php
		$post_id           = get_the_ID();
		$short_description = get_post_meta( $post_id, '_sb1_short_description', true );
		$icon              = get_post_meta( $post_id, '_sb1_icon', true );
		$cta_url           = get_post_meta( $post_id, '_sb1_cta_url', true );
		$is_image_url      = $icon && filter_var( $icon, FILTER_VALIDATE_URL );
		?>
		<div class="sb1-service-card">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="sb1-service-thumbnail">
					<?php the_post_thumbnail( 'medium' ); ?>
				</div>
			<?php endif; ?>

			<?php if ( $icon ) : ?>
				<div class="sb1-service-icon">
					<?php if ( $is_image_url ) : ?>
						<img src="<?php echo esc_url( $icon ); ?>" alt="<?php the_title_attribute(); ?>" />
					<?php else : ?>
						<i class="<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<h3 class="sb1-service-title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h3>

			<?php if ( $short_description ) : ?>
				<p class="sb1-service-description"><?php echo esc_html( $short_description ); ?></p>
			<?php endif; ?>

			<?php if ( $cta_url ) : ?>
				<a class="sb1-service-cta" href="<?php echo esc_url( $cta_url ); ?>">
					<?php esc_html_e( 'Learn More', 'wp-sitebuilderone-lite' ); ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endwhile; ?>
</div>
