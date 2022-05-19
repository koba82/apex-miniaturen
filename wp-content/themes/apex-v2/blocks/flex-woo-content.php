<?php

    $wrapperClass = (get_sub_field('woo-wrap-class')) ?: '';

    get_template_part('/blocks/components/header-and-text');

    if ( WPEX_WOOCOMMERCE_ACTIVE ) :

        $addWrapperClass = '';
        if($wp_query->post->post_content) :
            $str = $wp_query->post->post_content;
            $ar = array('[', ']', '<!-- wp:shortcode -->', '<!-- /wp:shortcode -->', '<p>', '</p>', "\n");
            $addWrapperClass = str_replace($ar, '', $str);
        endif;

        echo ($wrapperClass) ? "<div class='$wrapperClass'>" : '';
        echo apply_filters('the_content', $wp_query->post->post_content);
        echo ($wrapperClass) ? "</div>" : '';


    endif;

