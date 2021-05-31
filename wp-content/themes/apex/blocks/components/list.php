<?php

    $list = get_sub_field('list-group');

        echo ($list['list-numbered']) ? '<ol class="usp-list" start="' . $list['list-start-int'] . '">' : '<ul class="usp-list">';

        foreach($list['list-repeater'] as $list_item) :

            if($list['list-numbered']) : ?>
                <li><span class='usp-text'><?=$list_item['list-item']; ?></span></li>
            <?php else :
                $usp_icon = ($list_item['icon-select']) ? '<span class="icon-wrap small">' . display_icon($list_item['icon-select']) . '</span>' : '';?>
                <li><?=$usp_icon;?><span class='usp-text'><?=$list_item['list-item']; ?></span></li>
            <?php endif;
        endforeach;

        echo ($list['numbered']) ? '</ol>' : '</ul>';