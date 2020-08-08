<?php
if (!defined('ABSPATH')) {exit;}

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
            '{{WRAPPER}} .tmpenvo-widget-acffield-inner' => 'color: {{VALUE}}',
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
            '{{WRAPPER}} .tmpenvo-widget-acffield-inner p' => 'color: {{VALUE}}',
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
            '{{WRAPPER}} .tmpenvo-widget-acffield-inner a' => 'color: {{VALUE}}',
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
            '{{WRAPPER}} .tmpenvo-widget-acffield-inner h1' => 'color: {{VALUE}}',
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
            '{{WRAPPER}} .tmpenvo-widget-acffield-inner h2' => 'color: {{VALUE}}',
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
            '{{WRAPPER}} .tmpenvo-widget-acffield-inner h3' => 'color: {{VALUE}}',
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
            '{{WRAPPER}} .tmpenvo-widget-acffield-inner h4' => 'color: {{VALUE}}',
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
            '{{WRAPPER}} .tmpenvo-widget-acffield-inner h5' => 'color: {{VALUE}}',
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
            '{{WRAPPER}} .tmpenvo-widget-acffield-inner h6' => 'color: {{VALUE}}',
        ],
    ]
);

$this->end_controls_tab();

$this->start_controls_tab(
    'style_hover_tab_1',
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
        'selector' => '{{WRAPPER}} .tmpenvo-widget-acffield-inner',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'tmpenvo_acf_text_typography_p',
        'label'    => esc_html__('Typography Paragraph', 'tmpenvo'),
        'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .tmpenvo-widget-acffield-inner p',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'tmpenvo_acf_text_typography_a',
        'label'    => esc_html__('Typography Links', 'tmpenvo'),
        'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .tmpenvo-widget-acffield-inner a',
    ]
);
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'tmpenvo_acf_text_typography_h1',
        'label'    => esc_html__('Typography H1', 'tmpenvo'),
        'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .tmpenvo-widget-acffield-inner h1',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'tmpenvo_acf_text_typography_h2',
        'label'    => esc_html__('Typography H2', 'tmpenvo'),
        'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .tmpenvo-widget-acffield-inner h2',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'tmpenvo_acf_text_typography_h3',
        'label'    => esc_html__('Typography H3', 'tmpenvo'),
        'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .tmpenvo-widget-acffield-inner h3',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'tmpenvo_acf_text_typography_h4',
        'label'    => esc_html__('Typography H4', 'tmpenvo'),
        'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .tmpenvo-widget-acffield-inner h4',
    ]
);
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'tmpenvo_acf_text_typography_h5',
        'label'    => esc_html__('Typography H5', 'tmpenvo'),
        'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .tmpenvo-widget-acffield-inner h5',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'tmpenvo_acf_text_typography_h6',
        'label'    => esc_html__('Typography H6', 'tmpenvo'),
        'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .tmpenvo-widget-acffield-inner h6',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'     => 'tmpenvo_acf_text_typography_li',
        'label'    => esc_html__('Typography List', 'tmpenvo'),
        'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
        'selector' => '{{WRAPPER}} .tmpenvo-widget-acffield-inner li',
    ]
);

$this->end_controls_section();
