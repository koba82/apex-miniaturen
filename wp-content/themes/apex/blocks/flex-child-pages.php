<section class="content-wrap block-child-pages <?php getBackgroundColor(); ?>" >
    <div class="content" >

        <?php if(get_sub_field('flex-title')) : ?>
            <h2><?php the_sub_field('flex-title'); ?></h2>
        <?php endif; ?>
        <?php if(get_sub_field('flex-text')) : ?>
            <div class="child-pages-intro"><?php the_sub_field('flex-text'); ?></div>
        <?php endif; ?>

        <div class="flex-cta flex-child-pages">
            <?php
            $childPages = get_pages( array( 'child_of' => $post->ID, 'sort_column' => 'menu_order', 'sort_order' => 'desc' ) );

            foreach( $childPages as $page ) :

                $content = $page->post_content;
                $content = apply_filters( 'the_content', $content ); 	?>

                <div class="flex-cta-button-wrap child-page-wrap">

                    <a href="<?php echo get_page_link( $page->ID ); ?>" class="button flex-cta-button large-button">
                        <?php echo $page->post_title; ?>
                    </a>

                </div>

            <?php
            endforeach; ?>
        </div>
    </div>
</section>