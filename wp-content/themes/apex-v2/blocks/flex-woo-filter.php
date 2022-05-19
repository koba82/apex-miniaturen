<?php

$filter = get_sub_field('filter');
var_dump(get_sub_field('test-taxonomy'));
?>

<div class="products columns-4">

<?php

    foreach($filter as $fil ) :

        $post_object = get_post( $fil->ID );
        setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
        wc_get_template_part( 'content', 'product' );


    endforeach;
    ?>

</div>


<?php
$slider_id = rand (9999, 99999);
$id = rand (9999, 99999);
$slider_autoplay = get_sub_field('slider-autoplay');
if($slider_autoplay): $slider_autoplay_string = 'true'; else: $slider_autoplay_string = 'false'; endif;
$slider_interval = get_sub_field('slider-interval') * 100;
?>

<?php get_template_part('/blocks/components/header-and-text'); ?>

<div class="flex-content-slider flex-slider flex-slider-<?php echo $slider_id; ?>">

    <?php
    if ( have_rows( 'flex-slider-slides' ) ) :
        while ( have_rows( 'flex-slider-slides' ) ) : the_row();
            if( get_row_layout() == 'the-slides' ): ?>
                <div class="flex-slider-slide">
                    <div class="flex-slider-content">
                        <q><?php the_sub_field( 'the-slide-text' ); ?></q>
                        <br><strong><?php the_sub_field( 'the-slide-text2'); ?></strong>
                    </div>
                </div>
            <?php endif;
        endwhile;
    endif;
    ?>

    <script>
        window.addEventListener('load', function () {

            growToTallestElement('.flex-slider-<?=$slider_id; ?> .flex-slide-content','.flex-slider-<?=$slider_id; ?> .flickity-slider');

            var elem<?=$id; ?> = document.querySelector('.flex-slider-<?php echo $slider_id; ?>');
            var flkty<?=$id; ?> = new Flickity( elem<?=$id; ?>, {
                // options
                cellAlign: 'center',
                contain: true,
                freeScroll: false,
                wrapAround: true,
                autoPlay: true,
                pageDots: true,
                prevNextButtons: true,
                arrowShape: {
                    x0: 10,
                    x1: 60, y1: 50,
                    x2: 60, y2: 50,
                    x3: 60
                }
            });
        });
    </script>


</div>
