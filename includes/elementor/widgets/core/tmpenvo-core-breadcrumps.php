<?php
namespace Elementor;
if (!defined('ABSPATH')) {
    exit;
}

class Ggowl_Elementor_Breadcrump_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'tmpenvo_breadcrump';
    }

    public function get_title()
    {
        return esc_html__('Dynamic Breadcrump', 'tmpenvo');
    }

    public function get_icon()
    {
        return 'fab fa-cuttlefish';
    }

    public function get_keywords()
    {
        return ['dyn', 'owl', 'breadcrump'];
    }

    public function get_categories()
    {
        return ['tmpenvo-category'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'tmpenvo_breadcrump_control',
            [
                'label' => esc_html__('Customize Breadcrump', 'tmpenvo'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tmpenvo_breadcrump_breadcrump_seperator',
            [
                'label'   => esc_html__('Seperator', 'tmpenvo'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => ' > ',
                'options' => [
                    ' | '  => ' | ',
                    ' || ' => ' || ',
                    ' > '  => ' > ',
                    ' < '  => ' < ',
                    ' - '  => ' - ',
                    ' -- ' => ' -- ',
                    ' >> ' => ' >> ',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_breadcrump_breadcrump_color',
            [
                'label'     => esc_html__('Breadcrump Text Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-breadcrump' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_breadcrump_breadcrump_link_color',
            [
                'label'     => esc_html__('Breadcrump Link Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-breadcrump a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'tmpenvo_breadcrump_background',
                'label'    => esc_html__('Background', 'tmpenvo'),
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .tmpenvo-widget-breadcrump',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_breadcrump_content_typography',
                'label'    => esc_html__('Typography', 'tmpenvo'),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-breadcrump',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'tmpenvo_breadcrump_text_shadow',
                'label'    => esc_html__('Text Shadow', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-breadcrump',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'tmpenvo_breadcrump_border',
                'label'    => esc_html__('Border', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-breadcrump',
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_breadcrump_margin',
            [
                'label'      => esc_html__('Margin', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-breadcrump' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_breadcrump_padding',
            [
                'label'      => esc_html__('Padding', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-breadcrump' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_text_align',
            [
                'label'     => esc_html__('Alignment', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'breadcrump' => esc_html__('Left', 'tmpenvo'),
                        'icon'       => 'fa fa-align-left',
                    ],
                    'center'     => [
                        'breadcrump' => esc_html__('Center', 'tmpenvo'),
                        'icon'       => 'fa fa-align-center',
                    ],
                    'flex-end'   => [
                        'breadcrump' => esc_html__('Right', 'tmpenvo'),
                        'icon'       => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-breadcrump' => 'justify-content:{{VALUE}}',
                ],
                'default'   => 'left',
                'toggle'    => true,
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {

        $settings   = $this->get_settings_for_display();
        $tmpenvobread = new \TMPENVOHELPERNS\GgowlHelper();
        $tmpenvo_sep  = '&nbsp;' . $settings['tmpenvo_breadcrump_breadcrump_seperator'] . '&nbsp;';

        echo '<div class="tmpenvo-widget-breadcrump">';
        $tmpenvobread->tmpenvo_c_breadcrump_render($tmpenvo_sep);
        echo '</div>';

    }

}
