<?php
namespace Elementor;
if (!defined('ABSPATH')) {
    exit;
}

class TMPENVO_Elementor_CustomFields_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'tmpenvo-customfields';
    }

    public function get_title()
    {
        return esc_html__('ACF Text/ Button', 'tmpenvo');
    }

    public function get_icon()
    {
        return 'fas fa-laptop-code';
    }

    public function get_keywords()
    {
        return ['dyn', 'owl', 'custom', 'acf', 'text', 'button'];
    }

    public function get_categories()
    {
        return ['tmpenvo-category'];
    }

    private function get_acf_list()
    {
        global $wpdb;
        $tmpenvo_qry          = "SELECT post_excerpt as 'field_name', post_title as 'field_label' FROM {$wpdb->prefix}posts where post_type = 'acf-field'";
        $tmpenvo_list_results = $wpdb->get_results($tmpenvo_qry, ARRAY_A);
        $acf_field_array    = array();
        if (!empty($tmpenvo_list_results)) {
            foreach ($tmpenvo_list_results as $value) {
                $acf_field_array[$value['field_name']] = $value['field_label'];
            }
        }
        return $acf_field_array;
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'tmpenvo'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'fieldtype',
            [
                'label'       => esc_html__('Field Type', 'tmpenvo'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'text',
                'options'     => [
                    'text'   => esc_html__('Text / Text Area', 'tmpenvo'),
                    'button' => esc_html__('Button', 'tmpenvo'),
                ],
                'description' => esc_html__('', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'tmpenvo_text_header_size',
            [
                'label'   => esc_html__('Field Wrapper', 'tmpenvo'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'div',
            ]
        );

        $this->add_control(
            'fieldtype_setter',
            [
                'label'       => esc_html__('Field Key Setter', 'tmpenvo'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'manual',
                'options'     => [
                    'manual' => esc_html__('Type Field Key Manually', 'tmpenvo'),
                    'list'   => esc_html__('Choose Field Key From List', 'tmpenvo'),
                ],
                'description' => esc_html__('', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'tmpenvo_field_name',
            [
                'label'       => esc_html__('Custom Field Name (Key)', 'tmpenvo'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Type field name here.', 'tmpenvo'),
                'condition'   => [
                    'fieldtype_setter' => ['manual'],
                ],
            ]
        );

        $this->add_control(
            'fieldtype_setter_list',
            [
                'label'       => esc_html__('Custom Field Name', 'tmpenvo'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'manual',
                'options'     => $this->get_acf_list(),
                'description' => esc_html__('', 'tmpenvo'),
                'condition'   => [
                    'fieldtype_setter' => ['list'],
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_field_name_append',
            [
                'label'     => esc_html__('Append Before', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::CODE,
                'language'  => 'html',
                'rows'      => 4,
                'condition' => [
                    'fieldtype' => 'text',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_field_name_prepend',
            [
                'label'     => esc_html__('Prepend Content', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::CODE,
                'language'  => 'html',
                'rows'      => 4,
                'condition' => [
                    'fieldtype' => 'text',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_woo_fields_color_content_alighstraight',
            [
                'label'        => esc_html__('Align Content to a single line ?', 'tmpenvo'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('Yes', 'your-plugin'),
                'label_off'    => esc_html__('No', 'your-plugin'),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tmpenvo_text_section_title',
            [
                'label'     => esc_html__('Text', 'tmpenvo'),
                'condition' => [
                    'fieldtype' => 'text',
                ],
            ]
        );
        include plugin_dir_path(__FILE__) . 'acfcustomfields/tmpenvo-custom-text.php';
        $this->end_controls_section();

        $this->start_controls_section(
            'section_button',
            [
                'label'     => esc_html__('Button', 'tmpenvo'),
                'condition' => [
                    'fieldtype' => 'button',
                ],
            ]
        );
        include plugin_dir_path(__FILE__) . 'acfcustomfields/tmpenvo-custom-button.php';
        $this->end_controls_section();

        include plugin_dir_path(__FILE__) . 'acfcustomfields/tmpenvo-custom-typography.php';
    }

    protected function render()
    {
        global $post;
        $settings                = $this->get_settings_for_display();
        $settings                = $this->get_settings_for_display();
        $tmpenvo_acffield_instance = new \TMPENVOHELPERNS\TMPENVOHelper();

        if ($post->post_type == 'tmpenvo_template'):
            $post_id         = get_the_ID();
            $tmpenvo_post_type = $tmpenvo_acffield_instance->tmpenvo_active_post_template($post_id);
            $tmpenvo_id        = $tmpenvo_acffield_instance->tmpenvo_single_post_returner($tmpenvo_post_type);
            if (is_int($tmpenvo_id)) {
                echo '<div class="tmpenvo-widget-acffield" >';
                echo '<div class="tmpenvo-widget-acffield-inner">';
                $tmpenvo_acffield_instance->tmpenvo_acf_content_render($settings, $tmpenvo_id, $tmpenvo_post_type = 'tmpenvo_template');
                echo '</div>';
                echo '</div>';
            } else {
                $tmpenvo_id;
            } else :
            $tmpenvo_id = get_the_id();
            echo '<div class="tmpenvo-widget-acffield" >';
            echo '<div class="tmpenvo-widget-acffield-inner">';
            $tmpenvo_acffield_instance->tmpenvo_acf_content_render($settings, $tmpenvo_id);
            echo '</div>';
            echo '</div>';
        endif;
    }

}
