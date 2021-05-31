<?php
/**
 * Template Name: Standaardpagina
 */

get_header(); ?>
	
<?php
    $page_properties = get_field('seo-options');

    if(!$page_properties['hide-h1']) :

        $args[0] = ($page_properties['h1-text'] !== '') ? $page_properties['h1-text'] : ( ($page_properties['seo-title'] !== '') ? $page_properties['seo-title'] : get_the_title() );

        if($args[0]) :

            get_template_part('/blocks/block-h1', 'h1-headline', $args);

        endif;

    endif;

?>

<main>

    <?php
    get_template_part('acf-flex-content-loop');

    ?>

</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
