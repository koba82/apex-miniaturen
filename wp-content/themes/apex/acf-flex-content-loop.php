
<?php

	if( have_rows('flex') ):

		while ( have_rows('flex') ) : the_row();

			if( validateFlexItem(get_sub_field('flex-options')) ) :

				get_template_part('/blocks/' . get_row_layout() );

			endif;

		endwhile;

	endif;