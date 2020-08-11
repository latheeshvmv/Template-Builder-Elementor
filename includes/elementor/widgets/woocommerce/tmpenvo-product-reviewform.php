<?php
namespace Elementor;
if (!defined('ABSPATH')) {
    exit;
}

class Ggowl_Elementor_product_reviewform extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'tmpenvo_product_reviewform';
    }

    public function get_title()
    {
        return esc_html__('Review Form', 'tmpenvo');
    }


    public function get_icon()
    {
        return 'fab fa-product-hunt';
    }

    public function get_keywords()
    {
        return ['dyn', 'owl', 'review', 'product', 'woo'];
    }

    public function get_categories()
    {
        return ['tmpenvo-category-woo'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'tmpenvo_product_reviewform_control',
            [
                'label' => esc_html__('Customize Review', 'tmpenvo'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );



        $this->add_control(
            'tmpenvo_product_reviewform_type',
            [
                'label'   => esc_html__('Review', 'tmpenvo'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'rating',
                'options' => [
                    'rating'          => esc_html__('Rating', 'tmpenvo'),
                    'reviews'         => esc_html__('Reviews', 'tmpenvo'),
                    'reviewform'      => esc_html__('Review Form', 'tmpenvo'),
                    'reviewformtheme' => esc_html__('Theme Form (Frontend Only)', 'tmpenvo'),
                ],
            ]
        );

        $this->start_controls_tabs(
          'style_tabs_reviews'
        );

        $this->start_controls_tab(
          'style_icon_tab',
          [
            'label' => esc_html__( 'Icon', 'tmpenvo' ),
          ]
        );

        $this->add_control(
            'set_1',
            [
                'label'     => esc_html__('Icon Settings', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'tmpenvo_product_reviewform_icon',
            [
                'label'     => esc_html__('Icon', 'text-domain'),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-star',
                    'library' => 'solid',
                ],
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['rating', 'reviews'],
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_product_reviewform_color_terc',
            [
                'label'     => esc_html__('Review Icon Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-rating-review' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['rating', 'reviews'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'tmpenvo_product_reviewform_content_typography_terc',
                'label'     => esc_html__('Icon Size', 'tmpenvo'),
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'selector'  => '{{WRAPPER}} .tmpenvo-rating-review',
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['rating', 'reviews'],
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_product_reviewform_margin_terc',
            [
                'label'      => esc_html__('Icon Margin', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-rating-review i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'tmpenvo_product_reviewform_type' => ['rating', 'reviews'],
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_product_reviewform_padding_terc',
            [
                'label'      => esc_html__('Icon Padding', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-rating-review i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'tmpenvo_product_reviewform_type' => ['rating', 'reviews'],
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
          'style_hover_tab_7',
          [
            'label' => esc_html__( 'Block Controls', 'tmpenvo' ),
          ]
        );

        $this->add_control(
			'show_date_reviews',
			[
				'label' => esc_html__( 'Show Review Date', 'tmpenvo' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tmpenvo' ),
				'label_off' => esc_html__( 'Hide', 'tmpenvo' ),
				'return_value' => 'yes',
				'default' => 'yes',
        'condition'  => [
            'tmpenvo_product_reviewform_type' => ['reviews'],
        ],
			]
		);


        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'tmpenvo_product_reviewform_background',
                'label'    => esc_html__('Background', 'tmpenvo'),
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner',
            ]
        );

        $this->add_control(
      			'important_note_background',
      			[
      				'label' => '',
      				'type' => \Elementor\Controls_Manager::RAW_HTML,
      				'raw' => esc_html__( 'Background option below can be used for individal review background', 'tmpenvo' ),
      				'content_classes' => 'your-class',
              'condition'  => [
                  'tmpenvo_product_reviewform_type' => ['reviews'],
              ],
      			]
      		);

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'tmpenvo_product_reviewform_background_indivi',
                'label'    => esc_html__('Background Individual', 'tmpenvo'),
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .tmpenvo-reviews-woocommerce',
                'condition'  => [
                    'tmpenvo_product_reviewform_type' => ['reviews'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'tmpenvo_product_reviewform_text_shadow',
                'label'    => esc_html__('Review Shadow', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'tmpenvo_product_reviewform_border',
                'label'    => esc_html__('Border', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'tmpenvo_product_reviewform_border_ind',
                'label'     => esc_html__('Border for Individual lists', 'tmpenvo'),
                'selector'  => '{{WRAPPER}} .tmpenvo-reviews-woocommerce',
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['reviews'],
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_product_reviewform_margin',
            [
                'label'      => esc_html__('Margin', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_product_reviewform_padding',
            [
                'label'      => esc_html__('Padding', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_product_reviewform_margin_list',
            [
                'label'      => esc_html__('Margin for Individual list items', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} 	.tmpenvo-reviews-woocommerce' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'tmpenvo_product_reviewform_type' => ['reviews'],
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_product_reviewform_padding_list',
            [
                'label'      => esc_html__('Margin for Individual list items', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-reviews-woocommerce' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'tmpenvo_product_reviewform_type' => ['reviews'],
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_review_form_width_setter',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_product_reviewform_align',
            [
                'label'     => esc_html__('Review Text Alignment', 'tmpenvo'),
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'left',
                'toggle'    => true,
            ]
        );

        $this->add_control(
            'tmpenvo_product_reviewform_content_align',
            [
                'label'     => esc_html__('Review Alignment', 'tmpenvo'),
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform' => 'justify-content: {{VALUE}};',
                ],
                'default'   => 'left',
                'toggle'    => true,
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
            'tmpenvo_product_reviewform_color_button',
            [
                'label'     => esc_html__('Submit Button Text Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-form-group input' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['reviewform'],
                ],
            ]
        );



        $this->add_control(
            'tmpenvo_product_reviewform_color_button_background',
            [
                'label'     => esc_html__('Submit Button Background Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-form-group input' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['reviewform'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'tmpenvo_product_reviewform_border_button',
                'label'     => esc_html__('Border', 'tmpenvo'),
                'selector'  => '{{WRAPPER}} .tmpenvo-form-group input',
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['reviewform'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tmpenvo_product_reviewform_background_button',
                'label'     => esc_html__('Button Background Color', 'tmpenvo'),
                'types'     => ['classic', 'gradient'],
                'default'   => '#000000',
                'selector'  => '{{WRAPPER}} .tmpenvo-form-group input',
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['reviewform'],
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_reviewform_gravathar_size',
            [
                'label'     => esc_html__('Gravatar Size(in px)', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 30,
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['reviews'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'tmpenvo_product_reviewform_background_terc',
                'label'     => esc_html__('Background', 'tmpenvo'),
                'types'     => ['classic', 'gradient', 'video'],
                'selector'  => '{{WRAPPER}} .tmpenvo-rating-review i',
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['rating', 'reviews'],
                ],
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'tmpenvo_product_reviewform_control_pagination',
            [
                'label'     => esc_html__('Customize Pagination', 'tmpenvo'),
                'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['reviews'],
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_reviewform_comments_per_page',
            [
                'label'     => esc_html__('Reviews Per Page', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'default'   => 10,
                'condition' => [
                    'tmpenvo_product_reviewform_type' => ['reviews'],
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_reviewform_enable_pagination_top',
            [
                'label'        => esc_html__('Enable Pagination Top', 'tmpenvo'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('No', 'your-plugin'),
                'label_off'    => esc_html__('Yes', 'your-plugin'),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => [
                    'tmpenvo_product_reviewform_type' => ['reviews'],
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_reviewform_enable_pagination_bottom',
            [
                'label'        => esc_html__('Enable Pagination Bottom', 'tmpenvo'),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__('No', 'your-plugin'),
                'label_off'    => esc_html__('Yes', 'your-plugin'),
                'return_value' => 'yes',
                'default'      => 'no',
                'condition'    => [
                    'tmpenvo_product_reviewform_type' => ['reviews'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'pagination_typography',
                'label'    => esc_html__('Pagination Typography', 'tmpenvo'),
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-reviewlist-pagination',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'tmpenvo_paggination_background',
                'label'    => esc_html__('Background', 'tmpenvo'),
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .tmpenvo-reviewlist-pagination',
            ]
        );

        $this->add_control(
            'paggination_text_color',
            [
                'label'     => esc_html__('Pagination Text Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#5b5b5b',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-reviewlist-pagination .page-numbers' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'paggination_background_color_pagenumber',
            [
                'label'     => esc_html__('Pagination background color for page numbers', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-reviewlist-pagination .page-numbers' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hractive',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'paggination_background_color_active',
            [
                'label'     => esc_html__('Pagination background color for active page', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#54595f',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-reviewlist-pagination .current ' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'paggination_text_color_active',
            [
                'label'     => esc_html__('Pagination text Color For active page', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-reviewlist-pagination .current' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hrbackcol',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'tmpenvo_pagination_margin',
            [
                'label'      => esc_html__('Pagination Block Margin', 'tmpenvo'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-reviewlist-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_pagination_padding',
            [
                'label'      => esc_html__('Pagination Block Padding', 'tmpenvo'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '10',
                    'bottom'   => '10',
                    'left'     => '10',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-reviewlist-pagination' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hrpagenum',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_control(
            'tmpenvo_pagination_margin_pagenumber',
            [
                'label'      => esc_html__('Page number Margin', 'tmpenvo'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '2',
                    'right'    => '20',
                    'bottom'   => '2',
                    'left'     => '20',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-reviewlist-pagination .page-numbers' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_pagination_padding_pagenumber',
            [
                'label'      => esc_html__('Page number Padding', 'tmpenvo'),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'      => '5',
                    'right'    => '20',
                    'bottom'   => '5',
                    'left'     => '20',
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-reviewlist-pagination .page-numbers' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'paggination_numbers_border_border_radius',
            [
                'label'     => esc_html__('Pagination number border radius', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::NUMBER,
                'scheme'    => [
                    'type'  => \Elementor\Controls_Manager::NUMBER,
                    'value' => \Elementor\Controls_Manager::NUMBER,
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-reviewlist-pagination .page-numbers' => 'border-radius: {{VALUE}}px',
                ],
                'default'   => 0,

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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner p' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner a' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h1' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h2' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h3' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h4' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h5' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h6' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab_8',
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
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_p',
                'label'    => esc_html__('Typography Paragraph', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_a',
                'label'    => esc_html__('Typography Links', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner a',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h1',
                'label'    => esc_html__('Typography H1', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h1',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h2',
                'label'    => esc_html__('Typography H2', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h3',
                'label'    => esc_html__('Typography H3', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h3',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h4',
                'label'    => esc_html__('Typography H4', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h4',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h5',
                'label'    => esc_html__('Typography H5', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h5',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h6',
                'label'    => esc_html__('Typography H6', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner h6',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_li',
                'label'    => esc_html__('Typography List', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-product_reviewform-inner li',
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
        $tmpenvo_product_reviewform_instance = new \TMPENVOHELPERNS\GgowlHelper();
        $tmpenvo_review_type                 = $settings['tmpenvo_product_reviewform_type'];
        $gravatar_size                     = $settings['tmpenvo_reviewform_gravathar_size'];
        $commentsperpage                   = $settings['tmpenvo_reviewform_comments_per_page'];
        $enable_pagination_bottom          = $settings['tmpenvo_reviewform_enable_pagination_bottom'];
        $enable_pagination_top             = $settings['tmpenvo_reviewform_enable_pagination_top'];
        $show_review_date                  = $settings['show_date_reviews'];
        global $post;
        $icon_html = $settings['tmpenvo_product_reviewform_icon'];
        echo '<div class="tmpenvo-widget-product_reviewform" >';
        echo '<div class="tmpenvo-widget-product_reviewform-inner" >';

        if ($post->post_type == 'tmpenvo_template'):
            $post_id         = get_the_ID();
            $tmpenvo_post_type = $tmpenvo_product_reviewform_instance->tmpenvo_active_post_template($post_id);
            $tmpenvo_id        = $tmpenvo_product_reviewform_instance->tmpenvo_single_post_returner($tmpenvo_post_type);
            if (is_int($tmpenvo_id)) {
                switch ($tmpenvo_review_type) {
                    case 'rating':
                        $tmpenvo_product_reviewform_instance->tmpenvo_comment_form_rating($tmpenvo_id, $icon_html);
                        break;
                    case 'reviews':
                        $tmpenvo_product_reviewform_instance->tmpenvo_comment_lister($show_review_date,$tmpenvo_id, $icon_html, $gravatar_size, $commentsperpage, $enable_pagination_top, $enable_pagination_bottom);
                        break;
                    case 'reviewform':
                        $tmpenvo_product_reviewform_instance->tmpenvo_comment_form($tmpenvo_id);
                        break;
                    case 'reviewformtheme':
                        comments_template('woocommerce/single-product-reviews');
                        break;
                }
            } else {
                $tmpenvo_id;
            } else :
            $tmpenvo_id = get_the_id();
            switch ($tmpenvo_review_type) {
                case 'rating':
                    $tmpenvo_product_reviewform_instance->tmpenvo_comment_form_rating($tmpenvo_id, $icon_html);
                    break;
                case 'reviews':
                    $tmpenvo_product_reviewform_instance->tmpenvo_comment_lister($show_review_date,$tmpenvo_id, $icon_html, $gravatar_size, $commentsperpage, $enable_pagination_top, $enable_pagination_bottom);
                    break;
                case 'reviewform':
                    $tmpenvo_product_reviewform_instance->tmpenvo_comment_form($tmpenvo_id);
                    break;
                case 'reviewformtheme':
                    comments_template('woocommerce/single-product-reviews');
                    break;
            }
        endif;

        echo '</div>';
        echo '</div>';

    }

}
