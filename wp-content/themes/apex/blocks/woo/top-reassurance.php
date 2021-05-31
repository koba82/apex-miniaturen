<?php

    if(get_field('woo-set-top-reassurance', 'option')) : ?>

        <div class="top-reassurance-bar">
            <div class="top-reassurance-bar-inner">

                <?php while( have_rows('woo-set-top-reassurance', 'option')) : the_row(); ?>

                    <div class="reassurance-item">
                        <?php if(get_sub_field('icon-select')) : ?>
                            <span class="icon-wrap small"><?php echo display_icon(get_sub_field('icon-select'));?></span>
                        <?php endif; ?>

                        <?php if(get_sub_field('text')) : ?>
                            <span class="reassurance-text"><?php the_sub_field('text'); ?></span>
                        <?php endif; ?>
                    </div>

                <?php endwhile; ?>

                <?php get_template_part('nav-top'); ?>

            </div>
        </div>

    <?php endif;
