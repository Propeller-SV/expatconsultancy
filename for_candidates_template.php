<?php
/**
 * Template name: For Candidates Page
 */
?>

<?php get_header(); ?>
<div class="forcandidates-content content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="background-color content-text">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile;	?>
					<?php $doc = get_post_meta(get_the_ID(), 'expat_doc_attachment', true); ?>
					<?php if (isset($doc[1])): ?>
						<ol>
						<?php for ($i=1; $i < count($doc); $i++): ?>
							<?php $filename = pathinfo($doc[$i]['file'])['filename']; ?>
							<?php $extension = pathinfo($doc[$i]['file'])['extension']; ?>
							<?php $url = $doc[$i]['url']; ?>
								<li>
									<p><?php echo $filename . '&nbsp; &nbsp; &nbsp;' . $extension . __(' file ', 'expatconsultany'); ?><a href="<?php echo $url; ?>" role="button"><?php _e('Download', 'expatconsultany') ?></a></p>
								</li>
						<?php endfor; ?>
						</ol>
					<?php endif; ?>
<?php get_footer(); ?>