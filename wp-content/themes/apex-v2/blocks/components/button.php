<?php
    $icon;
    $link;

    if( $args['icon-select'] !== '-' && $args['icon-select'] !== '' && $args['icon-select'] ) :
        $icon = $args['icon-select'];
    else :
        $icon = false;
    endif;

    if($args['button-link-type'] == 'no-link') :
        $link = false;
    else :
        if($args['button-link-type'] == 'internal') :
            $link = $args['button-internal-link'];
        elseif ($args['button-link-type'] == 'external') :
            $link = $args['button-external-link'];
        else :
            $link = $args['button-file-link'];
        endif;
    endif;

    $icon_button = ($args['button-text']) ? '' : 'icon-only-button';

    echo ($link) ? '<a href="' . $link . '" class="button ' . $args['button-type'] . ' ' . $icon_button . '">' : '<div class="button ' . $args['button-type'] . ' ' . $icon_button . '">';
    if($icon) : ?><span class="icon-wrap small"><?php echo display_icon($args['icon-select']);?></span><?php endif; ?>

    <?php if($args['button-text']) : ?>
        <span class="cta-text"><?=$args['button-text']; ?></span>
    <?php endif; ?>

    <?php echo ($link) ? '</a>' : '</div>';

