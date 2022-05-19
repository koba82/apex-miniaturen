<?php
/************************************
 *  flex-button
 ***********************************/

        $args['button-repeater-field'] = get_field('button-repeater');

?>

        <?php get_template_part('/blocks/components/header-and-text'); ?>

        <?php get_template_part('/blocks/components/button-group', NULL, $args); ?>
