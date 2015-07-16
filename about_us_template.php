<?php
/**
 * Template name: About Us page
 */
?>

<?php get_header(); ?>

<div class="index-content content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="item banner">
					<?php
						while ( have_posts() ) : the_post();
							?>
							<!-- display featured image -->
							<?php $img = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_id()), 'full')[0];?>
							<img class="img-responsive" src="<?php if ($img) echo $img; else echo IMAGES . '/brand-foto.png';?>" alt="...">
							<!-- display excerpt -->
							<div class="carousel-caption">
								<h6 class="hidden-sm hidden-md hidden-lg"><?php echo get_the_excerpt();?> </h6>
								<h1 class="hidden-xs"><?php echo get_the_excerpt();?> </h1>
							</div>
							<?php
						endwhile;
						?>
					</div>
			</div>
			<div class="col-sm-12">
				<div class="background-color">
					<!-- display content -->
					<?php
					while ( have_posts() ) : the_post();
						?><p class="content-text"><?php echo get_the_content();?> </p><?php
					endwhile;
					?>

<?php get_footer(); ?>