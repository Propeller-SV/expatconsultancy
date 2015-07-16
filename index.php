<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 */

get_header(); ?>

	<div class="vacancies-content content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="background-color">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<p class="content-text">
					<?php echo get_the_content();?>
				</p>

				<?php endwhile; else: ?>
	<div class="content">
		<p class="content-text">
			<?php _e('Sorry, no posts matched your criteria.'); ?>
		</p>
	</div>
	<?php endif; ?>

<?php get_footer(); ?>