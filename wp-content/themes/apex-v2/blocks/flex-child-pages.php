<?php
/************************************
 *  flex-child-pages
 ***********************************/
 ?>

<?php if(get_sub_field('flex-title')) : ?>
    <h2><?php the_sub_field('flex-title'); ?></h2>
<?php endif; ?>
<?php if(get_sub_field('flex-text')) : ?>
    <div class="child-pages-intro"><?php the_sub_field('flex-text'); ?></div>
<?php endif; ?>

<div class="flex-child-pages">
    <div class="button-container">
    <?php
    $childPages = get_pages( array( 'child_of' => $post->ID, 'sort_column' => 'menu_order', 'sort_order' => 'desc' ) );
    $icon = get_sub_field('icon-select');
    $open_close = get_sub_field('open-closed');

    foreach( $childPages as $page ) :

        $content = $page->post_content;
        $content = apply_filters( 'the_content', $content );

        $args = [
                    "icon-select"           => $icon,
                    "button-text"           => $page->post_title,
                    "button-link-type"      => "internal",
                    "button-type"           => $open_close,
                    "button-internal-link"  => get_page_link( $page->ID ),
                    "button-external-link"  => "",
                    "button-file-link"      => ""
            ];

            get_template_part('/blocks/components/button', NULL, $args); ?>
    <?php
    endforeach; ?>
    </div>
</div>