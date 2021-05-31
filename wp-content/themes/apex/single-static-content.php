<?php
/**
 * Template Name: Static content
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

<?php if ( WPEX_WOOCOMMERCE_ACTIVE ) : ?>

	<?php do_shortcode('aws_search_form'); ?>

	<section class="content-wrap woo-content-wrap">
		<div class="content woo-content">
		</div>	
	</section>

<?php endif; ?>

</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
