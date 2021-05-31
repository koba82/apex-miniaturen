<?php
/**
 * Template Name: Verhuuroverzicht

 */

get_header(); ?>



<?php
//Determine what H1 text we will use. First comes custom H1 field called 'H1 Kop', then 'Paginatitel', then Wordpress page title.
if (get_field('h1-text')) {
    $args[0] = get_field('h1-text');
} elseif (get_field('seo-title')) {
    $args[0] = get_field('seo-title');
} else {
    $args[0] = get_the_title();
};
?>

<?php get_template_part('/blocks/block-h1', 'h1-headline', $args) ?>

<main>

<?php get_template_part('acf-flex-content-loop'); ?>


<div class="content-wrap button-wrap">
		<div class="button filter-button" data-filter="drinks">Dranken en toebehoren</div>
		<div class="button filter-button" data-filter="tables-chairs">Tafels en stoelen</div>
		<div class="button filter-button" data-filter="facility">Overige inrichting</div>
		<div class="button filter-button" data-filter="rent-wrap">Alles tonen</div>
</div>		

<div class="content-wrap rent-overview-wrap">


		
	
	<?php
	
	$args = array(	
		'post_type' => 'verhuur',
		'posts_per_page' => -1, 
		);                                              
	$the_query = new WP_Query( $args );
	
	// The Loop
	if ( $the_query->have_posts() ) :
	  
	    while ( $the_query->have_posts() ) :
	        $the_query->the_post();
	        
	        $rentImg = get_field('rent-image');
	         ?>
	        
	     	<div class="rent-wrap <?php the_field('rent-group');?>">
		     	
		     	<?php if($rentImg) : ?>
		     		<div class="rent-img" style="background: url(<?=$rentImg['sizes']['hero-640'];?>); background-size: cover; background-position: center center">
			    <?php else : ?>
			    	<div class="rent-img default-img">
			    <?php endif;?>
			    
			    </div>
			    <div class="rent-info">
				    <div class="rent-title"><h3><?php the_field('rent-title');?></h3></div>
			     	
			     	<?php if(get_field('rent-price-on-request')): ?>
			     		<div class="rent-price on-request">Prijs op aanvraag</div>
			     	<?php elseif(get_field('rent-price')) : ?>
				    	<div class="rent-price price">&euro; <?php the_field('rent-price'); ?></div>
				    <?php else :
					    endif; 
					?>
			    </div>
			    
			    
	     	</div>
	    
		 	<div 
	    
	    
	    <?php endwhile;
	    
	    wp_reset_postdata();
		    
	endif; 
	
	?>
		
	
</div>
	<script>
		
		$(document).ready(function($) {
		
			$(".filter-button").click(function() {
				
				//Set buttons to active
				$(".filter-button.active").removeClass('active');
				$(this).addClass('active');
				
				let filterProp = '.' + $(this).attr('data-filter');
				
				$(".rent-overview-wrap .hide").removeAttr("style")	;
				$(".rent-overview-wrap .visible").removeClass("visible");
				$(".rent-overview-wrap .hide").removeClass("hide"),
				$(".rent-overview-wrap").children().not(filterProp).addClass("hide");
				$(".rent-overview-wrap").children(filterProp).addClass("visible");
				
				setTimeout(function() {
					$(".rent-overview-wrap .hide").css('display', 'none');
				}, 220);
			
			});		
			
	
		});	
		
	</script>	


</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
