<?php
/**
 * The template to display the reviewers star rating in reviews
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $comment;
$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

if ( $rating && get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) :

    $star_width = $rating * 20;
    ?>

    <div class="woocommerce-product-rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" title="<?=$rating;?> van 5 sterren">
        <div class="star-container">
            <div class="star-wrap open">
                <div class="star star-open"><?php echo display_icon('fnd-star');?></div>
                <div class="star star-open"><?php echo display_icon('fnd-star');?></div>
                <div class="star star-open"><?php echo display_icon('fnd-star');?></div>
                <div class="star star-open"><?php echo display_icon('fnd-star');?></div>
                <div class="star star-open"><?php echo display_icon('fnd-star');?></div>
            </div>
            <div class="star-wrap closed" style="width: <?=$star_width;?>%;">
                <div class="star star-closed"><?php echo display_icon('fnd-star-filled');?></div>
                <div class="star star-closed"><?php echo display_icon('fnd-star-filled');?></div>
                <div class="star star-closed"><?php echo display_icon('fnd-star-filled');?></div>
                <div class="star star-closed"><?php echo display_icon('fnd-star-filled');?></div>
                <div class="star star-closed"><?php echo display_icon('fnd-star-filled');?></div>
            </div>
        </div>
        <span> <strong itemprop="ratingValue"><?php echo esc_attr( $rating ); ?></strong> van 5</span>

    </div>


<?php endif;
