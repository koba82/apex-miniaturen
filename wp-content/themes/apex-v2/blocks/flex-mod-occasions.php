<div class="content-block <?php getBackgroundColor(); ?>" >
    <div class="content c-flex-mod-occ-overview" >
        
        <?php $loop = new WP_Query( array( 'post_type' => 'occasions' ) ); ?>

        <?php while ( $loop->have_posts() ) : $loop->the_post(); 
            
            $mod_occ_img_gallery = get_field('mod-occ-img');
            $mod_occ_img = $mod_occ_img_gallery[1];
            ?>
            <a href="<?php the_permalink(); ?>">
                <div class="mod-occ-overview-block">
                    <div class="mod-occ-overview-img">
                        <img src="<?=$mod_occ_img['sizes']['image-gallery-thumbnail-size']; ?>">
                    </div>
                    <div class="mod-occ-overview-title">
                        <?php the_field('mod-occ-brand'); ?> <?php the_field('mod-occ-type'); ?>
                    </div>
                </div>
            </a>
            
            
            
        <?php endwhile; ?>
            
    </div>
</div>