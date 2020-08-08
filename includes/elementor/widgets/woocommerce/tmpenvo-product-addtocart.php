<?php
namespace Elementor;
if (!defined('ABSPATH')) {
    exit;
}

class Ggowl_Elementor_addtocart extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'tmpenvo_addtocart';
    }

    public function get_title()
    {
        return esc_html__('Add to Cart Button', 'tmpenvo');
    }

    public function get_icon()
    {
        return 'fas fa-luggage-cart';
    }

    public function get_categories()
    {
        return ['tmpenvo-category-woo'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'tmpenvo_addtocart_control',
            [
                'label' => esc_html__('Customize Add to Cart', 'tmpenvo'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tmpenvo_addtocart_button_text',
            [
                'label'   => esc_html__('Button Text', 'tmpenvo'),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Add to Cart', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'tmpenvo_button_text_color_net',
            [
                'label'     => esc_html__('Text Content Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#54595f',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-addtocart-cont' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_button_text_color_net_yeps',
            [
                'label'     => esc_html__('Link Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-addtocart-cont a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_addtocart_content_typography_net',
                'label'    => esc_html__('Typography for Content', 'tmpenvo'),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-addtocart-cont',
            ]
        );

        $this->start_controls_tabs(
            'style_tabs'
        );

        $this->start_controls_tab(
            'tmpenvo_common',
            [
                'label' => esc_html__('Common', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'tmpenvo_button_text_color',
            [
                'label'     => esc_html__('Button Text Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-addtocart-inner-cont button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_button_background_color',
            [
                'label'     => esc_html__('Button Background Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-addtocart-inner-cont button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'border_button',
                'label'    => esc_html__('Border', 'tmpenvo'),
                'default'  => '',
                'selector' => '{{WRAPPER}} .tmpenvo-widget-addtocart-inner-cont button',
            ]
        );

        $this->add_control(
            'tmpenvo_button_border_radius',
            [
                'label'     => esc_html__('Border Radius', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 0,
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-addtocart-inner-cont button' => 'border-radius: {{VALUE}}px',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_addtocart_content_typography',
                'label'    => esc_html__('Typography', 'tmpenvo'),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-addtocart-inner-cont button',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'tmpenvo_addtocart_text_shadow',
                'label'    => esc_html__('Add to Cart Shadow', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-addtocart-inner-cont button',
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_addtocart_width_control',
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
                    '{{WRAPPER}} .tmpenvo-addtocart-main-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_addtocart_padding_outer',
            [
                'label'      => esc_html__('Button Margin', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-addtocart-inner-cont button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_addtocart_padding',
            [
                'label'      => esc_html__('Padding', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-addtocart-inner-cont button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_addtocart_padding_quantity_selector',
            [
                'label'      => esc_html__('Padding Quantity Selector', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-addtocart-main-container-quantity input[type="number"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_button_background_color_quanity_selector',
            [
                'label'     => esc_html__('Quanity Selector Background Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#d8d8d8',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-addtocart-main-container-quantity input[type="number"]' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_addtocart_width_control_quantity_selct',
            [
                'label'      => esc_html__('Quantity Selector Width', 'tmpenvo'),
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
                    'unit' => 'px',
                    'size' => 150,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-addtocart-main-container-quantity input[type="number"]' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_addtocart_align',
            [
                'label'     => esc_html__('Add to Cart Text Alignment', 'tmpenvo'),
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
                    '{{WRAPPER}} .tmpenvo-widget-addtocart-inner-cont button' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
                'toggle'    => true,
            ]
        );

        $this->add_control(
            'tmpenvo_addtocart_content_align',
            [
                'label'     => esc_html__('Add to Cart Alignment', 'tmpenvo'),
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
                    '{{WRAPPER}} .tmpenvo-cart' => 'justify-content: {{VALUE}};',
                ],
                'default'   => 'left',
                'toggle'    => true,
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tmpenvo-variable',
            [
                'label' => esc_html__('Select Design', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'tmpenvo_button_text_color_net_3',
            [
                'label'     => esc_html__('Select Text Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo_value select' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_button_text_color_net_2',
            [
                'label'     => esc_html__('Select Background Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo_value select' => 'background-color: {{VALUE}}',
                ],
            ]
        );

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
        $tmpenvo_button_text        = $settings['tmpenvo_addtocart_button_text'];
        $tmpenvo_addtocart_instance = new \TMPENVOHELPERNS\GgowlHelper();
        global $post;

        echo '<div class="tmpenvo-widget-addtocart-cont" >';
        echo '<div class="tmpenvo-widget-addtocart-inner-cont add-to-cart" >';

        if ($post->post_type == 'tmpenvo_template'):
            $post_id         = get_the_ID();
            $tmpenvo_post_type = $tmpenvo_addtocart_instance->tmpenvo_active_post_template($post_id);
            $tmpenvo_id        = $tmpenvo_addtocart_instance->tmpenvo_single_post_returner($tmpenvo_post_type);
            if (is_int($tmpenvo_id)) {
                $tmpenvo_addtocart_instance->tmpenvo_addtocart_gen_template($tmpenvo_id, $tmpenvo_button_text);
            } else {
                $tmpenvo_id;
            } else :
            global $product;
            $tmpenvo_id = get_the_id();

            $tmpenvo_addtocart_instance->tmpenvo_addtocart_gen($tmpenvo_id, $tmpenvo_button_text);

        endif;
        echo '</div>';
        echo '</div>';

    }

}
