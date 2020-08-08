<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.5
 */
defined('ABSPATH') || exit;

$attribute_keys  = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);
do_action('woocommerce_before_add_to_cart_form');?>

<form class="tmpenvo-cart tmpenvo_variation variations_form" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok.  ?>">
	<?php do_action('woocommerce_before_variations_form');?>

	<?php if (empty($available_variations) && false !== $available_variations): ?>
		<p class="stock out-of-stock"><?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', esc_html__('This product is currently out of stock and unavailable.', 'tmpenvo'))); ?></p>
	<?php else: ?>
		<div class="variations" cellspacing="0">
			<div>
				<?php foreach ($attributes as $attribute_name => $options): ?>
					<div class="tmpenvo-variation-options">
						<div class="tmpenvo_label">
              <div class="tmpenvo_label_post" for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>"><?php echo wc_attribute_label($attribute_name); // WPCS: XSS ok.  ?>
              </div>
						<div class="tmpenvo_value">
							<?php
wc_dropdown_variation_attribute_options(array(
    'options'   => $options,
    'attribute' => $attribute_name,
    'product'   => $product,
));
?>
						</div>
					</div>
          <?php echo end($attribute_keys) === $attribute_name ? wp_kses_post(apply_filters('woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__('Clear', 'tmpenvo') . '</a>')) : ''; ?>
        </div>
				<?php endforeach;?>
			</div>
		</div>

		<div class="single_variation_wrap">
			<?php
/**
 * Hook: woocommerce_before_single_variation.
 */
echo '<div class="tmpenvo-woocommerce-variation woocommerce-variation single_variation"></div>';
/**
 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
 *
 * @since 2.4.0
 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
 */
require plugin_dir_path(__FILE__) . '/tmpenvo-variation-add-to-cart-button.php';
/**
 * Hook: woocommerce_after_single_variation.
 */
 ?>
		</div>
	<?php endif;?>

	<?php do_action('woocommerce_after_variations_form');?>
</form>

<?php
do_action('woocommerce_after_add_to_cart_form');
