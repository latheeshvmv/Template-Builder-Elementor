<?php
namespace GEEKYGREENOWLSECBACKNS;
if (!defined('ABSPATH')) {
    exit;
}

class TMPENVOSecBack
{

    public function gen_image_url_normal($section)
    {
        $key        = $section->get_settings('tmpenvo_back_section_img_field_key');
        $returntype = $section->get_settings('tmpenvo_back_section_img_field_type');
        $size       = $section->get_settings('tmpenvo_back_section_image_nor_size');
        $field_output = '';
        if (class_exists('ACF')) {
            $field_output = get_field($key);
        }
        if ((get_the_post_thumbnail_url() !== false && $returntype == 'featuredimage')) {
            $image_url = get_the_post_thumbnail_url(get_the_ID(), $size);
            return $image_url;
        } elseif ((isset($field_output) && $field_output != '')) {
            switch ($returntype) {
                case 'acf_array':
                    $image_url = $field_output['sizes'][$size];
                    return $image_url;
                    break;
                case 'acf_url':
                    $image_url = $field_output;
                    return $image_url;
                    break;
                case 'acf_id':
                    $image_url = wp_get_attachment_image_url($field_output, $size);
                    return $image_url;
                    break;
                case 'customfield':
                    $image_url = wp_get_attachment_image_url($field_output, $size);
                    return $image_url;
                    break;
            }} else {
            $alt_image = $section->get_settings('tmpenvo_back_section_img_placeholder_ren')['url'];
            return $alt_image;
        }
    }

    public function gen_image_url_hover($section)
    {
        $key          = $section->get_settings('tmpenvo_back_section_img_field_key_hover');
        $returntype   = $section->get_settings('tmpenvo_back_section_img_field_type_hover');
        $size         = $section->get_settings('tmpenvo_back_section_image_nor_hover_size');
        $field_output = '';
        if (class_exists('ACF')) {
            $field_output = get_field($key);
        }
        if (isset($field_output) && $field_output != '') {
            switch ($returntype) {
                case 'featuredimage':
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), $size);
                    return $image_url;
                    break;
                case 'acf_array':
                    $image_url = $field_output['sizes'][$size];
                    return $image_url;
                    break;
                case 'acf_url':
                    $image_url = $field_output;
                    return $image_url;
                    break;
                case 'acf_id':
                    $image_url = wp_get_attachment_image_url($field_output, $size);
                    return $image_url;
                    break;
                case 'customfield':
                    $image_url = wp_get_attachment_image_url($field_output, $size);
                    return $image_url;
                    break;
            }} else {
            $alt_image = $section->get_settings('tmpenvo_back_section_img_placeholder_hover')['url'];
            return $alt_image;
        }
    }

}
