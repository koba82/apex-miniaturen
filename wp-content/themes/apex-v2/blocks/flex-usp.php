<?php
$usp_header = get_sub_field('flex-usp-header');
$usp_cta_link = get_sub_field('flex-usp-cta-link'); ?>

        <?php get_template_part('/blocks/components/header-and-text'); ?>

        <div class="usp-content-wrap">

            <?php get_template_part('/blocks/components/list'); ?>

        </div>

        <?php $args['button-repeater-field'] = get_field('button-repeater'); ?>

        <?php get_template_part('/blocks/components/button-group', 'button-group', $args); ?>

