<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TMPENVO_Elementor_product_gallerygrid extends Widget_Base
{

    public function get_name()
    {
        return 'tmpenvo-product-gallery';
    }

    public function get_title()
    {
        return esc_html__('Product Image Gallery', 'tmpenvo');
    }

    public function get_icon()
    {
        return 'fab fa-product-hunt';
    }

    public function get_keywords()
    {
        return ['image', 'photo', 'visual', 'gallery', 'dyn', 'owl', 'product', 'woo'];
    }

    public function get_categories()
    {
        return ['tmpenvo-category-woo'];
    }

    public function add_lightbox_data_to_image_link($link_html,$id)
    {
        return preg_replace('/^<a/', '<a ' . $this->get_render_attribute_string('link'), $link_html);
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_gallery',
            [
                'label' => esc_html__('Image Gallery', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'wp_gallery',
            [
                'label'      => esc_html__('Add Images', 'tmpenvo'),
                'type'       => Controls_Manager::GALLERY,
                'show_label' => false,
                'dynamic'    => [
                    'active' => true,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'exclude'   => ['custom'],
                'separator' => 'none',
            ]
        );

        $gallery_columns = range(1, 10);
        $gallery_columns = array_combine($gallery_columns, $gallery_columns);

        $this->add_control(
            'gallery_columns',
            [
                'label'   => esc_html__('Columns', 'tmpenvo'),
                'type'    => Controls_Manager::SELECT,
                'default' => 4,
                'options' => $gallery_columns,
            ]
        );

        $this->add_control(
            'gallery_link',
            [
                'label'   => esc_html__('Link', 'tmpenvo'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'file',
                'options' => [
                    'file'       => esc_html__('Media File', 'tmpenvo'),
                    'attachment' => esc_html__('Attachment Page', 'tmpenvo'),
                    'none'       => esc_html__('None', 'tmpenvo'),
                ],
            ]
        );

        $this->add_control(
            'open_lightbox',
            [
                'label'     => esc_html__('Lightbox', 'tmpenvo'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'default',
                'options'   => [
                    'default' => esc_html__('Default', 'tmpenvo'),
                    'yes'     => esc_html__('Yes', 'tmpenvo'),
                    'no'      => esc_html__('No', 'tmpenvo'),
                ],
                'condition' => [
                    'gallery_link' => 'file',
                ],
            ]
        );

        $this->add_control(
            'gallery_rand',
            [
                'label'   => esc_html__('Order By', 'tmpenvo'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    ''     => esc_html__('Default', 'tmpenvo'),
                    'rand' => esc_html__('Random', 'tmpenvo'),
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => esc_html__('View', 'tmpenvo'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_gallery_images',
            [
                'label' => esc_html__('Images', 'tmpenvo'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'image_spacing',
            [
                'label'        => esc_html__('Spacing', 'tmpenvo'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    ''       => esc_html__('Default', 'tmpenvo'),
                    'custom' => esc_html__('Custom', 'tmpenvo'),
                ],
                'prefix_class' => 'gallery-spacing-',
                'default'      => '',
            ]
        );

        $columns_margin  = is_rtl() ? '0 0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}};' : '0 -{{SIZE}}{{UNIT}} -{{SIZE}}{{UNIT}} 0;';
        $columns_padding = is_rtl() ? '0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};' : '0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0;';

        $this->add_control(
            'image_spacing_custom',
            [
                'label'      => esc_html__('Image Spacing', 'tmpenvo'),
                'type'       => Controls_Manager::SLIDER,
                'show_label' => false,
                'range'      => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 15,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gallery-item' => 'padding:' . $columns_padding,
                    '{{WRAPPER}} .gallery'      => 'margin: ' . $columns_margin,
                ],
                'condition'  => [
                    'image_spacing' => 'custom',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} .gallery-item img',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .gallery-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_caption',
            [
                'label' => esc_html__('Caption', 'tmpenvo'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'gallery_display_caption',
            [
                'label'     => esc_html__('Display', 'tmpenvo'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    ''     => esc_html__('Show', 'tmpenvo'),
                    'none' => esc_html__('Hide', 'tmpenvo'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .gallery-item .gallery-caption' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'align',
            [
                'label'     => esc_html__('Alignment', 'tmpenvo'),
                'type'      => Controls_Manager::CHOOSE,
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
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .gallery-item .gallery-caption' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'gallery_display_caption' => '',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Text Color', 'tmpenvo'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .gallery-item .gallery-caption' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'gallery_display_caption' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'typography',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .gallery-item .gallery-caption',
                'condition' => [
                    'gallery_display_caption' => '',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render image gallery widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (!class_exists('WooCommerce')) {
            echo esc_html__("WooCommerce  Not Active", 'tmpenvo');
            return;
        }
        $tmpenvo_product_gallerycarousel_instance = new \TMPENVOHELPERNS\TMPENVOHelper();
        global $post;

        if ($post->post_type == 'tmpenvo_template'):
            $post_id         = get_the_ID();
            $tmpenvo_post_type = $tmpenvo_product_gallerycarousel_instance->tmpenvo_active_post_template($post_id);
            $tmpenvo_id        = $tmpenvo_product_gallerycarousel_instance->tmpenvo_single_post_returner($tmpenvo_post_type);
            if (is_int($tmpenvo_id)) {

                $ids = $tmpenvo_product_gallerycarousel_instance->tmpenvo_product_gallery_gen($tmpenvo_id);
                $this->add_render_attribute('shortcode', 'ids', implode(',', $ids));
                $this->add_render_attribute('shortcode', 'size', $settings['thumbnail_size']);

                if ($settings['gallery_columns']) {
                    $this->add_render_attribute('shortcode', 'columns', $settings['gallery_columns']);
                }

                if ($settings['gallery_link']) {
                    $this->add_render_attribute('shortcode', 'link', $settings['gallery_link']);
                }

                if (!empty($settings['gallery_rand'])) {
                    $this->add_render_attribute('shortcode', 'orderby', $settings['gallery_rand']);
                }
                ?>
							<div class="elementor-image-gallery">
								<?php
    $this->add_render_attribute('link', [
                    'data-elementor-open-lightbox'      => $settings['open_lightbox'],
                    'data-elementor-lightbox-slideshow' => $this->get_id(),
                ]);

                if (Plugin::$instance->editor->is_edit_mode()) {
                    $this->add_render_attribute('link', [
                        'class' => 'elementor-clickable',
                    ]);
                }

                add_filter('wp_get_attachment_link', [$this, 'add_lightbox_data_to_image_link']);

                echo do_shortcode('[gallery ' . $this->get_render_attribute_string('shortcode') . ']');

                remove_filter('wp_get_attachment_link', [$this, 'add_lightbox_data_to_image_link']);
                ?>
							</div>
							<?php
    } else {
                $tmpenvo_id;
            } else :
            $tmpenvo_id = get_the_id();
            $ids      = $tmpenvo_product_gallerycarousel_instance->tmpenvo_product_gallery_gen($tmpenvo_id);

            $this->add_render_attribute('shortcode', 'ids', implode(',', $ids));
            $this->add_render_attribute('shortcode', 'size', $settings['thumbnail_size']);

            if ($settings['gallery_columns']) {
                $this->add_render_attribute('shortcode', 'columns', $settings['gallery_columns']);
            }

            if ($settings['gallery_link']) {
                $this->add_render_attribute('shortcode', 'link', $settings['gallery_link']);
            }

            if (!empty($settings['gallery_rand'])) {
                $this->add_render_attribute('shortcode', 'orderby', $settings['gallery_rand']);
            }
            ?>
						<div class="elementor-image-gallery">
							<?php
    $this->add_render_attribute('link', [
                'data-elementor-open-lightbox'      => $settings['open_lightbox'],
                'data-elementor-lightbox-slideshow' => $this->get_id(),
            ]);

            if (Plugin::$instance->editor->is_edit_mode()) {
                $this->add_render_attribute('link', [
                    'class' => 'elementor-clickable',
                ]);
            }

            add_filter('wp_get_attachment_link', [$this, 'add_lightbox_data_to_image_link']);

            echo do_shortcode('[gallery ' . $this->get_render_attribute_string('shortcode') . ']');

            remove_filter('wp_get_attachment_link', [$this, 'add_lightbox_data_to_image_link']);
            ?>
						</div>
						<?php
endif;


    }
}
