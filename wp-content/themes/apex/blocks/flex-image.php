
<?php

$image_array = get_sub_field('flex-image-array');
$id = rand (9999, 99999); ?>

<section class="content-wrap block-image <?php getBackgroundColor(); ?>" >
    <div class="content" >

        <?php include 'components/header-and-text.php'; ?>

        <div class="content-image-group-wrap">
            <?php if($image_array) :
                foreach($image_array as $image) :

                    $component['context'] = 'gallery-image';
                    $component['image'] = $image;

                    get_template_part('/blocks/components/content-image', 'content-image', $component);

                endforeach;
            endif;
            ?>
        </div>
    </div>

    <script>
        window.addEventListener('load', function () {

            jQuery("a[data-lightbox-id=<?php echo $id; ?>] > img").each(function() {
                let imageHeight = $(this).height();
                let imageWidth = $(this).width();

                let imageMode = (imageHeight > imageWidth) ? 'portrait' : 'landscape';

                $(this).parent().parent().addClass(imageMode);
            });

            $('a[data-lightbox-id="<?php echo $id; ?>"]').simpleLightbox();

        });
    </script>
</section>