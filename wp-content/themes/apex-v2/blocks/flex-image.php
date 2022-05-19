
<?php

    $image_array = get_sub_field('flex-image-array');
    $id = rand (9999, 99999);
    $type = (get_sub_field('display-type')) ?: 'gallery';
    $component['lightbox'] = get_sub_field('enable-lightbox');

?>

        <?php get_template_part('/blocks/components/header-and-text'); ?>

<?php if($type === 'gallery') : ?>

        <div class="content-image-group-wrap" data-images="<?php echo count($image_array) ?>">
            <?php if($image_array) :
                foreach($image_array as $image) :

                    $component['context'] = 'gallery-image';
                    $component['image'] = $image;
                    $component['lightbox-id'] = $id;

                    get_template_part('/blocks/components/content-image', 'content-image', $component);

                endforeach;
            endif;
            ?>
        </div>

<?php elseif($type === 'slider') : ?>
    <div class="flex-gallery large-slider slider-<?=$id; ?>">
        <?php if($image_array) :
            foreach($image_array as $image) :

                $component['context'] = 'gallery-image';
                $component['image'] = $image;
                $component['lightbox-id'] = $id;
                $component['image-size'] = 'main-image-size';

                get_template_part('/blocks/components/content-image', 'content-image', $component);

             endforeach;
        endif; ?>
    </div>

<?php elseif($type === 'thumbnail-slider') : ?>

    <div class="flex-gallery slider-<?=$id; ?>">
        <?php if($image_array) :
            foreach($image_array as $image) :

                $component['context'] = 'gallery-image';
                $component['image'] = $image;
                $component['lightbox-id'] = $id;
                $component['image-size'] = 'image-560';

                get_template_part('/blocks/components/content-image', 'content-image', $component);

            endforeach;
        endif; ?>
    </div>

<?php endif; ?>

    <script>
        (function() {
            window.addEventListener('load', function () {
                if(!document.querySelector('.slider-<?=$id; ?>')) return;

                <?php $options = get_sub_field('slider-options');
                $op = $options['slider-options'];?>

                var elem<?=$id; ?> = document.querySelector('.slider-<?=$id; ?>');
                var flkty<?=$id; ?> = new Flickity( elem<?=$id; ?>, {
                    cellAlign: '<?=$op['cellAlign']?>',
                    contain: false,
                    percentPosition: false,
                    freeScroll: <?php echo ($op['freeScroll']) ? 'true' : 'false';?>,
                    wrapAround: <?php echo ($op['wrapAround']) ? 'true' : 'false';?>,
                    autoPlay: <?=$op['autoPlay']?>,
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

        (function() {
            window.addEventListener('load', function () {
                let options = {
                    animationSlide: true,
                    animationSpeed: 50,
                    alertErrorMessage: 'De afbeelding is niet gevonden, de volgende afbeelding wordt geladen.',
                }

                jQuery('a[data-lightbox-id="<?php echo $id; ?>"]').simpleLightbox(options);
            });
        })();
    </script>
