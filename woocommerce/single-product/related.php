<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) :

	if(function_exists('get_field')){
		$related_posts = get_field('product_related_posts', 'options');
	} else {
		$related_posts = array(
			'sub_heading' => __( 'Style Change Your Life', 'influencers' ),
			'heading' => __( 'Related Products', 'influencers' ),
			'text_heading' => ''
		);
	}

?>

	<section class="related products">

		<div class="bt-related-heading">
			<?php
				if(!empty($related_posts['sub_heading'])) {
					echo '<div class="bt-sub-text">' . $related_posts['sub_heading'] . '</div>';
				}

				if(!empty($related_posts['heading'])) {
					echo '<h2 class="bt-main-text">' . $related_posts['heading'] . '</h2>';
				}

				if(!empty($related_posts['text_heading'])) {
					echo '<div class="bt-head-text">' . $related_posts['text_heading'] . '</div>';
				}
			?>
		</div>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

					<?php
					$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'product' );
					?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

		<?php
			if(!empty($related_posts['bottom_text'])) {
				echo '<div class="bt-related-bottom-text">' . $related_posts['bottom_text'] . '</div>';
			}
		?>
	</section>
	<?php
endif;

wp_reset_postdata();
