<?php
namespace Elementor;
if (!defined('ABSPATH')) {
    exit;
}

class TMPENVO_Elementor_Comment_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'tmpenvo_comment';
    }

    public function get_title()
    {
        return esc_html__('Theme Comment', 'tmpenvo');
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
        return ['dyn', 'owl', 'comment'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'tmpenvo_comment_control',
            [
                'label' => esc_html__('Customize Comment', 'tmpenvo'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'tmpenvo-content-helper',
            [
                'label'           => esc_html__('', 'tmpenvo'),
                'type'            => \Elementor\Controls_Manager::RAW_HTML,
                'raw'             => esc_html__('This widget is for displaying the comment form. The Form appearance completely depends on the theme styling. You may be able to customize the color and typogrpahy of the form if it is not hardcoded by your theme.', 'tmpenvo'),
                'content_classes' => 'tmpenvo-content-helper',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'tmpenvo_comment_background',
                'label'    => esc_html__('Background', 'tmpenvo'),
                'types'    => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'tmpenvo_comment_border',
                'label'    => esc_html__('Border', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment',
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_comment_margin',
            [
                'label'      => esc_html__('Margin', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-comment' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tmpenvo_comment_padding',
            [
                'label'      => esc_html__('Padding', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'devices'    => ['desktop', 'tablet', 'mobile'],
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .tmpenvo-widget-comment' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_comment_align',
            [
                'label'   => esc_html__('Content Alignment', 'tmpenvo'),
                'type'    => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'comment' => esc_html__('Left', 'tmpenvo'),
                        'icon'    => 'fa fa-align-left',
                    ],
                    'center' => [
                        'comment' => esc_html__('Center', 'tmpenvo'),
                        'icon'    => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'comment' => esc_html__('Right', 'tmpenvo'),
                        'icon'    => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle'  => true,
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
                    '{{WRAPPER}} .tmpenvo-widget-comment' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-comment p' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-comment a' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-comment h1' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-comment h2' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-comment h3' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-comment h4' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-comment h5' => 'color: {{VALUE}}',
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
                    '{{WRAPPER}} .tmpenvo-widget-comment h6' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'style_hover_tab_2',
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
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_p',
                'label'    => esc_html__('Typography Paragraph', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_a',
                'label'    => esc_html__('Typography Links', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment a',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h1',
                'label'    => esc_html__('Typography H1', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment h1',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h2',
                'label'    => esc_html__('Typography H2', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment h2',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h3',
                'label'    => esc_html__('Typography H3', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment h3',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h4',
                'label'    => esc_html__('Typography H4', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment h4',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h5',
                'label'    => esc_html__('Typography H5', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment h5',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_h6',
                'label'    => esc_html__('Typography H6', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment h6',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_li',
                'label'    => esc_html__('Typography List', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment li',
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'tmpenvo_content_text_shadow',
                'label'    => esc_html__('Text Shadow', 'tmpenvo'),
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment',
            ]
        );

        $this->add_control(
            'hr_1',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'tmpenvo_acf_text_typography_button',
                'label'    => esc_html__('Typography Button', 'tmpenvo'),
                'scheme'   => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .tmpenvo-widget-comment input',
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color_button_color',
            [
                'label'     => esc_html__('Button Text Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-comment input' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'tmpenvo_title_title_color_background_cl',
            [
                'label'     => esc_html__('Button Background Color', 'tmpenvo'),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'default'   => '#54595f',
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-comment input' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings               = $this->get_settings_for_display();
        $tmpenvo_comment_instance = new \TMPENVOHELPERNS\TMPENVOHelper();
        global $post;

        if ($post->post_type == 'tmpenvo_template'):
            $post_id         = get_the_ID();
            $tmpenvo_post_type = $tmpenvo_comment_instance->tmpenvo_active_post_template($post_id);
            $tmpenvo_id        = $tmpenvo_comment_instance->tmpenvo_single_post_returner($tmpenvo_post_type);
            if (is_int($tmpenvo_id)) {
                echo '<div class="tmpenvo-widget-comment" style="max-width: fit-comment; text-align:' . $settings['tmpenvo_comment_align'] . ';">';
                comments_template('', true);
                echo '</div>';
            } else {
                $tmpenvo_id;
            } else :
            if (comments_open()) {
              echo '<div class="tmpenvo-widget-comment" style="max-width: fit-comment; text-align:' . $settings['tmpenvo_comment_align'] . ';">';
                comments_template('', true);
              echo '</div>';
            }
        endif;
    }

}
