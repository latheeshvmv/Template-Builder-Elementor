<?php
namespace Elementor;
if (!defined('ABSPATH')) {
    exit;
}

class TMPENVO_Elementor_Title_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'tmpenvo_title';
    }

    public function get_title()
    {
        return esc_html__('Dynamic Title', 'tmpenvo');
    }

    public function get_icon()
    {
        return 'fab fa-cuttlefish';
    }

    public function get_categories()
    {
        return ['tmpenvo-category'];
    }

    public function get_keywords()
    {
        return ['dyn', 'owl', 'title'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'tmpenvo_title_control',
            [
                'label' => esc_html__('Customize Title', 'tmpenvo'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
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

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'tmpenvo_title_background',
                'label'    => esc_html__('Background', 'tmpenvo'),
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'tmpenvo_title_text_shadow',
                'label'    => esc_html__('Text Shadow', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'tmpenvo_title_border',
                'label'    => esc_html__('Border', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner',
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_title_margin',
            [
                'label'      => esc_html__('Margin', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_title_padding',
            [
                'label'      => esc_html__('Padding', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_title_width',
            [
                'label'      => esc_html__('Width', 'tmpenvo'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_text_align',
            [
                'label'     => esc_html__('Title Alignment', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => esc_html__('Left', 'tmpenvo'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'tmpenvo'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__('Right', 'tmpenvo'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
                'toggle'    => true,
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_content_text_align',
            [
                'label'     => esc_html__('Content Alignment', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'tmpenvo'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'tmpenvo'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Right', 'tmpenvo'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title' => 'justify-content: {{VALUE}};',
                ],
                'default'   => 'left',
                'toggle'    => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'tmpenvo_text_section_title_typography_meta',
            [
                'label' => esc_html__('Typography', 'tmpenvo'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'style_normal_tab',
            [
                'label' => esc_html__('Text Color', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color',
            [
                'label'     => esc_html__('Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color_p',
            [
                'label'     => esc_html__('Paragraph Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner p' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color_a',
            [
                'label'     => esc_html__('Links Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color_h1',
            [
                'label'     => esc_html__('H1 Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner h1' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color_h2',
            [
                'label'     => esc_html__('H2 Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner h2' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color_h3',
            [
                'label'     => esc_html__('H3 Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner h3' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color_h4',
            [
                'label'     => esc_html__('H4 Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner h4' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color_h5',
            [
                'label'     => esc_html__('H5 Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner h5' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color_h6',
            [
                'label'     => esc_html__('H6 Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-title-inner h6' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab_5',
            [
                'label' => esc_html__('Typography', 'tmpenvo'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography',
                'label'    => esc_html__('Typography', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_p',
                'label'    => esc_html__('Typography Paragraph', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_a',
                'label'    => esc_html__('Typography Links', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner a',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h1',
                'label'    => esc_html__('Typography H1', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner h1',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h2',
                'label'    => esc_html__('Typography H2', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner h2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h3',
                'label'    => esc_html__('Typography H3', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner h3',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h4',
                'label'    => esc_html__('Typography H4', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner h4',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h5',
                'label'    => esc_html__('Typography H5', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner h5',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h6',
                'label'    => esc_html__('Typography H6', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner h6',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_li',
                'label'    => esc_html__('Typography List', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-title-inner li',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings             = $this->get_settings_for_display();
        $tmpenvo_title_instance = new \TMPENVOHELPERNS\TMPENVOHelper();
        $tmpenvo_selector       = $settings['tmpenvo_text_header_size'];
        global $post;
        if ($post->post_type == 'tmpenvo_template'):
            $post_id         = get_the_ID();
            $tmpenvo_post_type = $tmpenvo_title_instance->tmpenvo_active_post_template($post_id);
            $tmpenvo_id        = $tmpenvo_title_instance->tmpenvo_single_post_returner($tmpenvo_post_type);
            if (is_int($tmpenvo_id)) {
                echo '<div class="tmpenvo-widget-title" >';
                echo '<div class="tmpenvo-widget-title-inner" >';
                echo "<$tmpenvo_selector>";
                echo esc_html($tmpenvo_title_instance->tmpenvo_core_title_gen($tmpenvo_id));
                echo "</$tmpenvo_selector>";
                echo '</div>';
                echo '</div>';
            } else {
                $tmpenvo_id;
            } else :
            echo '<div class="tmpenvo-widget-title" >';
            echo '<div class="tmpenvo-widget-title-inner" >';
            $tmpenvo_id = get_the_id();
            echo "<$tmpenvo_selector>";
            echo esc_html($tmpenvo_title_instance->tmpenvo_core_title_gen($tmpenvo_id));
            echo "</$tmpenvo_selector>";
            echo '</div>';
            echo '</div>';
        endif;
    }

}
