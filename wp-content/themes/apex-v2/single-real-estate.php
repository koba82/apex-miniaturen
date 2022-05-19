<?php

get_header(); ?>

<div class="content-wrapper mod-res" role="main">
		
<div class="content content-width h1-headline">
	<h1 itemprop="headline"><?php the_field('mod-res-adres'); ?></h1>
	<span class="mr-head mr-post"><?php the_field('mod-res-postcode'); ?></span><span class="mr-head mr-plaa"><?php the_field('mod-res-plaats'); ?></span><br>
	<span class="mr-head mr-vraa"><?php the_field('mod-res-vraagprijs'); ?></span>
</div>

<?php
	$slider_id = rand (9999, 99999); ?>
		<div class="content-block">
			<div class="content content-width block-slider -image-slider">
				<div class="mod-res-top-wrap">
				<?php $slider_id = rand (9999, 99999); ?>
				<div class="flex-image-slider">
					<div class="flex-slider" id="owl-carousel-<?php echo $slider_id; ?>">
						
						<?php
						$gallery_images = get_field('mod-res-img');
						if( $gallery_images ): 
							
							foreach( $gallery_images as $gallery_single_image ):
								echo '<div class="flex-slider-slide">';
								?>
								
								<img src="<?php echo $gallery_single_image['sizes']['slider-image-size']; ?>" alt="<?php echo $gallery_single_image['alt']; ?>" />
								<a href="<?php echo $gallery_single_image['sizes']['main-image-size']; ?>" data-imagelightbox="g">
									<div class="content-image-overlay">	
										<div class="content-image-enlarge-icon">
											<div class="icon-plus"></div>
										</div>
									</div>
								</a>
								<?php
								echo '</div>';
								//end actual slides
							endforeach;
						endif; ?>
						
				
			</div>	
			<script>
				
			
			$(document).ready(function() {
			  $("#owl-carousel-<?php echo $slider_id; ?>").owlCarousel({
		    
			  navigation : true,
			  slideSpeed : 100,
			  paginationSpeed : 400, 
			  singleItem : true,
			  autoPlay: true,
			  rewindSpeed: 300,
			  lazyLoad: true,
			  // "singleItem:true" is a shortcut for:
			  // items : 1, 
			  // itemsDesktop : false,
			  // itemsDesktopSmall : false,
			  // itemsTablet: false,
			  // itemsMobile : false
		    
			  });
			});
	  		</script>
				</div>

			<div class="mod-res-specs-wrap">
				<div class="mod-res-specs-block mr-block-1">
					<h3>Hoofdkenmerken</h3>
					<span class="mod-res-spec mr-aang">Aangeboden sinds</span><span class="mod-res-value mr-aang"><?php the_field('mod-res-aangeboden-sinds'); ?></span>
					<span class="mod-res-spec mr-stat">Status</span><span class="mod-res-value mr-stat"><?php the_field('mod-res-status'); ?></span>
					<span class="mod-res-spec mr-type">Type</span><span class="mod-res-value mr-type"><?php the_field('mod-res-type'); ?></span>
					<span class="mod-res-spec mr-bouw">Bouwjaar</span><span class="mod-res-value mr-bouw"><?php the_field('mod-res-bouwjaar'); ?></span>

				</div>
				<div class="clear"></div>

			</div>
		</div><div class="clear"></div>
	</div><div class="clear"></div>
</div>

<div class="content-block">
	<div class="content content-width">
		<div class="mod-res-specs-wrap">
				<div class="mod-res-specs-block mr-block-2">
					<h3>Energie</h3>
					<?php $res_el = get_field('mod-res-energie-label'); ?>
					<span class="mod-res-spec mr-ener">Energielabel</span><span class="mod-res-value mr-ener el-<?php echo $res_el; ?>"><?php the_field('mod-res-energie-label'); ?></span>
					<span class="mod-res-spec mr-isol">Isolatie</span><span class="mod-res-value mr-isol"><?php the_field('mod-res-isolatie'); ?></span>
					<span class="mod-res-spec mr-verw">Verwarming</span><span class="mod-res-value mr-verw"><?php the_field('mod-res-verwarming'); ?></span>
					<span class="mod-res-spec mr-warm">Warm water</span><span class="mod-res-value mr-warm"><?php the_field('mod-res-warm-water'); ?></span>
					<span class="mod-res-spec mr-cvke">CV-Ketel</span><span class="mod-res-value mr-cvke"><?php the_field('mod-res-cv-ketel'); ?></span>
		
				</div>
			<div class="clear"></div>
		</div>
	</div>
</div>


<?php // GOOGLE MAPS
$marker_address = get_field('mod-res-adres') . ', ' . get_field('mod-res-plaats'); ?>

			
	<div class="content-block"><div class="google-maps-wrap maps-full-width">
		<div id="map"></div>
			<script>
				function initMap() {
					var lat = "";
					var lng = "";
					var x = new XMLHttpRequest();
						
						//Get address from user and convert it to url friendly format, then construct the URL
						var addressString = "<?php echo $marker_address; ?>";
						addressString = encodeURIComponent(addressString.trim());
						var geocodeUrl = "https://maps.googleapis.com/maps/api/geocode/xml?address=" + addressString;
						
						x.open("GET", geocodeUrl, true);
						
						x.onreadystatechange = function () {
							if (x.readyState == 4 && x.status == 200)
								{
									//Get the latitude and longitude from the XML file
									var doc = x.responseXML;
									lat = doc.getElementsByTagName("lat")[0].textContent;
									lng = doc.getElementsByTagName("lng")[0].textContent;
										
									//Put the map otions in an array
									var mapOptions = {
										center: new google.maps.LatLng(lat,lng),
										zoom: 18,
										scrollWheel: false,
										mapTypeId: google.maps.MapTypeId.ROADMAP
									};
										
									//Create the map 
									var map = new google.maps.Map(document.getElementById("map"), mapOptions);   
									var image = {
										url : '<?php echo get_template_directory_uri(); ?>/img/maps-marker.svg',
										size: new google.maps.Size(42, 54),
									};
									map.setOptions({'scrollwheel': false});
									var myLatLng = new google.maps.LatLng(lat,lng);
									var mapsMarker = new google.maps.Marker({
										position: myLatLng,
										map: map,
									//label: 'This is a test',
										icon: image
										});
											
									}
							};
							
							x.send(null);
					}   
					
					  
				</script>
				
				<script async defer
					src="https://maps.googleapis.com/maps/api/js?key=<?php the_field('google_maps_api_key', 'option'); ?>&callback=initMap&language=nl">
				</script>
			</div>
		</div>


<?php get_template_part('acf-flex-content-loop'); ?>


<div class="clear"></div>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
