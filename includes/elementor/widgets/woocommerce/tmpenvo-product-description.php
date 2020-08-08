<?php
namespace Elementor;
if (!defined('ABSPATH')) {
    exit;
}

class Ggowl_Elementor_product_description extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'tmpenvo_product_description';
    }

    public function get_title()
    {
        return esc_html__('Product Description', 'tmpenvo');
    }

    public function get_icon()
    {
        return 'fab fa-product-hunt';
    }

    public function get_keywords()
    {
        return ['dyn', 'owl', 'description', 'product', 'woo'];
    }

    public function get_categories()
    {
        return ['tmpenvo-category-woo'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'tmpenvo_product_description_control',
            [
                'label' => esc_html__('Customize Product Description', 'tmpenvo'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'tmpenvo_product_description_background',
                'label'    => esc_html__('Background', 'tmpenvo'),
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'tmpenvo_product_description_text_shadow',
                'label'    => esc_html__('Text Shadow', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'tmpenvo_product_description_border',
                'label'    => esc_html__('Border', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner',
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_product_description_margin',
            [
                'label'      => esc_html__('Margin', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_product_description_padding',
            [
                'label'      => esc_html__('Padding', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_product_description_align',
            [
                'label'     => esc_html__('Product Description Text Alignment', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'tmpenvo'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'tmpenvo'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'tmpenvo'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
                'toggle'    => true,
            ]
        );

        $this->add_control(
            'tmpenvo_product_description_content_align',
            [
                'label'     => esc_html__('Product Description Alignment', 'tmpenvo'),
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
                    '{{WRAPPER}} .tmpenvo-widget-product_description' => 'justify-content: {{VALUE}};',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner p' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner a' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner h1' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner h2' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner h3' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner h4' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner h5' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_description-inner h6' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab_6',
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
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_p',
                'label'    => esc_html__('Typography Paragraph', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_a',
                'label'    => esc_html__('Typography Links', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner a',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h1',
                'label'    => esc_html__('Typography H1', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner h1',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h2',
                'label'    => esc_html__('Typography H2', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner h2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h3',
                'label'    => esc_html__('Typography H3', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner h3',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h4',
                'label'    => esc_html__('Typography H4', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner h4',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h5',
                'label'    => esc_html__('Typography H5', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner h5',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h6',
                'label'    => esc_html__('Typography H6', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner h6',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_li',
                'label'    => esc_html__('Typography List', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_description-inner li',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();
        if (!class_exists('WooCommerce')) {
            echo esc_html("WooCommerce  Not Active", 'tmpenvo');
            return;
        }
        $tmpenvo_product_description_instance = new \TMPENVOHELPERNS\GgowlHelper();
        $tmpenvo_allowed                      = $tmpenvo_product_description_instance->ggwol_allowed_html();
        global $post;

        if ($post->post_type == 'tmpenvo_template'):
            $post_id         = get_the_ID();
            $tmpenvo_post_type = $tmpenvo_product_description_instance->tmpenvo_active_post_template($post_id);
            $tmpenvo_id        = $tmpenvo_product_description_instance->tmpenvo_single_post_returner($tmpenvo_post_type);
            if (is_int($tmpenvo_id)) {
                echo '<div class="tmpenvo-widget-product_description" >';
                echo '<div class="tmpenvo-widget-product_description-inner" >';
                echo wp_kses($tmpenvo_product_description_instance->tmpenvo_product_decription_gen($tmpenvo_id), $tmpenvo_allowed);
                echo '</div>';
                echo '</div>';
            } else {
                $tmpenvo_id;
            } else :
            echo '<div class="tmpenvo-widget-product_description" >';
            echo '<div class="tmpenvo-widget-product_description-inner" >';
            $tmpenvo_id = get_the_id();
            echo wp_kses($tmpenvo_product_description_instance->tmpenvo_product_decription_gen($tmpenvo_id), $tmpenvo_allowed);
            echo '</div>';
            echo '</div>';
        endif;

    }

}
