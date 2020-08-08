<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('tmpenvo_woocommerce_simple_add_to_cart', 'tmpenvo_woocommerce_simple_add_to_cart_action', $priority = 10, 2);
add_action('tmpenvo_woocommerce_variable_add_to_cart', 'tmpenvo_woocommerce_variable_add_to_cart_action', $priority = 10, 2);
add_action('tmpenvo_woocommerce_external_add_to_cart', 'tmpenvo_woocommerce_external_add_to_cart_action', $priority = 10, 2);
add_action('tmpenvo_woocommerce_grouped_add_to_cart', 'tmpenvo_woocommerce_grouped_add_to_cart_action', $priority = 10, 2);
add_action('tmpenvo_woocommerce_simple_add_to_cart_template', 'tmpenvo_woocommerce_simple_add_to_cart_action', $priority = 10, 2);
add_action('tmpenvo_woocommerce_variable_add_to_cart_template', 'tmpenvo_woocommerce_variable_add_to_cart_action', $priority = 10, 2);
add_action('tmpenvo_woocommerce_external_add_to_cart_template', 'tmpenvo_woocommerce_external_add_to_cart_action', $priority = 10, 2);
add_action('tmpenvo_woocommerce_grouped_add_to_cart_template', 'tmpenvo_woocommerce_grouped_add_to_cart_action', $priority = 10, 2);
add_action('pre_get_posts', 'tmpenvo_archive_setter_woocommerce');

function tmpenvo_woocommerce_simple_add_to_cart_action($product, $tmpenvo_button_text)
{
    require plugin_dir_path(__FILE__) . 'elementor/widgets/woocommerce/templates/addtocart/tmpenvo-simpleproduct.php';
}

function tmpenvo_woocommerce_variable_add_to_cart_action($product, $tmpenvo_button_text)
{
    wp_enqueue_script('wc-add-to-cart-variation');
    $get_variations = count($product->get_children()) <= apply_filters('woocommerce_ajax_variation_threshold', 30, $product);
    $available_variations = $get_variations ? $product->get_available_variations() : false;
    $attributes           = $product->get_variation_attributes();
    $selected_attributes  = $product->get_default_attributes();
    require plugin_dir_path(__FILE__) . 'elementor/widgets/woocommerce/templates/addtocart/tmpenvo-variableproduct.php';
}

function tmpenvo_woocommerce_external_add_to_cart_action($product, $tmpenvo_button_text)
{
    wp_enqueue_script('wc-add-to-cart-variation');
    $product_url = $product->add_to_cart_url();
    $button_text = $product->single_add_to_cart_text();
    require plugin_dir_path(__FILE__) . 'elementor/widgets/woocommerce/templates/addtocart/tmpenvo-externalproduct.php';
}

function tmpenvo_woocommerce_grouped_add_to_cart_action($product, $tmpenvo_button_text)
{
    $products = array_filter(array_map('wc_get_product', $product->get_children()), 'wc_products_array_filter_visible_grouped');
    $grouped_product    = $product;
    $grouped_products   = $products;
    $quantites_required = false;
    require plugin_dir_path(__FILE__) . 'elementor/widgets/woocommerce/templates/addtocart/tmpenvo-groupedproduct.php';
}


function tmpenvo_archive_setter_woocommerce($query){
	if ( $query->is_archive('product') || $query->is_category() ) {
			if( !empty(get_option('tmpenvo_admin_options')['tmpenvo_woo_archive_num_count']) ){
				$tmpenvo_woo_archive_set = intval( get_option('tmpenvo_admin_options')['tmpenvo_woo_archive_num_count'] );
			}else{
				$tmpenvo_woo_archive_set = 12;
			}
			set_query_var('posts_per_page', $tmpenvo_woo_archive_set);
	}
}

add_filter( 'manage_elementor_library_posts_columns', 'tmpenvo_edit_elementor_library_posts_columns' );
function tmpenvo_edit_elementor_library_posts_columns( $columns ) {
	$columns['tmpenvo_shortcode_column'] = esc_html__( 'Shortcode', 'tmpenvo' );
	return $columns;
}
add_action( 'manage_elementor_library_posts_custom_column', 'tmpenvo_add_elementor_library_columns', 10, 2 );
function tmpenvo_add_elementor_library_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'tmpenvo_shortcode_column' :
			echo '<input type="text" class="widefat" value=\'[GEEKYGREENOWLTEMP id="' . $post_id . '"]\' readonly>';
			break;
	}
}
add_shortcode( 'GEEKYGREENOWLTEMP', 'tmpenvo_add_elementor_temp' );
function tmpenvo_add_elementor_temp( $atts ) {
	if ( ! class_exists( 'Elementor\Plugin' ) ) {
		return false;
	}
	if ( ! isset( $atts['id'] ) || empty( $atts['id'] ) ) {
		return false;
	}
	$post_id  = $atts['id'];
	$response = Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post_id );
	return $response;
}
