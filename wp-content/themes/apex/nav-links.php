<?php 
	
$top_nav_links = get_field('top-nav-links', 'option');

if($top_nav_links) :

	echo '<div class="nav-top"><ul>';

	foreach($top_nav_links as $link) :
	
		$link_url;
		
		if( $link['link'] == 'internal' ) :
			$link_url = $link['internal-link'];
		elseif( $link['link'] == 'external' ) :
			$link_url = $link['external-link'];
		else :
			$link_url = $link['file'];
		endif;
		
		$link_content;
		
		
		if( $link['link-type'] == 'text' ) :
			$link_content = $link['name'];
		else: 
			$link_content = "<span data-icon='&#" . $link['icon'] . ";'></span>";
		endif;
		
		?>
	
		<li>
			<a href="<?=$link_url; ?>"><?=$link_content; ?></a>
		</li>
	
	<?php
	endforeach;
	
	echo '</ul></div>';
	
endif;