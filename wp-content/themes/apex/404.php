<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>


<?php
    $args[0] = 'Pagina niet gevonden';
    get_template_part('/blocks/block-h1', 'h1-headline', $args);
?>

<main>

<section class="content-wrap c-flex-text no-bgc">
	<div class="content">
		<p style="display:block; text-align: center; margin: 50px 0px;">De pagina kan niet worden gevonden</p>
	</div>
</section>


<!-- /content-wrapper -->
</main><!-- /content-wrapper -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
