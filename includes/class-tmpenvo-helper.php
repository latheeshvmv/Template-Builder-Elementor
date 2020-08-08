<?php
namespace TMPENVOHELPERNS {

    if (!defined('ABSPATH')) {
        exit;
    }

    class GgowlHelper
    {
        public function tmpenvo_post_featuredimage_gen($tmpenvo_id){
          $attachemnt_id = get_post_thumbnail_id($tmpenvo_id);
          return $attachemnt_id;
        }

        public function tmpenvo_taxonomy_render($settings, $tmpenvo_id)
        {
            $taxonomy                  = $settings['tmpenvo_metadata_taxonmomny_array'];
            $taxonomy_load_links       = $settings['tmpenvo_metadata_load_links'];
            $taxonomy_load_links_count = $settings['tmpenvo_metadata_count'];
            $taxonomy_load_links_hira  = $settings['tmpenvo_metadata_hirarachical'];
            if ($taxonomy_load_links_hira == 'yes') {
                $taxonomy_load_links_hira_ena = true;
            } else {
                $taxonomy_load_links_hira_ena = false;
            }

            $taxonomy_load_links_child = $settings['tmpenvo_metadata_childless'];
            if ($taxonomy_load_links_child == 'yes') {
                $taxonomy_load_links_hira_ena = true;
            } else {
                $taxonomy_load_links_hira_ena = false;
            }

            $terms = wp_get_object_terms($tmpenvo_id, $taxonomy, array(
                'hide_empty'   => true,
                'hierarchical' => $taxonomy_load_links_hira_ena,
                'childless'    => $taxonomy_load_links_hira_ena,
                'number'       => $taxonomy_load_links_count,
            ));

            if ($taxonomy_load_links == 'yes') {
                $terms_list = array();
                foreach ($terms as $key => $value) {
                    $terms_list[] = array(
                        'name' => $value->name,
                        'link' => get_term_link($value->name, $taxonomy),
                    );
                }

                foreach ($terms_list as $key => $value) {
                    $render_link[] = '<a href="' . $value['link'] . '">' . $value['name'] . '</a>';
                }
                if (!empty($render_link)) {
                    $the_terms = implode(", ", $render_link);
                    return $the_terms;
                }
            } else {
                $terms_list = array();
                foreach ($terms as $key => $value) {
                    $terms_list[] = $value->name;
                }
                if (!empty($terms_list)) {
                    $the_terms = implode(", ", $terms_list);
                    return $the_terms;
                }
            }
        }

        public function tmpenvo_meta_data_retrievier($settings, $tmpenvo_id)
        {
            $tmpenvo_append      = $settings['tmpenvo_field_name_append'];
            $tmpenvo_prepend     = $settings['tmpenvo_field_name_prepend'];
            $tmpenvo_header_size = $settings['tmpenvo_text_header_size'];
            $metatoload        = $settings['tmpenvo_meta_to_load'];
            $aligninstraight   = $settings['tmpenvo_woo_fields_color_content_alighstraight'];

            if ('yes' === $aligninstraight) {
                $styler = 'style="display:inline-flex;"';
            } else {
                $styler = '';
            }
            switch ($metatoload) {
                case 'author':
                    $author_id    = get_post_field('post_author', $tmpenvo_id);
                    $display_name = get_the_author_meta('display_name', $author_id);
                    if (!empty($display_name)) {
                        echo '<div class="tmpenvo-meta-field" ' . $styler . '>';
                        echo wp_kses($tmpenvo_append, $this->ggwol_allowed_html());
                    }

                    echo '<' . $tmpenvo_header_size . ' class="tmpenvo-meta-field-in">';
                    echo esc_html($display_name);
                    echo "</$tmpenvo_header_size>";

                    if (!empty($display_name)) {
                        echo wp_kses($tmpenvo_prepend, $this->ggwol_allowed_html());
                        echo '</div>';
                    }
                    break;

                case 'taxonomy':
                    if (!empty($this->tmpenvo_taxonomy_render($settings, $tmpenvo_id))) {
                        echo '<div class="tmpenvo-meta-field" ' . $styler . '>';
                        echo wp_kses($tmpenvo_append, $this->ggwol_allowed_html());
                    }
                    echo '<' . $tmpenvo_header_size . ' class="tmpenvo-meta-field-in">';
                    echo wp_kses($this->tmpenvo_taxonomy_render($settings, $tmpenvo_id), $this->ggwol_allowed_html());
                    echo "</$tmpenvo_header_size>";
                    if (!empty($this->tmpenvo_taxonomy_render($settings, $tmpenvo_id))) {
                        echo wp_kses($tmpenvo_prepend, $this->ggwol_allowed_html());
                        echo '</div>';
                    }
                    break;

                case 'date':
                    if (!empty(get_the_date('j F Y', $tmpenvo_id))) {
                        echo '<div class="tmpenvo-meta-field" ' . $styler . '>';
                        echo wp_kses($tmpenvo_append, $this->ggwol_allowed_html());
                    }
                    echo '<' . $tmpenvo_header_size . ' class="tmpenvo-meta-field-in">';
                    echo get_the_date('j F Y', $tmpenvo_id);
                    echo "</$tmpenvo_header_size>";
                    if (!empty(get_the_date('j F Y', $tmpenvo_id))) {
                        echo wp_kses($tmpenvo_prepend, $this->ggwol_allowed_html());
                        echo '</div>';
                    }
                    break;
                case 'commentcount':
                    if (!empty(get_comments_number($tmpenvo_id))) {
                        echo '<div class="tmpenvo-meta-field" ' . $styler . '>';
                        echo wp_kses($tmpenvo_append, $this->ggwol_allowed_html());
                    }
                    if (!empty(get_comments_number($tmpenvo_id))) {
                    echo '<' . $tmpenvo_header_size . ' class="tmpenvo-meta-field-in">';
                    echo esc_html(get_comments_number($tmpenvo_id));
                    echo "</$tmpenvo_header_size>";
                    }
                    if (!empty(get_comments_number($tmpenvo_id))) {
                        echo wp_kses($tmpenvo_prepend, $this->ggwol_allowed_html());
                        echo '</div>';
                    }
                    break;
            }
        }

        public function tmpenvo_meta_data_retrievier_taxonomy()
        {
            $args = array(
                'public' => true,
            );
            $output     = 'object'; // or objects
            $operator   = 'and'; // 'and' or 'or'
            $taxonomies = get_taxonomies($args, $output, $operator);
            $taxonarray = array();
            foreach ($taxonomies as $key => $value) {
                $taxonarray[$value->name] = $value->label;
            }
            return $taxonarray;
        }

        public function tmpenvo_acf_video_render($settings, $tmpenvo_id)
        {
            $fieldsetter    = $settings['fieldtype_setter_video'];
            $enableautoplay = $settings['youtube_vide_autoplay_setter'];
            if ($enableautoplay == 'yes') {
                $set_auto = 1;
            } else {
                $set_auto = 0;
            }
            switch ($fieldsetter) {
                case 'manual':
                    $tmpenvo_field = $settings['tmpenvo_field_name_video'];
                    break;
                case 'list':
                    $tmpenvo_field = $settings['fieldtype_setter_list_video'];
                    break;
            }

            if (!empty($tmpenvo_field)) {

                $iframe = get_field($tmpenvo_field, $tmpenvo_id);
                if(empty($iframe)){
                  return;
                }
                preg_match('/src="(.+?)"/', $iframe, $matches);
                $src = $matches[1];
                $params = array(
                    'controls' => 1,
                    'hd'       => 1,
                    'autohide' => 1,
                    'autoplay' => $set_auto,
                );
                apply_filters( 'tmpenvo_video_parameters', $params );
                $new_src = add_query_arg($params, $src);
                $iframe  = str_replace($src, $new_src, $iframe);
                $attributes = 'frameborder="0"';
                $iframe     = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
                echo '<div class="tmpenvo-widget-acf_video" >';
                  echo '<div class="tmpenvo-widget-acf_video-inner" >';
                    echo wp_filter_oembed_result($iframe,'','');
                  echo '</div>';
                echo '</div>';
            } else {
                return;
            }
        }

        public function tmpenvo_acf_video_url_returner($settings, $tmpenvo_id)
        {
            $video_url_field = $settings['tmpenvovideourl'];
            if (!empty($video_url_field)) {
                $output = get_field($video_url_field, $tmpenvo_id);
                return $output;
            } else {
                return '';
            }
        }

        private function tmpenvo_acf_text_gen($settings, $tmpenvo_id)
        {
            $fieldsetter = $settings['fieldtype_setter'];
            switch ($fieldsetter) {
                case 'manual':
                    $tmpenvo_field = $settings['tmpenvo_field_name'];
                    break;
                case 'list':
                    $tmpenvo_field = $settings['fieldtype_setter_list'];
                    break;
            }
            if (!empty($tmpenvo_field)) {
                $output = get_field($tmpenvo_field, $tmpenvo_id);
                return $output;
            } else {
                return '';
            }
        }

        private function tmpenvo_acf_button_gen($settings, $tmpenvo_id)
        {
            $fieldsetter = $settings['fieldtype_setter'];
            switch ($fieldsetter) {
                case 'manual':
                    $tmpenvo_field = $settings['tmpenvo_field_name'];
                    break;
                case 'list':
                    $tmpenvo_field = $settings['fieldtype_setter_list'];
                    break;
            }
            if (!empty($tmpenvo_field)) {
                $output = get_field($tmpenvo_field, $tmpenvo_id);
                if (is_array($output)) {
                    $link_target = $output['target'] ? $output['target'] : '_self';
                    $outputarray = array(
                        'url'    => $output['url'],
                        'title'  => $output['title'],
                        'target' => $link_target,
                    );
                } else {
                    $outputarray = array(
                        'url' => $output,
                    );
                }
                return $outputarray;
            } else {
                return '';
            }
        }

        public function tmpenvo_acf_image_gen($settings, $tmpenvo_id)
        {
            $fieldsetter = $settings['fieldtype_setter'];
            switch ($fieldsetter) {
                case 'manual':
                    $tmpenvo_field = $settings['tmpenvo_field_name'];
                    break;
                case 'list':
                    $tmpenvo_field = $settings['fieldtype_setter_list'];
                    break;
            }
            if (!empty($tmpenvo_field)) {
                $output = get_field($tmpenvo_field, $tmpenvo_id);
                if (!is_int($output)) {
                    return '';
                } else {
                    return $output;
                }
            } else {
                return '';
            }
        }

        public function tmpenvo_acf_content_render($settings, $tmpenvo_id, $tmpenvo_post_type = '')
        {
            if (!class_exists('acf')) {
                esc_html_e('ACF plugin not active', 'tmpenvo');
                return;
            }

            $fieldsetter = $settings['fieldtype_setter'];
            switch ($fieldsetter) {
                case 'manual':
                    $tmpenvo_field = $settings['tmpenvo_field_name'];
                    break;
                case 'list':
                    $tmpenvo_field = $settings['fieldtype_setter_list'];
                    break;
            }
            $ggoowl_field_type = $settings['fieldtype'];
            $tmpenvo_append      = $settings['tmpenvo_field_name_append'];
            $tmpenvo_prepend     = $settings['tmpenvo_field_name_prepend'];
            $tmpenvo_header_size = $settings['tmpenvo_text_header_size'];
            $aligninstraight   = $settings['tmpenvo_woo_fields_color_content_alighstraight'];
            if ('yes' === $aligninstraight) {
                $styler = 'style="display:inline-flex;"';
            } else {
                $styler = '';
            }
            switch ($ggoowl_field_type) {
                case 'text':
                    if (!empty($this->tmpenvo_acf_text_gen($settings, $tmpenvo_id))) {
                        echo '<div class="tmpenvo-text-customfield" ' . $styler . '>';
                        echo wp_kses($tmpenvo_append, $this->ggwol_allowed_html());
                    }
                    if (($tmpenvo_post_type == 'tmpenvo_template') && (empty($this->tmpenvo_acf_text_gen($settings, $tmpenvo_id))) && (!empty($tmpenvo_field))) {
                        echo "<div>";
                        esc_html_e("This message is only visible in backend : The field returned empty or this field does not exist ", 'tmpenvo');
                        echo "</div>";
                    } elseif (($tmpenvo_post_type == 'tmpenvo_template') && (empty($this->tmpenvo_acf_text_gen($settings, $tmpenvo_id))) && (empty($tmpenvo_field))) {
                        echo "<div>";
                        esc_html_e('Field Name Not Set !', 'tmpenvo');
                        echo "</div>";
                    }
                    echo '<' . $tmpenvo_header_size . ' class="tmpenvo-text-customfield-in">';
                    echo esc_html($this->tmpenvo_acf_text_gen($settings, $tmpenvo_id));
                    echo "</$tmpenvo_header_size>";
                    if (!empty($this->tmpenvo_acf_text_gen($settings, $tmpenvo_id))) {
                        echo wp_kses($tmpenvo_prepend, $this->ggwol_allowed_html());
                        echo '</div>';
                    }
                    break;
                case 'button':

                    $button_text_alt = $settings['tmpenvo_button_text'];
                    $migrated        = isset($settings['__fa4_migrated']['tmpenvo_button_selected_icon']);
                    $is_new          = empty($settings['tmpenvo_button_icon']) && \Elementor\Icons_Manager::is_migration_allowed();
                    if (!empty($this->tmpenvo_acf_button_gen($settings, $tmpenvo_id)) && $this->tmpenvo_acf_button_gen($settings, $tmpenvo_id)['url'] !== NULL) {
                        $buttondata = $this->tmpenvo_acf_button_gen($settings, $tmpenvo_id);
                        if (array_key_exists('target', $buttondata) && !empty($buttondata['target'])) {
                            $buttontarget       = esc_attr($buttondata['target']);
                            $button_target_html = 'target="' . $buttontarget . '"';
                        } else {
                            $button_target_html = "";
                        }
                        if (filter_var(esc_url($buttondata['url']), FILTER_VALIDATE_URL) === false) {
                            $buttontext = esc_html__('Not a Valid URL', 'tmpenvo');
                        } elseif (array_key_exists('title', $buttondata) && !empty($buttondata['title'])) {
                            $buttontext = $buttondata['title'];
                        } else {
                            $buttontext = $button_text_alt;
                        }

                        echo '<div class="tmpenvo-button-customfield">';

                        echo '<a class="elementor-button-link elementor-button" href="' . esc_url($buttondata['url']) . '" ' . $button_target_html . '>';
                        ?>
              <span class="elementor-button-content-wrapper">
              <?php if (!empty($settings['tmpenvo_button_icon']) || !empty($settings['tmpenvo_button_selected_icon']['value'])): ?>
              <span class="elementor-button-icon elementor-align-icon-<?php echo esc_attr($settings['tmpenvo_button_icon_align']); ?>">
                <?php if ($is_new || $migrated):
                            \Elementor\Icons_Manager::render_icon($settings['tmpenvo_button_selected_icon'], ['aria-hidden' => 'true']);
                        else: ?>
                  <i class="<?php echo esc_attr($settings['tmpenvo_button_icon']); ?>" aria-hidden="true"></i>
                <?php endif;?>
              </span><span class="elementor-button-text"><?php endif;
                        echo esc_html($buttontext);
                        echo "</span>";
                        echo '</a>';
                        echo '</span>';
                        echo "</div>";
                    }
                    break;
                case 'image':
                    $size = $settings['tmpenvo_img_dyn_image_size'];
                    if (!empty($this->tmpenvo_acf_image_gen($settings, $tmpenvo_id))) {
                        $imagedata = $this->tmpenvo_acf_image_gen($settings, $tmpenvo_id);
                        if (!is_int($imagedata) && $tmpenvo_post_type == 'tmpenvo_template') {
                            esc_html_e('Custom field is not returing attachment ID', 'tmpenvo');
                        } else {
                            $attachment_id = $imagedata;
                            echo '<div class="elementor-image grid tmpenvo-image-customfield">';
                            echo \Elementor\Ggowl_Featurred_Image_Getter::get_attachment_image_html_generator($attachment_id, $settings, $image_key = 'tmpenvo_img_dyn_image');
                            echo '</div>';
                        }
                    } else {
                        $attachment_id = $settings['tmpenvo_img_dyn_image']['id'];
                        echo '<div class="elementor-image grid tmpenvo-image-customfield">';
                        echo \Elementor\Ggowl_Featurred_Image_Getter::get_attachment_image_html_generator($attachment_id, $settings, $image_key = 'tmpenvo_img_dyn_image');
                        echo '</div>';
                    }
                    break;
            }

        }

        public function tmpenvo_core_title_gen($tmpenvo_id)
        {
            if(is_post_type_archive()){
              $title = get_the_archive_title($tmpenvo_id);
            }else{
              $title = get_the_title($tmpenvo_id);
            }
            return $title;
        }

        public function tmpenvo_core_content_gen($post, $tmpenvo_id, $template = '', $trim_content = '', $trim_count = '')
        {
            if ($template == 'tmpenvo_template') {
                if ($trim_content == 'yes') {
                    $content = wp_trim_words(get_post_field('post_content', $tmpenvo_id), $trim_count);
                } else {
                    $content = get_post_field('post_content', $tmpenvo_id);
                }
                echo do_shortcode($content); //executing shortcodes
            } else {
                $args = array(
                    'p'         => $tmpenvo_id,
                    'post_type' => $post->post_type,
                );
                $tmpenvo_query = new \WP_Query($args);
                while ($tmpenvo_query->have_posts()):
                    $tmpenvo_query->the_post();
                    if ($trim_content == 'yes') {
                        echo wp_trim_words(get_the_content(), $trim_count);
                    } else {
                        the_content();
                    }
                endwhile;
                wp_reset_postdata();
            }
        }

        public function tmpenvo_addtocart_gen($tmpenvo_id, $tmpenvo_button_text)
        {
            $product = wc_get_product($tmpenvo_id);
            if (is_bool(wc_get_product($tmpenvo_id))) {
                echo esc_html__("This can't be used here. The WooCommerce option will only work in template pages", 'tmpenvo');
            } else {
                do_action('tmpenvo_woocommerce_' . $product->get_type() . '_add_to_cart', $product, $tmpenvo_button_text);
            }
        }

        public function tmpenvo_addtocart_gen_template($tmpenvo_id, $tmpenvo_button_text)
        {
            $product = wc_get_product($tmpenvo_id);
            if (is_bool(wc_get_product($tmpenvo_id))) {
                echo esc_html__("This can't be used here. The WooCommerce option will only work in template pages", 'tmpenvo');
            } else {
                do_action('tmpenvo_woocommerce_' . $product->get_type() . '_add_to_cart_template', $product, $tmpenvo_button_text);
            }
        }

        public function tmpenvo_product_woofields_gen($settings, $tmpenvo_id, $field_type)
        {
            $product = wc_get_product($tmpenvo_id);
            if (is_bool(wc_get_product($tmpenvo_id))) {
                $attachment_arr = esc_html__("This can't be used here. The WooCommerce option will only work in template pages", 'tmpenvo');
                return $attachment_arr;
            } else {
                switch ($field_type) {
                    case 'price':
                        return $product->get_price();
                        break;
                    case 'regular_price':
                        $type = $product->get_type();
                        if ($type == 'simple') {
                            return $product->get_regular_price();
                        } elseif ($type == 'variable') {
                            $min_price = $product->get_variation_regular_price('min', true);
                            $max_price = $product->get_variation_regular_price('max', true);
                            $sy        = get_woocommerce_currency_symbol();
                            return $sy . $min_price . ' - ' . $sy . $max_price;
                        } else {
                            return '';
                        }
                        break;
                    case 'sale_price':
                        $type = $product->get_type();
                        if ($type == 'simple') {
                            return $product->get_sale_price();
                        } elseif ($type == 'variable') {
                            $min_price = $product->get_variation_sale_price('min', true);
                            $max_price = $product->get_variation_sale_price('max', true);
                            $sy        = get_woocommerce_currency_symbol();
                            return $sy . $min_price . ' - ' . $sy . $max_price;
                        } else {
                            return '';
                        }
                        break;
                    case 'total_sales':
                        return $product->get_total_sales();
                        break;
                    case 'type':
                        return $product->get_type();
                        break;
                    case 'name':
                        return $product->get_name();
                        break;
                    case 'slug':
                        return $product->get_slug();
                        break;
                    case 'date_created':
                        return $product->get_date_created();
                        break;
                    case 'date_modified':
                        return $product->get_date_modified();
                        break;
                    case 'product_status':
                        return $product->get_status();
                        break;
                    case 'get_virtual':
                        if ($product->get_virtual() === true) {
                            return esc_html($settings['tmpenvo_woo_fields_color_content_is_virtual']);
                        }
                        break;
                    case 'get_featured':
                        if ($product->get_featured() === true) {
                            return esc_html($settings['tmpenvo_woo_fields_color_content_is_featured']);
                        }
                        break;
                    case 'get_sku':
                        return $product->get_sku();
                        break;
                    case 'review_count':
                        return $product->get_review_count();
                        break;
                    case 'rating_count':
                        return $product->get_rating_count();
                        break;
                    case 'average_rating':
                        return $product->get_average_rating();
                        break;
                    case 'get_attributes':
                        $attributes = $product->get_attributes();
                        if (!$attributes) {
                            return;
                        }
                        $pa_array           = array();
                        $pa_array_exclude   = array();
                        $product_attributes = array();
                        foreach ($attributes as $key => $attribute) {
                            $test_str = 'pa_';
                            $paName   = $attribute['name'];
                            if ($paName[0] . $paName[1] . $paName[2] == $test_str) {
                                $pa_array[] = $paName;
                            } else {
                                $att_arr_norm[] = array(
                                    'name' => $attribute['name'],
                                    'attr' => implode(", ", explode('|', $attribute['value'])),
                                );
                            }
                        }
                        $att_arr         = array();
                        $list_attr_array = array();
                        if (!empty($pa_array)) {

                            foreach ($pa_array as $key => $pa_attr_taxon) {
                                $tmpenvo_attr = get_terms($pa_attr_taxon);
                                $list_attr_array = array();
                                foreach ($tmpenvo_attr as $key => $value) {
                                    $list_attr_array[] = $value->name;
                                }

                                $list_arr_string = implode(", ", $list_attr_array);

                                $att_arr[] = array(
                                    'name' => ucfirst(substr($pa_attr_taxon, 3)),
                                    'attr' => $list_arr_string,
                                );
                            }
                        }

                        if (empty($att_arr)) {
                            $att_arr = array();
                        }
                        if (empty($att_arr_norm)) {
                            $att_arr_norm = array();
                        }

                        $final_arr = array_merge($att_arr, $att_arr_norm);

                        foreach ($final_arr as $key => $value) {

                            $list[] = '<div class="tmpenvo-woo-attributes-lister">
                          <div class="tmpenvo-woo-attributes-lister-name">
                            <p><strong>' . $value['name'] . '</strong></p>
                          </div>
                          <div class="tmpenvo-woo-attributes-lister-attribute">
                            <p><strong>' . $value['attr'] . '</strong></p>
                          </div>
                        </div>';
                        }

                        if (empty($list)) {
                            return $list = '';
                        } else {
                            return implode($list);
                        }

                        break;
                    case 'get_width':
                        return $product->get_weight();
                        break;
                    case 'get_height':
                        return $product->get_height();
                        break;
                    case 'get_length':
                        return $product->get_length();
                        break;
                    case 'get_weight':
                        return $product->get_weight();
                        break;
                    case 'stock_quanity':
                        return $product->get_weight();
                        break;
                }
            }
        }

        public function ggwol_allowed_html()
        {

            $allowed_tags = array(
                '&nbsp;'     => array(),
                'a'          => array(
                    'class' => array(),
                    'href'  => array(),
                    'rel'   => array(),
                    'title' => array(),
                ),
                'abbr'       => array(
                    'title' => array(),
                ),
                'b'          => array(),
                'blockquote' => array(
                    'cite' => array(),
                ),
                'cite'       => array(
                    'title' => array(),
                ),
                'code'       => array(),
                'del'        => array(
                    'datetime' => array(),
                    'title'    => array(),
                ),
                'dd'         => array(),
                'div'        => array(
                    'class' => array(),
                    'title' => array(),
                    'style' => array(),
                ),
                'dl'         => array(),
                'dt'         => array(),
                'em'         => array(),
                'h1'         => array(),
                'h2'         => array(),
                'h3'         => array(),
                'h4'         => array(),
                'h5'         => array(),
                'h6'         => array(),
                'i'          => array(),
                'img'        => array(
                    'alt'    => array(),
                    'class'  => array(),
                    'height' => array(),
                    'src'    => array(),
                    'width'  => array(),
                ),
                'li'         => array(
                    'class' => array(),
                ),
                'ol'         => array(
                    'class' => array(),
                ),
                'p'          => array(
                    'class' => array(),
                ),
                'q'          => array(
                    'cite'  => array(),
                    'title' => array(),
                ),
                'span'       => array(
                    'class' => array(),
                    'title' => array(),
                    'style' => array(),
                ),
                'strike'     => array(),
                'strong'     => array(),
                'ul'         => array(
                    'class' => array(),
                ),
            );

            return $allowed_tags;
        }

        public function tmpenvo_product_decription_gen($tmpenvo_id)
        {
            $product = wc_get_product($tmpenvo_id);
            if (is_bool(wc_get_product($tmpenvo_id))) {
                $attachment_arr = esc_html__("This can't be used here. The WooCommerce option will only work in template pages", 'tmpenvo');
                return $attachment_arr;
            } else {
                return $product->get_description();
            }
        }

        public function tmpenvo_product_short_decription_gen($tmpenvo_id)
        {
            $product = wc_get_product($tmpenvo_id);
            if (is_bool(wc_get_product($tmpenvo_id))) {
                $attachment_arr = esc_html__("This can't be used here. The WooCommerce option will only work in template pages", 'tmpenvo');
                return $attachment_arr;
            } else {
                return $product->get_short_description();
            }
        }

        public function tmpenvo_product_title_gen($tmpenvo_id)
        {
            $product = wc_get_product($tmpenvo_id);
            if (is_bool(wc_get_product($tmpenvo_id))) {
                $attachment_arr = esc_html__("This can't be used here. The WooCommerce option will only work in template pages", 'tmpenvo');
                return $attachment_arr;
            } else {
                return $product->get_name();
            }
        }

        public function tmpenvo_product_gallery_gen($tmpenvo_id)
        {
            $product = wc_get_product($tmpenvo_id);
            if (is_bool(wc_get_product($tmpenvo_id))) {
                $attachment_ids = esc_html__("This can't be used here. The WooCommerce option will only work in template pages", 'tmpenvo');
            } else {
                $attachment_ids = $product->get_gallery_image_ids();
            }

            return $attachment_ids;
        }

        public function tmpenvo_product_carousel_gen($tmpenvo_id)
        {
            $product = wc_get_product($tmpenvo_id);
            if (is_bool(wc_get_product($tmpenvo_id))) {
                $attachment_arr = esc_html__("This can't be used here. The WooCommerce option will only work in template pages", 'tmpenvo');
            } else {
                $attachment_ids = $product->get_gallery_image_ids();
                if (!empty($attachment_ids)) {
                    foreach ($attachment_ids as $key => $attachment_id) {
                        $attachment_arr[] = array(
                            'id'  => $attachment_id,
                            'url' => wp_get_attachment_url($attachment_id),
                        );
                    }
                } else {
                    $attachment_arr = array();
                }
            }
            return $attachment_arr;
        }

        public function tmpenvo_product_featuredimage_gen($tmpenvo_id)
        {
            $product = wc_get_product($tmpenvo_id);
            if (is_bool(wc_get_product($tmpenvo_id))) {
                $attachment_arr = esc_html__("This can't be used here. The WooCommerce option will only work in template pages", 'tmpenvo');
                return $attachment_arr;
            } else {
                return get_post_thumbnail_id($tmpenvo_id);
            }
        }

        public function tmpenvo_comment_form_rating($tmpenvo_id, $icon_html)
        {

            $product = wc_get_product($tmpenvo_id);
            if (is_bool(wc_get_product($tmpenvo_id))) {
                $attachment_arr = esc_html__("This can't be used here. The WooCommerce option will only work in template pages", 'tmpenvo');
                return $attachment_arr;
            } else {
                if ($product->get_rating_count() == 0) {
                    return;
                }
                $rating     = $product->get_rating_count();
                $avg_rating = $product->get_average_rating();
                $rating_1   = $product->get_rating_count(1);
                $rating_2   = $product->get_rating_count(2);
                $rating_3   = $product->get_rating_count(3);
                $rating_4   = $product->get_rating_count(4);
                $rating_5   = $product->get_rating_count(5);

                if ($rating != 0) {
                    $per5 = ($rating_1 / $rating) * 100;
                    $per4 = ($rating_2 / $rating) * 100;
                    $per3 = ($rating_3 / $rating) * 100;
                    $per2 = ($rating_4 / $rating) * 100;
                    $per1 = ($rating_5 / $rating) * 100;
                } else {
                    $per5 = '';
                    $per4 = '';
                    $per3 = '';
                    $per2 = '';
                    $per1 = '';
                }

                ?>

          <div class="tmpenvoratingbox">
            <div>
              <div class="tmpenvo-rating-review">
              <?php
for ($i = 0; $i < $avg_rating; $i++) {
                    \Elementor\Icons_Manager::render_icon($icon_html, ['aria-hidden' => 'true']);
                }
                ?>
             </div>
               <div>
                 <?php echo floatval($avg_rating); ?> <?php esc_html_e( 'out of 5.0 stars', 'tmpenvo' ); ?>
               </div>
            </div>
            <div class="tmpenvoratingboxinner tmpenvo-5star">
              <div class="tmpenvoratingboxinnertext">
                <?php esc_html_e('5 Star', 'tmpenvo');?>
              </div>
              <div class="tmpenvoratingboxinnerprogressbar">
                <progress max="100" value="<?php echo intval($per1); ?>"></progress>
              </div>
              <div class="tmpenvoratingboxinnerpercentage">
                <?php echo number_format((float) intval($per1), 0, '.', '') . '%'; ?>
              </div>
            </div>
            <div class="tmpenvoratingboxinner tmpenvo-4star">
              <div class="tmpenvoratingboxinnertext">
                <?php esc_html_e('4 Star', 'tmpenvo');?>
              </div>
              <div class="tmpenvoratingboxinnerprogressbar">
                <progress max="100" value="<?php echo intval($per2); ?>"></progress>
              </div>
              <div class="tmpenvoratingboxinnerpercentage">
                <?php echo number_format((float) intval($per2), 0, '.', '') . '%'; ?>
              </div>
            </div>
            <div class="tmpenvoratingboxinner tmpenvo-5star">
              <div class="tmpenvoratingboxinnertext">
                <?php esc_html_e('3 Star', 'tmpenvo');?>
              </div>
              <div class="tmpenvoratingboxinnerprogressbar">
                <progress max="100" value="<?php echo intval($per3); ?>"></progress>
              </div>
              <div class="tmpenvoratingboxinnerpercentage">
                <?php echo number_format((float) intval($per3), 0, '.', '') . '%'; ?>
              </div>
            </div>
            <div class="tmpenvoratingboxinner tmpenvo-5star">
              <div class="tmpenvoratingboxinnertext">
                <?php esc_html_e('2 Star', 'tmpenvo');?>
              </div>
              <div class="tmpenvoratingboxinnerprogressbar">
                <progress max="100" value="<?php echo intval($per4); ?>"></progress>
              </div>
              <div class="tmpenvoratingboxinnerpercentage">
                <?php echo number_format((float) $per4, 0, '.', '') . '%'; ?>
              </div>
            </div>
            <div class="tmpenvoratingboxinner tmpenvo-5star">
              <div class="tmpenvoratingboxinnertext">
                <?php esc_html_e('1 Star', 'tmpenvo');?>
              </div>
              <div class="tmpenvoratingboxinnerprogressbar">
                <progress max="100" value="<?php echo intval($per5); ?>"></progress>
              </div>
              <div class="tmpenvoratingboxinnerpercentage">
                <?php echo number_format((float) intval($per5), 0, '.', '') . '%'; ?>
              </div>
            </div>
          </div>
          <?php
}
        }

        public function tmpenvo_comment_form($tmpenvo_id)
        {
            require_once __DIR__ . '/elementor/widgets/woocommerce/templates/tmpenvo-woo-reviewform.php';
        }

        public function tmpenvo_comment_lister($show_review_date,$tmpenvo_id, $icon_html, $gravatar_size, $commentsperpage, $enable_pagination_top, $enable_pagination_bottom)
        {
            $id     = $tmpenvo_id;
            $page   = (get_query_var('page')) ? get_query_var('page') : 1;
            $limit  = $commentsperpage;
            $offset = ($page * $limit) - $limit;
            $param  = array(
                'status'  => 'approve',
                'offset'  => $offset,
                'post_id' => $id,
                'number'  => $limit,
            );
            $total_comments = get_comments(
                array('orderby' => 'post_date',
                    'order'         => 'DESC',
                    'post_id'       => $id,
                    'status'        => 'approve',
                    'parent'        => 0));

            $pages    = ceil(count($total_comments) / $limit);
            $comments = get_comments($param);
            if ($enable_pagination_top == 'yes') {
                echo '<div class="tmpenvo-reviewlist-pagination">';
                $args = array(
                    'base'      => @add_query_arg('page', '%#%'),
                    'format'    => '?page=%#%',
                    'total'     => $pages,
                    'current'   => $page,
                    'show_all'  => false,
                    'end_size'  => 1,
                    'mid_size'  => 2,
                    'prev_next' => true,
                    'prev_text' => esc_html__('Previous'),
                    'next_text' => esc_html__('Next'),
                    'type'      => 'plain',
                );

                echo paginate_links($args);
                echo '</div>';
            }
            if (empty($comments)) {
                echo '<div class="tmpenvo-reviews-woocommerce">';
                esc_html_e('There are no reviews yet. Be the first to review', 'tmpenvo');
                echo '</div>';
            }
            foreach ($comments as $key => $comment) {
                $verified       = wc_review_is_from_verified_owner($comment->comment_ID);
                $rating         = intval(get_comment_meta($comment->comment_ID, 'rating', true));
                $commentcontent = $comment->comment_content;
                $commentauthor  = $comment->comment_author;
                ?> <div class="tmpenvo-reviews-woocommerce">
            <div class="tmpenvo-reviews-woocommerce-gravathar">
              <?php echo get_avatar($comment, $gravatar_size); ?>
            </div>
            <div class="tmpenvo-reviews-woocommerce-review-box">
              <div class="tmpenvo-reviews-woocommerce-review-rating">
                <?php $rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));
                if ($rating && wc_review_ratings_enabled()) {
                    echo "<div class='tmpenvo-rating-review tmpenvo-rating-review-lists'>";
                    for ($i = 0; $i < $rating; $i++) {
                        \Elementor\Icons_Manager::render_icon($icon_html, ['aria-hidden' => 'true']);
                    }
                    echo '</div>';
                }?>
              </div>
              <div class="tmpenvo-reviews-woocommerce-review-content">
                <?php echo esc_html($commentcontent); ?>
              </div>
              <div class="tmpenvo-reviews-woocommerce-review-meta">
                <div class="tmpenvo-reviews-woocommerce-review-meta-author">
                  <h5><?php echo esc_html($commentauthor); ?> </h5>
                  <h6> <?php
                  if($show_review_date == 'yes'){
                    echo date('F j, Y', strtotime($comment->comment_date));
                  }
                  ?> </h6>
                </div>
                <div>
                  <?php
if ('yes' === get_option('woocommerce_review_rating_verification_label') && $verified) {
                    echo '<em class="woocommerce-review__verified verified">(' . esc_attr__('verified owner', 'tmpenvo') . ')</em> ';
                }
                ?>
                </div>
              </div>
            </div>
          </div>

          <?php
}
            if ($enable_pagination_bottom == 'yes') {
                echo '<div class="tmpenvo-reviewlist-pagination">';
                $args = array(
                    'base'      => @add_query_arg('page', '%#%'),
                    'format'    => '?page=%#%',
                    'total'     => $pages,
                    'current'   => $page,
                    'show_all'  => false,
                    'end_size'  => 1,
                    'mid_size'  => 2,
                    'prev_next' => true,
                    'prev_text' => esc_html__('Previous'),
                    'next_text' => esc_html__('Next'),
                    'type'      => 'plain',
                );

                echo paginate_links($args);
                echo '</div>';
            }

        }

        public function tmpenvo_featuredimage_url_template_attachment($tmpenvo_id, $settings)
        {
            // --- The sizes can be obtained from the $settings field
            //Case 1 - Featured Image is Set
            if (has_post_thumbnail($tmpenvo_id)) {
                $thumbnail_id = get_post_thumbnail_id($tmpenvo_id);
            } else {
                //Case 2 - Featured Image is empty - Set an image // Get the url
                $thumbnail_id = $settings['image']['id'];
            }
            return $thumbnail_id;
        }

        public function tmpenvo_featuredimage_url_template($tmpenvo_id, $settings)
        {
            // --- The sizes can be obtained from the $settings field
            //Case 1 - Featured Image is Set
            if (has_post_thumbnail($tmpenvo_id)) {
                $thumbnail_id  = get_post_thumbnail_id($tmpenvo_id);
                $size          = $settings['image_size'];
                $image_sizes   = get_intermediate_image_sizes();
                $image_sizes[] = 'full';
                $url = wp_get_attachment_image_src($thumbnail_id, $size, $icon = false);
            } else {
                //Case 2 - Featured Image is empty - Set an image // Get the url
                $thumbnail_id = $settings['image']['id'];
                $size         = $settings['image_size'];
                if ($size == 'custom') {
                    $size = $settings['image_custom_dimension'];
                }
                $url = wp_get_attachment_image_src($thumbnail_id, 'custom', $icon = false);
            }
            return $url;
        }

        public function tmpenvo_featuredimage_html_template($tmpenvo_id, $settings)
        {
            $url = $this->tmpenvo_featuredimage_url_template($tmpenvo_id, $settings);

            $image = '<img src="' . $url[0] . '" width="" height="" alt="">';
            return $image;
        }

        public function tmpenvo_list_of_posttypes()
        {
            $args = array(
                'public' => true,
            );

            $output   = 'names'; // 'names' or 'objects' (default: 'names')
            $operator = 'and'; // 'and' or 'or' (default: 'and')

            $post_types = get_post_types($args, $output, $operator);
            $post_types = array_map('ucfirst', $post_types);
            return $post_types;
        }

        public function ggwol_list_posttype_specific($tmpenvo_post_type)
        {
            $args = array(
                'numberposts' => -1,
                'post_type'   => $tmpenvo_post_type,
                'post_status' => 'publish',
            );
            $tmpenvo_template_list       = get_posts($args);
            $tmpenvo_template_list_array = array();
            foreach ($tmpenvo_template_list as $key => $value) {
                $tmpenvo_template_list_array[$value->ID] = $value->post_title;
            }
            return $tmpenvo_template_list_array;
        }

        public function tmpenvo_active_post_template($post_id)
        {
            $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
            $page_settings_model   = $page_settings_manager->get_model($post_id);
            $post_type             = $page_settings_model->get_settings('tmpenvo_d_custom_post_selector');
            $post_id_to_view       = $page_settings_model->get_settings('tmpenvo_d_custom_post_selector_id_setter');
            $tmpenvo_data            = array(
                'posttype' => $post_type,
                'post_id'  => $post_id_to_view,
            );
            return $tmpenvo_data;
        }

        public function tmpenvo_single_post_returner($tmpenvo_post_type)
        {

            if (!empty($tmpenvo_post_type['posttype'])) {
                $args = array(
                    'numberposts' => 1,
                    'post_type'   => $tmpenvo_post_type['posttype'],
                    'post_status' => 'publish',
                    'orderby'     => 'date',
                    'order'       => 'DESC',
                    'fields'      => 'ids',
                );
            }

            if(empty(get_posts($args))){
              return esc_html_e('Please add at least one published post', 'tmpenvo');
            }
            if(!empty($tmpenvo_post_type['post_type'])  && $tmpenvo_post_type['post_type'] != get_post_type($tmpenvo_post_type['post_id'] ) ){
              return esc_html_e('This post does not belong to post specified', 'tmpenvo');
            }else{
              return (int)$tmpenvo_post_type['post_id'];
            }

        }

        /*
        Since: 1.0.0
        Purpose : Render Breadcrump
        Coder : Latheesh V M Villa
         */
        public function tmpenvo_c_breadcrump_render($tmpenvo_sep)
        {
            $sep = $tmpenvo_sep;
            if (!is_front_page()) {
                // Start the breadcrumb with a link to your homepage
                echo '<div class="tmpenvo-breadcrumb">';
                echo '<a href="';
                echo get_option('home');
                echo '">';
                bloginfo('name');
                echo '</a>' . esc_html($sep);
                if (is_category() || is_single()) {
                    the_category(' / ');
                    if (is_single()) {
                        echo esc_html($sep);
                        the_title();
                    }
                } elseif (is_archive() || is_single()) {
                    if (is_day()) {
                        printf( esc_html__('%s', 'tmpenvo'), get_the_date());
                    } elseif (is_month()) {
                        printf( esc_html__('%s', 'tmpenvo'), get_the_date(_x('F Y', 'monthly archives date format', 'tmpenvo')));
                    } elseif (is_year()) {
                        printf( esc_html__('%s', 'tmpenvo'), get_the_date(_x('Y', 'yearly archives date format', 'tmpenvo')));
                    } elseif (is_author()) {
                        printf( esc_html__('%s', 'tmpenvo'), get_the_author());
                    } else {
                        esc_html_e('Blog Archives', 'tmpenvo');
                    }
                } elseif (is_single()) {
                    the_title_attribute();
                } elseif (is_page()) {
                    echo the_title_attribute();
                } elseif (is_search()) {
                    echo esc_html($sep) . esc_html( "Search Results for ", 'tmpenvo' );
                    echo '"<em>';
                    echo the_search_query();
                    echo '</em>"';
                } elseif (is_404()) {
                    echo esc_html( "404 Page Not Found", 'tmpenvo' );
                } elseif (is_home()) {
                    global $post;
                    $page_for_posts_id = get_option('page_for_posts');
                    if ($page_for_posts_id) {
                        $post = get_page($page_for_posts_id);
                        setup_postdata($post);
                        the_title();
                        rewind_posts();
                    }
                }
                echo '</div>';
            }

        }
    }

}
