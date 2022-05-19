<?php
if(get_field('module-occasions', 'option') == 'true' ) {
/**
 * Template Name: Module: Occasions
 */
};


get_header(); ?>

<div class="content-wrapper" role="main">
	<?php the_field('module-occasions', 'option'); ?>	
<div class="content content-width h1-headline">
	<h1 itemprop="headline"><?php the_field('h1-text'); ?></h1>
</div>

<?php get_template_part('acf-flex-content-loop'); ?>




<div class="content content-width">
<?php
if(get_field('module-occasions', 'option') == 'true' ) {

	$args = array( 'post_type' => 'occasions', 'posts_per_page' => 10 );
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post();
	  the_title();
	  echo '<br>';
	endwhile;
};
	?>

</div>

<div class="clear"></div>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
