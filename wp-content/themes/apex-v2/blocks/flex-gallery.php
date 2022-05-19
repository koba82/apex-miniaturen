<?php

$gallery_type = get_sub_field('flex-gallery-type'); ?>

        <?php include 'components/header-and-text.php';

        $id = rand (9999, 99999);

        $gallery_images = get_sub_field('flex-gallery-images');
        if( $gallery_images && $gallery_type == 'slider' ): ?>
            <div class="flex-gallery slider-<?=$id; ?>">
                <?php
                foreach( $gallery_images as $image ):

                    $component['context'] = 'gallery-image';
                    $component['image'] = $image;
                    $component['caption'] = false;
                    $component['lightbox-id'] = $id;
                    $component['image-size'] = 'image-560';

                    get_template_part('/blocks/components/content-image', 'content-image', $component);

                endforeach; ?>
                <span class="stretch"></span>
            </div>
            <script>
                window.addEventListener('load', function () {

                    $('a[data-lightbox-id="<?php echo $id; ?>"]').simpleLightbox();

                    var elem<?=$id; ?> = document.querySelector('.slider-<?=$id; ?>');
                    var flkty<?=$id; ?> = new Flickity( elem<?=$id; ?>, {
                        // options
                        cellAlign: 'left',
                        contain: false,
                        percentPosition: false,
                        freeScroll: true,
                        wrapAround: false,
                        autoPlay: false,
                        pageDots: false,
                        prevNextButtons: true,
                        groupCells: 3,
                        arrowShape: {
                            x0: 10,
                            x1: 60, y1: 50,
                            x2: 60, y2: 50,
                            x3: 60
                        }
                    });
                });
            </script>
        <?php
        endif;

        if( $gallery_images && $gallery_type == 'gallery' ): ?>
            <div class="flex-gallery-album">
                <?php
                foreach( $gallery_images as $image ):

                    $component['context'] = 'gallery-image';
                    $component['image'] = $image;
                    $component['caption'] = false;
                    $component['lightbox-id'] = $id;

                    get_template_part('/blocks/components/content-image', 'content-image', $component);

                endforeach; ?>
                <span class="stretch"></span>
            </div>
            <script>
                window.addEventListener('load', function () {

                    $('a[data-lightbox-id="<?php echo $id; ?>"]').simpleLightbox();

                });
            </script>
        <?php
        endif;?>