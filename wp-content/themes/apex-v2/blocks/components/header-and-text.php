<?php

    if(get_sub_field('content-header-text')) :

        $header_and_text = get_sub_field('content-header-text');
        $header_tag = $header_and_text['header-tag'] ?: 'h2';

        if ($header_and_text['icon-select'] !== '-' && $header_and_text['icon-select'] !== '' ) : ?>

            <div class="icon-wrap medium header-icon"><?php echo display_icon($header_and_text['icon-select']); ?></div>

        <?php endif;

        echo ($header_and_text['content-header']) ? '<' . $header_tag . '>' . $header_and_text['content-header'] . '</' . $header_tag . '>' : '';

        echo ($header_and_text['content-text']) ? strip_tags($header_and_text['content-text'], ['<i>', '<b>', '<ul>', '<li>', '<ol>', '<a>', '<p>', '<br>', '<quote>', '<img>']) : '';

    endif; ?>