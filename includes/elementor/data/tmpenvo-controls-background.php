<?php
if (!defined('ABSPATH')) {exit;}
$element->add_control(
    'tmpenvo_back_section_enable',
    [
        'label'        => esc_html__('Enable Custom Background', 'tmpenvo'),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => esc_html__('Yes', 'tmpenvo'),
        'label_off'    => esc_html__('No', 'tmpenvo'),
        'return_value' => 'yes',
        'default'      => 'no',
    ]
);

$element->add_control(
    'tmpenvo_back_section_enable_hover',
    [
        'label'        => esc_html__('Enable Custom Hover Background', 'tmpenvo'),
        'type'         => \Elementor\Controls_Manager::SWITCHER,
        'label_on'     => esc_html__('Yes', 'tmpenvo'),
        'label_off'    => esc_html__('No', 'tmpenvo'),
        'return_value' => 'yes',
        'default'      => 'no',
    ]
);

$element->start_controls_tabs(
    'tmpenvo_back_section_tab'
);

$element->start_controls_tab(
    'tmpenvo_back_section_normal_tab',
    [
        'label'     => esc_html__('Normal', 'tmpenvo'),
        'condition' => [
            'tmpenvo_back_section_enable' => ['yes'],
        ],
    ]
);

$element->add_control(
			'important_note_okay',
			[
				'label' => esc_html__( 'Important Note', 'tmpenvo' ),
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Use a placeholder image for the preview in live edit mode. For the actual post the background will show up based on field type selected. Overlay effects can be as used as usual from the background settings', 'tmpenvo' ),
				'content_classes' => 'your-class',
			]
		);

$element->add_control(
    'tmpenvo_back_section_img_field_type',
    [
        'label'       => esc_html__('Field Type', 'tmpenvo'),
        'type'        => \Elementor\Controls_Manager::SELECT,
        'default'     => 'featuredimage',
        'options'     => [
            'featuredimage' => esc_html__('Featured Image', 'tmpenvo'),
            'acf_array'     => esc_html__('ACF Array', 'tmpenvo'),
            'acf_url'       => esc_html__('ACF Url', 'tmpenvo'),
            'acf_id'        => esc_html__('ACF ID', 'tmpenvo'),
            'customfield'   => esc_html__('Custom Field ', 'tmpenvo'),
        ],
        'description' => esc_html__('Set Return Type. Custom field requrires attachment id to Passed', 'tmpenvo'),
        'condition'   => [
            'tmpenvo_back_section_enable' => ['yes'],
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_img_field_key',
    [
        'label'       => esc_html__('Field Key', 'tmpenvo'),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__('Enter Custom Field Key', 'tmpenvo'),
        'condition'   => [
            'tmpenvo_back_section_enable' => ['yes'],
            'tmpenvo_back_section_img_field_type' => ['acf_array','acf_url','acf_id','customfield']
        ],
    ]
);

$element->add_group_control(
    \Elementor\Group_Control_Image_Size::get_type(),
    [
        'name'      => 'tmpenvo_back_section_image_nor', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
        'exclude'   => ['custom', 'Full'],
        'include'   => [],
        'default'   => 'large',
        'condition' => [
            'tmpenvo_back_section_enable' => ['yes'],
        ],
    ]
);

$element->add_responsive_control(
    'tmpenvo_back_section_img_position',
    [
        'label'     => esc_html_x('Position', 'Background Control', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'devices'   => ['desktop', 'tablet', 'mobile'],
        'options'   => [
            'center center' => esc_html_x('Default', 'Background Control', 'tmpenvo'),
            'left top'      => esc_html_x('Top Left', 'Background Control', 'tmpenvo'),
            'center top'    => esc_html_x('Top Center', 'Background Control', 'tmpenvo'),
            'right top'     => esc_html_x('Top Right', 'Background Control', 'tmpenvo'),
            'left center'   => esc_html_x('Center Left', 'Background Control', 'tmpenvo'),
            'center center' => esc_html_x('Center Center', 'Background Control', 'tmpenvo'),
            'right center'  => esc_html_x('Center Right', 'Background Control', 'tmpenvo'),
            'left bottom'   => esc_html_x('Bottom Left', 'Background Control', 'tmpenvo'),
            'center bottom' => esc_html_x('Bottom Center', 'Background Control', 'tmpenvo'),
            'right bottom'  => esc_html_x('Bottom Right', 'Background Control', 'tmpenvo'),
            'initial'       => esc_html_x('Custom', 'Background Control', 'tmpenvo'),

        ],
        'selectors' => [
            '{{WRAPPER}} .tmpenvo-container' => 'background-position: {{VALUE}};',
        ],
        'condition' => [
            'tmpenvo_back_section_enable' => ['yes'],
        ],
    ]);

$element->add_responsive_control(
    'tmpenvo_back_section_img_x_pos',
    [
        'label'       => esc_html__('X Postion with units', 'tmpenvo'),
        'devices'     => ['desktop', 'tablet', 'mobile'],
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => '',
        'placeholder' => esc_html__('Example 120px No space between number and unit ', 'tmpenvo'),
        'required'    => true,
        'selectors'   => [
            '{{WRAPPER}} .tmpenvo-container' => 'background-position-x: {{VALUE}}',
        ],
        'condition'   => [
            'tmpenvo_back_section_img_position' => ['initial'],
            'tmpenvo_back_section_enable'       => ['yes'],
        ],
    ]
);

$element->add_responsive_control(
    'tmpenvo_back_section_img_y_pos',
    [
        'label'       => esc_html__('X Postion with units', 'tmpenvo'),
        'devices'     => ['desktop', 'tablet', 'mobile'],
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => '',
        'placeholder' => esc_html__('Example 120px No space between number and unit ', 'tmpenvo'),
        'required'    => true,
        'condition'   => [
            'tmpenvo_back_section_img_position' => ['initial'],
            'tmpenvo_back_section_enable'       => ['yes'],
        ],
        'selectors'   => [
            '{{WRAPPER}} .tmpenvo-container' => 'background-position-y: {{VALUE}}',
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_attachment',
    [
        'label'     => esc_html__('Background Attachment', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'default'   => 'scroll',
        'options'   => [
            'scroll' => esc_html__('Scroll', 'tmpenvo'),
            'fixed'  => esc_html__('Fixed', 'tmpenvo'),
        ],
        'selectors' => [
            '{{WRAPPER}} .tmpenvo-container' => 'background-attachment: {{VALUE}}',
        ],
        'condition' => [
            'tmpenvo_back_section_enable' => ['yes'],
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_repeat',
    [
        'label'     => esc_html__('Background Repeat', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'default'   => 'no-repeat',
        'options'   => [
            'no-repeat' => esc_html__('No repeat', 'tmpenvo'),
            'repeat'    => esc_html__('Repeat', 'tmpenvo'),
            'repeat-x'  => esc_html__('Repeat X', 'tmpenvo'),
            'repeat-y'  => esc_html__('Repeat Y', 'tmpenvo'),
        ],
        'selectors' => [
            '{{WRAPPER}} .tmpenvo-container' => 'background-repeat: {{VALUE}}',
        ],
        'condition' => [
            'tmpenvo_back_section_enable' => ['yes'],
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_size',
    [
        'label'     => esc_html__('Background Size', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'default'   => 'auto',
        'options'   => [
            'auto'    => esc_html__('Auto', 'tmpenvo'),
            'cover'   => esc_html__('Cover', 'tmpenvo'),
            'contain' => esc_html__('Contain', 'tmpenvo'),
        ],
        'selectors' => [
            '{{WRAPPER}} .tmpenvo-container' => 'background-size: {{VALUE}}',
        ],
        'condition' => [
            'tmpenvo_back_section_enable' => ['yes'],
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_img_placeholder_ren',
    [
        'label'     => esc_html__('Place holder for empty images', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::MEDIA,
        'default'   => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
        'selectors' => [
            '{{WRAPPER}} .tmpenvo-container' => 'background-image: url("{{URL}}")',
        ],
        'condition' => [
            'tmpenvo_back_section_enable' => ['yes'],
        ],
    ]
);

$element->end_controls_tab();

$element->start_controls_tab(
    'tmpenvo_back_sectione_hover_tab',
    [
        'label'     => esc_html__('Hover', 'tmpenvo'),
        'condition' => [
            'tmpenvo_back_section_enable_hover' => ['yes'],
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_img_field_type_hover',
    [
        'label'       => esc_html__('Field Type', 'tmpenvo'),
        'type'        => \Elementor\Controls_Manager::SELECT,
        'default'     => 'featuredimage',
        'options'     => [
            'featuredimage' => esc_html__('Featured Image', 'tmpenvo'),
            'acf_array'     => esc_html__('ACF Array', 'tmpenvo'),
            'acf_url'       => esc_html__('ACF Url', 'tmpenvo'),
            'acf_id'        => esc_html__('ACF ID', 'tmpenvo'),
            'customfield'   => esc_html__('Custom Field ', 'tmpenvo'),
        ],
        'description' => esc_html__('Set Return Type. Custom field requrires attachment id to Passed', 'tmpenvo'),
        'condition'   => [
            'tmpenvo_back_section_enable_hover' => ['yes'],
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_img_field_key_hover',
    [
        'label'       => esc_html__('Field Key', 'tmpenvo'),
        'type'        => \Elementor\Controls_Manager::TEXT,
        'placeholder' => esc_html__('Enter Custom Field Key', 'tmpenvo'),
        'condition'   => [
            'tmpenvo_back_section_enable_hover' => ['yes'],
        ],
    ]
);

$element->add_group_control(
    \Elementor\Group_Control_Image_Size::get_type(),
    [
        'name'      => 'tmpenvo_back_section_image_nor_hover', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
        'exclude'   => ['custom'],
        'include'   => [],
        'default'   => 'large',
        'condition' => [
            'tmpenvo_back_section_enable_hover' => ['yes'],
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_img_placeholder_hover',
    [
        'label'     => esc_html__('Place holder for empty images', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::MEDIA,
        'default'   => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
        'selectors' => [
            '{{WRAPPER}}:hover > .tmpenvo-container' => 'background-image: url("{{URL}}")',
        ],
        'condition' => [
            'tmpenvo_back_section_enable_hover' => ['yes'],
        ],
    ]
);

$element->add_responsive_control(
    'tmpenvo_back_section_img_position_hover',
    [
        'label'     => esc_html_x('Position', 'Background Control', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'devices'   => ['desktop', 'tablet', 'mobile'],
        'options'   => [
            ''              => esc_html_x('Default', 'Background Control', 'tmpenvo'),
            'left top'      => esc_html_x('Top Left', 'Background Control', 'tmpenvo'),
            'center top'    => esc_html_x('Top Center', 'Background Control', 'tmpenvo'),
            'right top'     => esc_html_x('Top Right', 'Background Control', 'tmpenvo'),
            'left center'   => esc_html_x('Center Left', 'Background Control', 'tmpenvo'),
            'center center' => esc_html_x('Center Center', 'Background Control', 'tmpenvo'),
            'right center'  => esc_html_x('Center Right', 'Background Control', 'tmpenvo'),
            'left bottom'   => esc_html_x('Bottom Left', 'Background Control', 'tmpenvo'),
            'center bottom' => esc_html_x('Bottom Center', 'Background Control', 'tmpenvo'),
            'right bottom'  => esc_html_x('Bottom Right', 'Background Control', 'tmpenvo'),
            'initial'       => esc_html_x('Custom', 'Background Control', 'tmpenvo'),
        ],
        'selectors' => [
            '{{WRAPPER}}:hover > .tmpenvo-container' => 'background-position:{{VALUE}}',
        ],
        'condition' => [
            'tmpenvo_back_section_enable_hover' => ['yes'],
        ],
    ]);

$element->add_responsive_control(
    'tmpenvo_back_section_img_x_pos_hover',
    [
        'label'       => esc_html__('X Postion with units', 'tmpenvo'),
        'devices'     => ['desktop', 'tablet', 'mobile'],
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => '',
        'placeholder' => esc_html__('Example 120px No space between number and unit ', 'tmpenvo'),
        'required'    => true,
        'condition'   => [
            'tmpenvo_back_section_img_position_hover' => ['initial'],
            'tmpenvo_back_section_enable_hover'       => ['yes'],
        ],
        'selectors'   => [
            '{{WRAPPER}}:hover > .tmpenvo-container' => 'background-position-x:{{VALUE}}',
        ],
    ]
);

$element->add_responsive_control(
    'tmpenvo_back_section_img_y_pos_hover',
    [
        'label'       => esc_html__('X Postion with units', 'tmpenvo'),
        'devices'     => ['desktop', 'tablet', 'mobile'],
        'type'        => \Elementor\Controls_Manager::TEXT,
        'default'     => '',
        'placeholder' => esc_html__('Example 120px No space between number and unit ', 'tmpenvo'),
        'required'    => true,
        'condition'   => [
            'tmpenvo_back_section_img_position_hover' => ['initial'],
            'tmpenvo_back_section_enable_hover'       => ['yes'],
        ],
        'selectors'   => [
            '{{WRAPPER}}:hover > .tmpenvo-container' => 'background-position-y:{{VALUE}}',
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_attachment_hover',
    [
        'label'     => esc_html__('Background Attachment', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'default'   => 'scroll',
        'options'   => [
            'scroll' => esc_html__('Scroll', 'tmpenvo'),
            'fixed'  => esc_html__('Fixed', 'tmpenvo'),
        ],
        'selectors' => [
            '{{WRAPPER}}:hover > .tmpenvo-container' => 'background-attachment:{{VALUE}}',
        ],
        'condition' => [
            'tmpenvo_back_section_enable_hover' => ['yes'],
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_repeat_hover',
    [
        'label'     => esc_html__('Background Repeat', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'default'   => 'no-repeat',
        'options'   => [
            'no-repeat' => esc_html__('No repeat', 'tmpenvo'),
            'repeat'    => esc_html__('Repeat', 'tmpenvo'),
            'repeat-x'  => esc_html__('Repeat X', 'tmpenvo'),
            'repeat-y'  => esc_html__('Repeat Y', 'tmpenvo'),
        ],
        'selectors' => [
            '{{WRAPPER}}:hover > .tmpenvo-container' => 'background-repeat:{{VALUE}}',
        ],
        'condition' => [
            'tmpenvo_back_section_enable_hover' => ['yes'],
        ],
    ]
);

$element->add_control(
    'tmpenvo_back_section_size_hover',
    [
        'label'     => esc_html__('Background Size', 'tmpenvo'),
        'type'      => \Elementor\Controls_Manager::SELECT,
        'default'   => 'auto',
        'options'   => [
            'auto'    => esc_html__('Auto', 'tmpenvo'),
            'cover'   => esc_html__('Cover', 'tmpenvo'),
            'contain' => esc_html__('Contain', 'tmpenvo'),
        ],
        'selectors' => [
            '{{WRAPPER}}:hover > .tmpenvo-container' => 'background-size:{{VALUE}}',
        ],
        'condition' => [
            'tmpenvo_back_section_enable_hover' => ['yes'],
        ],
    ]
);

$element->end_controls_tabs();

$element->end_controls_section();
