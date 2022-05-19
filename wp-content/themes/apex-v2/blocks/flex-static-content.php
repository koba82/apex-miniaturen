<?php

    $staticID = get_sub_field('content');

	if( have_rows('flex', $staticID) ):
        while ( have_rows('flex', $staticID) ) : the_row();

			$row_layout = get_row_layout();

			$flex_options = get_sub_field('flex-options');
			$flex_options['context'] = 'static-content';

			if( validateFlexItem($flex_options) ) :

                get_template_part('/blocks/components/block-header', NULL, $flex_options);

                get_template_part('/blocks/' . $row_layout, NULL, $flex_options);

                get_template_part('/blocks/components/block-footer', NULL, $flex_options);

			endif;

		endwhile;
	endif;


