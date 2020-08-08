<?php if (!defined('ABSPATH')) {exit;}

$this->add_responsive_control(
    'tmpenvo_text_align',
    [
        'label'     => esc_html__('Alignment', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::CHOOSE,
        'options'   => [
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
        'default'   => '',
        'selectors' => [
            '{{WRAPPER}}' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'tmpenvo_text_view',
    [
        'label'   => esc_html__('View', 'tmpenvo'),
        'type'    => \Elementor\Controls_Manager::HIDDEN,
        'default' => 'traditional',
    ]
);
$this->end_controls_section();

$this->start_controls_section(
    'tmpenvo_text_section_title_style',
    [
        'label'     => esc_html__('Title', 'tmpenvo'),
        'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'fieldtype' => 'text',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Text_Shadow::get_type(),
    [
        'name'     => 'text_shadow',
        'selector' => '{{WRAPPER}} .tmpenvo-text-customfield',
    ]
);

$this->add_control(
    'tmpenvo_text_blend_mode',
    [
        'label'     => esc_html__('Blend Mode', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'options'   => [
            ''            => esc_html__('Normal', 'tmpenvo'),
            'multiply'    => 'Multiply',
            'screen'      => 'Screen',
            'overlay'     => 'Overlay',
            'darken'      => 'Darken',
            'lighten'     => 'Lighten',
            'color-dodge' => 'Color Dodge',
            'saturation'  => 'Saturation',
            'color'       => 'Color',
            'difference'  => 'Difference',
            'exclusion'   => 'Exclusion',
            'hue'         => 'Hue',
            'luminosity'  => 'Luminosity',
        ],
        'selectors' => [
            '{{WRAPPER}} .tmpenvo-text-customfield' => 'mix-blend-mode: {{VALUE}}',
        ],
        'separator' => 'none',
    ]
);
