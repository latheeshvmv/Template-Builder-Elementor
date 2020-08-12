<?php
namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class TMPENVO_ACF_Widget_Image extends Widget_Base
{

    public function get_name()
    {
        return 'tmpenvo-acf-image';
    }

    public function get_title()
    {
        return esc_html__('ACF Image', 'tmpenvo');
    }

    public function get_icon()
    {
        return 'fas fa-laptop-code';
    }

    public function get_categories()
    {
        return ['tmpenvo-category'];
    }

    public function get_keywords()
    {
        return ['image', 'photo', 'visual', 'acf', 'owl'];
    }

    private function get_acf_list()
    {
        global $wpdb;
        $tmpenvo_qry          = "SELECT post_excerpt as 'field_name', post_title as 'field_label' FROM {$wpdb->prefix}posts where post_type = 'acf-field'";
        $tmpenvo_list_results = $wpdb->get_results($tmpenvo_qry, ARRAY_A);
        $acf_field_array    = array();
        if (!empty($tmpenvo_list_results)) {
            foreach ($tmpenvo_list_results as $value) {
                $acf_field_array[$value['field_name']] = $value['field_label'];
            }
        }
        return $acf_field_array;
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_image',
            [
                'label' => esc_html__('Image', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'fieldtype_setter',
            [
                'label'       => esc_html__('Field Key Setter', 'tmpenvo'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'manual',
                'options'     => [
                    'manual' => esc_html__('Type Field Key Manually', 'tmpenvo'),
                    'list'   => esc_html__('Choose Field Key From List', 'tmpenvo'),
                ],
                'description' => esc_html__('', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'tmpenvo_field_name',
            [
                'label'       => esc_html__('Custom Field Name (Key)', 'tmpenvo'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Type field name here.', 'tmpenvo'),
                'condition'   => [
                    'fieldtype_setter' => ['manual'],
                ],
            ]
        );

        $this->add_control(
            'fieldtype_setter_list',
            [
                'label'       => esc_html__('Custom Field Name', 'tmpenvo'),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => 'manual',
                'options'     => $this->get_acf_list(),
                'description' => esc_html__('', 'tmpenvo'),
                'condition'   => [
                    'fieldtype_setter' => ['list'],
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label'       => esc_html__('Place holder Image', 'tmpenvo'),
                'type'        => Controls_Manager::MEDIA,
                'dynamic'     => [
                    'active' => true,
                ],
                'description' => esc_html__('If custom field returns no image then this will act as placeholder', 'tmpenvo'),
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default'   => 'large',
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'     => esc_html__('Alignment', 'tmpenvo'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => esc_html__('Left', 'tmpenvo'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'tmpenvo'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'Right'   => [
                        'title' => esc_html__('Right', 'tmpenvo'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .tmpenvo-widget-acf_image-inner' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'caption_source',
            [
                'label'   => esc_html__('Caption', 'tmpenvo'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'none'       => esc_html__('None', 'tmpenvo'),
                    'attachment' => esc_html__('Attachment Caption', 'tmpenvo'),
                    'custom'     => esc_html__('Custom Caption', 'tmpenvo'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_control(
            'caption',
            [
                'label'       => esc_html__('Custom Caption', 'tmpenvo'),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'placeholder' => esc_html__('Enter your image caption', 'tmpenvo'),
                'condition'   => [
                    'caption_source' => 'custom',
                ],
                'dynamic'     => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'link_to',
            [
                'label'   => esc_html__('Link', 'tmpenvo'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'   => esc_html__('None', 'tmpenvo'),
                    'file'   => esc_html__('Media File', 'tmpenvo'),
                    'custom' => esc_html__('Custom URL', 'tmpenvo'),
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => esc_html__('Link', 'tmpenvo'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('https://your-link.com', 'tmpenvo'),
                'condition'   => [
                    'link_to' => 'custom',
                ],
                'show_label'  => false,
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
                    'link_to' => 'file',
                ],
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
            'section_style_image',
            [
                'label' => esc_html__('Image', 'tmpenvo'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label'          => esc_html__('Width', 'tmpenvo'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units'     => ['%', 'px', 'vw'],
                'range'          => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .elementor-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label'          => esc_html__('Max Width', 'tmpenvo') . ' (%)',
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units'     => ['%'],
                'range'          => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .elementor-image img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type'  => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs('image_effects');

        $this->start_controls_tab('normal',
            [
                'label' => esc_html__('Normal', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label'     => esc_html__('Opacity', 'tmpenvo'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters',
                'selector' => '{{WRAPPER}} .elementor-image img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('hover',
            [
                'label' => esc_html__('Hover', 'tmpenvo'),
            ]
        );

        $this->add_control(
            'opacity_hover',
            [
                'label'     => esc_html__('Opacity', 'tmpenvo'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elementor-image:hover img',
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label'     => esc_html__('Transition Duration', 'tmpenvo'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'tmpenvo'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} .elementor-image img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'tmpenvo'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_box_shadow',
                'exclude'  => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .elementor-image img',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_caption',
            [
                'label'     => esc_html__('Caption', 'tmpenvo'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'caption_source!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'caption_align',
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
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'text-align: {{VALUE}};',
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
                    '{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
                ],
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_control(
            'caption_background_color',
            [
                'label'     => esc_html__('Background Color', 'tmpenvo'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'caption_typography',
                'selector' => '{{WRAPPER}} .widget-image-caption',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'caption_text_shadow',
                'selector' => '{{WRAPPER}} .widget-image-caption',
            ]
        );

        $this->add_responsive_control(
            'caption_space',
            [
                'label'     => esc_html__('Spacing', 'tmpenvo'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Check if the current widget has caption
     *
     * @access private
     * @since 2.3.0
     *
     * @param array $settings
     *
     * @return boolean
     */
    private function has_caption($settings)
    {
        return (!empty($settings['caption_source']) && 'none' !== $settings['caption_source']);
    }

    /**
     * Get the caption for current widget.
     *
     * @access private
     * @since 2.3.0
     * @param $settings
     *
     * @return string
     */
    private function get_caption($settings)
    {
        $caption = '';
        if (!empty($settings['caption_source'])) {
            switch ($settings['caption_source']) {
                case 'attachment':
                    $caption = wp_get_attachment_caption($settings['image']['id']);
                    break;
                case 'custom':
                    $caption = !empty($settings['caption']) ? $settings['caption'] : '';
            }
        }
        return $caption;
    }

    /**
     * Render image widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (!class_exists('acf')) {
            echo esc_html__("ACF Not Active", 'tmpenvo');
            return;
        }

        $tmpenvo_acf_image_instance = new \TMPENVOHELPERNS\TMPENVOHelper();
        global $post;
        echo '<div class="tmpenvo-widget-acf_image" >';
        echo '<div class="tmpenvo-widget-acf_image-inner elementor-image" >';

        if ($post->post_type == 'tmpenvo_template'):
            $post_id         = get_the_ID();
            $tmpenvo_post_type = $tmpenvo_acf_image_instance->tmpenvo_active_post_template($post_id);
            $tmpenvo_id        = $tmpenvo_acf_image_instance->tmpenvo_single_post_returner($tmpenvo_post_type);
            if (is_int($tmpenvo_id)) {
                $attachment_id = $tmpenvo_acf_image_instance->tmpenvo_acf_image_gen($settings, $tmpenvo_id);
                if (empty($attachment_id)) {
                    $attachment_id = $settings['image']['id'];
                }
                $this->add_render_attribute('wrapper', 'class', 'elementor-image');
                if (!empty($settings['shape'])) {
                    $this->add_render_attribute('wrapper', 'class', 'elementor-image-shape-' . $settings['shape']);
                }
                $featuredimage_lightbox = wp_get_attachment_image_url($tmpenvo_acf_image_instance->tmpenvo_acf_image_gen($settings, $tmpenvo_id), 'large');
                $link = $this->get_link_url($settings, $featuredimage_lightbox);
                if ($link) {
                    $this->add_render_attribute('link', [
                        'href'                         => $link['url'],
                        'data-elementor-open-lightbox' => $settings['open_lightbox'],
                    ]);
                    if (Plugin::$instance->editor->is_edit_mode()) {
                        $this->add_render_attribute('link', [
                            'class' => 'elementor-clickable',
                        ]);
                    }
                    if (!empty($link['is_external'])) {
                        $this->add_render_attribute('link', 'target', '_blank');
                    }
                    if (!empty($link['nofollow'])) {
                        $this->add_render_attribute('link', 'rel', 'nofollow');
                    }
                }
                ?>
	            <div <?php echo esc_html($this->get_render_attribute_string('wrapper')); ?>>
	            <?php if ($link): ?>
	            <a <?php echo wp_kses($this->get_render_attribute_string('link'), $tmpenvo_acf_image_instance->ggwol_allowed_html()); ?>>
	            <?php endif;
            echo TMPENVO_Featurred_Image_Getter::get_attachment_image_html_generator($attachment_id, $settings);
            if ($link): ?>
            </a>
            <?php endif;?>
          </div>
          <?php
} else {
            $tmpenvo_id;
        } else :
            $tmpenvo_id      = get_the_id();
            $attachment_id = $tmpenvo_acf_image_instance->tmpenvo_acf_image_gen($settings, $tmpenvo_id);
            if (empty($attachment_id)) {
                $attachment_id = $settings['image']['id'];
            }
            $this->add_render_attribute('wrapper', 'class', 'elementor-image');
            if (!empty($settings['shape'])) {
                $this->add_render_attribute('wrapper', 'class', 'elementor-image-shape-' . $settings['shape']);
            }
            $featuredimage_lightbox = wp_get_attachment_image_url($tmpenvo_acf_image_instance->tmpenvo_acf_image_gen($settings, $tmpenvo_id), 'large');
            $link                   = $this->get_link_url($settings, $featuredimage_lightbox);
            if ($link) {
                $this->add_render_attribute('link', [
                    'href'                         => $link['url'],
                    'data-elementor-open-lightbox' => $settings['open_lightbox'],
                ]);
                if (Plugin::$instance->editor->is_edit_mode()) {
                    $this->add_render_attribute('link', [
                        'class' => 'elementor-clickable',
                    ]);
                }
                if (!empty($link['is_external'])) {
                    $this->add_render_attribute('link', 'target', '_blank');
                }
                if (!empty($link['nofollow'])) {
                    $this->add_render_attribute('link', 'rel', 'nofollow');
                }
            }
            ?>
	           <div <?php echo esc_html($this->get_render_attribute_string('wrapper')) ; ?>>
	           <?php if ($link): ?>
	           <a <?php echo wp_kses($this->get_render_attribute_string('link'), $tmpenvo_acf_image_instance->ggwol_allowed_html() ); ?>>
	           <?php endif;
        echo TMPENVO_Featurred_Image_Getter::get_attachment_image_html_generator($attachment_id, $settings);
        if ($link): ?>
           </a>
           <?php endif;?>
         </div>
         <?php
endif;

        echo '</div>';
        echo '</div>';

    }
    /**
     * Render image widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _content_template()
    {
        ?>
		<# if ( settings.image.url ) {
			var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.image_size,
				dimension: settings.image_custom_dimension,
				model: view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image );

			if ( ! image_url ) {
				return;
			}

			var hasCaption = function() {
				if( ! settings.caption_source || 'none' === settings.caption_source ) {
					return false;
				}
				return true;
			}

			var ensureAttachmentData = function( id ) {
				if ( 'undefined' === typeof wp.media.attachment( id ).get( 'caption' ) ) {
					wp.media.attachment( id ).fetch().then( function( data ) {
						view.render();
					} );
				}
			}

			var getAttachmentCaption = function( id ) {
				if ( ! id ) {
					return '';
				}
				ensureAttachmentData( id );
				return wp.media.attachment( id ).get( 'caption' );
			}

			var getCaption = function() {
				if ( ! hasCaption() ) {
					return '';
				}
				return 'custom' === settings.caption_source ? settings.caption : getAttachmentCaption( settings.image.id );
			}

			var link_url;

			if ( 'custom' === settings.link_to ) {
				link_url = settings.link.url;
			}

			if ( 'file' === settings.link_to ) {
				link_url = settings.image.url;
			}

			#><div class="elementor-image{{ settings.shape ? ' elementor-image-shape-' + settings.shape : '' }}"><#
			var imgClass = '';

			if ( '' !== settings.hover_animation ) {
				imgClass = 'elementor-animation-' + settings.hover_animation;
			}

			if ( hasCaption() ) {
				#><figure class="wp-caption"><#
			}

			if ( link_url ) {
					#><a class="elementor-clickable" data-elementor-open-lightbox="{{ settings.open_lightbox }}" href="{{ link_url }}"><#
			}
						#><img src="{{ image_url }}" class="{{ imgClass }}" /><#

			if ( link_url ) {
					#></a><#
			}

			if ( hasCaption() ) {
					#><figcaption class="widget-image-caption wp-caption-text">{{{ getCaption() }}}</figcaption><#
			}

			if ( hasCaption() ) {
				#></figure><#
			}

			#></div><#
		} #>
		<?php
}

    /**
     * Retrieve image widget link URL.
     *
     * @since 1.0.0
     * @access private
     *
     * @param array $settings
     *
     * @return array|string|false An array/string containing the link URL, or false if no link.
     */
    private function get_link_url($settings, $featuredimage_lightbox)
    {
        if ('none' === $settings['link_to']) {
            return false;
        }

        if ('custom' === $settings['link_to']) {
            if (empty($settings['link']['url'])) {
                return false;
            }
            return $settings['link'];
        }

        return [
            'url' => $featuredimage_lightbox,
        ];
    }
}
