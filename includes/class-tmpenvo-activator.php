<?php

/**
 * Fired during plugin activation
 *
 * @link       https://envomart.com
 * @since      1.0.0
 *
 * @package    Ggowl
 * @subpackage Ggowl/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Ggowl
 * @subpackage Ggowl/includes
 * @author     Latheesh V M <owl@geekygreenowl.com>
 */
class Ggowl_Activator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        $tmpenvo_elementor_editor_support = get_option('elementor_cpt_support');
        if (!$tmpenvo_elementor_editor_support) {
            $tmpenvo_elementor_editor_support = ['tmpenvo_template', 'tmpenvo_templ_arch, tmpenvo_template_snip']; //create array of our default supported post types
            update_option('elementor_cpt_support', $tmpenvo_elementor_editor_support); //write it to the database
        }
        if (!in_array('tmpenvo_template', $tmpenvo_elementor_editor_support)) {
            $tmpenvo_elementor_editor_support[] = 'tmpenvo_template'; //append to array
            update_option('elementor_cpt_support', $tmpenvo_elementor_editor_support); //update database
        }
        if (!in_array('tmpenvo_templ_arch', $tmpenvo_elementor_editor_support)) {
            $tmpenvo_elementor_editor_support[] = 'tmpenvo_templ_arch'; //append to array
            update_option('elementor_cpt_support', $tmpenvo_elementor_editor_support); //update database
        }
        if (!in_array('tmpenvo_template_snip', $tmpenvo_elementor_editor_support)) {
            $tmpenvo_elementor_editor_support[] = 'tmpenvo_template_snip'; //append to array
            update_option('elementor_cpt_support', $tmpenvo_elementor_editor_support); //update database
        }

        require_once plugin_dir_path( TMPENVO_PLUGIN_FILE ) . 'admin/templatereg/tmpenvo-ptype-archive.php';
        require_once plugin_dir_path( TMPENVO_PLUGIN_FILE ) . 'admin/templatereg/tmpenvo-ptype-template.php';
        tmpenvo_custom_template_post_archive();
        tmpenvo_custom_template_post();
        flush_rewrite_rules();
    }

}
