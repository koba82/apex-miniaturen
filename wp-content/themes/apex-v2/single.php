<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div>
		<div>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>



			<?php endwhile; ?>

		</div>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>