<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
\Elementor\Plugin::$instance->frontend->add_body_class('elementor-template-full-width');
get_header();
do_action('geekygreenowl_before_content');?>
    <div class="tmpenvo-container tmpenvo-container-<?php echo get_the_ID(); ?>" id="tmpenvo-container tmpenvo-container-<?php echo get_the_ID(); ?>">
            <?php
$tmpenvoacf_admin_options       = get_option('tmpenvo_admin_options'); // Array of All Options
$tmpenvo_admin_template_options = $tmpenvoacf_admin_options['tmpenvo_select_post_template_repeater'];

foreach ($tmpenvo_admin_template_options as $key => $value) {
    $posttype                     = $value[0];
    $tmpenvo_select_post_template_0 = (int) $value['template'][0][0];
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

            $category_list = wp_get_post_categories(get_the_ID());
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
?>
    </div>
<?php
do_action('geekygreenowl_after_content');
get_footer();
