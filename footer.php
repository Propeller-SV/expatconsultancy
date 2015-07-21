					<div class="footer-content background-color text-center">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo"><?php if (strpos(strtolower(get_bloginfo( 'name' )), 'expatconsultancy') !== false) echo 'EXPAT<span>CONSULT</span>ANCY.com'; else bloginfo( 'name' ); ?></a>
						<p><?php _e('Copyright', 'expatconsultany'); ?> &#169; <?php the_time( 'Y' ); ?> <?php if (strpos(strtolower(get_bloginfo( 'name' )), 'expatconsultancy') !== false) echo '<span>EXPATCONSULTANCY.com</span>'; else bloginfo( 'name' ); ?> <?php _e('Designed by', 'expatconsultany') ?> Fractal Soft.Com</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>
