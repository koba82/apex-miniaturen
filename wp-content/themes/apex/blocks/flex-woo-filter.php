<?php
//echo '<pre>';
//var_dump(get_sub_field('filter'));
//echo '</pre>';


$filter = get_sub_field('filter');

foreach($filter as $fil ) {
    echo '<section class="content-wrap"><div class="content"><a href="' . get_permalink($fil->ID) . '">' . get_the_title($fil->ID) . '</a></div></section>';

}