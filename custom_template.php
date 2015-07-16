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
				<div class="background-color">
					<?php
					while ( have_posts() ) : the_post();
						?><p class="content-text"><?php echo get_the_content();?> </p><?php
					endwhile;
					?>

<?php get_footer(); ?>