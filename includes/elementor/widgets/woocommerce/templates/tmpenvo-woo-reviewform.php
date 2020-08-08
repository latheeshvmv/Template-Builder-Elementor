<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */
defined('ABSPATH') || exit;
$product = wc_get_product($tmpenvo_id);
if (!comments_open()) {
    return;
}
?>
<div id="tmpenvo-reviews" class="tmpenvo-woocommerce-Reviews">

	<?php if (get_option('woocommerce_review_rating_verification_required') === 'no' || wc_customer_bought_product('', get_current_user_id(), $product->get_id())): ?>
		<div id="tmpenvo-review_form_wrapper">
			<div id="tmpenvo-review_form">
				<?php
$commenter    = wp_get_current_commenter();
$comment_form = array(
    /* translators: %s is product title */
    'title_reply'          => '',
    /* translators: %s is product title */
    'title_reply_to'       => '',
    'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
    'title_reply_after'    => '</span>',
    'comment_notes_after'  => '',
    'label_submit'         => esc_html__('Submit', 'tmpenvo'),
    'logged_in_as'         => '',
    'comment_field'        => '',
    'comment_notes_before' => '',
    'submit_button'        => '<div class="tmpenvo-form-group">
            <input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />
        	</div>',
);
$name_email_required = (bool) get_option('require_name_email', 1);
$fields              = array(
    'author' => array(
        'label'    => esc_html__('Name', 'tmpenvo'),
        'type'     => 'text',
        'value'    => $commenter['comment_author'],
        'required' => $name_email_required,
    ),
    'email'  => array(
        'label'    => esc_html__('Email', 'tmpenvo'),
        'type'     => 'email',
        'value'    => $commenter['comment_author_email'],
        'required' => $name_email_required,
    ),
);
$comment_form['fields'] = array();
foreach ($fields as $key => $field) {
    $field_html = '<p class="tmpenvo-comment-form-' . esc_attr($key) . '">';
    $field_html .= '<label for="' . esc_attr($key) . '">' . esc_html($field['label']);
    if ($field['required']) {
        $field_html .= '&nbsp;<span class="required">*</span>';
    }
    $field_html .= '</label><input id="' . esc_attr($key) . '" name="' . esc_attr($key) . '" type="' . esc_attr($field['type']) . '" value="' . esc_attr($field['value']) . '" size="30" ' . ($field['required'] ? 'required' : '') . ' /></p>';
    $comment_form['fields'][$key] = $field_html;
}
$account_page_url = wc_get_page_permalink('myaccount');
if ($account_page_url) {
    /* translators: %s opening and closing link tags respectively */
    $comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf(esc_html__('You must be %1$slogged in%2$s to post a review.', 'tmpenvo'), '<a href="' . esc_url($account_page_url) . '">', '</a>') . '</p>';
}
if (wc_review_ratings_enabled()) {
    $comment_form['comment_field'] = '<div class="tmpenvo-rating-star comment-form-rating"><label for="rating">' . esc_html__('Your rating', 'tmpenvo') . '</label><select name="rating" id="rating" required>
						<option value="">' . esc_html__('Rate&hellip;', 'tmpenvo') . '</option>
						<option value="5">' . esc_html__('Perfect', 'tmpenvo') . '</option>
						<option value="4">' . esc_html__('Good', 'tmpenvo') . '</option>
						<option value="3">' . esc_html__('Average', 'tmpenvo') . '</option>
						<option value="2">' . esc_html__('Not that bad', 'tmpenvo') . '</option>
						<option value="1">' . esc_html__('Very poor', 'tmpenvo') . '</option>
					</select></div>';
}
$comment_form['comment_field'] .= '<p class="tmpenvo-comment-form-comment"><label for="comment">' . esc_html__('Your review', 'tmpenvo') . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';
comment_form(apply_filters('woocommerce_product_review_comment_form_args', $comment_form));
?>
			</div>
		</div>
	<?php else: ?>
		<p class="woocommerce-verification-required"><?php esc_html_e('Only logged in customers who have purchased this product may leave a review.', 'tmpenvo');?></p>
	<?php endif;?>

	<div class="clear"></div>
</div>
