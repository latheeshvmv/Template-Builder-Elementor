<?php
if (!defined('ABSPATH')) {
    exit;
}
final class TMPENVO_Elementor_Ggowl_Extension
{

    /**
     * Plugin Version
     *
     * @since 1.0.0
     *
     * @var string The plugin version.
     */
    const tmpenvo_VERSION = '2.0.0';

    /**
     * Minimum Elementor Version
     *
     * @since 1.0.0
     *
     * @var string Minimum Elementor version required to run the plugin.
     */
    const tmpenvo_MINIMUM_ELEMENTOR_VERSION = '2.7.2';

    /**
     * Minimum PHP Version
     *
     * @since 1.0.0
     *
     * @var string Minimum PHP version required to run the plugin.
     */
    const tmpenvo_MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     *
     * @since 1.0.0
     *
     * @access private
     * @static
     *
     */
    private static $tmpenvo_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     *
     * @access public
     * @static
     *
     */
    public static function tmpenvo_instance()
    {

        if (is_null(self::$tmpenvo_instance)) {
            self::$tmpenvo_instance = new self();
        }
        return self::$tmpenvo_instance;

    }

    /**
     * Constructor
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function __construct()
    {

        add_action('init', [$this, 'tmpenvo_i18n']);
        add_action('plugins_loaded', [$this, 'tmpenvo_init']);

    }

    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     *
     * Fired by `init` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function tmpenvo_i18n()
    {

        load_plugin_textdomain('tmpenvo');

    }

    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed load the files required to run the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function tmpenvo_init()
    {

        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'tmpenvo_admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::tmpenvo_MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'tmpenvo_admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::tmpenvo_MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'tmpenvo_admin_notice_minimum_php_version']);
            return;
        }

        // Add Plugin actions

        add_action('elementor/widgets/widgets_registered', [$this, 'tmpenvo_init_widgets']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'tmpenvo_run_script']);
        add_action('elementor/widget/print_template', [$this, 'tmpenvo_template_modifier']);
        //add the section new menu
        add_action('elementor/element/before_section_start', [$this, 'tmpenvo_custom_background'], 10, 3);
        add_action('elementor/frontend/section/before_render', [$this, 'tmpenvo_custom_background_data_adder'], 10, 1);
        add_action('elementor/section/print_template', [$this, 'tmpenvo_custom_background_frontend'], 10, 2);
        add_action('elementor/section/render_content', [$this, 'tmpenvo_custom_background_frontend_test'], 10, 2);
        add_action('elementor/documents/register_controls', [$this, 'add_elementor_page_settings_controls'], 10, 1);

        add_action( 'elementor/frontend/after_enqueue_styles', [$this, 'tmpenvo_run_styles']);
    }


    public function add_elementor_page_settings_controls($page)
    {
        global $post;
        //var_dump($post);
        if(isset($post->post_type)){
          if ($post->post_type != 'tmpenvo_template'){
            return;
          }
        }

        $tmpenvo_data             = new \TMPENVOHELPERNS\GgowlHelper();
        $tmpenvo_custom_post_list = $tmpenvo_data->tmpenvo_list_of_posttypes();

        $page->start_controls_section(
        	'tmpenvo_custom_section',
        	[
        		'label' => esc_html__( 'Post Selector', 'tmpenvo' ),
        		'tab' => \Elementor\Controls_Manager::TAB_SETTINGS,
        	]
        );
        $page->add_control(
            'tmpenvo_d_custom_post_selector',
            [
                'label'   => esc_html__('Post Type Selector', 'tmpenvo'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $tmpenvo_custom_post_list,
            ]
        );

        $all_post_ids = get_posts(array(
            'post_type'      => $tmpenvo_custom_post_list,
            'fields'         => 'ids', // Only get post IDs
            'posts_per_page' => -1,
        ));

        $tmpenvo_lat_array = array();
        foreach ($all_post_ids as $key => $value) {
            $tmpenvo_lat_array[$value] = get_the_title($value);
        }

        $page->add_control(
            'tmpenvo_d_custom_post_selector_id_setter',
            [
                'label'   => esc_html__('Post Selector', 'tmpenvo'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'post',
                'options' => $tmpenvo_lat_array,
            ]
        );

        $page->end_controls_section();
    }

    public function tmpenvo_custom_background_frontend_test($content, $widget)
    {
        return $content;
    }

    public function tmpenvo_custom_background($element, $section_id, $args)
    {
        if ('section' === $element->get_name() && 'section_background' === $section_id) {

            $element->start_controls_section(
                'tmpenvo_back_section',
                [
                    'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                    'label' => esc_html__('Template Pro - Background', 'tmpenvo'),
                ]
            );

            require_once __DIR__ . '/data/tmpenvo-controls-background.php';

            $element->end_controls_section();
        }
    }

    public function tmpenvo_custom_background_data_adder($section)
    {

        $ggwol_enable_custombackground = $section->get_settings('tmpenvo_back_section_enable');
        if ($ggwol_enable_custombackground == 'yes') {
            require_once __DIR__ . '/class-tmpenvo-sectionbackground.php';

            $tmpenvodat               = new \GEEKYGREENOWLSECBACKNS\GgowlSecBack();
            $img_source             = $tmpenvodat->gen_image_url_normal($section);
            $img_source_position_lg = $section->get_settings('tmpenvo_back_section_img_position');
            $img_source_position_md = $section->get_settings('tmpenvo_back_section_img_position_tablet');
            $img_source_position_sm = $section->get_settings('tmpenvo_back_section_img_position_mobile');

            //x pos
            $img_source_position_lg_x = $section->get_settings('tmpenvo_back_section_img_x_pos');
            $img_source_position_md_x = $section->get_settings('tmpenvo_back_section_img_x_pos_tablet');
            $img_source_position_sm_x = $section->get_settings('tmpenvo_back_section_img_x_pos_mobile');

            //ypos

            $img_source_position_lg_y = $section->get_settings('tmpenvo_back_section_img_y_pos');
            $img_source_position_md_y = $section->get_settings('tmpenvo_back_section_img_y_pos_tablet');
            $img_source_position_sm_y = $section->get_settings('tmpenvo_back_section_img_y_pos_mobile');

            //attachment , repeat , size

            $tmpenvo_sec_img_attachment = $section->get_settings('tmpenvo_back_section_attachment');
            $tmpenvo_sec_img_repeat     = $section->get_settings('tmpenvo_back_section_repeat');
            $tmpenvo_sec_img_size       = $section->get_settings('tmpenvo_back_section_size');

            $json_data = array(
                'backgroundimage'            => $img_source,
                'backgroundposition_lg'      => $img_source_position_lg,
                'backgroundposition_md'      => $img_source_position_md,
                'backgroundposition_sm'      => $img_source_position_sm,
                'backgroundposition_lg_x'    => $img_source_position_lg_x,
                'backgroundposition_md_x'    => $img_source_position_md_x,
                'backgroundposition_sm_x'    => $img_source_position_sm_x,
                'backgroundposition_lg_y'    => $img_source_position_lg_y,
                'backgroundposition_md_y'    => $img_source_position_md_y,
                'backgroundposition_sm_y'    => $img_source_position_sm_y,
                'backgroundimage_attachment' => $tmpenvo_sec_img_attachment,
                'backgroundimage_repeat'     => $tmpenvo_sec_img_repeat,
                'backgroundimage_size'       => $tmpenvo_sec_img_size,
            );

            //hover
            $img_source_hover             = $tmpenvodat->gen_image_url_hover($section);
            $img_source_position_lg_hover = $section->get_settings('tmpenvo_back_section_img_position_hover');
            $img_source_position_md_hover = $section->get_settings('tmpenvo_back_section_img_position_tablet_hover');
            $img_source_position_sm_hover = $section->get_settings('tmpenvo_back_section_img_position_mobile_hover');

            //x pos
            $img_source_position_lg_x_hover = $section->get_settings('tmpenvo_back_section_img_x_pos_hover');
            $img_source_position_md_x_hover = $section->get_settings('tmpenvo_back_section_img_x_pos_tablet_hover');
            $img_source_position_sm_x_hover = $section->get_settings('tmpenvo_back_section_img_x_pos_mobile_hover');

            //ypos

            $img_source_position_lg_y_hover = $section->get_settings('tmpenvo_back_section_img_y_pos_hover');
            $img_source_position_md_y_hover = $section->get_settings('tmpenvo_back_section_img_y_pos_tablet_hover');
            $img_source_position_sm_y_hover = $section->get_settings('tmpenvo_back_section_img_y_pos_mobile_hover');

            //attachment , repeat , size

            $tmpenvo_sec_img_attachment_hover = $section->get_settings('tmpenvo_back_section_attachment_hover');
            $tmpenvo_sec_img_repeat_hover     = $section->get_settings('tmpenvo_back_section_repeat_hover');
            $tmpenvo_sec_img_size_hover       = $section->get_settings('tmpenvo_back_section_size_hover');

            $json_data_hover = array(
                'backgroundimage_hover'            => $img_source_hover,
                'backgroundposition_lg_hover'      => $img_source_position_lg_hover,
                'backgroundposition_md_hover'      => $img_source_position_md_hover,
                'backgroundposition_sm_hover'      => $img_source_position_sm_hover,
                'backgroundposition_lg_x_hover'    => $img_source_position_lg_x_hover,
                'backgroundposition_md_x_hover'    => $img_source_position_md_x_hover,
                'backgroundposition_sm_x_hover'    => $img_source_position_sm_x_hover,
                'backgroundposition_lg_y_hover'    => $img_source_position_lg_y_hover,
                'backgroundposition_md_y_hover'    => $img_source_position_md_y_hover,
                'backgroundposition_sm_y_hover'    => $img_source_position_sm_y_hover,
                'backgroundimage_attachment_hover' => $tmpenvo_sec_img_attachment_hover,
                'backgroundimage_repeat_hover'     => $tmpenvo_sec_img_repeat_hover,
                'backgroundimage_size_hover'       => $tmpenvo_sec_img_size_hover,
            );

            $tmpenvo_enable_hover_background = $section->get_settings('tmpenvo_back_section_enable_hover');

            $json_data_descode       = json_encode($json_data);
            $json_data_descode_hover = json_encode($json_data_hover);
            $section->add_render_attribute('_wrapper', [
                'class'                  => 'tmpenvo-background-wrapper',
                'data-tmpenvo'             => $json_data_descode,
                'data-ggow-enable_hover' => $tmpenvo_enable_hover_background,
                'data-tmpenvo-hover'       => $json_data_descode_hover,
            ]);
        }
    }

    public function tmpenvo_custom_background_frontend($template, $element)
    {
        if ('section' === $element->get_name()) {
            $new_template = '<#
      if ( settings.background_video_link ) {
        let videoAttributes = "autoplay muted playsinline";
        if ( ! settings.background_play_once ) {
          videoAttributes += " loop";
        }
        #>
          <div class="elementor-background-video-container elementor-hidden-phone">
            <div class="elementor-background-video-embed"></div>
            <video class="elementor-background-video-hosted elementor-html5-video" {{ videoAttributes }}></video>
          </div>
        <# } #>
        <div class="elementor-background-overlay tmpenvo-background-overlay"></div>
        <div class="elementor-shape elementor-shape-top" style="z-index:1;"></div>
        <div class="elementor-shape elementor-shape-bottom" style="z-index:1;"></div>
        <div class="elementor-container elementor-column-gap-{{ settings.gap }} tmpenvo-container">
          <div class="elementor-row"></div>
        </div>';
            $template = $new_template;
        }

        return $template;
    }

    public function tmpenvo_run_script()
    {
        wp_register_script('tmpenvo-elementor', plugin_dir_url(TMPENVO_PLUGIN_FILE) . 'public/js/tmpenvo-elementor.js', ['jquery'], '1.0', false);
        wp_enqueue_script('tmpenvo-elementor');

        wp_register_script('tmpenvo-select-ui-js', plugin_dir_url(TMPENVO_PLUGIN_FILE) . 'public/js/tmpenvo-dropdown.min.js', ['jquery'], '1.0', false);
        wp_enqueue_script('tmpenvo-select-ui-js');

        wp_register_script('tmpenvo-core-jquery', plugin_dir_url(TMPENVO_PLUGIN_FILE) . 'public/js/tmpenvo-gribuilder.js', ['jquery','tmpenvo-select-ui-js'], '1.0', false);
        wp_enqueue_script('tmpenvo-core-jquery');

        $tmpenvo_elementor_size = Elementor\Core\Responsive\Responsive::get_breakpoints();
        $tmpenvo_data_array     = array(
            'sm' => $tmpenvo_elementor_size['sm'],
            'md' => $tmpenvo_elementor_size['md'],
            'lg' => $tmpenvo_elementor_size['lg'],
        );
        wp_localize_script('tmpenvo-elementor', 'tmpenvoDataLoder', $tmpenvo_data_array);

    }

    public function tmpenvo_run_styles()
    {
        wp_register_style('tmpenvo-select-ui-css', plugin_dir_url(TMPENVO_PLUGIN_FILE) . 'public/css/tmpenvo-dropdown.min.css');
        wp_enqueue_style('tmpenvo-select-ui-css');

        wp_register_style('tmpenvo-core-css', plugin_dir_url(TMPENVO_PLUGIN_FILE) . 'public/css/tmpenvo-gridbuilder.min.css');
        wp_enqueue_style('tmpenvo-core-css');
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function tmpenvo_admin_notice_missing_main_plugin()
    {
      $tmpenvo_admin_notice_missing_main_plugin_get = filter_input(
          INPUT_GET,
          'activate',
          FILTER_CALLBACK,
          ['options' => 'esc_html']
      );

        if ( isset( $tmpenvo_admin_notice_missing_main_plugin_get ) ) {
            unset( $tmpenvo_admin_notice_missing_main_plugin_get );
        }

        $tmpenvo_message = sprintf(
            /* translators: 1: Plugin name 2: Elementor */
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'tmpenvo'),
            '<strong>' . esc_html__('Template Builder Elementor', 'tmpenvo') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'tmpenvo') . '</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $tmpenvo_message);

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function tmpenvo_admin_notice_minimum_elementor_version()
    {
      $tmpenvo_admin_notice_missing_main_plugin_get = filter_input(
          INPUT_GET,
          'activate',
          FILTER_CALLBACK,
          ['options' => 'esc_html']
      );

        if ( isset( $tmpenvo_admin_notice_missing_main_plugin_get ) ) {
            unset( $tmpenvo_admin_notice_missing_main_plugin_get );
        }



        $tmpenvo_message = sprintf(
            /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'tmpenvo'),
            '<strong>' . esc_html__('Template Builder Elementor', 'tmpenvo') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'tmpenvo') . '</strong>',
            self::tmpenvo_MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $tmpenvo_message);

    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function tmpenvo_admin_notice_minimum_php_version()
    {
      $tmpenvo_admin_notice_missing_main_plugin_get = filter_input(
          INPUT_GET,
          'activate',
          FILTER_CALLBACK,
          ['options' => 'esc_html']
      );
        if ( isset( $tmpenvo_admin_notice_missing_main_plugin_get ) ) {
            unset( $tmpenvo_admin_notice_missing_main_plugin_get );
        }

        $tmpenvo_message = sprintf(
            /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'tmpenvo'),
            '<strong>' . esc_html__('Template Builder Elementor', 'tmpenvo') . '</strong>',
            '<strong>' . esc_html__('PHP', 'tmpenvo') . '</strong>',
            self::tmpenvo_MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $tmpenvo_message);

    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @since 1.0.0
     *
     * @access public
     */
    public function tmpenvo_init_widgets()
    {

        require_once __DIR__ . '/class-tmpenvo-image-render.php';
        require_once __DIR__ . '/class-tmpenvo-archive.php';

        //core files require
        require_once __DIR__ . '/widgets/core/tmpenvo-core-title.php';
        require_once __DIR__ . '/widgets/core/tmpenvo-core-breadcrumps.php';
        require_once __DIR__ . '/widgets/core/tmpenvo-core-content.php';
        require_once __DIR__ . '/widgets/core/tmpenvo-core-featured-image.php';
        require_once __DIR__ . '/widgets/core/tmpenvo-core-comments.php';
        require_once __DIR__ . '/widgets/core/tmpenvo-core-acf-fields.php';
        require_once __DIR__ . '/widgets/core/tmpenvo-core-acf-video.php';
        require_once __DIR__ . '/widgets/core/tmpenvo-core-acf-image.php';
        require_once __DIR__ . '/widgets/core/tmpenvo-core-metadata.php';

        //core files class reg
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_Title_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_Breadcrump_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_Comment_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_Dynamic_Content_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_Featured_image_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_CustomFields_Widget());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\GgowlWidget_Video());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_ACF_Widget_Image());
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_metadata());

        // WooCommerce  widgets - title
        require_once __DIR__ . '/widgets/woocommerce/tmpenvo-product-title.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_producttitle());

        // WooCommerce  widgets - add to cart
        require_once __DIR__ . '/widgets/woocommerce/tmpenvo-product-addtocart.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_addtocart());

        // WooCommerce  widgets - desciption
        require_once __DIR__ . '/widgets/woocommerce/tmpenvo-product-description.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_product_description());

        require_once __DIR__ . '/widgets/woocommerce/tmpenvo-product-short-description.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_product_short_description());

        require_once __DIR__ . '/widgets/woocommerce/tmpenvo-product-woofields.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_woo_fields());

        require_once __DIR__ . '/widgets/woocommerce/tmpenvo-product-gallery-grid.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_product_gallerygrid());

        require_once __DIR__ . '/widgets/woocommerce/tmpenvo-product-reviewform.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_product_reviewform());

        require_once __DIR__ . '/widgets/woocommerce/tmpenvo-product-featuredimage.php';
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\Ggowl_Elementor_product_featuredimage());

    }

}

TMPENVO_Elementor_Ggowl_Extension::tmpenvo_instance();

function tmpenvo_add_elementor_widget_categories($tmpenvo_elements_manager)
{

    $tmpenvo_elements_manager->add_category(
        'tmpenvo-category',
        [
            'title' => esc_html__('Geeky Green Owl Dynamic Widgets', 'tmpenvo'),
            'icon'  => 'fa fa-braille',
        ]
    );
    $tmpenvo_elements_manager->add_category(
        'tmpenvo-category-woo',
        [
            'title' => esc_html__('Geeky Green Owl WooCommerce ', 'tmpenvo'),
            'icon'  => 'fa fa-braille',
        ]
    );

}
add_action('elementor/elements/categories_registered', 'tmpenvo_add_elementor_widget_categories');


// allows to use the grid in single blog contents
function tmpenvo_fix_usage_single_posts(){
  $args = array(
      'public' => true,
  );
  $output   = 'names'; // 'names' or 'objects' (default: 'names')
  $operator = 'and'; // 'and' or 'or' (default: 'and')

  $post_types = get_post_types($args, $output, $operator);
	if ( is_singular( $post_types ) ) {
			global $wp_query;
			$page = ( int ) $wp_query->get( 'page' );
			if ( $page > 1 ) {
					// convert 'page' to 'paged'
					$wp_query->set( 'page', 1 );
					$wp_query->set( 'paged', $page );
			}
			// prevent redirect
			remove_action( 'template_redirect', 'redirect_canonical' );
	}
}
add_action( 'template_redirect', 'tmpenvo_fix_usage_single_posts',0 );
