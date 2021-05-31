<?php
    $group_field = ($args['group-field']) ? $args['group-field'] : 'button-group';
    $button = get_sub_field($group_field);
    $icon = $button['icon-select'] ? $button['icon-select'] : false;
    $link;

    if($button['button-link-type'] == 'no-link') :
        $link = false;
    else :
        if($button['button-link-type'] == 'internal') :
            $link = $button['button-internal-link'];
        elseif ($button['button-link-type'] == 'external') :
            $link = $button['button-external-link'];
        else :
            $link = $button['button-file-link'];
        endif;
    endif;

    echo ($link) ? '<a href="' . $link . '" class="button ' . $button['button-type'] . '">' : '<div class="button ' . $button['button-type'] . '">';
    if($button['icon-select'] !== '-') : ?><span class="icon-wrap small"><?php echo display_icon($button['icon-select']);?></span><?php endif; ?>
        <span class="cta-text"><?=$button['button-text']; ?></span>
    <?php echo ($link) ? '</a>' : '</div>';

