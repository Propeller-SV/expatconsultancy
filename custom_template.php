<?php
/**
 * Template name: Custom page
 */
?>

<?php get_header(); ?>

<div class="vacancies-content content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="background-color content-text">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile;	?>
<?php get_footer(); ?>