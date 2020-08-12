<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
add_action('init', 'tmpenvo_custom_template_post_archive', 0);

function tmpenvo_custom_template_post_archive()
{
    $labels = array(
        'name'                  => esc_html_x('Archive Templates', 'Post Type General Name', 'tmpenvo'),
        'singular_name'         => esc_html_x('Archive Template', 'Post Type Singular Name', 'tmpenvo'),
        'menu_name'             => esc_html__('TmpEnvo Archive Templates', 'tmpenvo'),
        'name_admin_bar'        => esc_html__('Post Type', 'tmpenvo'),
        'archives'              => esc_html__('Archive Template Archives', 'tmpenvo'),
        'attributes'            => esc_html__('Archive Template Attributes', 'tmpenvo'),
        'parent_item_colon'     => esc_html__('Parent Archive Template :', 'tmpenvo'),
        'all_items'             => esc_html__('All Archive Template', 'tmpenvo'),
        'add_new_item'          => esc_html__('Add New Archive Template', 'tmpenvo'),
        'add_new'               => esc_html__('Add New', 'tmpenvo'),
        'new_item'              => esc_html__('New Archive Template', 'tmpenvo'),
        'edit_item'             => esc_html__('Edit Archive Template', 'tmpenvo'),
        'update_item'           => esc_html__('Update Archive Template', 'tmpenvo'),
        'view_item'             => esc_html__('View Archive Template', 'tmpenvo'),
        'view_items'            => esc_html__('View Archive Template', 'tmpenvo'),
        'search_items'          => esc_html__('Search Archive Template', 'tmpenvo'),
        'not_found'             => esc_html__('Not found', 'tmpenvo'),
        'not_found_in_trash'    => esc_html__('Not found in Trash', 'tmpenvo'),
        'featured_image'        => esc_html__('Featured Image', 'tmpenvo'),
        'set_featured_image'    => esc_html__('Set featured image', 'tmpenvo'),
        'remove_featured_image' => esc_html__('Remove featured image', 'tmpenvo'),
        'use_featured_image'    => esc_html__('Use as featured image', 'tmpenvo'),
        'insert_into_item'      => esc_html__('Insert into Archive Template', 'tmpenvo'),
        'uploaded_to_this_item' => esc_html__('Uploaded to this Archive Template', 'tmpenvo'),
        'items_list'            => esc_html__('Archive Templates list', 'tmpenvo'),
        'items_list_navigation' => esc_html__('Archive Templates list navigation', 'tmpenvo'),
        'filter_items_list'     => esc_html__('Filter Archive Templates list', 'tmpenvo'),
    );
    $args = array(
        'label'               => esc_html__('Archive Template', 'tmpenvo'),
        'description'         => esc_html__('Create Archive templates for elementor', 'tmpenvo'),
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
    register_post_type('tmpenvo_templ_arch', $args);
}

add_filter('manage_tmpenvo_templ_arch_posts_columns', 'tmpenvo_edit_tmpenvo_templ_arch_posts_columns');
function tmpenvo_edit_tmpenvo_templ_arch_posts_columns($columns)
{
    $columns['tmpenvo_shortcode_column'] = esc_html__('Shortcode', 'tmpenvo');
    return $columns;
}

add_action('manage_tmpenvo_templ_arch_posts_custom_column', 'tmpenvo_add_tmpenvo_templ_arch_columns', 10, 2);
function tmpenvo_add_tmpenvo_templ_arch_columns($column, $post_id)
{
    switch ($column) {
        case 'tmpenvo_shortcode_column':
            echo '<input type="text" class="widefat" value=\'[GEEKYGREENOWL id="' . $post_id . '"]\' readonly>';
            break;
    }
}
add_shortcode('GEEKYGREENOWLARCHIVE', 'tmpenvo_add_elementor_archive');
function tmpenvo_add_elementor_archive($atts)
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

function tmpenvo_archive_template_default_comments_on($data)
{
    if ($data['post_type'] == 'tmpenvo_templ_arch') {
        $data['comment_status'] = 1;
    }
    return $data;
}
add_filter('wp_insert_post_data', 'tmpenvo_archive_template_default_comments_on');

add_filter('archive_template', 'tmpenvo_templ_archive_post_function', -20, 1);
function tmpenvo_templ_archive_post_function($single)
{
    if ((false !== get_option('tmpenvo_admin_options')) && (!is_single())) {
        global $post;
        if (!is_object($post)) {
            return $single;
        }
        $tmpenvo_admin_options = get_option('tmpenvo_admin_options_archive');

        if (isset($tmpenvo_admin_options['tmpenvo_select_post_template_repeater_archive'])) {
            $tmpenvo_admin_template_options = $tmpenvo_admin_options['tmpenvo_select_post_template_repeater_archive'];
            foreach ($tmpenvo_admin_template_options as $key => $value) {
                $posttype = $value[0];
                $tmpenvo_select_post_template_0 = (int) $value['template'][0][0];
                $tmpenvo_inclution              = (int) $value['templateinc'][0][0]; // include or exclude
                $tmpenvo_inclution_type         = (int) $value['templateinctype'][0][0]; //  What kind of inclution

                switch ($tmpenvo_inclution_type) {
                    case '0': //all
                        if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0)) {
                          if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php')) {
                              return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php';
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
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (in_array(get_queried_object()->term_id, $tmpenvo_spec_array_data))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php';
                              }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!in_array(get_queried_object()->term_id, $tmpenvo_spec_array_data))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php';
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
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php';
                              }
                            }

                        } elseif ($tmpenvo_inclution == 1) {

                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (empty($commoncheck))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php';
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
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php';
                              }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (empty($commoncheck))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php';
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
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php';
                              }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!in_array($author_id, $tmpenvo_spec_array_data))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/templates/tmpenvo-template-archive.php';
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

add_filter('single_template', 'tmpenvo_templ_arch_core');

function tmpenvo_templ_arch_core($single)
{

    global $post;
    /* Checks for single template by post type */
    if ($post->post_type == 'tmpenvo_templ_arch') {
        if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/core-template/tmpenvo-template-core.php')) {
            return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/templatereg/core-template/tmpenvo-template-core.php';
        }
    }
    return $single;
}
