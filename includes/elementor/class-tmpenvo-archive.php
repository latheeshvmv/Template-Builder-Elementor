<?php
namespace TMPENVOARCHIVEBUILDERNS {

  if (!defined('ABSPATH')) {
    exit;
  }

  class TMPENVOarchiver
  {

    protected $tmpenvo_version;

    public function __construct()
    {

      if (defined('TMPENVO_VERSION')) {
        $this->tmpenvo_version = TMPENVO_VERSION;
      } else {
        $this->tmpenvo_version = '1.0.0';
      }

    }

    /*
    ID: TMPENVO-1
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class : Returns list of post types
    */
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

    /*
    ID: TMPENVO-2
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class : Returns list of post Taxonomy
    */
    public function tmpenvo_list_of_taxonomy()
    {
      $args = array(
        'public'   => true,
        '_builtin' => true,
      );
      $tax_list = get_taxonomies($args);
      return $tax_list;
    }

    /*
    ID: TMPENVO-3
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class : Generates the list of all taxonomy - Used in taxonomy
    */
    public function tmpenvo_list_of_taxonomy_repeater_field()
    {
      $tax_list = get_taxonomies();
      return $tax_list;
    }

    /*
    ID: TMPENVO-4
    Since ver 5.1.1
    Modified By : Latheesh V M Villa
    Purpose of the function/class : Generates the list of terms for the all the category
    */
    public function tmpenvo_list_of_terms()
    {
      //$tax = $this->tmpenvo_list_of_taxonomy();
      $terms = get_terms(array('taxonomy' => 'category'));
      $lat = array();
      foreach ($terms as $key => $term) {
        $lat[$term->term_taxonomy_id] = $term->name;
      }
      return $lat;
    }

    /*
    ID: TMPENVO-5
    Since ver 5.1.1
    Modified By : Latheesh V M Villa
    Purpose of the function/class : Generates the list of terms for the all the category - Used in repeater
    */
    public function tmpenvo_list_of_terms_repeater_field()
    {
      $tax   = $this->tmpenvo_list_of_taxonomy_repeater_field();
      $terms = get_terms(array('taxonomy' => $tax));
      $lat = array();
      foreach ($terms as $key => $term) {
        $lat[$term->term_taxonomy_id] = $term->name;
      }
      return $lat;
    }

    /*
    ID: TMPENVO-6
    Since ver 5.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :Generates the list of terms for the all the the_terms
    */
    public function tmpenvo_list_of_tags()
    {
      $tax   = $this->tmpenvo_list_of_taxonomy();
      $terms = get_tags();
      $lat2 = array();
      foreach ($terms as $key => $term) {
        $lat2[$term->term_taxonomy_id] = $term->name;
      }
      return $lat2;
    }

    /*
    ID: TMPENVO-7
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  convert the meta value to array if comma exits other wise string
    */
    public function tmpenvo_mata_value_gen($tmpenvo_u_meta_value)
    {
      $searchString = ',';
      if (strpos($tmpenvo_u_meta_value, $searchString) !== false) {
        $tmpenvo_u_meta_value = explode(",", $tmpenvo_u_meta_value);
      } else {
        $tmpenvo_u_meta_value = $tmpenvo_u_meta_value;
      }
      return $tmpenvo_u_meta_value;
    }



    /*
    ID: TMPENVO-8
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  Collects ids of all the post types, then getpost to collect the IDs, Then returns the key array
    */
    public function tmpenvo_custom_post_type_keylist()
    {
      $tmpenvo_custompostype_array = $this->tmpenvo_list_of_posttypes();

      $tmpenvo_getposts            = array();
      foreach ($tmpenvo_custompostype_array as $value) {
        $args = array(
          'numberposts' => 1,
          'post_type'   => $value,
        );
        if (!empty(get_posts($args)[0]->ID)) {
          $tmpenvo_getposts[] = get_posts($args)[0]->ID;
        }

      }
      $new_array = array();
      foreach ($tmpenvo_getposts as $value) {
        $new_array[] = get_post_custom($value);
      }

      $result = array();
      foreach ($new_array as $sub) {
        $result = array_merge($result, $sub);
      }
      $result     = array_keys($result);
      $result     = array_unique($result);
      $result     = array_combine($result, $result);
      $result[''] = 'NONE';
      return $result;
    }

    /*
    ID: TMPENVO-8
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  Collects ids of all the post types, then getpost to collect the IDs, Then returns the key array
    */
    public function tmpenvo_catergory_id_generator($tmpenvo_u_catid, $tmpenvo_u_catidexclude)
    {

      if (is_array($tmpenvo_u_catid)) {
        $tmpenvo_u_catid = implode(", ", $tmpenvo_u_catid);
      } else {
        $tmpenvo_u_catid = '';
      }
      $tmpenvo_u_catidexcluder = array();
      if (is_array($tmpenvo_u_catidexclude)) {
        $tmpenvo_u_catidexclude = array_map('intval', $tmpenvo_u_catidexclude);

        foreach ($tmpenvo_u_catidexclude as $value) {
          $tmpenvo_u_catidexcluder[] = -1 * $value;
        }
      }
      if (is_array($tmpenvo_u_catidexcluder)) {
        $tmpenvo_u_catidexcluder = implode(",", $tmpenvo_u_catidexcluder);
      } else {
        $tmpenvo_u_catidexcluder = '';
      }

      if ($tmpenvo_u_catidexcluder != '') {
        $tmpenvo_cat_exculution = ',' . $tmpenvo_u_catidexcluder;
      } else {
        $tmpenvo_cat_exculution = $tmpenvo_u_catidexcluder;
      }
      $tmpenvo_u_catid2 = $tmpenvo_u_catid . $tmpenvo_cat_exculution;
      return $tmpenvo_u_catid2;
    }

    /*
    ID: TMPENVO-9
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  Get the post status as list
    */
    public function tmpenvo_list_of_post_status()
    {
      $post_stat = get_post_stati();
      return $post_stat;
    }

    /*
    ID: TMPENVO-9
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  This is the main argument generator for the wp query
    */
    public function tmpenvo_args_generator(
      $tmpenvo_u_posttype,
      $tmpenvo_u_poststatus,
      $tmpenvo_u_postpagingenable,
      $tmpenvo_u_paginate_num,
      $tmpenvo_u_password,
      $tmpenvo_u_order,
      $tmpenvo_u_orderby,
      $tmpenvo_u_meta_key,
      $tmpenvo_u_meta_value,
      $tmpenvo_u_meta_compare,
      $tmpenvo_u_authorid,
      $tmpenvo_u_catid,
      $tmpenvo_u_tagid,
      $tmpenvo_u_tagid_exclude,
      $tmpenvo_u_tax_array
    ) {
      $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

      $arg = array(
        'post_type'      => $tmpenvo_u_posttype,
        'post_status'    => $tmpenvo_u_poststatus, //post_type_status
        'paged'          => $paged,
        'nopaging'       => $tmpenvo_u_postpagingenable, //post_enable_pagination
        'posts_per_page' => $tmpenvo_u_paginate_num, //post_count
        'has_password'   => $tmpenvo_u_password, //password_protected
        'order'          => $tmpenvo_u_order, //order
        'orderby'        => $tmpenvo_u_orderby, //orderby
        'meta_query'     => array(
          array(
            'key'     => $tmpenvo_u_meta_key,
            'value'   => $tmpenvo_u_meta_value,
            'compare' => $tmpenvo_u_meta_compare, //meta_compare
          ),
        ),
        'meta_key'       => $tmpenvo_u_meta_key, //sortingbymetakey
        'author'         => $tmpenvo_u_authorid,
        'cat'            => $tmpenvo_u_catid,
        'tag__in'        => $tmpenvo_u_tagid,
        'tag__not_in'    => $tmpenvo_u_tagid_exclude,
        'tax_query'      => $tmpenvo_u_tax_array,
      );

      return apply_filters('tmpenvo_args_generator_hook', $arg);
    }

    /*
    ID: TMPENVO-10
    Apply filter provided - TMPENVO AP1
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  Renders the title of the post safer
    */
    public function tmpenvo_ren_title()
    {
      $title = the_title_attribute('echo=0');
      return apply_filters('tmpenvo_ren_title_hook', $title);
    }

    /*
    ID: TMPENVO-11
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  This returns the url of the image when used
    */
    public function tmpenvo_ren_image($adv_settings,$tmpenvo_img_type, $tmpenvo_img_id, $tmpenvo_img_type_size='', $tmpenvo_img_custom)
    {
      switch ($tmpenvo_img_type) {
        case "featured":
        $imageurl_before = get_post_thumbnail_id($tmpenvo_img_id);
        $imageurl_url = wp_get_attachment_url($imageurl_before);
        $extra= array(
          'url'=> $imageurl_url,
          'id'=> $imageurl_before,
        );
        if($adv_settings == 'old'){
          $imageurl = get_the_post_thumbnail_url($tmpenvo_img_id, $tmpenvo_img_type_size);
        }else{
          $imageurl =  \Elementor\TMPENVO_Featurred_Image_Getter::get_attachment_image_html_generator($imageurl_before, $adv_settings, $image_size_key = 'image', $image_key = null, $extra);
          if(empty($imageurl)){
            $imageurl_before = $adv_settings['image']['id'];
            if(!empty($imageurl_before)){
              $imageurl =  \Elementor\TMPENVO_Featurred_Image_Getter::get_attachment_image_html_generator($imageurl_before, $adv_settings, $image_size_key = 'image', $image_key = null, $extra);
            }
          }
        }
        return $imageurl;
        break;
        case "acf_image":
        $imageurl_before = get_field($tmpenvo_img_custom, $tmpenvo_img_id);
        $imageurl_url = wp_get_attachment_url($imageurl_before);
        $extra= array(
          'url'=> $imageurl_url,
          'id'=> $imageurl_before,
        );
        if($adv_settings == 'old'){
          $imageurl = get_the_post_thumbnail_url($tmpenvo_img_id, $tmpenvo_img_type_size);
        }else{
          $imageurl =  \Elementor\TMPENVO_Featurred_Image_Getter::get_attachment_image_html_generator($imageurl_before, $adv_settings, $image_size_key = 'image', $image_key = null, $extra);
          if(empty($imageurl)){
            $imageurl_before = $adv_settings['image']['id'];
            if(!empty($imageurl_before)){
              $imageurl =  \Elementor\TMPENVO_Featurred_Image_Getter::get_attachment_image_html_generator($imageurl_before, $adv_settings, $image_size_key = 'image', $image_key = null, $extra);
            }
          }
        }
        return $imageurl;
        break;
        case "custom_field":
        $imageurl_cus = get_post_meta($tmpenvo_img_id, $tmpenvo_img_custom, true);
        $imageurl_cus = wp_get_attachment_image_src($imageurl_cus, $tmpenvo_img_type_size);
        return $imageurl_cus;
        break;
        case "woocommerce_image":
        $imageurl_cus = wp_get_attachment_image_src(get_post_thumbnail_id($tmpenvo_img_id), $tmpenvo_img_type_size);
        $imageurl_cus = $imageurl_cus[0];
        return $imageurl_cus;
        break;
        default:
        $imageurl = get_the_post_thumbnail_url($tmpenvo_img_id, $tmpenvo_img_type_size);
        return $imageurl;

      }
    }

    /*
    ID: TMPENVO-12
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  This decides the content for the content selector
    */
    public function tmpenvo_ren_content($tmpenvo_cont_id, $tmpenvo_r_content_type, $tmpenvo_r_enable_excerpt, $tmpenvo_excerpt_len, $tmpenvo_r_fieldname)
    {

      switch ($tmpenvo_r_content_type) {
        case "editor":
        $content = get_the_content();
        if ($tmpenvo_r_enable_excerpt == 'yes') {
          $content = wp_trim_words($content, $tmpenvo_excerpt_len, '...');
          return $content;
        } else {
          return $content;
        }
        break;
        case "customfield_acf":
        $content = get_field($tmpenvo_r_fieldname);
        if(is_object($content) || is_array($content)){
          return "Check Field Type. Field Type Returns an Object or Array";
        }
        if ($tmpenvo_r_enable_excerpt == 'yes') {
          $content = wp_trim_words($content, $tmpenvo_excerpt_len, '...');
          return $content;
        } else {
          return $content;
        }
        break;
        case 'customfield':
        $post_id = $tmpenvo_cont_id;
        $key     = $tmpenvo_r_fieldname;
        $single  = true;

        $content = get_post_meta($post_id, $key, $single);
        if (is_array($content)) {
          return " ";
        }
        if ($tmpenvo_r_enable_excerpt == 'yes') {
          $content = wp_trim_words($content, $tmpenvo_excerpt_len, '...');
          return $content;
        } else {
          return $content;
        }
        break;

        default:
        $content = the_content();
        if ($tmpenvo_r_enable_excerpt == 'yes') {
          $content = wp_trim_words($content, $tmpenvo_excerpt_len, '...');
          return $content;
        } else {
          return $content;
        }

      }
    }

    /*
    ID: TMPENVO-13
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  This decides the content for the button selector
    */
    public function tmpenvo_ren_button($tmpenvo_r_id, $tmpenvo_r_buttonfieldtype, $tmpenvo_r_customfieldname)
    {
      switch ($tmpenvo_r_buttonfieldtype) {
        case "linktopost":
        $url = get_permalink();
        return $url;
        break;
        case "customfieldurl":
        $post_id = $tmpenvo_r_id;
        $key     = $tmpenvo_r_customfieldname;
        $single  = true;
        $url     = get_post_meta($post_id, $key, $single);
        return $url;
        break;
        case "customfieldurlacfdonwload":
        $url = get_field($tmpenvo_r_customfieldname);
        return $url['url'];
        break;
        case "customfieldurlacf":
        $url = get_field($tmpenvo_r_customfieldname);
        return $url;
        break;
        default:
        $url = get_permalink();
        return $url;
      }
    }

    /*
    ID: TMPENVO-14
    Since ver 1.1.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  This decides the content for the metadata selector
    */
    public function tmpenvo_ren_metadata($tmpenvo_m_id, $tmpenvo_m_en_date, $tmpenvo_m_en_tags, $tmpenvo_m_en_tax, $tmpenvo_m_en_auth, $tmpenvo_m_en_comm, $tmpenvo_m_taxvalue)
    {

      if ($tmpenvo_m_en_date == 'yes') {
        $tmpenvo_date = get_the_date();
      } else {
        $tmpenvo_date = '';
      }

      //check for woocommerce product type is introduced  verion 1.1.0
      if (($tmpenvo_m_en_tags == 'yes') && ( get_post_type($tmpenvo_m_id) == 'product')){
        $tmpenvo_tag = get_the_term_list($tmpenvo_m_id, 'product_tag', '', ', ');
      }
      elseif ($tmpenvo_m_en_tags == 'yes') {
        $tmpenvo_tag = get_the_tag_list("", $sep = ", ");
      } else {
        $tmpenvo_tag = '';
      }

      //check for woocommerce product type is introduced  versio 1.1.0
      if (($tmpenvo_m_en_tax == 'yes') && ( get_post_type($tmpenvo_m_id) == 'product')){
        $tmpenvo_tax = get_the_term_list($tmpenvo_m_id, 'product_cat', '', ', ');
      }
      elseif ($tmpenvo_m_en_tax == 'yes') {
        $tmpenvo_tax = get_the_term_list($tmpenvo_m_id, $tmpenvo_m_taxvalue, '', ', ');
      } else {
        $tmpenvo_tax = '';
      }

      if ($tmpenvo_m_en_auth == 'yes') {
        $tmpenvo_auth = get_the_author_meta('display_name');
      } else {
        $tmpenvo_auth = '';
      }
      if ($tmpenvo_m_en_comm == 'yes') {
        $tmpenvo_comm = get_comments_number();
      } else {
        $tmpenvo_comm = '';
      }

      $tmpenvo_met_array = array(
        'date' => esc_html(ucwords($tmpenvo_date)),
        'tag'  => esc_html__('Tags&nbsp;:&nbsp;', 'tmpenvo') . $tmpenvo_tag,
        'tax'  => ucwords($tmpenvo_m_taxvalue) . '&nbsp;:&nbsp;' . $tmpenvo_tax,
        'auth' => esc_html__('By&nbsp;', 'tmpenvo') . $tmpenvo_auth,
        'com'  => $tmpenvo_comm . esc_html__('&nbsp;Comments', 'tmpenvo'),
      );

      if (empty($tmpenvo_tag)) {
        unset($tmpenvo_met_array['tag']);
      }

      if (empty($tmpenvo_tax)) {
        unset($tmpenvo_met_array['tax']);
      }

      if (empty($tmpenvo_auth)) {
        unset($tmpenvo_met_array['auth']);
      }
      if (empty($tmpenvo_comm)) {
        unset($tmpenvo_met_array['com']);
      }

      $tmpenvo_met_array = array_filter($tmpenvo_met_array);
      return $tmpenvo_met_array;
    }

    /*
    ID: TMPENVO-15
    Apply filter provided -TMPENVO AP2
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  This decides the content for the shortcode selector
    */
    public function tmpenvo_ren_shortcode($tmpenvo_shortcode)
    {
      $input = $tmpenvo_shortcode;
      return apply_filters('tmpenvo_ren_shortcode_hook', $input);
    }

    /*
    ID: TMPENVO-16
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  Function modifed for repeater
    */
    public function tmpenvo_ren_func_repeater_to_array($tmpenvo_field_gen)
    {
      $valuescs = $tmpenvo_field_gen;
      return $valuescs;
    }

    /*
    ID: TMPENVO-17
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  Converts the image size array to elemenetor selector array
    */
    public function tmpenvo_ren_func_array_of_image_size()
    {
      $result = get_intermediate_image_sizes();
      $result = array_unique($result);
      $result = array_combine($result, $result);
      return $result;
    }

    /*
    ID: TMPENVO-18
    Apply filter provided - TMPENVO AP3
    Since ver 6.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  Pagination arguments
    */
    public function tmpenvo_paginate_args($tmpenvo_query)
    {
      $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
      $paged = apply_filters('tmpenvo_paginate_args_paged_hook', $paged);
      $args  = array(
        'format'    => '?paged=%#%',
        'current'   => intval($paged),
        'total'     => intval($tmpenvo_query->max_num_pages),
        'mid_size'  => 2,
        'prev_text' => '<i class="fa fa-arrow-left"></i>',
        'next_text' => '<i class="fa fa-arrow-right"></i>',
      );
      return apply_filters('tmpenvo_paginate_args_hook', $args);
    }

    /*
    ID: TMPENVO-19
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  background image generator for row;
    */
    public function tmpenvo_background_image_genenrator($tmpenvo_b_img_id, $tmpenvo_b_enable, $tmpenvo_b_img_type_size, $tmpenvo_b_cover, $tmpenvo_b_repeat, $tmpenvo_b_top_grad, $tmpenvo_bottom_grad, $tmpenvo_b_position)
    {
      $featured_image_url = get_the_post_thumbnail_url($tmpenvo_b_img_id, $tmpenvo_b_img_type_size);

      return 'style="background: linear-gradient(' . esc_attr($tmpenvo_b_top_grad) . ',' . esc_attr($tmpenvo_bottom_grad) . '),url(' . esc_url($featured_image_url) . '); background-size:cover; background-repeat:no-repeat; background-position:' . esc_html($tmpenvo_b_position) . ' "';
    }

    /*
    ID: TMPENVO-20
    Since ver 1.0.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  Security for the html
    */
    public function tmpenvo_html_allowed_html()
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


    /*
    ID: TMPENVO-21
    Since ver 1.1.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  Returns the variable product price in neat way . Filter provided
    */
    public function tmpenvo_woocommmerce_variation_price_printer($tmpenvo_available_variations,$tmpenvo_price_param,$tmpenvo_woocommerce_cur){
      $tmpenvo_pricing_array = array();
      foreach ($tmpenvo_available_variations as $key => $tmpenvo_available_variation) {
        $tmpenvo_pricing_array[] = $tmpenvo_available_variation[$tmpenvo_price_param];
      }
      $tmpenvo_max_price = $tmpenvo_woocommerce_cur.max($tmpenvo_pricing_array);
      $tmpenvo_min_price = $tmpenvo_woocommerce_cur.min($tmpenvo_pricing_array);

      $tmpenvo_price_range = $tmpenvo_min_price."&nbsp;-&nbsp;".$tmpenvo_max_price;
      return apply_filters('tmpenvo_variation_price_range_hook', $tmpenvo_price_range);

    }


    /*
    ID: TMPENVO-22
    Since ver 1.1.0
    Modified By : Latheesh V M Villa
    Purpose of the function/class :  Returns the simple and external product price in neat way . Filter provided
    */
    public function tmpenvo_woocommmerce_simple_price_printer($tmpenvo_simple_regualar_price,$tmpenvo_simple_sale_price,$tmpenvo_woocommerce_cur){

      if($tmpenvo_simple_sale_price){
        $tmpenvo_price = $tmpenvo_woocommerce_cur."<del>".$tmpenvo_simple_regualar_price."</del>&nbsp;". $tmpenvo_woocommerce_cur.$tmpenvo_simple_sale_price;
      }elseif($tmpenvo_simple_regualar_price){
        $tmpenvo_price = $tmpenvo_woocommerce_cur.$tmpenvo_simple_regualar_price;
      }else{
        $tmpenvo_price ="";
      }
      return apply_filters('tmpenvo_simple_price_range_hook', $tmpenvo_price);

    }

    public function tmpenvo_image_css_gen($tmpenvo_img_position, $tmpenvo_img_position_setter, $tmpenvo_img_width, $tmpenvo_img_padding, $tmpenvo_img_margin, $tmpenvo_img_border_radius)
    {
      $tmpenvo_return_array = [
        'width'                      => $tmpenvo_img_width['size'] . $tmpenvo_img_width['unit'],
        'position'                   => $tmpenvo_img_position,
        'top'                        => $tmpenvo_img_position_setter['top'] . $tmpenvo_img_position_setter['unit'],
        'right'                      => $tmpenvo_img_position_setter['right'] . $tmpenvo_img_position_setter['unit'],
        'left'                       => $tmpenvo_img_position_setter['left'] . $tmpenvo_img_position_setter['unit'],
        'bottom'                     => $tmpenvo_img_position_setter['bottom'] . $tmpenvo_img_position_setter['unit'],
        'padding-left'               => $tmpenvo_img_padding['left'] . $tmpenvo_img_padding['unit'],
        'padding-right'              => $tmpenvo_img_padding['right'] . $tmpenvo_img_padding['unit'],
        'padding-top'                => $tmpenvo_img_padding['top'] . $tmpenvo_img_padding['unit'],
        'padding-bottom'             => $tmpenvo_img_padding['bottom'] . $tmpenvo_img_padding['unit'],
        'margin-top'                 => $tmpenvo_img_margin['top'] . $tmpenvo_img_margin['unit'],
        'margin-left'                => $tmpenvo_img_margin['left'] . $tmpenvo_img_margin['unit'],
        'margin-right'               => $tmpenvo_img_margin['right'] . $tmpenvo_img_margin['unit'],
        'margin-bottom'              => $tmpenvo_img_margin['bottom'] . $tmpenvo_img_margin['unit'],
        'border-top-left-radius'     => $tmpenvo_img_border_radius['top'] . $tmpenvo_img_border_radius['unit'],
        'border-top-right-radius'    => $tmpenvo_img_border_radius['left'] . $tmpenvo_img_border_radius['unit'],
        'border-bottom-left-radius'  => $tmpenvo_img_border_radius['bottom'] . $tmpenvo_img_border_radius['unit'],
        'border-bottom-right-radius' => $tmpenvo_img_border_radius['right'] . $tmpenvo_img_border_radius['unit'],
      ];

      $tmpenvo_return_var = '';
      foreach ($tmpenvo_return_array as $key => $value) {
        $tmpenvo_return_var .= $key . ':' . $value . ';';
      }
      return $tmpenvo_return_var;
    }



    public function tmpenvo_taxonomy_render($tmpenvo_id,$tmpenvo_field_gen,$tmpenvo_key)
    {
      $taxonomy                  = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metadata_taxonmomny_array'];
      $taxonomy_load_links       = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metadata_load_links'];
      $taxonomy_load_links_count = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metadata_count'];
      $taxonomy_load_links_hira  = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metadata_hirarachical'];

      if ($taxonomy_load_links_hira == 'yes') {
        $taxonomy_load_links_hira_ena = true;
      } else {
        $taxonomy_load_links_hira_ena = false;
      }

      $taxonomy_load_links_child = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metadata_childless'];
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
          // $terms_list[] = $value->name;
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

    public function tmpenvo_ren_metadata_new($tmpenvo_id,$tmpenvo_field_gen,$tmpenvo_key){
      $metatoload        = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_meta_to_load'];

      switch ($metatoload) {
        case 'author':
        $author_id    = get_post_field('post_author', $tmpenvo_id);
        $display_name = get_the_author_meta('display_name', $author_id);
        return esc_html($display_name);
        break;
        case 'taxonomy':
        return wp_kses($this->tmpenvo_taxonomy_render($tmpenvo_id,$tmpenvo_field_gen,$tmpenvo_key), $this->tmpenvo_html_allowed_html());
        break;

        case 'date':
        return get_the_date('j F Y', $tmpenvo_id);
        break;
        case 'commentcount':
        return esc_html(get_comments_number($tmpenvo_id));
        break;
      }

    }

    public function tmpenvo_core_grid_loader($tmpenvo_field_gen,$tmpenvo_make_clickable,$tmpenvo_allowed){

      foreach (array_column($tmpenvo_field_gen, 'field_type') as $tmpenvo_key => $tmpenvo_value) {

        global $product;
        switch ($tmpenvo_value) {

          case "title":
          if ($tmpenvo_make_clickable == 'yes'):
            echo '<a id="tmpenvo-cl-title-a" class="tmpenvo-cl-title-a" href="' . get_post_permalink() . '">';
          endif;
          echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
          echo '<div class="tmpenvo-repeater-container-inner">';
          echo esc_html($this->tmpenvo_ren_title()); //the_title_attribute which is safe to use
          echo '</div>';
          echo '</div>';
          if ($tmpenvo_make_clickable == 'yes'):
            echo '</a>';
          endif;
          break;

          case "image":
          $tmpenvo_img_id        = get_the_ID();
          $tmpenvo_img_type      = $tmpenvo_field_gen[$tmpenvo_key]['field_image_url'];
          $tmpenvo_img_custom    = $tmpenvo_field_gen[$tmpenvo_key]['field_image_acf_or_custom'];
          $adv_settings = $tmpenvo_field_gen[$tmpenvo_key];
          $tmpenvo_img_src      = $this->tmpenvo_ren_image($adv_settings,$tmpenvo_img_type, $tmpenvo_img_id, $tmpenvo_img_type_size='', $tmpenvo_img_custom);
          $tmpenvo_alt_gen           = get_the_title(get_the_ID());
          if ($tmpenvo_make_clickable == 'yes'):
            echo '<a class="tmpenvo-cl-image-a" href="' . get_post_permalink() . '">';
          endif;
          if (!empty($tmpenvo_img_src)):
            echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
            echo '<div class="tmpenvo-repeater-container-inner">';
            echo wp_kses($tmpenvo_img_src, $this->tmpenvo_html_allowed_html());
            echo '</div>';
            echo '</div>';
          endif;
          if ($tmpenvo_make_clickable == 'yes'):
            echo '</a>';
          endif;
          break;

          case "content":
          $tmpenvo_cont_id          = get_the_ID();
          $tmpenvo_r_content_type   = $tmpenvo_field_gen[$tmpenvo_key]['field_content_type'];
          $tmpenvo_r_enable_excerpt = $tmpenvo_field_gen[$tmpenvo_key]['trim_content'];
          $tmpenvo_excerpt_len = $tmpenvo_field_gen[$tmpenvo_key]['excerpt_length'];
          if($tmpenvo_r_content_type == 'customfield_acf'){
            $tmpenvo_r_fieldname = $tmpenvo_field_gen[$tmpenvo_key]['field_content_type_acf'];
          }else{
            $tmpenvo_r_fieldname = $tmpenvo_field_gen[$tmpenvo_key]['field_content_custom_value_acf'];
          }
          $tmpenvo_c_src       = $this->tmpenvo_ren_content($tmpenvo_cont_id, $tmpenvo_r_content_type, $tmpenvo_r_enable_excerpt, $tmpenvo_excerpt_len, $tmpenvo_r_fieldname);

          if ($tmpenvo_make_clickable == 'yes'):
            echo '<a id="tmpenvo-cl-content-a" class="tmpenvo-cl-content-a" href="' . get_post_permalink() . '">';
          endif;
          if(!empty($tmpenvo_c_src)){
            echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
            echo '<div class="tmpenvo-repeater-container-inner">';
            echo wp_kses($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_content_before_placer'],$tmpenvo_allowed);
            echo esc_html($tmpenvo_c_src);
            echo wp_kses($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_content_after_placer'], $tmpenvo_allowed);
            echo '</div>';
            echo '</div>';
          }
          if ($tmpenvo_make_clickable == 'yes'):
            echo '</a>';
          endif;
          break;

          case "metadata":
          $tmpenvo_m_id       = get_the_ID();
          $tmpenvo_m_en_date  = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metaldata_show_date'];
          $tmpenvo_m_en_tags  = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metaldata_show_tags'];
          $tmpenvo_m_en_tax   = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metaldata_show_taxonomy'];
          $tmpenvo_m_en_auth  = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metaldata_show_author'];
          $tmpenvo_m_en_comm  = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metaldata_show_comment'];
          $tmpenvo_m_taxvalue = $tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_metaldata_select_taxonomy'];

          $pggg_m_out       = $this->tmpenvo_ren_metadata($tmpenvo_m_id, $tmpenvo_m_en_date, $tmpenvo_m_en_tags, $tmpenvo_m_en_tax, $tmpenvo_m_en_auth, $tmpenvo_m_en_comm, $tmpenvo_m_taxvalue);
          $pggg_m_out       = implode("&nbsp;|&nbsp;", $pggg_m_out);

          echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
          echo '<div class="tmpenvo-repeater-container-inner">';
          echo wp_kses($pggg_m_out, $tmpenvo_allowed);
          echo '</div>';
          echo '</div>';

          break;

          case "metadatasingle":
          $tmpenvo_id       = get_the_ID();

          $tmpenvo_data  = $this->tmpenvo_ren_metadata_new($tmpenvo_id,$tmpenvo_field_gen,$tmpenvo_key);


          if (!empty($tmpenvo_data)){
            echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
            echo '<div class="tmpenvo-repeater-container-inner">';
            echo wp_kses($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_content_before_placer'],$tmpenvo_allowed);
            echo wp_kses($tmpenvo_data, $tmpenvo_allowed);
            echo wp_kses($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_content_after_placer'], $tmpenvo_allowed);
            echo '</div>';
            echo '</div>';
          }
          break;

          case "button":

          $tmpenvo_r_id              = get_the_ID();
          $tmpenvo_r_buttonfieldtype = $tmpenvo_field_gen[$tmpenvo_key]['button_field_type'];
          $tmpenvo_r_customfieldname = $tmpenvo_field_gen[$tmpenvo_key]['customfieldurl_gen'];
          $tmpenvo_r_buttonfieldtext = $tmpenvo_field_gen[$tmpenvo_key]['button_field_type_text'];

          if( $tmpenvo_r_buttonfieldtype == 'woocommercecart' ){
            echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
            echo '<div class="tmpenvo-repeater-container-inner">';
            echo sprintf( '<a href="%s" data-quantity="1" style="' . esc_attr($tmpenvo_button_css_gen) . '" class="%s" %s>%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( implode( ' ', array_filter( array(
              'tmpenvo-cl-button-a '. $tmpenvo_field_gen[$tmpenvo_key]['field_class'] , 'product_type_' . $product->get_type(),
              $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
              $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
            ) ) ) ),
            wc_implode_html_attributes( array(
              'data-product_id'  => $product->get_id(),
              'data-product_sku' => $product->get_sku(),
              'aria-label'       => $product->add_to_cart_description(),
              'rel'              => 'nofollow',
            ) ),
            esc_html($tmpenvo_r_buttonfieldtext) ); ?></div></div> <?php
          }elseif($tmpenvo_r_buttonfieldtype == 'customfieldurlacfdonwload'){
            $tmpenvo_c_url = $this->tmpenvo_ren_button($tmpenvo_r_id, $tmpenvo_r_buttonfieldtype, $tmpenvo_r_customfieldname);
            if(!empty($tmpenvo_c_url)):
              echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
              echo '<div class="tmpenvo-repeater-container-inner">';
              echo '<a href="' . esc_url($tmpenvo_c_url) . '" download >' . esc_html($tmpenvo_r_buttonfieldtext) . '</a>';
              echo '</div>';
              echo '</div>';
            endif;
          }
          else {
            $tmpenvo_c_url   = $this->tmpenvo_ren_button($tmpenvo_r_id, $tmpenvo_r_buttonfieldtype, $tmpenvo_r_customfieldname);
            echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
            echo '<div class="tmpenvo-repeater-container-inner">';
            echo '<a href="' . esc_url($tmpenvo_c_url) . '" >' . esc_html($tmpenvo_r_buttonfieldtext) . '</a>';
            echo '</div>';
            echo '</div>';
          }
          break;

          case "rating":
          if (get_post_type(get_the_id()) == 'product') {
            $tmpenvo_average = $product->get_average_rating();
            if ($tmpenvo_make_clickable == 'yes'):
              echo '<a id="tmpenvo-cl-rating-a" class="tmpenvo-cl-rating-a" href="' . get_post_permalink() . '">';
            endif;

            if (!empty($product->get_average_rating())):
              echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
              echo '<div class="tmpenvo-repeater-container-inner">';
              echo '<div class="star-rating" title="' . sprintf(__('Rated %s out of 5', 'woocommerce'), intval($tmpenvo_average)) . '"><span style="width:' . ((intval($tmpenvo_average) / 5) * 100) . '%"><strong itemprop="ratingValue" class="rating">' . intval($tmpenvo_average) . '</strong> ' . __('out of 5', 'tmpenvo') . '</span></div>';
              echo '</div>';
              echo '</div>';
            endif;

            if ($tmpenvo_make_clickable == 'yes'):
              echo '</a>';
            endif;


          } else {
            esc_html_e('This field only works with Post type WooCommerce', 'tmpenvo');
          }
          break;

          case "html":
          $tmpenvo_html = $tmpenvo_field_gen[$tmpenvo_key]['field_html'];
          if ($tmpenvo_make_clickable == 'yes'):
            echo '<a id="tmpenvo-cl-html-a" class="tmpenvo-cl-html-a" href="' . get_post_permalink() . '">';
          endif;
          echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . ' animated tmpenvo-cl-html ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . '" >';
          echo wp_kses($tmpenvo_html, $tmpenvo_allowed);
          echo '</div>';
          if ($tmpenvo_make_clickable == 'yes'):
            echo '</a>';
          endif;

          break;

          case "shortcode":
          $tmpenvo_shortcode = $tmpenvo_field_gen[$tmpenvo_key]['field_shortcode'];
          $tmpenvo_shortcode = $this->tmpenvo_ren_shortcode($tmpenvo_shortcode);
          if ($tmpenvo_make_clickable == 'yes'):
            echo '<a class="tmpenvo-cl-shortcode-a" href="' . get_post_permalink() . '">';
          endif;
          echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
          echo '<div class="tmpenvo-repeater-container-inner">';
          echo wp_kses($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_content_before_placer'],$tmpenvo_allowed);
          echo do_shortcode($tmpenvo_shortcode);
          echo wp_kses($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_content_after_placer'], $tmpenvo_allowed);
          echo '</div>';
          echo '</div>';
          if ($tmpenvo_make_clickable == 'yes'):
            echo '</a>';
          endif;
          break;

          case "wooprice":
          if (get_post_type(get_the_id()) == 'product') {

            if( ($product->is_type( 'simple' )) || ($product->is_type( 'external' ))  ){
              $tmpenvo_woocommerce_cur = get_woocommerce_currency_symbol();
              $tmpenvo_simple_regualar_price = get_post_meta( get_the_ID(), '_regular_price', true);
              $tmpenvo_simple_sale_price = get_post_meta( get_the_ID(), '_sale_price', true);

              if(!empty($this->tmpenvo_woocommmerce_simple_price_printer($tmpenvo_simple_regualar_price,$tmpenvo_simple_sale_price,$tmpenvo_woocommerce_cur))){
                echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
                echo '<div class="tmpenvo-repeater-container-inner">';
                echo wp_kses($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_content_before_placer'],$tmpenvo_allowed);
                echo wp_kses($this->tmpenvo_woocommmerce_simple_price_printer($tmpenvo_simple_regualar_price,$tmpenvo_simple_sale_price,$tmpenvo_woocommerce_cur),$tmpenvo_allowed);
                echo wp_kses($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_content_after_placer'], $tmpenvo_allowed);
                echo '</div>';
                echo '</div>';
              }

            } elseif( $product->is_type( 'variable' ) ){

              $tmpenvo_available_variations = $product->get_available_variations();
              $tmpenvo_price_param = "display_price";
              $tmpenvo_woocommerce_cur = get_woocommerce_currency_symbol();
              if(!empty($this->tmpenvo_woocommmerce_variation_price_printer($tmpenvo_available_variations,$tmpenvo_price_param,$tmpenvo_woocommerce_cur))){
                echo '<div id="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_id']) . '" class="' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['field_class']) . ' tmpenvo-repeater-container elementor-repeater-item-' . $tmpenvo_field_gen[$tmpenvo_key]['_id'] . ' elementor-animation-' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_hover_animation']) . '  animated  ' . esc_attr($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_title_entrance_animation']) . ' ">';
                echo '<div class="tmpenvo-repeater-container-inner">';
                echo wp_kses($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_content_before_placer_variable'],$tmpenvo_allowed);
                echo esc_html($this->tmpenvo_woocommmerce_variation_price_printer($tmpenvo_available_variations,$tmpenvo_price_param,$tmpenvo_woocommerce_cur) );
                echo wp_kses($tmpenvo_field_gen[$tmpenvo_key]['tmpenvo_content_after_placer_variable'], $tmpenvo_allowed);
                echo '</div>';
                echo '</div>';
              }

            }else{
              do_action( 'tmpenvo_suppport_for_custom_product_type_hook_act', 'tmpenvo_suppport_for_custom_product_type' );
            }

          }else {
            esc_html_e('This field only works with Post type - WooCommerce', 'tmpenvo');
          }

          break;
          default:
          echo "";
        }
      }
    }

    public function tmpenvo_taxonomy_selector(){

      $args = array(
        'public'   => true,);
        $output = 'objects';

        $taxonomies = get_taxonomies( $args,$output );

        $formated = array();
        if ( $taxonomies ) {
          foreach ( $taxonomies as $taxonomy ) {
            $formated[$taxonomy->name] =   $taxonomy->labels->name;
          }
        }

        return $formated;
      }

      public function tmpenvo_taxonomy_selector_terms($taxonomy){
        $terms = get_terms([
          'taxonomy' => $taxonomy,
          'hide_empty' => false,
        ]);
        return $terms;
      }

      public function tmpenvo_acf_realational_field_support($tmpenvo_args,$settings){
        $tmpenvo_relational = $settings['tmpenvo_post_grid_post_id_show_only'];
        if (!empty($tmpenvo_relational)) {
          if (!empty(get_field($tmpenvo_relational)) && get_field($tmpenvo_relational) !== null) {
            $tmpenvo_dis_this_only = get_field($tmpenvo_relational);

            $tmpenvo_relationshiptype = $settings['tmpenvo_relation_type_set'];
            switch ($tmpenvo_relationshiptype) {
              case 'postobject':
              if (is_object($tmpenvo_dis_this_only)) {
                $tmpenvo_rel_arr[] = $tmpenvo_dis_this_only->ID;
              } elseif (is_object($tmpenvo_dis_this_only[0])) {
                $tmpenvo_rel_arr = array();
                foreach ($tmpenvo_dis_this_only as $key => $value) {
                  $tmpenvo_rel_arr[] = $value->ID;
                }
              } elseif (is_array($tmpenvo_dis_this_only)) {
                $tmpenvo_rel_arr2 = array();
                foreach ($tmpenvo_dis_this_only as $key => $value) {
                  $tmpenvo_rel_arr2[] = $value;
                }
                $tmpenvo_rel_arr= $tmpenvo_rel_arr2;
              } elseif (is_int($tmpenvo_dis_this_only)) {
                $tmpenvo_rel_arr[] = $tmpenvo_dis_this_only;
              }
              if (!empty($tmpenvo_rel_arr)) {
                if (array_key_exists('post__in', $tmpenvo_args)) {
                  unset($tmpenvo_args['post__in']);
                }
                $tmpenvo_args['post__in'] = $tmpenvo_rel_arr;
                return $tmpenvo_args;
              }
              break;
              case 'relationship':
              if (is_object($tmpenvo_dis_this_only)) {
                $tmpenvo_rel_arr[] = $tmpenvo_dis_this_only->ID;
              } elseif (is_object($tmpenvo_dis_this_only[0])) {
                $tmpenvo_rel_arr = array();
                foreach ($tmpenvo_dis_this_only as $key => $value) {
                  $tmpenvo_rel_arr[] = $value->ID;
                }
              } elseif (is_array($tmpenvo_dis_this_only)) {
                $tmpenvo_rel_arr2 = array();
                foreach ($tmpenvo_dis_this_only as $key => $value) {
                  $tmpenvo_rel_arr2[] = $value;
                }
                $tmpenvo_rel_arr= $tmpenvo_rel_arr2;
              } elseif (is_int($tmpenvo_dis_this_only)) {
                $tmpenvo_rel_arr[] = $tmpenvo_dis_this_only;
              }
              if (!empty($tmpenvo_rel_arr)) {
                if (array_key_exists('post__in', $tmpenvo_args)) {
                  unset($tmpenvo_args['post__in']);
                }
                $tmpenvo_args['post__in'] = $tmpenvo_rel_arr;
                return $tmpenvo_args;
              }
              break;

              case 'user':
              if (is_object($tmpenvo_dis_this_only)) {
                $tmpenvo_rel_arr[] = $tmpenvo_dis_this_only->ID;
              } elseif (is_object($tmpenvo_dis_this_only[0])) {
                $tmpenvo_rel_arr = array();
                foreach ($tmpenvo_dis_this_only as $key => $value) {
                  $tmpenvo_rel_arr[] = $value->ID;
                }
              } elseif (is_array($tmpenvo_dis_this_only)) {
                $tmpenvo_rel_arr2 = array();
                if(array_key_exists('user_firstname',$tmpenvo_dis_this_only)){
                  foreach ($tmpenvo_dis_this_only as $key => $value) {
                    $tmpenvo_rel_arr2[] = $value['ID'];
                  }
                }else{
                  foreach ($tmpenvo_dis_this_only as $key => $value) {
                    $tmpenvo_rel_arr2[] = $value;
                  }
                }
                $tmpenvo_rel_arr= $tmpenvo_rel_arr2;
              } elseif (is_int($tmpenvo_dis_this_only)) {
                $tmpenvo_rel_arr[] = $tmpenvo_dis_this_only;
              }
              if (!empty($tmpenvo_rel_arr)) {
                if (array_key_exists('author__in', $tmpenvo_args)) {
                  unset($tmpenvo_args['author__in']);
                }
                $tmpenvo_args['author__in'] = $tmpenvo_rel_arr;
                return $tmpenvo_args;
              }
              break;
            }
          }
        }

      }

      public static function tmpenvo_sort_filer_form_gen($settings,$tmpenvo_user_data,$tmpenvo_args,$tmpenvo_acend_var,$tmpenvo_decend_var){
        ?>
        <div class="tmpenvo-sort-collapse">
          <div class="tmpenvo-filter-box">
            <div class="tmpenvo-sort-collapse-button">
              <?php esc_html_e( 'Filter', $domain = 'tmpenvo' ); ?>
            </div>
          </div>
          <div class="<?php if($settings['tmpenvo_enable_sorter_collapse']== 'yes'){ echo "tmpenvo-sort-collapase-content ";}?> tmpenvo-sort-collapse-content-box">
            <form class="tmpenvo-sort-filter-form" id = "tmpenvo-sort-filter-form" name="tmpenvoformsub" action="" method="get">
              <div id="tmpenvo-sort-filter" class="tmpenvo-sort-filter">
                <ul>
                  <?php
                  // #2
                  if ( $settings['tmpenvo_grid_sort_and_filter_layout'] ) {
                    $count = -1;
                    if(!empty($tmpenvo_args['tax_query'])){
                      $tmpenvo_taxon_array = $tmpenvo_args['tax_query'];
                    }else{
                      $tmpenvo_taxon_array = array();
                    }
                    foreach (  $settings['tmpenvo_grid_sort_and_filter_layout'] as $item ) {

                      switch ($item['tmpenvo_grid_sort_and_filter_type']) {
                        case 'sort':
                        ?>
                        <li class="tmpenvo-li-checkbox">
                          <div class="tmpenvo-select-label tmpenvo-select-label-select">
                            <?php echo esc_html( $item['tmpenvo_grid_sort_and_filter_label'] ); ?>
                          </div>
                          <label>
                            <input class="tmpenvo-check-boxer tmpenvocheckboxaccendinp" type="checkbox" name="tmpenvo-sort-acend" <?php if(!empty($tmpenvo_acend_var) && $tmpenvo_acend_var == 'on' ){ echo "checked"; }elseif(empty($tmpenvo_decend_var) && empty($tmpenvo_acend_var) && !empty($tmpenvo_args['order'] && $tmpenvo_args['order']=='ASC')){echo "checked"; }  ?>>
                            <div class="icon-box tmpenvocheckboxaccend">
                              <i class="fa fa-arrow-circle-o-down" area-hidden="true"></i>
                            </div>
                          </label>
                          <label>
                            <input class="tmpenvo-check-boxer tmpenvocheckboxdecendinp" type="checkbox" name="tmpenvo-sort-decend"<?php if(!empty($tmpenvo_decend_var) && $tmpenvo_decend_var == 'on' ){ echo "checked"; }elseif(empty($tmpenvo_decend_var) && empty($tmpenvo_acend_var) && !empty($tmpenvo_args['order'] && $tmpenvo_args['order']=='DESC')){echo "checked"; }   ?>>
                            <div class="icon-box tmpenvocheckboxdecend">
                              <i class="fa fa-arrow-circle-o-up" area-hidden="true"></i>
                            </div>
                          </label>
                        </li>
                        <?php
                        break;
                        case 'select':
                        $tmpenvo_current_taxon = $item['taxonomy'];
                        $tmpenvo_current_taxon_terms = $tmpenvo_user_data->tmpenvo_taxonomy_selector_terms($tmpenvo_current_taxon);
                        echo '<li>';
                        ?>
                        <div class="tmpenvo-ui">
                          <div class="tmpenvo-select-label tmpenvo-select-label-select">
                            <?php echo esc_html( $item['tmpenvo_grid_sort_and_filter_label'] ); ?>
                          </div>
                          <select <?php echo esc_attr($item['tmpenvo_grid_sort_and_filter_multiselect']);  ?> name="<?php echo 'tmpenvo-taxon-select-'.$tmpenvo_current_taxon.'-'.$count.'[]' ?>" class="ui fluid dropdown">
                            <?php
                            $tmpenvo_array_data = array();
                            foreach ($tmpenvo_taxon_array as $key => $value) {
                              if($value['taxonomy'] == $tmpenvo_current_taxon ){
                                $tmpenvo_array_data[] = $value['terms'];
                              }
                            }
                            echo '<option value="">'.esc_html($item['tmpenvo_grid_sort_and_filter_label']).'</option>';
                            foreach ($tmpenvo_current_taxon_terms as $key => $value) {
                              // create the array for checking
                              $tmpenvo_array_in =array();

                              if(!empty($tmpenvo_array_data)){
                                  $tmpenvo_array_in = $tmpenvo_array_data[0];
                                }

                              if(in_array($value->term_id, $tmpenvo_array_in ) && !empty($tmpenvo_array_in) ){
                                echo '<option value="'.esc_html($value->term_id).'" selected>'.esc_html($value->name).'</option>';
                              }else{
                                echo '<option value="'.esc_html($value->term_id).'">'.esc_html($value->name).'</option>';
                              }
                            }
                            ?>
                          </select>
                        </div>

                        <?php
                        echo '</li>';
                        break;
                        case 'list':
                        $tmpenvo_current_taxon = $item['taxonomy'];
                        $tmpenvo_current_taxon_terms = $tmpenvo_user_data->tmpenvo_taxonomy_selector_terms($tmpenvo_current_taxon);
                        $tmpenvo_array_data2 = array();
                        foreach ($tmpenvo_taxon_array as $key => $value) {
                          if($value['taxonomy'] == $tmpenvo_current_taxon ){
                            $tmpenvo_array_data2[] = $value['terms'];
                          }
                        }
                        echo "<div class='tmpenvo-list-taxon-main'>";
                        ?>
                        <div class="tmpenvo-select-label tmpenvo-select-label-select">
                          <?php echo esc_html( $item['tmpenvo_grid_sort_and_filter_label'] ); ?>
                        </div>
                        <?php
                        echo "<div class='tmpenvo-list-taxon'>";
                        foreach ($tmpenvo_current_taxon_terms as $key => $value) {
                          echo '<li>';
                          ?>
                          <label>
                            <?php
                            if(!empty($tmpenvo_array_data2[0]) && is_array($tmpenvo_array_data2)){
                              $tmpenvo_store_array = $tmpenvo_array_data2[0];
                            }else{
                              $tmpenvo_store_array =array();
                            }

                            if(in_array(strval($value->term_id), $tmpenvo_store_array)): ?>
                              <input type="checkbox" name="<?php echo "tmpenvo-$tmpenvo_current_taxon-sep-$value->term_id[]";?>" checked>
                            <?php else: ?>
                              <input type="checkbox" name="<?php echo "tmpenvo-$tmpenvo_current_taxon-sep-$value->term_id[]";?>">
                            <?php endif; ?>
                            <div class="icon-box">
                              <?php echo '<div name="'.esc_html($value->slug).'">'.esc_html(ucwords($value->name)).'</div>'; ?>
                            </div>
                          </label>
                          <?php
                          echo '</li>';
                        }
                        echo "</div>";
                        echo "</div>";
                        break;
                      }
                      $count = $count+1;
                    }
                  }
                  ?>
                </ul>
                <input class="tmpenvo-sort-collapse-submit" type="submit" value="Sort/Filter">
              </div>
            </form>
          </div>
        </div>
        <?php
      }


      public static function tmpenvo_generator_select($settings,$tmpenvo_user_data){
        if($settings['tmpenvo_enable_sorter'] != 'yes'){
          return;
        }
        if(empty($settings['tmpenvo_grid_sort_and_filter_layout'])){
          return;
        }

        $tmpenvo_current_taxon = array();
        $tmpenvo_current_taxon_list = array();
        foreach ($settings['tmpenvo_grid_sort_and_filter_layout'] as $key => $value) {
          switch ($value['tmpenvo_grid_sort_and_filter_type']) {
            case 'select':
            $tmpenvo_current_taxon[] = $value['taxonomy'];
            break;
            case 'list':
            $tmpenvo_current_taxon_list[] = $value['taxonomy'];
            break;
          }
        }
        $tmpenvo_selection_var =array();
        foreach ($tmpenvo_current_taxon as $key => $value) {
          for ($i=0; $i < 5; $i++) {
            $tmpenvo_selection_var[$value][] = (get_query_var('tmpenvo-taxon-select-'.$value.'-'.$i.'')) ? get_query_var('tmpenvo-taxon-select-'.$value.'-'.$i.'') : array();
          }
        }

        if(!empty($tmpenvo_selection_var)){

                  $tmpenvo_array_module = [];
                  foreach($tmpenvo_selection_var as $key=>$value){
                    $tmpenvo_array_module[$key]['taxonomy'] = $key;

                    $value= array_filter(array_map('array_filter', $value));
                    if(count($value) > 0){
                      foreach($value as $val){
                        if (is_array($val)) {
                          $tmpenvo_array_module[$key]['data'] = (isset($tmpenvo_array_module[$key]['data'])) ? array_merge($tmpenvo_array_module[$key]['data'], $val) : $val;
                        }
                      }
                      $tmpenvo_array_module[$key]['data'] = array_unique($tmpenvo_array_module[$key]['data']);
                    }else{
                      $tmpenvo_array_module[$key]['data'] = '';
                    }
                  }

                  $tmpenvo_selection_var = array_values($tmpenvo_array_module);


        }

        $tmpenvo_arrayNameSelect = array();
        if(!empty($tmpenvo_selection_var) && is_array($tmpenvo_selection_var)){
          foreach ($tmpenvo_selection_var as $key => $value) {
            if(!empty($value['data'])){
              $tmpenvo_arrayNameSelect[] = array(
                'taxonomy' => $value['taxonomy'],
                 'field' => 'term_id',
                 'terms' => $value['data'],
              );
            }
          }
        }

        //list module
        $tmpenvo_selection_var_tec =array();
        foreach ($tmpenvo_current_taxon_list as $key => $value) {
          $taxonomy = $value;
          $get_associated_terms = $tmpenvo_user_data->tmpenvo_taxonomy_selector_terms($value);
          foreach ($get_associated_terms as $key => $value_term) {
            if(is_array(get_query_var( 'tmpenvo-'.$taxonomy.'-sep-'.$value_term->term_id ))){
              if(get_query_var( 'tmpenvo-'.$taxonomy.'-sep-'.$value_term->term_id )[0] == 'on'){
                $tmpenvo_selection_var_tec[$taxonomy][] = $value_term->term_id;
              }
            }
          }

        }

        $tmpenvo_arrayNameList = array();
        foreach ($tmpenvo_selection_var_tec as $key => $value) {
           $tmpenvo_arrayNameList[] = array(
             'taxonomy' => $key,
              'field' => 'term_id',
              'terms' => $value,
           );
        }

        return $tmpenvo_selection_var_data = array(
          'select_array' => $tmpenvo_arrayNameSelect,
          'list_array' => $tmpenvo_arrayNameList,
        );
      }
    }
  }
