<?php

    $component = ($args) ? $args : '';
    $repeater_field = ($component['repeater-field']) ? $component['repeater-field'] : 'button-repeater';

    if( have_rows($repeater_field) ): ?>

        <div class="button-container">

            <?php while ( have_rows($repeater_field) ) : the_row();

                include 'button.php';

            endwhile; ?>

        </div>

    <?php endif;
