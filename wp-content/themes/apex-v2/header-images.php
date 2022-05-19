<?php

	//Check if this page is a real estate page
	if ( ( get_post_type() == 'real-estate' ) || ( get_post_type() == 'occasions' ) ) : 
		get_template_part('modules/module-real-estate/header-module-real-estate');		
	else :
	
	// Images from the current page have precedence over the images from the options page
	$img = [];

	if(get_field('page-header-images')) :
        $img[] = get_field('page-header-images');
	else :
        $img = get_field('header-images', 'options');
	endif;

	//If there's only one image, display a static image. If more than one image, create a flickity slider
	if(!$img) : ?>
		<div class="header-images header-background-color"></div>
	<?php	
	elseif( count($img) == 1 ) :

        $focus_v = get_field('focus-point-v', $img['0']['ID']);
	    $focus_h = get_field('focus-point-h', $img['0']['ID']);
	    ?>

		<div class="header-images">
			<div class="header-image-slider">
				<div class="header-slider-slide">						
					<picture class="header-image" style="background-position: <?=$focus_h?>% <?=$focus_v?>%;">
						<source srcset="<?=$img['0']['sizes']['hero-480']; ?>" media="(max-width: 480px)">
						<source srcset="<?=$img['0']['sizes']['hero-640']; ?>" media="(max-width: 640px)">
						<source srcset="<?=$img['0']['sizes']['hero-770']; ?>" media="(max-width: 770px)">
						<source srcset="<?=$img['0']['sizes']['hero-1280']; ?>" media="(max-width: 1280px)">
						<source srcset="<?=$img['0']['sizes']['hero-1980']; ?>" media="(max-width: 1980px)">
						<source srcset="<?=$img['0']['sizes']['hero-2500']; ?>" media="(max-width: 2900px)">
						<img src="<?=$img['0']['sizes']['hero-480']; ?>" alt="MDN">
					</picture>
						
					
				</div>
			</div>
		</div>
	<?php		
	elseif( count($img) > 1 ):
	//Create random id to avoid inteference with other sliders on the page
	$id = rand (9999, 99999); ?>
		<div class="header-images pos-rel">
			<div class="header-image-slider slider-<?=$id; ?> slider">
			<?php foreach($img as $i) : ?>
				<div class="header-slider-slide">						
					<picture class="header-image">
						<source srcset="<?=$i['sizes']['hero-480']; ?>" media="(max-width: 480px)">
						<source srcset="<?=$i['sizes']['hero-640']; ?>" media="(max-width: 640px)">
						<source srcset="<?=$i['sizes']['hero-770']; ?>" media="(max-width: 770px)">
						<source srcset="<?=$i['sizes']['hero-1280']; ?>" media="(max-width: 1280px)">
						<source srcset="<?=$i['sizes']['hero-1980']; ?>" media="(max-width: 1980px)">
						<source srcset="<?=$i['sizes']['hero-2500']; ?>" media="(max-width: 2900px)">
						<img src="<?=$i['sizes']['hero-480']; ?>" alt="MDN">
					</picture>
				</div>
			<?php endforeach; ?>
			</div>
		</div>

<script>
	window.addEventListener('load', function () {
		var elem<?=$id; ?> = document.querySelector('.slider-<?=$id; ?>');
		var flkty<?=$id; ?> = new Flickity( elem<?=$id; ?>, {
		// options
		cellAlign: 'center',
			contain: true,
			percentPosition: false,
			freeScroll: false,
			wrapAround: true,
			autoPlay: 4000,
			pageDots: false,
			prevNextButtons: false,
			arrowShape: { 
				x0: 10,
				x1: 60, y1: 50,
				x2: 60, y2: 50,
				x3: 60
				}
		});
	});
</script>
    <?php
    endif;
endif; ?>