<?php

    $component = ($args) ? $args : '';
    $repeater_field = ($component['button-repeater-field'])?: 'button-repeater';

    if( have_rows($repeater_field) ): ?>

        <div class="button-container">

            <?php while ( have_rows($repeater_field) ) : the_row();

                $args = get_sub_field('button-group');

                get_template_part('/blocks/components/button', NULL, $args);

            endwhile; ?>

        </div>

    <?php endif;
