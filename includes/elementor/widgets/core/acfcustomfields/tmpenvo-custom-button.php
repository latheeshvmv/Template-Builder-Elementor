<?php if (!defined('ABSPATH')) {exit;}

$this->add_control(
    'tmpenvo_button_button_type',
    [
        'label'        => esc_html__('Type', 'tmpenvo'),
        'type'         => \Elementor\Controls_Manager::SELECT,
        'default'      => '',
        'options'      => [
            ''        => esc_html__('Default', 'tmpenvo'),
            'info'    => esc_html__('Info', 'tmpenvo'),
            'success' => esc_html__('Success', 'tmpenvo'),
            'warning' => esc_html__('Warning', 'tmpenvo'),
            'danger'  => esc_html__('Danger', 'tmpenvo'),
        ],
        'prefix_class' => 'elementor-button-',
        'condition'    => [
            'fieldtype' => 'button',
        ],
    ]
);

$this->add_control(
    'tmpenvo_button_text',
    [
        'label'       => esc_html__('Text', 'tmpenvo'),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'dynamic'     => [
            'active' => true,
        ],
        'default'     => esc_html__('Click here', 'tmpenvo'),
        'placeholder' => esc_html__('Click here', 'tmpenvo'),
        'description' => esc_html__('This will only work if the url is only passed', 'tmpenvo'),
        'condition'   => [
            'fieldtype' => 'button',
        ],
    ]
);

$this->add_responsive_control(
    'tmpenvo_button_align',
    [
        'label'        => esc_html__('Alignment', 'tmpenvo'),
        'type'         => \Elementor\Controls_Manager::CHOOSE,
        'options'      => [
            'left'    => [
                'title' => esc_html__('Left', 'tmpenvo'),
                'icon'  => 'eicon-text-align-left',
            ],
            'center'  => [
                'title' => esc_html__('Center', 'tmpenvo'),
                'icon'  => 'eicon-text-align-center',
            ],
            'right'   => [
                'title' => esc_html__('Right', 'tmpenvo'),
                'icon'  => 'eicon-text-align-right',
            ],
            'justify' => [
                'title' => esc_html__('Justified', 'tmpenvo'),
                'icon'  => 'eicon-text-align-justify',
            ],
        ],
        'prefix_class' => 'elementor%s-align-',
        'default'      => '',
        'condition'    => [
            'fieldtype' => 'button',
        ],
    ]
);

$this->add_control(
    'tmpenvo_button_selected_icon',
    [
        'label'            => esc_html__('Icon', 'tmpenvo'),
        'type'             => \Elementor\Controls_Manager::ICONS,
        'label_block'      => true,
        'fa4compatibility' => 'icon',
        'condition'        => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->add_control(
    'tmpenvo_button_icon_align',
    [
        'label'     => esc_html__('Icon Position', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'default'   => 'left',
        'options'   => [
            'left'  => esc_html__('Before', 'tmpenvo'),
            'right' => esc_html__('After', 'tmpenvo'),
        ],
        'condition' => [
            'tmpenvo_button_selected_icon[value]!' => '',
        ],
    ]
);
$this->add_control(
    'tmpenvo_button_icon_indent',
    [
        'label'     => esc_html__('Icon Spacing', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SLIDER,
        'range'     => [
            'px' => [
                'max' => 50,
            ],
        ],
        'selectors' => [
            '{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
            '{{WRAPPER}} .elementor-button .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->add_control(
    'tmpenvo_button_view',
    [
        'label'     => esc_html__('View', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::HIDDEN,
        'default'   => 'traditional',
        'condition' => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->add_control(
    'tmpenvo_button_button_css_id',
    [
        'label'       => esc_html__('Button ID', 'tmpenvo'),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'dynamic'     => [
            'active' => true,
        ],
        'default'     => '',
        'title'       => esc_html__('Add your custom id WITHOUT the Pound key. e.g: my-id', 'tmpenvo'),
        'label_block' => false,
        'description' => esc_html__('Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'tmpenvo'),
        'separator'   => 'before',
        'condition'   => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->end_controls_section();
$this->start_controls_section(
    'tmpenvo_button_section_style',
    [
        'label'     => esc_html__('Button', 'tmpenvo'),
        'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name'      => 'tmpenvo_button_typography',
        'scheme'    => \Elementor\Scheme_Typography::TYPOGRAPHY_4,
        'selector'  => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
        'condition' => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->add_group_control(
    \Elementor\Group_Control_Text_Shadow::get_type(),
    [
        'name'      => 'tmpenvo_button_text_shadow',
        'selector'  => '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button',
        'condition' => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->start_controls_tabs('tabs_button_style');
$this->start_controls_tab(
    'tmpenvo_button_tab_button_normal',
    [
        'label'     => esc_html__('Normal', 'tmpenvo'),
        'condition' => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->add_control(
    'tmpenvo_button_button_text_color',
    [
        'label'     => esc_html__('Text Color', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'default'   => '',
        'selectors' => [
            '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'fill: {{VALUE}}; color: {{VALUE}};',
        ],
        'condition' => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->add_control(
    'tmpenvo_button_background_color',
    [
        'label'     => esc_html__('Background Color', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'scheme'    => [
            'type'  => \Elementor\Scheme_Color::get_type(),
            'value' => \Elementor\Scheme_Color::COLOR_4,
        ],
        'selectors' => [
            '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
        ],
        'condition' => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->end_controls_tab();
$this->start_controls_tab(
    'tmpenvo_button_tab_button_hover',
    [
        'label'     => esc_html__('Hover', 'tmpenvo'),
        'condition' => [
            'fieldtype' => 'button',
        ],
    ]
);
$this->add_control(
    'tmpenvo_button_hover_color',
    [
        'label'     => esc_html__('Text Color', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus'                 => 'color: {{VALUE}};',
            '{{WRAPPER}} a.elementor-button:hover svg, {{WRAPPER}} .elementor-button:hover svg, {{WRAPPER}} a.elementor-button:focus svg, {{WRAPPER}} .elementor-button:focus svg' => 'fill: {{VALUE}};',
        ],
    ]
);
$this->add_control(
    'tmpenvo_button_button_background_hover_color',
    [
        'label'     => esc_html__('Background Color', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'background-color: {{VALUE}};',
        ],
    ]
);
$this->add_control(
    'tmpenvo_button_button_hover_border_color',
    [
        'label'     => esc_html__('Border Color', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::COLOR,
        'condition' => [
            'border_border!' => '',
        ],
        'selectors' => [
            '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover, {{WRAPPER}} a.elementor-button:focus, {{WRAPPER}} .elementor-button:focus' => 'border-color: {{VALUE}};',
        ],
    ]
);
$this->add_control(
    'tmpenvo_button_hover_animation',
    [
        'label' => esc_html__('Hover Animation', 'tmpenvo'),
        'type'  => \Elementor\Controls_Manager::HOVER_ANIMATION,
    ]
);
$this->end_controls_tab();
$this->end_controls_tabs();
$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name'      => 'tmpenvo_button_border',
        'selector'  => '{{WRAPPER}} .elementor-button',
        'separator' => 'before',
    ]
);
$this->add_control(
    'tmpenvo_button_border_radius',
    [
        'label'      => esc_html__('Border Radius', 'tmpenvo'),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors'  => [
            '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);
$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name'     => 'tmpenvo_button_button_box_shadow',
        'selector' => '{{WRAPPER}} .elementor-button',
    ]
);
$this->add_responsive_control(
    'tmpenvo_button_text_padding',
    [
        'label'      => esc_html__('Padding', 'tmpenvo'),
        'type'       => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', '%'],
        'selectors'  => [
            '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'separator'  => 'before',
    ]
);
