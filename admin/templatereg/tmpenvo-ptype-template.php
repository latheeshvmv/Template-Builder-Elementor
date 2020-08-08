<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
add_action('init', 'tmpenvo_custom_template_post', 0);

function tmpenvo_custom_template_post()
{
    $labels = array(
        'name'                  => esc_html_x('Templates', 'Post Type General Name', 'tmpenvo'),
        'singular_name'         => esc_html_x('Template', 'Post Type Singular Name', 'tmpenvo'),
        'menu_name'             => esc_html__('GGOwl Templates', 'tmpenvo'),
        'name_admin_bar'        => esc_html__('Post Type', 'tmpenvo'),
        'archives'              => esc_html__('Template Archives', 'tmpenvo'),
        'attributes'            => esc_html__('Template Attributes', 'tmpenvo'),
        'parent_item_colon'     => esc_html__('Parent Template :', 'tmpenvo'),
        'all_items'             => esc_html__('All Template', 'tmpenvo'),
        'add_new_item'          => esc_html__('Add New Template', 'tmpenvo'),
        'add_new'               => esc_html__('Add New', 'tmpenvo'),
        'new_item'              => esc_html__('New Template', 'tmpenvo'),
        'edit_item'             => esc_html__('Edit Template', 'tmpenvo'),
        'update_item'           => esc_html__('Update Template', 'tmpenvo'),
        'view_item'             => esc_html__('View Template', 'tmpenvo'),
        'view_items'            => esc_html__('View Template', 'tmpenvo'),
        'search_items'          => esc_html__('Search Template', 'tmpenvo'),
        'not_found'             => esc_html__('Not found', 'tmpenvo'),
        'not_found_in_trash'    => esc_html__('Not found in Trash', 'tmpenvo'),
        'featured_image'        => esc_html__('Featured Image', 'tmpenvo'),
        'set_featured_image'    => esc_html__('Set featured image', 'tmpenvo'),
        'remove_featured_image' => esc_html__('Remove featured image', 'tmpenvo'),
        'use_featured_image'    => esc_html__('Use as featured image', 'tmpenvo'),
        'insert_into_item'      => esc_html__('Insert into Template', 'tmpenvo'),
        'uploaded_to_this_item' => esc_html__('Uploaded to this Template', 'tmpenvo'),
        'items_list'            => esc_html__('Templates list', 'tmpenvo'),
        'items_list_navigation' => esc_html__('Templates list navigation', 'tmpenvo'),
        'filter_items_list'     => esc_html__('Filter Templates list', 'tmpenvo'),
    );
    $args = array(
        'label'               => esc_html__('Template', 'tmpenvo'),
        'description'         => esc_html__('Create templates for elementor', 'tmpenvo'),
        'labels'              => $labels,
        'supports'            => array('title', 'editor', 'revisions', 'comments'),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-clipboard',
        'show_in_admin_bar'   => false,
        'show_in_nav_menus'   => false,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type('tmpenvo_template', $args);
}

add_filter('manage_tmpenvo_template_posts_columns', 'tmpenvo_edit_tmpenvo_template_posts_columns');
function tmpenvo_edit_tmpenvo_template_posts_columns($columns)
{
    $columns['tmpenvo_shortcode_column'] = esc_html__('Shortcode', 'tmpenvo');
    return $columns;
}

add_action('manage_tmpenvo_template_posts_custom_column', 'tmpenvo_add_tmpenvo_template_columns', 10, 2);
function tmpenvo_add_tmpenvo_template_columns($column, $post_id)
{
    switch ($column) {
        case 'tmpenvo_shortcode_column':
            echo '<input type="text" class="widefat" value=\'[GEEKYGREENOWL id="' . $post_id . '"]\' readonly>';
            break;
    }
}
add_shortcode('GEEKYGREENOWL', 'tmpenvo_add_elementor');
function tmpenvo_add_elementor($atts)
{
    if (!class_exists('Elementor\Plugin')) {
        return false;
    }
    if (!isset($atts['id']) || empty($atts['id'])) {
        return false;
    }
    $post_id  = $atts['id'];
    $response = Elementor\Plugin::instance()->frontend->get_builder_content_for_display($post_id);
    return $response;
}

function tmpenvo_template_default_comments_on($data)
{
    if ($data['post_type'] == 'tmpenvo_template') {
        $data['comment_status'] = 1;
    }

    return $data;
}
add_filter('wp_insert_post_data', 'tmpenvo_template_default_comments_on');
add_filter('single_template', 'tmpenvo_template_post_function', -20, 1);
add_filter('page_template', 'tmpenvo_template_post_function', -20, 1);

function tmpenvo_template_post_function($single)
{
    if (false !== get_option('tmpenvo_admin_options')) {
        global $post;
        if (!is_object($post)) {
            return $single;
        }

        $tmpenvo_admin_options = get_option('tmpenvo_admin_options'); // Array of All Options
        if (isset($tmpenvo_admin_options['tmpenvo_select_post_template_repeater'])) {
            $tmpenvo_admin_template_options = $tmpenvo_admin_options['tmpenvo_select_post_template_repeater'];
            foreach ($tmpenvo_admin_template_options as $key => $value) {
                $posttype                     = $value[0];
                $tmpenvo_select_post_template_0 = (int) $value['template'][0][0];
                $tmpenvo_inclution              = (int) $value['templateinc'][0][0]; // include or exclude
                $tmpenvo_inclution_type         = (int) $value['templateinctype'][0][0]; //  What kind of inclution

                switch ($tmpenvo_inclution_type) {
                    case '0': //all
                        if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0)) {
                            if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php')) {
                                return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php';
                            }
                        }
                        break;
                    case '1': // specific post

                        $tmpenvo_spec_array = $value['templateincdata'][0][0]; //the ids to be considered
                        if (!empty($tmpenvo_spec_array)) {
                            $tmpenvo_spec_array_data = array_map('intval', (array_map('trim', explode("|", $tmpenvo_spec_array))));
                        } else {
                            $tmpenvo_spec_array_data = array();
                        }

                        if ($tmpenvo_inclution == 0) {
                            # code...
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (in_array(get_the_ID(), $tmpenvo_spec_array_data))) {
                                if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php')) {
                                    return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php';
                                }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!in_array(get_the_ID(), $tmpenvo_spec_array_data))) {
                                if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php')) {
                                    return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php';
                                }
                            }
                        }

                        break;

                    case '2': //category
                        $tmpenvo_spec_array = $value['templateincdata'][0][0]; //the ids to be considered
                        if (!empty($tmpenvo_spec_array)) {
                            $tmpenvo_spec_array_data = array_map('intval', (array_map('trim', explode("|", $tmpenvo_spec_array))));
                        } else {
                            $tmpenvo_spec_array_data = array();
                        }

                        $category_list = wp_get_post_categories(get_the_ID());

                        if (!empty($category_list)) {
                            $commoncheck = count(array_intersect($category_list, $tmpenvo_spec_array_data));
                        } else {
                            $commoncheck = "";
                        }

                        if ($tmpenvo_inclution == 0) {
                            # code...
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!empty($commoncheck))) {
                                if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php')) {
                                    return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php';
                                }
                            }

                        } elseif ($tmpenvo_inclution == 1) {

                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (empty($commoncheck))) {
                                if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php')) {
                                    return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php';
                                }
                            }

                        }

                        break;

                    case '3': //tages
                        $tmpenvo_spec_array = $value['templateincdata'][0][0]; //the ids to be considered
                        if (!empty($tmpenvo_spec_array)) {
                            $tmpenvo_spec_array_data = array_map('intval', (array_map('trim', explode("|", $tmpenvo_spec_array))));
                        } else {
                            $tmpenvo_spec_array_data = array();
                        }

                        $tag_list = get_the_tags(get_the_ID());
                        $taglist_id = array();

                        foreach ($tag_list as $key => $value) {
                            $taglist_id[] = $value->term_id;
                        }
                        if (!empty($taglist_id)) {
                            $commoncheck = count(array_intersect($taglist_id, $tmpenvo_spec_array_data));
                        } else {
                            $commoncheck = "";
                        }

                        if ($tmpenvo_inclution == 0) {
                            # code...
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!empty($commoncheck))) {
                                if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php')) {
                                    return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php';
                                }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (empty($commoncheck))) {
                                if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php')) {
                                    return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php';
                                }
                            }
                        }

                        break;
                    case '4': //author
                        $tmpenvo_spec_array = $value['templateincdata'][0][0]; //the ids to be considered
                        if (!empty($tmpenvo_spec_array)) {
                            $tmpenvo_spec_array_data = array_map('intval', (array_map('trim', explode("|", $tmpenvo_spec_array))));
                        } else {
                            $tmpenvo_spec_array_data = array();
                        }
                        global $post;
                        $author_id = $post->post_author;

                        if ($tmpenvo_inclution == 0) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (in_array($author_id, $tmpenvo_spec_array_data))) {
                                if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php')) {
                                    return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php';
                                }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!in_array($author_id, $tmpenvo_spec_array_data))) {
                                if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php')) {
                                    return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-post.php';
                                }
                            }
                        }
                        break;
                }

            }
        }
    }
    return $single;
}
add_filter('single_template', 'tmpenvo_template_core');

function tmpenvo_template_core($single)
{

    global $post;
    /* Checks for single template by post type */
    if ($post->post_type == 'tmpenvo_template') {
        if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/core-template/tmpenvo-template-core.php')) {
            return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/core-template/tmpenvo-template-core.php';
        }
    }
    return $single;
}

add_action('updated_option', 'tmpenvo_update_elelementor_as_defualt', $priority = 10, $accepted_args = 1);
function tmpenvo_update_elelementor_as_defualt($option)
{
    if ($option == 'elementor_cpt_support') {
        $tmpenvo_elementor_editor_support = get_option('elementor_cpt_support');
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
        flush_rewrite_rules();
    }
}
