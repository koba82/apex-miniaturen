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
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

if ( ! comments_open() ) {
    return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
    <div id="comments">
        <h4 class="woocommerce-Reviews-title"><?php
            if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
                //printf( _n( '%s review for %s%s%s', '%s reviews for %s%s%s', $count, 'woocommerce' ), $count, '<span>', get_the_title(), '</span>' );
                echo 'Beoordelingen voor ' . get_the_title();
            else
                _e( 'Reviews', 'woocommerce' );
            ?></h4>

        <?php if ( have_comments() ) : ?>

            <div class="reviews-container">
                <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
            </div>

            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
                echo '<nav class="woocommerce-pagination">';
                paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
                    'prev_text' => '&larr;',
                    'next_text' => '&rarr;',
                    'type'      => 'list',
                ) ) );
                echo '</nav>';
            endif; ?>

        <?php else : ?>


        <?php endif; ?>
    </div>

    <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

        <div id="review_form_wrapper">
            <div id="review_form">
                <?php
                $commenter = wp_get_current_commenter();

                $comment_form = array(
                    'title_reply'          => have_comments() ? __( 'Add a review', 'woocommerce' ) : sprintf( __( 'Be the first to review &ldquo;%s&rdquo;', 'woocommerce' ), get_the_title() ),
                    'title_reply_before'    => '<p class="reviews-main-title">',
                    'title_reply_after'     => '</p>',
                    'title_reply_to'       => __( 'Leave a Reply to %s', 'woocommerce' ),
                    'comment_notes_before' => 'Kies het aantal sterren:',
                    'comment_notes_after'  => '',
                    'fields'               => array(
                        'author' => '<p class="comment-form-author">' . ' ' .
                            '<input id="author" name="author" placeholder="Naam" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></p>',
                        'email'  => '<p class="comment-form-email"> ' .
                            '<input id="email" name="email" placeholder="E-mail adres" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></p>',
                        'cookies' => '<p class="form-email-notes">We gebruiken je e-mail adres alleen om je beoordeling te verifiëren, <em>niet</em> voor commerciële doeleinden.</p>',
                    ),
                    'label_submit'  => __( 'Submit', 'woocommerce' ),
                    'logged_in_as'  => ''
                    //'comment_field' => ''
                );

                if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
                    $comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'woocommerce' ), esc_url( $account_page_url ) ) . '</p>';
                }

                if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
                    $comment_form['comment_field'] = '<select name="rating" id="rating" aria-required="true" hidden required>
							<option value="">' . __( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . __( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . __( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . __( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . __( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . __( 'Very Poor', 'woocommerce' ) . '</option>
						</select>
						
						<div class="woocommerce-product-rating">
        <div class="star-container">
            <div class="star-wrap open">
                <div class="star star-open" data-stars="2">' .  display_icon('fnd-star') . '</div>
                <div class="star star-open" data-stars="3">' .  display_icon('fnd-star') . '</div>
                <div class="star star-open" data-stars="4">' .  display_icon('fnd-star') . '</div>
                <div class="star star-open" data-stars="5">' .  display_icon('fnd-star') . '</div>
                <div class="star star-open" data-stars="1">' .  display_icon('fnd-star') . '</div>
            </div>
            <div class="star-wrap closed" style="width: 100%">
                <div class="star star-closed">' .  display_icon('fnd-star-filled') . '</div>
                <div class="star star-closed">' .  display_icon('fnd-star-filled') . '</div>
                <div class="star star-closed">' .  display_icon('fnd-star-filled') . '</div>
                <div class="star star-closed">' .  display_icon('fnd-star-filled') . '</div>
                <div class="star star-closed">' .  display_icon('fnd-star-filled') . '</div>
            </div>
        </div>

    </div>';
                }

                $comment_form['comment_field'] .= '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="Beoordeling" aria-required="true"></textarea></p>';

                    comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
                ?>
            </div>
        </div>

    <?php else : ?>

        <p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>

    <?php endif; ?>

    <script>
        jQuery('#rating').val(5);
        jQuery('#commentform .star-open').on('click', function() {
            let stars = parseInt(jQuery(this).attr('data-stars'));
            jQuery('#rating').val(stars);
            let starWidth = 20 * stars;
            jQuery('#commentform .star-wrap.closed').css('width', starWidth + '%');
        })

        jQuery('.reviews-main-title').on('click', function() {

            jQuery('#respond .comment-form').toggleClass('active');

        });

        jQuery('#commentform #submit').on('click', function(e) {
            e.preventDefault();

            if( !jQuery('#commentform #comment').val()) {
                jQuery('#commentform #comment').val('-geen tekst-');
            }

            jQuery('#commentform').submit();

        })

    </script>




    <div class="clear"></div>
</div>
