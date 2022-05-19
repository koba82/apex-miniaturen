<?php

    if($args['context'] == 'main-content' && get_row_layout() !== 'flex-static-content') : ?>

        </div></div>

    <?php elseif($args['context'] == 'static-content' && get_row_layout() !== 'flex-static-content' ) : ?>

        </div></div>

    <?php endif; ?>





