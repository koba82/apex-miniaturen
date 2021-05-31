<?php

    $wrapperClass = get_sub_field('woo-wrap-class');

    if ( WPEX_WOOCOMMERCE_ACTIVE ) :

        $addWrapperClass = '';
        if($wp_query->post->post_content) :
            $str = $wp_query->post->post_content;
            $ar = array('[', ']', '<!-- wp:shortcode -->', '<!-- /wp:shortcode -->', '<p>', '</p>', "\n");
            $addWrapperClass = str_replace($ar, '', $str);
        endif; ?>


        <section class="content-wrap woo-content-wrap <?php getBackgroundColor(); ?> <?=$wrapperClass;?> <?=$addWrapperClass;?>">
            <div class="content woo-content">

                <?php include 'components/header-and-text.php'; ?>

                <?php echo apply_filters('the_content', $wp_query->post->post_content);?>

            </div>
        </section>

    <?php
    endif; ?>

