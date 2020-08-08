<?php
namespace Elementor;
if (!defined('ABSPATH')) {
    exit;
}

class Ggowl_Elementor_woo_fields extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'tmpenvo_woo_fields';
    }

    public function get_title()
    {
        return esc_html__('Product Fields', 'tmpenvo');
    }

    public function get_icon()
    {
        return 'fab fa-product-hunt';
    }

    public function get_keywords()
    {
        return ['dyn', 'owl', 'woofield', 'product', 'woo'];
    }

    public function get_categories()
    {
        return ['tmpenvo-category-woo'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'tmpenvo_woo_fields_control',
            [
                'label' => esc_html__('Customize Fields', 'tmpenvo'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tmpenvo_woo_fields_control_type',
            [
                'label'   => esc_html__('General Information', 'tmpenvo'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'price',
                'options' => [
                    'price'          => esc_html__('Price', 'tmpenvo'),
                    'regular_price'  => esc_html__('Regualar Price', 'tmpenvo'),
                    'sale_price'     => esc_html__('Sale Price', 'tmpenvo'),
                    'total_sales'    => esc_html__('Total Sale Count', 'tmpenvo'),
                    'type'           => esc_html__('Product Type', 'tmpenvo'),
                    'name'           => esc_html__('Product Name', 'tmpenvo'),
                    'slug'           => esc_html__('Product Slug', 'tmpenvo'),
                    'date_created'   => esc_html__('Date Created', 'tmpenvo'),
                    'date_modified'  => esc_html__('Date Modified', 'tmpenvo'),
                    'product_status' => esc_html__('Product Status', 'tmpenvo'),
                    'get_virtual'    => esc_html__('Is Product Virtual', 'tmpenvo'),
                    'get_featured'   => esc_html__('Is Product Featured?', 'tmpenvo'),
                    'get_sku'        => esc_html__('Product SKU', 'tmpenvo'),
                    'review_count'   => esc_html__('Review Count', 'tmpenvo'),
                    'rating_count'   => esc_html__('Rating Count', 'tmpenvo'),
                    'average_rating' => esc_html__('Average Rating', 'tmpenvo'),
                    'get_attributes' => esc_html__('Product Attributes', 'tmpenvo'),
                    'get_width'      => esc_html__('Product Width', 'tmpenvo'),
                    'get_height'     => esc_html__('Product Height', 'tmpenvo'),
                    'get_length'     => esc_html__('Product Length', 'tmpenvo'),
                    'get_weight'     => esc_html__('Product Weight', 'tmpenvo'),
                    'stock_quanity'  => esc_html__('Stock Quantity', 'tmpenvo'),
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_woo_fields_color_content_is_virtual',
            [
                'label'     => esc_html__('Content to display if Virtual', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::CODE,
                'language'  => 'html',
                'rows'      => 4,
                'condition' => ['tmpenvo_woo_fields_control_type' => 'get_virtual'],
            ]
        );

        $this->add_control(
            'tmpenvo_woo_fields_color_content_is_featured',
            [
                'label'     => esc_html__('Content to display if Featured', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::CODE,
                'language'  => 'html',
                'rows'      => 4,
                'condition' => ['tmpenvo_woo_fields_control_type' => 'get_featured'],
            ]
        );

        $this->add_control(
            'tmpenvo_woo_fields_color_content_before',
            [
                'label'    => esc_html__('Content Before', 'tmpenvo'),
                'type'     => \Elementor\Controls_Manager::CODE,
                'language' => 'html',
                'rows'     => 4,
            ]
        );

        $this->add_control(
            'tmpenvo_woo_fields_color_content_after',
            [
                'label'    => esc_html__('Content After', 'tmpenvo'),
                'type'     => \Elementor\Controls_Manager::CODE,
                'language' => 'html',
                'rows'     => 4,
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

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'tmpenvo_woo_fields_background',
                'label'    => esc_html__('Background', 'tmpenvo'),
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'tmpenvo_woo_fields_text_shadow',
                'label'    => esc_html__('Fields Shadow', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'tmpenvo_woo_fields_border',
                'label'    => esc_html__('Border', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner',
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_woo_fields_margin',
            [
                'label'      => esc_html__('Margin', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_woo_fields_padding',
            [
                'label'      => esc_html__('Padding', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_woo_fields_width',
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_woo_fields_text_align',
            [
                'label'     => esc_html__('Product Content Alignment', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start'   => [
                        'title' => esc_html__('Left', 'tmpenvo'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'tmpenvo'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'flex-end'  => [
                        'title' => esc_html__('Right', 'tmpenvo'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner' => 'justify-content: {{VALUE}};',
                ],
                'default'   => 'left',
                'toggle'    => true,
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_woo_fields_text_align_text_only',
            [
                'label'     => esc_html__('Product Content Alignment', 'tmpenvo'),
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
                'toggle'    => true,
            ]
        );



        $this->add_responsive_control(
            'tmpenvo_woo_fields_content_align',
            [
                'label'     => esc_html__('Fields Alignment', 'tmpenvo'),
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields' => 'justify-content: {{VALUE}};',
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner p' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner a' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h1' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h2' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h3' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h4' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h5' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h6' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab_11',
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
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_p',
                'label'    => esc_html__('Typography Paragraph', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_a',
                'label'    => esc_html__('Typography Links', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner a',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h1',
                'label'    => esc_html__('Typography H1', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h1',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h2',
                'label'    => esc_html__('Typography H2', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h3',
                'label'    => esc_html__('Typography H3', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h3',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h4',
                'label'    => esc_html__('Typography H4', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h4',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h5',
                'label'    => esc_html__('Typography H5', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h5',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h6',
                'label'    => esc_html__('Typography H6', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner h6',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_li',
                'label'    => esc_html__('Typography List', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-woo_fields-inner li',
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
        $tmpenvo_woo_fields_instance = new \TMPENVOHELPERNS\GgowlHelper();
        $field_type                = $settings['tmpenvo_woo_fields_control_type'];
        $aligninstraight           = $settings['tmpenvo_woo_fields_color_content_alighstraight'];
        $allowed_html              = $tmpenvo_woo_fields_instance->ggwol_allowed_html();
        if ('yes' === $aligninstraight) {
            $styler = 'style="display:inline-flex;"';
        } else {
            $styler = '';
        }
        global $post;
        if ($post->post_type == 'tmpenvo_template'):
            $post_id         = get_the_ID();
            $tmpenvo_post_type = $tmpenvo_woo_fields_instance->tmpenvo_active_post_template($post_id);
            $tmpenvo_id        = $tmpenvo_woo_fields_instance->tmpenvo_single_post_returner($tmpenvo_post_type);

            if (is_int($tmpenvo_id)) {
                if (empty($tmpenvo_woo_fields_instance->tmpenvo_product_woofields_gen($settings, $tmpenvo_id, $field_type))) {
                    return;
                }
                echo '<div class="tmpenvo-widget-woo_fields" >';
                echo '<div class="tmpenvo-widget-woo_fields-inner" ' . $styler . '>';
                if (!empty($tmpenvo_woo_fields_instance->tmpenvo_product_woofields_gen($settings, $tmpenvo_id, $field_type))) {
                    echo wp_kses($settings['tmpenvo_woo_fields_color_content_before'], $tmpenvo_woo_fields_instance->ggwol_allowed_html()) ;
                }
                echo wp_kses($tmpenvo_woo_fields_instance->tmpenvo_product_woofields_gen($settings, $tmpenvo_id, $field_type), $allowed_html);
                if (!empty($tmpenvo_woo_fields_instance->tmpenvo_product_woofields_gen($settings, $tmpenvo_id, $field_type))) {
                    echo wp_kses($settings['tmpenvo_woo_fields_color_content_after'], $tmpenvo_woo_fields_instance->ggwol_allowed_html());
                }
                echo '</div>';
                echo '</div>';
            } else {
                $tmpenvo_id;
            } else :
            $tmpenvo_id = get_the_id();
            if (empty($tmpenvo_woo_fields_instance->tmpenvo_product_woofields_gen($settings, $tmpenvo_id, $field_type))) {
                return;
            }
            echo '<div class="tmpenvo-widget-woo_fields" >';
            echo '<div class="tmpenvo-widget-woo_fields-inner" ' . $styler . '>';
            if (!empty($tmpenvo_woo_fields_instance->tmpenvo_product_woofields_gen($settings, $tmpenvo_id, $field_type))) {
                echo wp_kses($settings['tmpenvo_woo_fields_color_content_before'], $tmpenvo_woo_fields_instance->ggwol_allowed_html());
            }
            echo wp_kses($tmpenvo_woo_fields_instance->tmpenvo_product_woofields_gen($settings, $tmpenvo_id, $field_type), $allowed_html);
            if (!empty($tmpenvo_woo_fields_instance->tmpenvo_product_woofields_gen($settings, $tmpenvo_id, $field_type))) {
                echo wp_kses($settings['tmpenvo_woo_fields_color_content_after'], $tmpenvo_woo_fields_instance->ggwol_allowed_html());
            }
            echo '</div>';
            echo '</div>';
        endif;
    }

}
