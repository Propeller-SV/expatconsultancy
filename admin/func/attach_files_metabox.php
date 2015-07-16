<?php
/**
 * ----------------------------------------------------------------------------------------
 * Add metabox for files attaching
 * ----------------------------------------------------------------------------------------
 */

function expat_attach_files() {
	// Verify page template
	global $post;
	if (!empty($post)) {
		$pageTemplate = get_post_meta( $post->ID, '_wp_page_template', true );
		  if ($pageTemplate == 'for_candidates_template.php' ) {
			add_meta_box(
				'expat_doc_attachment',
				__('Custom Attachments', 'expatconsultany'),
				'expat_doc_attachment',
				'page',
				'normal'
			);
		}
	}
} // end expat_attach_files

// meta_box call-back function
function expat_doc_attachment() {
	global $post;
	$doc = get_post_meta( $post->ID, 'expat_doc_attachment', true );
	// die(print_r($doc));

	wp_nonce_field(plugin_basename(__FILE__), 'expat_doc_attachment_nonce');

	$html = '<p class="description">';
	$html .= __('Upload your files here', 'expatconsultany') . '&#8594;';
	$html .= ' <input type="file" id="expat_doc_attachment" name="expat_doc_attachment" value="" size="25" />';
	$html .= '</p>';
	if (isset($doc[0])) {
		for ($i=1; $i<count($doc); $i++) {
			$html .= '<div class="field_row"><input type="text" class="expat_doc_attachment_url" name="expat_doc_attachment_url[]" value="' . $doc[$i]['url'] . '" size="80" />';
			// Display the 'Delete' option if a URL to a file exists
			if(strlen(trim($doc[$i]['url'])) > 0) {
				$html .= '<input class="button" type="button" value="' . __('Remove file', 'expatconsultany') . '" onclick="jQuery(this).closest(\'div\').remove();" /></div><br>';
			} // end if
		}
	}

	echo $html;

} // end expat_doc_attachment

function save_custom_meta_data($id) {

	/* --- security verification --- */
	if( isset($_POST['expat_doc_attachment_nonce']) && !wp_verify_nonce($_POST['expat_doc_attachment_nonce'], plugin_basename(__FILE__))) {
	  return $id;
	} // end if

	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
	  return $id;
	} // end if

	if(isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
		if(!current_user_can('edit_page', $id)) {
		return $id;
		} // end if
	} else {
		if(!current_user_can('edit_page', $id)) {
			return $id;
		} // end if
	} // end if
	/* - end security verification - */

	// uploading docs

	if(!empty($_FILES['expat_doc_attachment']['name'])) {
		// Setup the array of supported file types. In this case, it's PDF, doc, docx, xls, xlsx, ppt, pptx .
		$supported_types = array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');

		// Get the file type of the upload
		$arr_file_type = wp_check_filetype(basename($_FILES['expat_doc_attachment']['name']));
		$uploaded_type = $arr_file_type['type'];

		// Check if the type is supported. If not, throw an error.
		if(in_array($uploaded_type, $supported_types)) {

			// $upload = array();
			// Use the WordPress API to upload the file
			$upload = (array) get_post_meta( get_the_id(), 'expat_doc_attachment', true );
			$upload[] = wp_upload_bits($_FILES['expat_doc_attachment']['name'], null, file_get_contents($_FILES['expat_doc_attachment']['tmp_name']));
			if(isset($upload[1]['error']) && $upload[1]['error'] != 0) {
				wp_die(__('There was an error uploading your file. The error is: ', 'expatconsultany') . $upload[1]['error']);
			} else {
				add_post_meta($id, 'expat_doc_attachment', $upload);
				update_post_meta($id, 'expat_doc_attachment', $upload);
			} // end if/else

		} else {
			wp_die(__('The file type that you\'ve uploaded is not a PDF or doc', 'expatconsultany'));
		} // end if/else
	} else {

		if (isset($_POST['expat_doc_attachment_url'])) {
			if ($_POST['expat_doc_attachment_url']) {

				$visible_files = array();
				for ($i=0; $i<count($_POST['expat_doc_attachment_url']); $i++) {
					$visible_files[] = basename($_POST['expat_doc_attachment_url'][$i]);
				}
// die(print_r($visible_files));
				$doc = get_post_meta($id, 'expat_doc_attachment', true);
				$uploaded = array();
				for ($i=1; $i<count($doc); $i++) {
					$uploaded[] = basename($doc[$i]['file']);
				}
// die(print_r($uploaded));
				for ($i=0; $i<count($uploaded); $i++) {
					if (!in_array($uploaded[$i], $visible_files)) {
						if (unlink($doc[$i+1]['file'])) {
							unset($doc[$i+1]);
						} else {
							wp_die(__('There was an error trying to delete your file.', 'expatconsultany'));
						} // end if/else
					} // end if
				} // end for
				$doc = array_values($doc);
				// Delete succeeded so reset the WordPress meta data
				update_post_meta($id, 'expat_doc_attachment', $doc);
			} // end if
		} else {
			$doc = get_post_meta($id, 'expat_doc_attachment', true);
			$uploaded = array();
			for ($i=1; $i<count($doc); $i++) {
				$uploaded[] = $doc[$i]['file'];
			}
			for ($i=0; $i<count($uploaded); $i++) {
				if (unlink($uploaded[$i])) {
					// Delete succeeded so reset the WordPress meta data
					delete_post_meta($id, 'expat_doc_attachment');
				} else {
					wp_die(__('There was an error trying to delete your file.', 'expatconsultany'));
				} // end if/else
			} // end for
		} // end if/else
	} // end if/else

} // end save_custom_meta_data

add_action('add_meta_boxes', 'expat_attach_files');
add_action('save_post', 'save_custom_meta_data');
