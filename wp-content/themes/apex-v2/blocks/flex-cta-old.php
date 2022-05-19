<?php

    //Count buttons and decide for 1, 2 or 3 buttons per row.
    $number_of_cards = count(get_sub_field('card'));
    $attr_bgc_value = get_sub_field('flex-card-bgc-select');

    get_template_part('/blocks/components/header-and-text');

    if( have_rows('card') ) : ?>

    <div class="flex-cta card-container" data-cards="<?=$number_of_cards;?>">

        <?php while ( have_rows('card') ) : the_row();

        $card_link_type = get_sub_field('flex-cta-type');
        $card_link = false;

        switch($card_link_type) :
            case "internal" :
                $cta_link = get_sub_field('flex-cta-link');
                $open_new_window = false;
                $card_link = true;
                break;
            case "file" :
                $file = get_sub_field('flex-cta-file');
                $cta_link = $file['url'] ;
                $open_new_window = true;
                $card_link = true;
                break;
            case "external" :
                $cta_link = get_sub_field('flex-cta-external-link');
                $open_new_window = true;
                $card_link = true;
                break;
            default:
                $card_link = false;
        endswitch;

        $attr_bg_img = get_sub_field('flex-cta-bg-image') ? 'has-bg-img' : '';
        $attr_target = ($open_new_window) ? 'target="_blank"' : '';

        if($card_link) : ?>
        <a href="<?=$cta_link;?>" <?=$attr_target; ?> class="flex-cta-button-wrap card <?=$attr_bgc_value; ?> <?=$attr_bg_img;?>">
            <?php else : ?>
            <div class="flex-cta-button-wrap card <?=$attr_bgc;?> <?=$attr_bgc_value; ?> <?=$attr_bg_img;?>">
                <?php endif;

                if($attr_bg_img == 'has-bg-img') :
                    $image = get_sub_field('flex-cta-bg-image'); ?>

                    <div class="flex-cta-bg-image">
                        <img src="<?=$image['sizes']['front-end-thumb']; ?>" alt="<?=$image['alt']; ?>" />
                    </div>
                <?php endif;

                if( have_rows('flex-cta-object') ) :

                    while ( have_rows('flex-cta-object') ) : the_row(); ?>

                        <?php if( get_row_layout() == 'icon' ): ?>

                            <div class="icon-wrap large">
                                <?php echo display_icon(get_sub_field('icon-select')); ?>
                            </div>

                        <?php elseif( get_row_layout() == 'text' ): ?>

                            <div class="cta-text">
                                <?php the_sub_field('flex-cta-text'); ?>
                            </div>

                        <?php elseif( get_row_layout() == 'header' ): ?>

                            <h2><?php the_sub_field('header-text'); ?></h2>

                        <?php elseif( get_row_layout() == 'card-image' ):

                            $component['image'] = get_sub_field('image');
                            $component['context'] = 'card';
                            get_template_part('/blocks/components/content-image', 'content-image', $component); ?>

                        <?php elseif( get_row_layout() == 'usp' ): ?>

                            <?php get_template_part('/blocks/components/list'); ?>

                        <?php elseif(  get_row_layout() == 'button' ): ?>

                                <?php $args['button-repeater-field'] = get_field('button-repeater');
                                get_template_part('/blocks/components/button-group', NULL, $args); ?>

                        <?php else :

                        endif;

                    endwhile;
                endif;?>
                <?php
                echo ($card_link) ? "</a>" : "</div>";

                endwhile; ?>
            </div>
            <?php
            endif;?>
