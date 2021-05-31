<?php

    $staticID = get_sub_field('content');

	if( have_rows('flex', $staticID) ):
        while ( have_rows('flex', $staticID) ) : the_row();
			
			$row_layout = get_row_layout();
		
			if( validateFlexItem(get_sub_field('flex-options')) ) :
		
				get_template_part('/blocks/' . $row_layout);
		
			endif;

		endwhile;
	endif;
