<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
class TMPENVO_Admin
{
    private $plugin_name;

    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        add_action('admin_menu', array($this, 'tmpenvo_add_plugin_admin_menu'));
        add_action('admin_menu', array($this, 'tmpenvo_main_options_page'));
        add_action('admin_init', array($this, 'tmpenvo_page_init'));
    }

    public function enqueue_styles($hook)
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/tmpenvo-admin.min.css', array(), $this->version, 'all');
        if ($hook == 'toplevel_page_tmpenvo_add_menu_page') {
            wp_enqueue_style('geekygreenowl_bulma', plugin_dir_url(__FILE__) . 'css/tmpenvo-admin-bulma.min.css', array(), $this->version, 'all');
        }
    }

    public function enqueue_scripts($hook)
    {
        if ($hook == 'toplevel_page_tmpenvo_add_menu_page') {
            wp_enqueue_script('geekygreenowl_repeater', plugin_dir_url(__FILE__) . 'js/tmpenvo-repeater.js', array('jquery'), $this->version, false);
            wp_enqueue_script('geekygreenowl_repeater_setter', plugin_dir_url(__FILE__) . 'js/tmpenvo-repeater-settings.js', array('jquery'), $this->version, false);
        }
    }

    private $tmpenvo_admin_options;
    private $tmpenvo_admin_options_archive;
    private $tmpenvo_admin_options_woocommerce;

    public function tmpenvo_add_plugin_admin_menu()
    {
        $tmpenvo_admin_icon_url = 'dashicons-welcome-widgets-menus';
        add_menu_page($page_title = 'GGOwl Templates', $menu_title = 'Template Builder', $capability = 'manage_options', $menu_slug = 'tmpenvo_add_menu_page', array($this, $function = 'tmpenvo_add_menu_callback'), $icon_url = $tmpenvo_admin_icon_url, $position = 10);
        add_submenu_page($parent_slug = 'tmpenvo_add_menu_page', $page_title = 'Set Template', $menu_title = 'Set Template', $capability = 'manage_options', $menu_slug = 'tmpenvo_add_menu_page', array($this, $function = 'tmpenvo_main_menu_callback'));
        add_submenu_page($parent_slug = 'tmpenvo_add_menu_page', $page_title = 'Templates', $menu_title = 'Templates', $capability = 'manage_options', 'edit.php?post_type=tmpenvo_template');
        add_submenu_page($parent_slug = 'tmpenvo_add_menu_page', $page_title = 'Archive Templates', $menu_title = 'Archive Templates', $capability = 'manage_options', 'edit.php?post_type=tmpenvo_templ_arch');
    }

    public function tmpenvo_add_menu_callback()
    {
        ?>
        <div class="tmpenvo-admin-columns columns">
            <div class="tmpenvo-admin-column column">
                <h1><?php esc_html_e('Template Builder Elementor', 'tmpenvo')?><p> <?php esc_html_e( 'Version 1.0.0', 'tmpenvo' ); ?> </p></h1>

                <a class="button is-dark" href="<?php echo esc_url(admin_url('edit.php?post_type=tmpenvo_template')); ?>"><?php esc_html_e('Create new Template', 'tmpenvo');?></a>
                <a class="button is-dark" href="<?php echo esc_url(admin_url('edit.php?post_type=tmpenvo_templ_arch')); ?>"><?php esc_html_e('Create new Archive Template', 'tmpenvo');?></a>
            </div>
        </div>
        <?php
    }

    public function tmpenvo_main_menu_callback()
    {
        $this->tmpenvo_admin_options = get_option('tmpenvo_admin_options');
        $this->tmpenvo_admin_options_archive = get_option('tmpenvo_admin_options_archive');
        $this->tmpenvo_admin_options_woocommerce = get_option('tmpenvo_admin_options_woocommerce');
        $data = $this->tmpenvo_admin_options['tmpenvo_select_post_template_repeater'][0]['templateincdata'][0][0];

        ?>
        <div class="tmpenvo-admin-template-selector">
            <form class="tmpenvo_repeater" method="post" action="options.php"><?php
              settings_errors();
              $tmpenvo_tab = filter_input(
                    INPUT_GET,
                    'tab',
                    FILTER_CALLBACK,
                    ['options' => 'esc_html']
                );
                $active_tab = $tmpenvo_tab ?: 'front_page_options';
        ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=tmpenvo_add_menu_page&tab=front_page_options" class="nav-tab <?php echo $active_tab == 'front_page_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Post Template', 'tmpenvo' ); ?></a>
            <a href="?page=tmpenvo_add_menu_page&tab=header_options" class="nav-tab <?php echo $active_tab == 'header_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Archive Template', 'tmpenvo' ); ?></a>
            <a href="?page=tmpenvo_add_menu_page&tab=tmpenvo_woo_options" class="nav-tab <?php echo $active_tab == 'tmpenvo_woo_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'WooCommerce', 'tmpenvo' ); ?></a>
        </h2>
        <?php
                if( $active_tab == 'front_page_options' ){
                    settings_fields('tmpenvo_admin_options_group');
                    do_settings_sections('tmpenvo-settings-admin');
                }elseif( $active_tab == 'header_options' ) {
                    settings_fields('tmpenvo_admin_options_group_archive');
                    do_settings_sections('tmpenvo-settings-admin-archive');
                }elseif( $active_tab == 'tmpenvo_woo_options'){
                    settings_fields('tmpenvo_admin_options_group_woocommerce');
                    do_settings_sections('tmpenvo-settings-admin-woocommerce');
                }


              submit_button();?>
            </form>
        </div><?php
}

    public function tmpenvo_page_init()
    {
        register_setting($option_group = 'tmpenvo_admin_options_group', $option_name = 'tmpenvo_admin_options', array($this, $sanitize_callback = 'tmpenvo_sanitize'));
        add_settings_section($id = 'tmpenvo_settings_section_id', $title = 'Post Templates', array($this, $callback = 'tmpenvo_print_section_describer'), $page = 'tmpenvo-settings-admin');
        add_settings_field($id = 'tmpenvo_select_post_template_repeater', $title = 'Set Single Page/Post Template', array($this, 'tmpenvo_select_post_template_repeater_callback'), $page = 'tmpenvo-settings-admin', $section = 'tmpenvo_settings_section_id');

        register_setting($option_group = 'tmpenvo_admin_options_group_archive', $option_name = 'tmpenvo_admin_options_archive', array($this, $sanitize_callback = 'tmpenvo_sanitize_archive'));
        add_settings_section($id = 'tmpenvo_settings_section_id_archive', $title = 'Archive Templates', array($this, $callback = 'tmpenvo_print_section_describer'), $page = 'tmpenvo-settings-admin-archive');
        add_settings_field($id = 'tmpenvo_select_post_template_repeater_archive', $title = 'Set Archive Template', array($this, 'tmpenvo_select_post_template_repeater_archive_callback'), $page = 'tmpenvo-settings-admin-archive', $section = 'tmpenvo_settings_section_id_archive');


        register_setting($option_group = 'tmpenvo_admin_options_group_woocommerce', $option_name = 'tmpenvo_admin_options_woocommerce', array($this, $sanitize_callback = 'tmpenvo_sanitize_woocoommerce'));
        add_settings_section($id = 'tmpenvo_settings_section_id_woocommerce', $title = 'WooCommerce Templates', array($this, $callback = 'tmpenvo_print_section_describer'), $page = 'tmpenvo-settings-admin-woocommerce');
        add_settings_field($id = 'tmpenvo_select_post_template_repeater_woocommerce', $title = 'Set WooCommerce  Templates', array($this, 'tmpenvo_select_post_template_repeater_woocommerce_callback'), $page = 'tmpenvo-settings-admin-woocommerce', $section = 'tmpenvo_settings_section_id_woocommerce');
        add_settings_field($id = 'tmpenvo_woocommerce_archive_count_setter', $title = 'Set WooCommerce  archive posts per page (Taxonomy Archives)', array($this, 'tmpenvo_woocommerce_archive_count_setter_callback'), $page = 'tmpenvo-settings-admin-woocommerce', $section = 'tmpenvo_settings_section_id_woocommerce');
    }

    public function tmpenvo_sanitize($input)
    {
        $sanitary_values = array();
        if (isset($input['tmpenvo_select_post_template_repeater'])) {
            $monitoring_array_post = array();
            foreach ($input['tmpenvo_select_post_template_repeater'] as $key => $value) {
              $monitoring_array_post[$key][0] = sanitize_text_field( $value[0] );
              $monitoring_array_post[$key]['template'][0][0] = sanitize_text_field( $value['template'][0][0] );
              $monitoring_array_post[$key]['templateinc'][0][0] = sanitize_text_field( $value['templateinc'][0][0] );
              $monitoring_array_post[$key]['templateinctype'][0][0] = sanitize_text_field( $value['templateinctype'][0][0] );
              $monitoring_array_post[$key]['templateincdata'][0][0] = sanitize_text_field( $value['templateincdata'][0][0] );
            }
            $input['tmpenvo_select_post_template_repeater'] = $monitoring_array_post;
            $sanitary_values['tmpenvo_select_post_template_repeater'] = $input['tmpenvo_select_post_template_repeater'];
        }

        return $sanitary_values;

    }

    public function tmpenvo_sanitize_archive($input)
    {
        $sanitary_values = array();
        if (isset($input['tmpenvo_select_post_template_repeater_archive'])) {
            $monitoring_array_post = array();
            foreach ($input['tmpenvo_select_post_template_repeater_archive'] as $key => $value) {
              $monitoring_array_post[$key][0] = sanitize_text_field( $value[0] );
              $monitoring_array_post[$key]['template'][0][0] = sanitize_text_field( $value['template'][0][0] );
              $monitoring_array_post[$key]['templateinc'][0][0] = sanitize_text_field( $value['templateinc'][0][0] );
              $monitoring_array_post[$key]['templateinctype'][0][0] = sanitize_text_field( $value['templateinctype'][0][0] );
              $monitoring_array_post[$key]['templateincdata'][0][0] = sanitize_text_field( $value['templateincdata'][0][0] );
            }
            $input['tmpenvo_select_post_template_repeater_archive'] = $monitoring_array_post;
            $sanitary_values['tmpenvo_select_post_template_repeater_archive'] = $input['tmpenvo_select_post_template_repeater_archive'];
        }
        return $sanitary_values;

    }

    public function tmpenvo_sanitize_woocoommerce($input)
    {
        $sanitary_values = array();
        if (isset($input['tmpenvo_select_post_template_repeater_woocommerce'])) {
            $monitoring_array_post = array();
            foreach ($input['tmpenvo_select_post_template_repeater_woocommerce'] as $key => $value) {
              $monitoring_array_post[$key][0] = sanitize_text_field( $value[0] );
              $monitoring_array_post[$key]['template'][0][0] = sanitize_text_field( $value['template'][0][0] );
              $monitoring_array_post[$key]['templateinc'][0][0] = sanitize_text_field( $value['templateinc'][0][0] );
              $monitoring_array_post[$key]['templateinctype'][0][0] = sanitize_text_field( $value['templateinctype'][0][0] );
              $monitoring_array_post[$key]['templateincdata'][0][0] = sanitize_text_field( $value['templateincdata'][0][0] );
            }
            $input['tmpenvo_select_post_template_repeater_woocommerce'] = $monitoring_array_post;
            $sanitary_values['tmpenvo_select_post_template_repeater_woocommerce'] = $input['tmpenvo_select_post_template_repeater_woocommerce'];
        }
        if (isset($input['tmpenvo_woo_archive_num_count'])) {
          $sanitary_values['tmpenvo_woo_archive_num_count'] = esc_html($input['tmpenvo_woo_archive_num_count']) ;
        }
        return $sanitary_values;

    }

    public function tmpenvo_woocommerce_archive_count_setter_callback(){
      if(isset($this->tmpenvo_admin_options_woocommerce['tmpenvo_woo_archive_num_count'])){
        $tmpenvo_value = $this->tmpenvo_admin_options_woocommerce['tmpenvo_woo_archive_num_count'];
      }else{
        $tmpenvo_value = 10;
      }
      echo '<div class="control">';
      echo "<input class='input' id='plugin_text_pass' name='tmpenvo_admin_options_woocommerce[tmpenvo_woo_archive_num_count]' style='width:100px;' type='number' value='{$tmpenvo_value}' />";
      echo '</div>';
    }

    public function tmpenvo_print_section_describer()
    {
        echo "<p>";
        esc_html_e('Set the template below. To revert back to defult template set template to  "Default"', 'tmpenvo');
        echo "</p>";
    }

    public function tmpenvo_template_list_array()
    {
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'tmpenvo_template',
            'post_status' => 'publish',
        );
        $tmpenvo_template_list       = get_posts($args);
        $tmpenvo_template_list_array = array();
        foreach ($tmpenvo_template_list as $key => $value) {
            $tmpenvo_template_list_array[$value->ID] = $value->post_title;
        }
        $tmpenvo_template_list_array[0] = "Default";
        return $tmpenvo_template_list_array;
    }

    public function tmpenvo_template_list_array_woo()
    {
        $args = array(
            'numberposts' => -1,
            'post_type'   => array('tmpenvo_template','tmpenvo_templ_arch'),
            'post_status' => 'publish',
        );
        $tmpenvo_template_list       = get_posts($args);
        $tmpenvo_template_list_array = array();
        foreach ($tmpenvo_template_list as $key => $value) {
            $tmpenvo_template_list_array[$value->ID] = $value->post_title;
        }
        $tmpenvo_template_list_array[0] = "Default";
        return $tmpenvo_template_list_array;
    }

    public function tmpenvo_archive_template_list_array()
    {
        $args = array(
            'numberposts' => -1,
            'post_type'   => 'tmpenvo_templ_arch',
            'post_status' => 'publish',
        );
        $tmpenvo_template_list = get_posts($args);
        $tmpenvo_template_list_array = array();
        foreach ($tmpenvo_template_list as $key => $value) {
            $tmpenvo_template_list_array[$value->ID] = $value->post_title;
        }
        $tmpenvo_default = array(
            '0' => 'default',
        );
        $tmpenvo_template_list_array = $tmpenvo_default + $tmpenvo_template_list_array;
        return $tmpenvo_template_list_array;
    }

    public function tmpenvo_list_of_post_types()
    {
        $args = array(
            'public' => true,
        );
        $output     = 'names';
        $operator   = 'and';
        $post_types = get_post_types($args, $output, $operator);
        $post_types = array_map('ucfirst', $post_types);
        return $post_types;
    }

    public function tmpenvo_html_form_repeater_defualt($tmpenvo_post_types, $tmpenvo_templates)
    {
        echo '<div class="repeater">';
        echo '<div class="tmpenvo-outerlist" data-repeater-list="tmpenvo_admin_options[tmpenvo_select_post_template_repeater]">';
        echo '<div class="tmpenvo-grid-area1 tmpenvo-repeater-item" data-repeater-item>';
        echo '<div class="field">';
        echo '<div class="control">';
        echo '<div class="select is-success">';
        echo '<select name="" id="tmpenvo_select_post_template_repeater" >';
        foreach ($tmpenvo_post_types as $key => $value) {
            echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
        }
        echo '</select>';
        echo '</div></div></div>';
        echo '<input class="tmpenvo-grid-area3 tmpenvo-delete-button button is-dark" data-repeater-delete type="button" value="Delete"/>';
        echo '<div class="tmpenvo-grid-area2 inner-repeater"><div data-repeater-list="template"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater">';
        foreach ($tmpenvo_templates as $key => $value) {
            if ($key == 0) {
                echo '<option value="' . esc_html($key) . '" selected="selected">' . esc_html($value) . '</option>';
            } else {
                echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
            }
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';


        // include or exclude
        $tmpenvo_inc_exc_array = array(
                                '0' => 'Include',
                                '1' => 'Exclude',
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinc"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '<select name="" id="tmpenvo_select_post_template_repeater_inc">';
        foreach ($tmpenvo_inc_exc_array as $key => $value) {
            if ($key == 0) {
                echo '<option value="' . esc_html($key) . '" selected="selected">' . esc_html($value) . '</option>';
            } else {
                echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
            }
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        //type of inclution
        $tmpenvo_inc_exc_type_array = array(
                                    '0' => 'All',
                                    '1' => 'Specific Posts By Id',
                                    '2' => 'Category',
                                    '3' => 'Tags',
                                    '4' => 'Author'
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinctype"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc_type">';
        foreach ($tmpenvo_inc_exc_type_array as $key => $value) {
            if ($key == 0) {
                echo '<option value="' . esc_html($key) . '" selected="selected">' . esc_html($value) . '</option>';
            } else {
                echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
            }
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateincdata"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div>';
        echo "<textarea class='textarea' placeholder='IDs seperated by |, eg: 15|16|20 .Check documentation for proper usage' id='tmpenvo_text_area_data' name='' rows='3' cols='50' type='textarea'></textarea>";
        echo '</div></div></div></div></div></div>';


        echo '</div>';
        echo '</div>';
        echo '<input class="button is-dark" data-repeater-create type="button" value="Add"/>';
        echo '</div>';
    }

    public function tmpenvo_html_form_repeater_saved($tmpenvo_post_types, $tmpenvo_templates, $tmpenvo_fields)
    {
        echo '<div class="repeater">';
        echo '<div class="tmpenvo-outerlist" data-repeater-list="tmpenvo_admin_options[tmpenvo_select_post_template_repeater]">';
        $i = 0;
        foreach ($tmpenvo_fields as $key_main => $value_main) {
            echo '<div class="tmpenvo-grid-area1 tmpenvo-repeater-item" data-repeater-item>';
            echo '<div class="field">';
            echo '<div class="control">';
            echo '<div class="select is-success">';
            echo '<select name="" id="tmpenvo_select_post_template_repeater-' . $i . '"> ';
            foreach ($tmpenvo_post_types as $key => $value_post_type) {
                $selected = (isset($value_main[0]) && ucwords($value_main[0]) === $value_post_type) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value_post_type) . '</option>';
            }
            echo '</select>';
            echo '</div></div></div>'; // The field div ends heere
            echo '<input class="tmpenvo-grid-area3 tmpenvo-delete-button button is-dark" data-repeater-delete type="button" value="Delete"/>';
            echo '<div class="tmpenvo-grid-area2 inner-repeater"><div data-repeater-list="template"><div data-repeater-item>';
            echo '<div class="field"><div class="control"><div class="select is-success">';
            echo '  <select name="" id="tmpenvo_select_post_template_repeater">';
            foreach ($tmpenvo_templates as $key => $value) {
                $selected = (isset($value_main['template'][0][0]) && $value_main['template'][0][0] === strval($key)) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value) . '</option>';
            }
            echo '</select>';
            echo '</div></div></div></div></div></div>';


            // include or exclude
        $tmpenvo_inc_exc_array = array(
                                '0' => 'Include',
                                '1' => 'Exclude',
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinc"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc">';
        foreach ($tmpenvo_inc_exc_array as $key => $value) {
                $selected = (isset($value_main['templateinc'][0][0]) && $value_main['templateinc'][0][0] === strval($key)) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value) . '</option>';
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        //type of inclution
      $tmpenvo_inc_exc_type_array = array(
                                    '0' => 'All',
                                    '1' => 'Specific Posts By Id',
                                    '2' => 'Category',
                                    '3' => 'Tags',
                                    '4' => 'Author'
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinctype"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc_type">';
         foreach ($tmpenvo_inc_exc_type_array as $key => $value) {
                $selected = (isset($value_main['templateinctype'][0][0]) && $value_main['templateinctype'][0][0] === strval($key)) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value) . '</option>';
            }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        if(isset($value_main['templateincdata'][0][0])) {
            $tmpenvo_data_ansy = $value_main['templateincdata'][0][0];
        }
        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateincdata"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div>';
        echo "<textarea class='textarea' placeholder='IDs seperated by |,  eg: 15|16|20. Check documentation for proper usage' id='tmpenvo_text_area_data' name='' rows='3' cols='50' type='textarea'>".esc_html($tmpenvo_data_ansy)."
        </textarea>";
        echo '</div></div></div></div></div></div>';




            echo '</div>';
            $i = $i + 1;
        } //foreach ends
        echo '</div>';
        echo '<input  class="button is-dark" data-repeater-create type="button" value="Add"/>';
        echo '</div>';
    }

    public function tmpenvo_select_post_template_repeater_callback()
    {
        $tmpenvo_post_types = $this->tmpenvo_list_of_post_types(); //array containing post types
        $tmpenvo_templates  = $this->tmpenvo_template_list_array(); //array containing template list
        if (isset($this->tmpenvo_admin_options['tmpenvo_select_post_template_repeater'])) {
            $tmpenvo_fields = $this->tmpenvo_admin_options['tmpenvo_select_post_template_repeater'];
            $this->tmpenvo_html_form_repeater_saved($tmpenvo_post_types, $tmpenvo_templates, $tmpenvo_fields);
        } else {
            $this->tmpenvo_html_form_repeater_defualt($tmpenvo_post_types, $tmpenvo_templates);
        }
    }

    public function tmpenvo_html_form_repeater_archive_defualt($tmpenvo_post_types, $tmpenvo_templates)
    {
        echo '<div class="repeater">';
        echo '<div class="tmpenvo-outerlist" data-repeater-list="tmpenvo_admin_options_archive[tmpenvo_select_post_template_repeater_archive]">';
        echo '<div class="tmpenvo-grid-area1 tmpenvo-repeater-item" data-repeater-item>';
        echo '<div class="field">';
        echo '<div class="control">';
        echo '<div class="select is-success">';
        echo '<select name="" id="tmpenvo_select_post_template_repeater_archive" >';
        foreach ($tmpenvo_post_types as $key => $value) {
            echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
        }
        echo '</select>';
        echo '</div></div></div>';
        echo '<input class="tmpenvo-grid-area3 tmpenvo-delete-button button is-dark" data-repeater-delete type="button" value="Delete"/>';
        //inner repeater;
        echo '<div class="tmpenvo-grid-area2 inner-repeater"><div data-repeater-list="template"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_archive">';
        foreach ($tmpenvo_templates as $key => $value) {
            if ($key == 0) {
                echo '<option value="' . esc_html($key) . '" selected="selected">' . esc_html($value) . '</option>';
            } else {
                echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
            }
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        // include or exclude
        $tmpenvo_inc_exc_array = array(
                                '0' => 'Include',
                                '1' => 'Exclude',
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinc"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc">';
        foreach ($tmpenvo_inc_exc_array as $key => $value) {
            if ($key == 0) {
                echo '<option value="' . esc_html($key) . '" selected="selected">' . esc_html($value) . '</option>';
            } else {
                echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
            }
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        //type of inclution
        $tmpenvo_inc_exc_type_array = array(
                                    '0' => 'All',
                                    '1' => 'Specific Posts By Id',
                                    '2' => 'Category',
                                    '3' => 'Tags',
                                    '4' => 'Author'
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinctype"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc_type">';
        foreach ($tmpenvo_inc_exc_type_array as $key => $value) {
            if ($key == 0) {
                echo '<option value="' . esc_html($key) . '" selected="selected">' . esc_html($value) . '</option>';
            } else {
                echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
            }
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateincdata"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div>';
        echo "<textarea class='textarea' placeholder='IDs seperated by |, eg: 15|16|20 .Check documentation for proper usage' id='tmpenvo_text_area_data' name='' rows='3' cols='50' type='textarea'></textarea>";
        echo '</div></div></div></div></div></div>';

        echo '</div>';
        echo '</div>';
        echo '<input class="button is-dark" data-repeater-create type="button" value="Add"/>';
        echo '</div>';
    }

    public function tmpenvo_html_form_repeater_archive_saved($tmpenvo_post_types, $tmpenvo_templates, $tmpenvo_fields)
    {
        echo '<div class="repeater">';
        echo '<div class="tmpenvo-outerlist" data-repeater-list="tmpenvo_admin_options_archive[tmpenvo_select_post_template_repeater_archive]">';
        $i = 0;
        foreach ($tmpenvo_fields as $key_main => $value_main) {
            echo '<div class="tmpenvo-grid-area1 tmpenvo-repeater-item" data-repeater-item>';
            echo '<div class="field">';
            echo '<div class="control">';
            echo '<div class="select is-success">';
            echo '<select name="" id="tmpenvo_select_post_template_repeater_archive-' . $i . '"> ';
            foreach ($tmpenvo_post_types as $key => $value_post_type) {
                $selected = (isset($value_main[0]) && ucwords($value_main[0]) === $value_post_type) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value_post_type) . '</option>';
            }
            echo '</select>';
            echo '</div></div></div>'; // The field div ends heere
            echo '<input class="button is-dark tmpenvo-grid-area3 tmpenvo-delete-button" data-repeater-delete type="button" value="Delete"/>';

            echo '<div class="tmpenvo-grid-area2 inner-repeater"><div data-repeater-list="template"><div data-repeater-item>';
            echo '<div class="field"><div class="control"><div class="select is-success">';

            echo '  <select name="" id="tmpenvo_select_post_template_repeater_archive">';
            foreach ($tmpenvo_templates as $key => $value) {
                $selected = (isset($value_main['template'][0][0]) && $value_main['template'][0][0] === strval($key)) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value) . '</option>';
            }
            echo '</select>';
            echo '</div></div></div></div></div></div>';

            // include or exclude
        $tmpenvo_inc_exc_array = array(
                                '0' => 'Include',
                                '1' => 'Exclude',
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinc"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc">';
        foreach ($tmpenvo_inc_exc_array as $key => $value) {
                $selected = (isset($value_main['templateinc'][0][0]) && $value_main['templateinc'][0][0] === strval($key)) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value) . '</option>';
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        //type of inclution
      $tmpenvo_inc_exc_type_array = array(
                                    '0' => 'All',
                                    '1' => 'Specific Posts By Id',
                                    '2' => 'Category',
                                    '3' => 'Tags',
                                    '4' => 'Author'
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinctype"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc_type">';
         foreach ($tmpenvo_inc_exc_type_array as $key => $value) {
                $selected = (isset($value_main['templateinctype'][0][0]) && $value_main['templateinctype'][0][0] === strval($key)) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value) . '</option>';
            }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        if(isset($value_main['templateincdata'][0][0])) {
            $tmpenvo_data_ansy = $value_main['templateincdata'][0][0];
        }
        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateincdata"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div>';
        echo "<textarea class='textarea' placeholder='IDs seperated by |,  eg: 15|16|20. Check documentation for proper usage' id='tmpenvo_text_area_data' name='' rows='3' cols='50' type='textarea'>".esc_html($tmpenvo_data_ansy)."
        </textarea>";
        echo '</div></div></div></div></div></div>';

            echo '</div>';
            $i = $i + 1;
        } //foreach ends
        echo '</div>';
        echo '<input class="button is-dark" data-repeater-create type="button" value="Add"/>';
        echo '</div>';
    }

    public function tmpenvo_select_post_template_repeater_archive_callback()
    {
        $tmpenvo_post_types = $this->tmpenvo_list_of_post_types(); //array containing post types
        $tmpenvo_templates  = $this->tmpenvo_archive_template_list_array(); //array containing template list
        if (isset($this->tmpenvo_admin_options_archive['tmpenvo_select_post_template_repeater_archive'])) {
            $tmpenvo_fields = $this->tmpenvo_admin_options_archive['tmpenvo_select_post_template_repeater_archive'];
            $this->tmpenvo_html_form_repeater_archive_saved($tmpenvo_post_types, $tmpenvo_templates, $tmpenvo_fields);
        } else {
            $this->tmpenvo_html_form_repeater_archive_defualt($tmpenvo_post_types, $tmpenvo_templates);
        }
    }

    /*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    WooCommerce Select

    +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

    public function tmpenvo_html_form_repeater_woocommerce_defualt($tmpenvo_post_types, $tmpenvo_templates)
    {
        echo '<div class="repeater">';
        echo '<div class="tmpenvo-outerlist" data-repeater-list="tmpenvo_admin_options_woocommerce[tmpenvo_select_post_template_repeater_woocommerce]">';
        echo '<div class="tmpenvo-grid-area1 tmpenvo-repeater-item" data-repeater-item>';
        echo '<div class="field">';
        echo '<div class="control">';
        echo '<div class="select is-success">';
        echo '<select name="" id="tmpenvo_select_post_template_repeater_woocommerce" >';
        foreach ($tmpenvo_post_types as $key => $value) {
            echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
        }
        echo '</select>';
        echo '</div></div></div>'; // The field div ends heere
        echo '<input class="tmpenvo-grid-area3 tmpenvo-delete-button button is-dark" data-repeater-delete type="button" value="Delete"/>';
        //inner repeater;
        echo '<div class="tmpenvo-grid-area2 inner-repeater"><div data-repeater-list="template"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_woocommerce">';
        foreach ($tmpenvo_templates as $key => $value) {
            if ($key == 0) {
                echo '<option value="' . esc_html($key) . '" selected="selected">' . esc_html($value) . '</option>';
            } else {
                echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
            }
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';
        // include or exclude
        $tmpenvo_inc_exc_array = array(
                                '0' => 'Include',
                                '1' => 'Exclude',
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinc"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc">';
        foreach ($tmpenvo_inc_exc_array as $key => $value) {
            if ($key == 0) {
                echo '<option value="' . esc_html($key) . '" selected="selected">' . esc_html($value) . '</option>';
            } else {
                echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
            }
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        //type of inclution
        $tmpenvo_inc_exc_type_array = array(
                                    '0' => 'All',
                                    '1' => 'Specific Posts By Id',
                                    '2' => 'Category',
                                    '3' => 'Tags',
                                    '4' => 'Author'
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinctype"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc_type">';
        foreach ($tmpenvo_inc_exc_type_array as $key => $value) {
            if ($key == 0) {
                echo '<option value="' . esc_html($key) . '" selected="selected">' . esc_html($value) . '</option>';
            } else {
                echo '<option value="' . esc_html($key) . '">' . esc_html($value) . '</option>';
            }
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateincdata"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div>';
        echo "<textarea class='textarea' placeholder='IDs seperated by |, eg: 15|16|20 .Check documentation for proper usage' id='tmpenvo_text_area_data' name='' rows='3' cols='50' type='textarea'></textarea>";
        echo '</div></div></div></div></div></div>';

        echo '</div>';
        echo '</div>';
        echo '<input class="button is-dark" data-repeater-create type="button" value="Add"/>';
        echo '</div>';
    }

    public function tmpenvo_html_form_repeater_woocommerce_saved($tmpenvo_post_types, $tmpenvo_templates, $tmpenvo_fields)
    {
        echo '<div class="repeater">';
        echo '<div class="tmpenvo-outerlist" data-repeater-list="tmpenvo_admin_options_woocommerce[tmpenvo_select_post_template_repeater_woocommerce]">';
        $i = 0;
        foreach ($tmpenvo_fields as $key_main => $value_main) {
            echo '<div class="tmpenvo-grid-area1 tmpenvo-repeater-item" data-repeater-item>';
            echo '<div class="field">';
            echo '<div class="control">';
            echo '<div class="select is-success">';
            echo '<select name="" id="tmpenvo_select_post_template_repeater_archive-' . $i . '"> ';
            foreach ($tmpenvo_post_types as $key => $value_post_type) {

                $selected = (isset($value_main[0]) && $value_main[0] === $key) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value_post_type) . '</option>';
            }
            echo '</select>';
            echo '</div></div></div>'; // The field div ends heere
            echo '<input class="tmpenvo-grid-area3 tmpenvo-delete-button button is-dark" data-repeater-delete type="button" value="Delete"/>';

            echo '<div class="tmpenvo-grid-area2 inner-repeater"><div data-repeater-list="template"><div data-repeater-item>';
            echo '<div class="field"><div class="control"><div class="select is-success">';

            echo '  <select name="" id="tmpenvo_select_post_template_repeater_woocommerce">';
            foreach ($tmpenvo_templates as $key => $value) {
                $selected = (isset($value_main['template'][0][0]) && $value_main['template'][0][0] === strval($key)) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value) . '</option>';
            }
            echo '</select>';
            echo '</div></div></div></div></div></div>';

            // include or exclude
        $tmpenvo_inc_exc_array = array(
                                '0' => 'Include',
                                '1' => 'Exclude',
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinc"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc">';
        foreach ($tmpenvo_inc_exc_array as $key => $value) {
                $selected = (isset($value_main['templateinc'][0][0]) && $value_main['templateinc'][0][0] === strval($key)) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value) . '</option>';
        }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        //type of inclution
      $tmpenvo_inc_exc_type_array = array(
                                    '0' => 'All',
                                    '1' => 'Specific Posts By Id',
                                    '2' => 'Category',
                                    '3' => 'Tags',
                                    '4' => 'Author'
                                );

        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateinctype"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div class="select is-success">';
        echo '  <select name="" id="tmpenvo_select_post_template_repeater_inc_type">';
         foreach ($tmpenvo_inc_exc_type_array as $key => $value) {
                $selected = (isset($value_main['templateinctype'][0][0]) && $value_main['templateinctype'][0][0] === strval($key)) ? 'selected' : '';
                echo '<option value="' . esc_html($key) . '" ' . esc_html($selected) . '>' . esc_html($value) . '</option>';
            }
        echo '</select>';
        echo '</div></div></div></div></div></div>';

        if(isset($value_main['templateincdata'][0][0])) {
            $tmpenvo_data_ansy = $value_main['templateincdata'][0][0];
        }
        echo '<div class="tmpenvo-grid-area4 inner-repeater"><div data-repeater-list="templateincdata"><div data-repeater-item>';
        echo '<div class="field"><div class="control"><div>';
        echo "<textarea class='textarea' placeholder='IDs seperated by |,  eg: 15|16|20. Check documentation for proper usage' id='tmpenvo_text_area_data' name='' rows='3' cols='50' type='textarea'>".esc_html($tmpenvo_data_ansy)."
        </textarea>";
        echo '</div></div></div></div></div></div>';

            echo '</div>';
            $i = $i + 1;
        } //foreach ends
        echo '</div>';
        echo '<input class="button is-dark" data-repeater-create type="button" value="Add"/>';
        echo '</div>';
    }

    public function tmpenvo_select_post_template_repeater_woocommerce_callback()
    {
        $tmpenvo_post_types = array(
            '0'             => esc_html('Select','tmpenvo'),
            'singleproduct' => esc_html('Single Product Page', 'tmpenvo'),
            'producttaxon'  => esc_html('Taxonomy Archives (Not shop)', 'tmpenvo'),
        );
        $tmpenvo_templates = $this->tmpenvo_template_list_array_woo(); //array containing template list
        if (isset($this->tmpenvo_admin_options_woocommerce['tmpenvo_select_post_template_repeater_woocommerce'])) {
            $tmpenvo_fields = $this->tmpenvo_admin_options_woocommerce['tmpenvo_select_post_template_repeater_woocommerce'];
            $this->tmpenvo_html_form_repeater_woocommerce_saved($tmpenvo_post_types, $tmpenvo_templates, $tmpenvo_fields);
        } else {
            $this->tmpenvo_html_form_repeater_woocommerce_defualt($tmpenvo_post_types, $tmpenvo_templates);
        }
    }

    // Main options page
    public function tmpenvo_main_options_page()
    {
        add_options_page($page_title = 'GGOwl Templates', $menu_title = 'GGOwl Templates', $capability = 'manage_options', 'tmpenvo-settings-admin', array($this, 'tmpenvo_main_menu_callback'));
    }

}
