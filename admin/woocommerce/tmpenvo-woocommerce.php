<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_filter('woocommerce_template_loader_files', function ($templates, $template_name) {
    wp_cache_set('tmpenvo_wc_main_template', $template_name); // cache the template name
    wp_cache_set('tmpenvo_wc_main_template_taxonomy_archive', $template_name);
    return $templates;
}, 100, 2);

add_filter('template_include', function ($template) {

    if (is_archive()) {
        return $template;
    }

    $tmpenvo_admin_options = get_option('tmpenvo_admin_options_woocommerce');
    if ($template_name = wp_cache_get('tmpenvo_wc_main_template') && isset($tmpenvo_admin_options['tmpenvo_select_post_template_repeater_woocommerce'])) {
        wp_cache_delete('tmpenvo_wc_main_template'); // delete the cache
        $tmpenvo_admin_template_options = $tmpenvo_admin_options['tmpenvo_select_post_template_repeater_woocommerce'];

        foreach ($tmpenvo_admin_template_options as $key => $value) {

            if ($value[0] = 'singleproduct' && $value['template'][0][0] != 0) {
              $posttype = 'product';
              $tmpenvo_select_post_template_0 = (int)$value['template'][0][0];
              $tmpenvo_inclution              = (int) $value['templateinc'][0][0]; // include or exclude
              $tmpenvo_inclution_type         = (int) $value['templateinctype'][0][0]; //  What kind of inclution


                switch ($tmpenvo_inclution_type) {
                    case '0': //all
                        if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0)) {
                          if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php')) {
                              return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php';
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
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php';
                              }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!in_array(get_the_ID(), $tmpenvo_spec_array_data))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php';
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

                        $argss = array(
                          'fields' => 'ids',
                        );
                        $category_list = wp_get_post_terms(get_the_ID(), 'product_cat', $argss );

                        if (!empty($category_list) && is_array($category_list)) {
                            $commoncheck = count(array_intersect($category_list, $tmpenvo_spec_array_data));
                        } else {
                            $commoncheck = "";
                        }

                        if ($tmpenvo_inclution == 0) {
                            # code...
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!empty($commoncheck))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php') ) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php';
                              }
                            }
                        } elseif ($tmpenvo_inclution == 1) {

                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (empty($commoncheck))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php';
                              }
                            }
                            else{
                              return $template;
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

                        $argss = array(
                         'fields' => 'ids',
                        );
                        $taglist_id = wp_get_post_terms(get_the_ID(), 'product_tag', $argss );
                        if (!empty($taglist_id)) {
                            $commoncheck = count(array_intersect($taglist_id, $tmpenvo_spec_array_data));
                        } else {
                            $commoncheck = "";
                        }

                        if ($tmpenvo_inclution == 0) {
                            # code...
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!empty($commoncheck))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php';
                              }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (empty($commoncheck))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php';
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
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php';
                              }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!in_array($author_id, $tmpenvo_spec_array_data))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/single-product.php';
                              }
                            }
                        }
                        break;
                }

            }
        }
    }
    return $template;
}, 100);

add_filter('template_include', function ($template) {
    if (!is_archive()) {
        return $template;
    }
    $tmpenvo_admin_options = get_option('tmpenvo_admin_options_woocommerce');

    if ($template_name = wp_cache_get('tmpenvo_wc_main_template_taxonomy_archive') && isset($tmpenvo_admin_options['tmpenvo_select_post_template_repeater_woocommerce'])) {
        wp_cache_delete('tmpenvo_wc_main_template_taxonomy_archive');
        $tmpenvo_admin_template_options = $tmpenvo_admin_options['tmpenvo_select_post_template_repeater_woocommerce'];

        foreach ($tmpenvo_admin_template_options as $key => $value) {
            if ($value[0] = 'producttaxon' && $value['template'][0][0] != 0) {
              $posttype = 'product';
              $tmpenvo_select_post_template_0 = (int)$value['template'][0][0];
              $tmpenvo_inclution              = (int) $value['templateinc'][0][0]; // include or exclude
            
              $tmpenvo_inclution_type         = (int) $value['templateinctype'][0][0]; //  What kind of inclution


                switch ($tmpenvo_inclution_type) {
                    case '0': //all
                        if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0)) {
                          if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php')) {
                              return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php';
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

                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (in_array(get_queried_object()->term_id, $tmpenvo_spec_array_data)) ) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php';
                              }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!in_array(get_queried_object()->term_id, $tmpenvo_spec_array_data))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php';
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

                        $argss = array(
                          'fields' => 'ids',
                        );
                        $category_list = wp_get_post_terms(get_the_ID(), 'product_cat', $argss );

                        if (!empty($category_list && is_array($category_list))) {
                            $commoncheck = count(array_intersect($category_list, $tmpenvo_spec_array_data));
                        } else {
                            $commoncheck = "";
                        }

                        if ($tmpenvo_inclution == 0) {
                            # code...
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!empty($commoncheck))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php';
                              }
                            }

                        } elseif ($tmpenvo_inclution == 1) {

                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (empty($commoncheck))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php';
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

                        $argss = array(
                         'fields' => 'ids',
                        );
                        $taglist_id = wp_get_post_terms(get_the_ID(), 'product_tag', $argss );
                        // foreach ($tag_list as $key => $value) {
                        //     $taglist_id[] = $value->term_id;
                        // }
                        if (!empty($taglist_id)) {
                            $commoncheck = count(array_intersect($taglist_id, $tmpenvo_spec_array_data));
                        } else {
                            $commoncheck = "";
                        }

                        if ($tmpenvo_inclution == 0) {
                            # code...
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!empty($commoncheck))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php';
                              }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (empty($commoncheck))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php';
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
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php';
                              }
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!in_array($author_id, $tmpenvo_spec_array_data))) {
                              if (file_exists(plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php')) {
                                  return plugin_dir_path(TMPENVO_PLUGIN_FILE) . 'admin/woocommerce/templates/taxonomy-product_cat_tag.php';
                              }
                            }
                        }
                        break;
                }
            }
        }
    }
    return $template;
}, 9999999);
