<?php

if( get_sub_field('flex-text-add-image') == 'false'  || ( get_sub_field('flex-text-add-image') == 'true' && get_sub_field('flex-text-column-select') == 'double-column' ) ) : ?>

    <section class="content-wrap block-text <?php getBackgroundColor(); ?> <?php the_sub_field('flex-text-spotlight'); ?>">
        <div class="content">
            <div class="flex-paragraph <?php the_sub_field('flex-text-column-select'); ?> <?php if (get_sub_field('flex-text-icon') !== '-') : echo 'has-icon'; endif;?> ">

                <?php

                if (get_sub_field('icon-select') !== '-') : ?>

                    <div class="icon-wrap medium"><?php echo display_icon(get_sub_field('icon-select')); ?></div>

                <?php endif;

                if(get_sub_field('flex-text-header')): ?> <h2 itemprop="description"> <?php the_sub_field('flex-text-header'); ?> </h2> <?php endif;

                if(get_sub_field('flex-text-block')): the_sub_field('flex-text-block'); endif;
                ?>

            </div>

            <?php if(get_sub_field('flex-text-column-select') == 'double-column') : ?>

                <div class="flex-paragraph <?php the_sub_field('flex-text-column-select'); ?> <?php if (get_sub_field('flex-text-icon') !== '-') : echo 'has-icon'; endif;?> ">

                    <?php

                    if (get_sub_field('icon-select-2') !== '-') : ?>

                        <div class="icon-wrap medium"><?php echo display_icon(get_sub_field('icon-select-2')); ?></div>

                    <?php endif;

                    if(get_sub_field('flex-text-header-2')): ?> <h2 itemprop="description"> <?php the_sub_field('flex-text-header-2'); ?> </h2> <?php endif;

                    if(get_sub_field('flex-text-block-2')): the_sub_field('flex-text-block-2'); endif;
                    ?>

                </div>
            <?php endif; ?>

        </div>
    </section>

<?php endif;

//Text WITH image
if(get_sub_field('flex-text-add-image') == 'true' ) :

    $image = get_sub_field('flex-text-image');
    $id = rand (9999, 99999);
    ?>
    <section class="content-wrap block-text <?php getBackgroundColor(); ?> <?php the_sub_field('flex-text-spotlight'); ?>" >
        <div class="content <?php the_sub_field('flex-text-image-position'); ?>" >
            <div class="flex-text-image-column text-col" >

                <?php if (get_sub_field('icon-select') !== '-') : ?>

                    <div class="icon-wrap medium"><?php echo display_icon(get_sub_field('icon-select')); ?></div>

                <?php endif; ?>

                <div class="flex-paragraph">
                    <?php
                    if(get_sub_field('flex-text-header')): ?>
                        <h2 itemprop="description"><?php the_sub_field('flex-text-header'); ?></h2>
                    <?php endif; the_sub_field('flex-text-block'); ?>
                </div>
            </div>

            <div class="flex-text-image-column image-col">

                <?php
                $component['context'] = 'gallery-image';
                $component['image'] = $image;

                get_template_part('/blocks/components/content-image', 'content-image', $component);
                ?>

            </div>
        </div>

        <script>
            window.addEventListener('load', function () {
                $('a[data-lightbox-id="<?php echo $id; ?>"]').simpleLightbox();
            });

        </script>
    </section>

<?php

endif;
