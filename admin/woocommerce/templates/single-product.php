<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

\Elementor\Plugin::$instance->frontend->add_body_class('elementor-template-full-width');
get_header('shop');

do_action('tmpenvo_woocommerce_before_main_content');
if (class_exists('WooCommerce')):
    echo '<div class="tmpenvo-wooocommerc-notices">';
    if (function_exists('wc_print_notices')) {
        wc_print_notices();
    }
    echo '</div>';
endif;

 while (have_posts()): the_post();?>

		<div class="tmpenvo-container tmpenvo-container-<?php echo get_the_ID(); ?>" id="tmpenvo-container tmpenvo-container-<?php echo get_the_ID(); ?>">
								<?php
    $tmpenvoacf_admin_options = get_option('tmpenvo_admin_options_woocommerce'); // Array of All Options
    if (isset($tmpenvoacf_admin_options['tmpenvo_select_post_template_repeater_woocommerce'])) {
        $tmpenvo_admin_template_options = $tmpenvoacf_admin_options['tmpenvo_select_post_template_repeater_woocommerce'];
        foreach ($tmpenvo_admin_template_options as $key => $value) {
            if ($value[0] = 'singleproduct') {
                $posttype = 'product';
								$tmpenvo_select_post_template_0 = (int)$value['template'][0][0];
								$tmpenvo_inclution              = (int) $value['templateinc'][0][0]; // include or exclude
						    $tmpenvo_inclution_type         = (int) $value['templateinctype'][0][0]; //  What kind of inclution
                switch ($tmpenvo_inclution_type) {
                    case '0': //all
                        if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0)) {
                            echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tmpenvo_select_post_template_0);
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
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (in_array(get_the_ID(), $tmpenvo_spec_array_data)) ) {
                                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tmpenvo_select_post_template_0);
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!in_array(get_the_ID(), $tmpenvo_spec_array_data)) ) {
                                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tmpenvo_select_post_template_0);
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
                        if (!empty($category_list)) {
                            $commoncheck = count(array_intersect($category_list, $tmpenvo_spec_array_data));
                        } else {
                            $commoncheck = "";
                        }

                        if ($tmpenvo_inclution == 0) {
                            # code...
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!empty($commoncheck))) {
                                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tmpenvo_select_post_template_0);
                            }

                        } elseif ($tmpenvo_inclution == 1) {

                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (empty($commoncheck))) {
                                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tmpenvo_select_post_template_0);
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
                                    if (!empty($taglist_id)) {
                                        $commoncheck = count(array_intersect($taglist_id, $tmpenvo_spec_array_data));
                                    } else {
                                        $commoncheck = "";
                                    }

                        if ($tmpenvo_inclution == 0) {
                            # code...
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!empty($commoncheck))) {
                                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tmpenvo_select_post_template_0);
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (empty($commoncheck))) {
                                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tmpenvo_select_post_template_0);
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
                                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tmpenvo_select_post_template_0);
                            }
                        } elseif ($tmpenvo_inclution == 1) {
                            if ((get_post_type() == $posttype) && ($tmpenvo_select_post_template_0 != 0) && (!in_array($author_id, $tmpenvo_spec_array_data))) {
                                echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tmpenvo_select_post_template_0);
                            }
                        }
                        break;
                }
            }
        }
    }
    ?>
				</div>

			<?php endwhile; // end of the loop. ?>

	<?php
do_action('tmpenvo_woocommerce_after_main_content');
?>

	<?php
do_action('tmpenvo_woocommerce_sidebar');
?>

<?php get_footer('shop');
