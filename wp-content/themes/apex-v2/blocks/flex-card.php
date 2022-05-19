<?php

$number_of_cards = count(get_sub_field('card-flex'));
$attr_bgc_value = get_sub_field('flex-card-bgc-select');
$slider = get_sub_field('display-as-slider');
$slider_class = ($slider) ? 'flex-slider slider-' . $args['uid'] : '';

get_template_part('/blocks/components/header-and-text'); ?>

<div class="flex-cta card-container <?=$slider_class?> " data-cards="<?=$number_of_cards;?>"/>

    <?php
    if( have_rows('card-flex') ) : while( have_rows('card-flex') ) : the_row();
        if(get_row_layout() === 'card-item') :
            while ( have_rows('card-group') ) : the_row();

                $card_link_type = get_sub_field('flex-cta-type');
                $attr_bgc_value = get_sub_field('flex-card-bgc-select');

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

                    <div class="card <?=$attr_bgc;?> <?=$attr_bgc_value; ?> <?=$attr_bg_img;?>">

                <?php endif;

                if($attr_bg_img == 'has-bg-img') :
                    $image = get_sub_field('flex-cta-bg-image'); ?>

                    <div class="flex-cta-bg-image">
                        <img src="<?=$image['sizes']['front-end-thumb']; ?>" alt="<?=$image['alt']; ?>" />
                    </div>

                <?php endif;

                while ( have_rows('flex-cta-object') ) : the_row();

                    if( get_row_layout() == 'icon' ): ?>

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

                    <?php  endif;
                endwhile;

                echo ($card_link) ? "</a>" : "</div>";

            endwhile;
        endif;
    endwhile; endif;?>
</div>

<?php if($slider) : ?>
    <script>
        (function() {
            window.addEventListener('load', function () {
                if(!document.querySelector('.slider-<?=$args['uid']; ?>')) return;

                <?php $options = get_sub_field('slider-options');
                $op = $options['slider-options'];?>

                var elem<?=$args['uid']; ?> = document.querySelector('.slider-<?=$args['uid']; ?>');
                var flkty<?=$args['uid']; ?> = new Flickity( elem<?=$args['uid']; ?>, {
                    cellAlign: '<?=$op['cellAlign']?>',
                    contain: false,
                    percentPosition: false,
                    freeScroll: <?php echo ($op['freeScroll']) ? 'true' : 'false';?>,
                    wrapAround: <?php echo ($op['wrapAround']) ? 'true' : 'false';?>,
                    autoPlay: <?php echo ($op['autoPlay'] == false) ? false : $op['autoPlay'] ?>,
                    pageDots: <?php echo ($op['pageDots']) ? 'true' : 'false';?>,
                    prevNextButtons: <?php echo ($op['prevNextButtons']) ? 'true' : 'false';?>,
                    groupCells: <?=$op['groupCells']?>,
                    arrowShape: {
                        x0: 10,
                        x1: 60, y1: 50,
                        x2: 60, y2: 50,
                        x3: 60
                    }
                });
            });
        })();
    </script>
<?php endif; ?>
