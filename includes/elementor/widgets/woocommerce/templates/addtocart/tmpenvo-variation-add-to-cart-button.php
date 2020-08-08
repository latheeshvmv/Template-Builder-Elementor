<?php
/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */
defined('ABSPATH') || exit;
?>
  <div class="tmpenvo-addtocart-main-container">
    <div class="tmpenvo-addtocart-main-container-quantity">
      <?php
woocommerce_quantity_input(array(
    'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
    'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
    'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
));
?>
    </div>
    <div class="tmpenvo-addtocart-main-container-button">
      <button type="submit" class="tmpenvo-button-addtocart"><?php echo esc_html($tmpenvo_button_text); ?></button>
      <input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
      <input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
      <input type="hidden" name="variation_id" class="variation_id" value="0" />
    </div>
  </div>
