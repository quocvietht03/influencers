<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<div <?php wc_product_class( 'woocommerce-loop-product', $product ); ?>>
	<div class="woocommerce-loop-product__thumbnail">
		<div class="wc-cover-image">
			<?php
				do_action('influencers_woocommerce_template_loop_product_link_open');
				do_action('influencers_woocommerce_template_loop_product_thumbnail');
				do_action('influencers_woocommerce_template_loop_product_link_close');
			?>
		</div>
		<?php
			do_action('influencers_woocommerce_show_product_loop_sale_flash');
			do_action('influencers_woocommerce_template_loop_add_to_cart');
		?>
	</div>
	<div class="woocommerce-loop-product__infor">
		<?php
			do_action('influencers_woocommerce_shop_loop_item_subtitle');
			do_action('influencers_woocommerce_template_loop_rating');
			do_action('influencers_woocommerce_template_loop_product_link_open');
			do_action('influencers_woocommerce_template_loop_product_title');
			do_action('influencers_woocommerce_template_loop_product_link_close');
			do_action('influencers_woocommerce_template_loop_price');
		?>
	</div>
	<?php

	?>
</div>
