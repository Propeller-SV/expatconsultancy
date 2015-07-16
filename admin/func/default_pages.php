<?php
/**
 * ----------------------------------------------------------------------------------------
 * Create pages and insert into database
 * ----------------------------------------------------------------------------------------
 */
function addThisPage() {

	// add about_us page
	$page_about_us = array(
		'post_title'	=> 'About Us',
		'post_status'	=> 'publish',
		'post_type'		=> 'page',
		'post_excerpt'	=> 'Consulting interior resources',
		'post_content'	=> 'This is Photoshop\'s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.',
		'menu_order'	=> 1
		);
	$page_about_us_exists = get_page_by_title( $page_about_us['post_title'] );

	if( ! $page_about_us_exists) {
		$page_about_us_id = wp_insert_post( $page_about_us );
		if( $page_about_us_id ) {

			// upload and set up the post thumbnail
			$image_url = IMAGES . '/brand-foto.png';
			$upload_dir = wp_upload_dir();
			$image_data = file_get_contents($image_url);
			$filename = basename($image_url);
			if(wp_mkdir_p($upload_dir['path']))
				$file = $upload_dir['path'] . '/' . $filename;
			else
				$file = $upload_dir['basedir'] . '/' . $filename;
			file_put_contents($file, $image_data);

			$wp_filetype = wp_check_filetype($filename, null );
			$attachment = array(
				'post_mime_type'	=> $wp_filetype['type'],
				'post_title'		=> sanitize_file_name($filename),
				'post_content'		=> '',
				'post_status'		=> 'inherit'
			);
			$attach_id = wp_insert_attachment( $attachment, $file, $page_about_us_id );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			wp_update_attachment_metadata( $attach_id, $attach_data );

			set_post_thumbnail( $page_about_us_id, $attach_id );

			// set page template
			update_post_meta( $page_about_us_id, '_wp_page_template', 'about_us_template.php' );

			// Set "static page" as the option
			update_option( 'show_on_front', 'page' );

			// Set the front page ID
			update_option( 'page_on_front', $page_about_us_id );
		}
	}

	// add main pages
	$pages = ['Vacancies', 'For Employer', 'Contacts' ];

	for ($i=0; $i<count($pages); $i++) {
		$new_page = array(
			'post_title'	=> $pages[$i],
			'post_status'	=> 'publish',
			'post_type'		=> 'page',
			'post_content'	=> 'This is Photoshop\'s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.
			This is Photoshop\'s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.

			This is Photoshop\'s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.',
			'menu order' => ($i+2)
			);
		$page_exists = get_page_by_title( $new_page['post_title'] );

		if( !$page_exists ) {
			$page_id = wp_insert_post( $new_page );
			if( $page_id ) {

			// set page template
			update_post_meta( $page_id, '_wp_page_template', 'custom_template.php' );
			}
		}
	}

	// add page For Candaidates
	$page_for_candidates = array(
		'post_title'	=> 'For Candidates',
		'post_status'	=> 'publish',
		'post_type'		=> 'page',
		'post_content'	=> 'This is Photoshop\'s version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet nibh vulputate cursus a sit amet mauris. Morbi accumsan ipsum velit. Nam nec tellus a odio tincidunt auctor a ornare odio. Sed non mauris vitae erat consequat auctor eu in elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris in erat justo. Nullam ac urna eu felis dapibus condimentum sit amet a augue. Sed non neque elit. Sed ut imperdiet nisi. Proin condimentum fermentum nunc. Etiam pharetra, erat sed fermentum feugiat, velit mauris egestas quam, ut aliquam massa nisl quis neque. Suspendisse in orci enim.',
		'menu_order'	=> 5
		);
	$page_for_candidates_exists = get_page_by_title( $page_for_candidates['post_title'] );

	if( ! $page_for_candidates_exists) {
		$page_for_candidates_id = wp_insert_post( $page_for_candidates );
		if( $page_for_candidates_id ) {

			// set page template
			update_post_meta( $page_for_candidates_id, '_wp_page_template', 'for_candidates_template.php' );
		}
	}
}
add_action( 'after_switch_theme', 'addThisPage' );
?>