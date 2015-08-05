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
					<?php while ( have_posts() ) : the_post(); ?>
						<!-- display custom image -->
						<?php $brand = get_post_meta( get_the_id(), 'brand_photo_attachment', true ); ?>
						<img class="img-responsive" src="<?php if ($brand) echo $brand; else echo IMAGES . '/brand-foto.png'; ?>" alt="...">
						<!-- display excerpt -->
						<div class="carousel-caption">
							<h6 class="hidden-sm hidden-md hidden-lg"><?php echo get_the_excerpt();?></h6>
							<h1 class="hidden-xs"><?php echo get_the_excerpt();?></h1>
						</div>
					<?php endwhile;	?>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="background-color content-text">
					<!-- display content -->
					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_content();?>
					<?php endwhile; ?>
<?php get_footer(); ?>