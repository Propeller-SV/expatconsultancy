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
				<div class="background-color">
					<?php
					while ( have_posts() ) : the_post();
						?><p class="content-text"><?php echo get_the_content();?> </p>
							<ol>
								<?php $doc = get_post_meta(get_the_ID(), 'expat_doc_attachment', true); ?>
								<?php
									if (isset($doc[1])) {
										for ($i=1; $i < count($doc); $i++) {
											$filename = pathinfo($doc[$i]['file'])['filename'];
											$extension = pathinfo($doc[$i]['file'])['extension'];
											$url = $doc[$i]['url'];
											?>
												<li>
													<p><?php echo $filename . '&nbsp; &nbsp; &nbsp;' . $extension . __(' file ', 'expatconsultany'); ?><a href="<?php echo $url; ?>" role="button"><?php _e('Download', 'expatconsultany') ?></a></p>
												</li>
											<?php
										}
									}
								?>
							</ol><?php
					endwhile;
					?>

<?php get_footer(); ?>