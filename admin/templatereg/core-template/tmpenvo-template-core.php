<?php
if (!defined('ABSPATH')) {exit;}
\Elementor\Plugin::$instance->frontend->add_body_class('elementor-template-full-width');
get_header();
if (have_posts()):
    while (have_posts()): the_post();?>
                <?php if (!post_password_required($post)):
            $post_id               = get_the_ID();
            $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers('page');
            $page_settings_model   = $page_settings_manager->get_model($post_id);
            $tmpenvo_page_type       = $page_settings_model->get_settings('tmpenvo_d_custom_post_selector');
            ?>
                 <div id="post-<?php the_ID();?>" <?php post_class('tmpenvo-class');?>>                  
                 <?php the_content();?>
                 </div>
               <?php else:
            echo get_the_password_form();
        endif;?>
            <?php endwhile;?>
      <?php else: ?>
        <?php esc_html_e('Not Found', 'tmpenvo');?>
  <?php endif;?>
<?php get_footer();?>
