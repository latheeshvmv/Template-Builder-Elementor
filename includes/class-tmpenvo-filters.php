<?php
namespace TMPENVOFILNS {
    if (!defined('ABSPATH')) {
        exit;
    }

    class TMPENVOFilters
    {
        public function __construct()
        {
            add_filter('comments_open', array($this, 'tmpenvo_comments_open'), 10, 2);
        }

        public function tmpenvo_comments_open($open, $post_id)
        {
            $post = get_post($post_id);
            if ('tmpenvo_template' == $post->post_type || 'tmpenvo_templ_arch' == $post->post_type || 'tmpenvo_template_snip' == $post->post_type) {
                $open = true;
            }
            return $open;
        }

    }
}
