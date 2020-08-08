<?php

/**
 * @link              https://envomart.com
 * @since             1.0.0
 * @package           Ggowl
 *
 * @wordpress-plugin
 * Plugin Name:       Template Builder Elementor
 * Plugin URI:        https://envomart.com
 * Description:       Create custom templates for your posts, pages, custom post types. Supports WooCommerce , ACF Custom fields
 * Version:           1.0.0
 * Author:            Latheesh V M Villa
 * Author URI:        https://envomart.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tmpenvo
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'ABSPATH' ) || exit;
define( 'TMPENVO_PLUGIN_FILE', __FILE__ );

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TMPENVO_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tmpenvo-activator.php
 */
function tmpenvo_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tmpenvo-activator.php';
	Ggowl_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tmpenvo-deactivator.php
 */
function tmpenvo_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tmpenvo-deactivator.php';
	Ggowl_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'tmpenvo_activate' );
register_deactivation_hook( __FILE__, 'tmpenvo_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/tmpenvo-functions.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-tmpenvo.php';
require plugin_dir_path( __FILE__ ) . 'admin/templatereg/tmpenvo-ptype-archive.php';
require plugin_dir_path( __FILE__ ) . 'admin/templatereg/tmpenvo-ptype-template.php';
require plugin_dir_path( __FILE__ ) . 'admin/woocommerce/tmpenvo-woocommerce.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-tmpenvo-helper.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-tmpenvo-filters.php';
//Elementor
require plugin_dir_path( __FILE__ ) . 'includes/elementor/tmpenvo-elementor-widget-register.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function tmpenvo_run() {
	$plugin_filers = new TMPENVOFILNS\GgowlFilters();
	$plugin = new Ggowl();
	$plugin->run();
}
tmpenvo_run();

function tmpenvo_query_vars( $tmpenvo_qvars ) {
		$args = array(
		'public'   => true,);
		$output = 'objects';

		$taxonomies = get_taxonomies( $args,$output );
		$formated = array();
		if ( $taxonomies ) {
		foreach ( $taxonomies as $taxonomy ) {
				$formated[$taxonomy->name] =   $taxonomy->labels->name;
				}
		}
		if(is_array($formated) && !empty($formated)){
			foreach ($formated as $key => $value) {
				for ($i=0; $i < 5; $i++) {
					$tmpenvo_qvars[] = 'tmpenvo-taxon-select-'.$key.'-'.$i;
				}
			}
		}

		$formated_new = array();
		if ( $taxonomies ) {
		foreach ( $taxonomies as $taxonomy ) {
				$formated_new[$taxonomy->name] =   $taxonomy->labels->name;
				}
		}
		foreach ($formated_new as $key => $value) {
			$terms = get_terms([
					'taxonomy' => $key,
					'hide_empty' => false,
			]);
			$saveterm = $key;
			foreach ($terms as $keyterm => $valuekey) {
				$tmpenvo_qvars[] = 'tmpenvo-'.$saveterm.'-sep-'.$valuekey->term_id;
			}
		}

    $tmpenvo_qvars[] = 'tmpenvo-sort-acend';
		$tmpenvo_qvars[] = 'tmpenvo-sort-decend';
    return $tmpenvo_qvars;
}
add_filter( 'query_vars', 'tmpenvo_query_vars' );



function tmpenvo_transient_del_save_post_callback($post_id){
    global $post;
		if(!empty($post->post_type)){
			if ($post->post_type != 'acf-field-group'){
					delete_transient( 'tmpenvo_acf_list_transient' );
	        return;
	    }
		}
}
add_action('save_post','tmpenvo_transient_del_save_post_callback');
add_action('after_delete_post','tmpenvo_transient_del_save_post_callback');
