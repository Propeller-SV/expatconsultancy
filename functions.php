<?php
/**
 * Theme functions and definitions
 */

/**
 * ----------------------------------------------------------------------------------------
 * Define constants.
 * ----------------------------------------------------------------------------------------
 */
define( 'THEMEROOT', get_stylesheet_directory_uri() );
define( 'IMAGES', THEMEROOT . '/img' );
define( 'SCRIPTS', THEMEROOT . '/js' );
define( 'THEMEFUNC', TEMPLATEPATH . '/admin/func' );

/**
 * ----------------------------------------------------------------------------------------
 * Create default pages
 * ----------------------------------------------------------------------------------------
 */
require_once(THEMEFUNC . '/default_pages.php');

/**
 * ----------------------------------------------------------------------------------------
 * Include the Plugin Activation function.
 * ----------------------------------------------------------------------------------------
 */
require_once THEMEFUNC . '/mu_plugins.php';

/**
 * ----------------------------------------------------------------------------------------
 * Include the function to add languges to Polylang plugin.
 * ----------------------------------------------------------------------------------------
 */
require_once THEMEFUNC . '/add_languages_polylang.php';

/**
 * ----------------------------------------------------------------------------------------
 * Include the functions for metaboxes.
 * ----------------------------------------------------------------------------------------
 */
require_once THEMEFUNC . '/attach_files_metabox.php';

/**
 * ----------------------------------------------------------------------------------------
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'expatconsultany_theme_setup' ) ) :
	function expatconsultany_theme_setup() {
		/*
		 * Make theme available for translation.
		 */

		load_theme_textdomain( 'expatconsultany', get_template_directory() . '/languages' );

		/*
		 *Enable support for Post Thumbnails on posts and pages.
		 */

		add_theme_support( 'post-thumbnails' );
	}
endif; /* /expatconsultany_theme_setup */
add_action( 'after_setup_theme', 'expatconsultany_theme_setup' );

/**
 * ----------------------------------------------------------------------------------------
 * Load styles and scripts
 * ----------------------------------------------------------------------------------------
 */
if (!function_exists('current_theme_resources')) :
	function current_theme_resources() {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
		wp_enqueue_style( 'style', get_stylesheet_uri() );

		wp_enqueue_script( 'custom-script', SCRIPTS . '/bootstrap.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'bootstrap-jquery', SCRIPTS . '/jquery.min.js' );
	}
endif;	/* /current_theme_resources */
add_action( 'wp_enqueue_scripts', 'current_theme_resources' );

/**
 * ----------------------------------------------------------------------------------------
 * Add Your Menu Locations
 * ----------------------------------------------------------------------------------------
 */
if (!function_exists('register_my_menus')) :
	function register_my_menus() {
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'expatconsultany' ),
		));
	}
endif;	/* /register_my_menus */
add_action( 'after_setup_theme', 'register_my_menus' );

/**
 * ----------------------------------------------------------------------------------------
 * Add Excerpts for pages
 * ----------------------------------------------------------------------------------------
 */
if (!function_exists('add_excerpts_to_pages')) :
	function add_excerpts_to_pages() {
		add_post_type_support( 'page', 'excerpt' );
	}
endif;	/* /add_excerpts_to_pages */
add_action( 'init', 'add_excerpts_to_pages' );

/**
 * ----------------------------------------------------------------------------------------
 * Hook for file uploading
 * ----------------------------------------------------------------------------------------
 */

function post_edit_form_tag() {
   echo ' enctype="multipart/form-data"';
}
add_action( 'post_edit_form_tag' , 'post_edit_form_tag' );

/**
 * ----------------------------------------------------------------------------------------
 * Custom resolution for image uploader
 * ----------------------------------------------------------------------------------------
 */
if ( function_exists( 'add_image_size' ) ) {
add_image_size( 'custon_size', 1080, 285, true ); //(cropped)
}

function my_image_sizes($sizes) {
$addsizes = array(
'custon_size' => __( 'Custom Size', 'expatconsultany')
);
$newsizes = array_merge($sizes, $addsizes);
return $newsizes;
}
add_filter('image_size_names_choose', 'my_image_sizes');

/**
 * ----------------------------------------------------------------------------------------
 * Add metabox for brand-photo adding
 * ----------------------------------------------------------------------------------------
 */
function brand_photo_change() {
	// Verify page template
	global $post;
	if (!empty($post)) {
		$pageTemplate = get_post_meta( $post->ID, '_wp_page_template', true );
		  if ($pageTemplate == 'about_us_template.php' ) {
			add_meta_box(
				'brand_photo_attachment',
				__('Brand photo', 'expatconsultany'),
				'brand_photo_attachment',
				'page',
				'normal'
			);
		}
	}
} // end brand_photo_change

// meta_box call-back function
function brand_photo_attachment() {
	global $post;
	$brand = get_post_meta( $post->ID, 'brand_photo_attachment', true );

	wp_nonce_field(plugin_basename(__FILE__), 'brand_photo_attachment_nonce');

	$html = '<div class="brand_row"><p class="description">';
	$html .= __('Upload your brand photo here', 'expatconsultany') . '&#8594;';
	$html .= '<input class="button" type="button" value="' . __('Upload image', 'expatconsultany') . '" onclick="add_brand_image(this)" /><br>';
	$html .= '</p>';
	$html .= '<input type="text" class="brand_photo" name="brand_photo" value="' . $brand . '" placeholder="' . __('Image URL', 'expatconsultany') . '" size="80" />';
	$html .= '<div class="image_wrap"><img src="' . $brand . '" width="320" alt="' . __('Image thumbnail', 'expatconsultany') . '" /></div></div>';

	echo $html;

} // end brand_photo_attachment

function print_brand_photo_scripts() {

// Check for correct post_type
global $post;
if( 'page' != $post->post_type )
	return;
?>
<script type="text/javascript">
	function add_brand_image(obj) {
		var parent=jQuery(obj).parent().parent('div.brand_row');
		var inputField = jQuery(parent).find('input.brand_photo');

		tb_show('', 'media-upload.php?TB_iframe=true');

		window.send_to_editor = function(html) {
			var url = jQuery(html).find('img').attr('src');
			inputField.val(url);
			jQuery(parent)
			.find("div.image_wrap")
			.html('<img src="'+url+'" height="160" width="320" />');

			tb_remove();
		};
	return false;
	}
</script>
<?php
}

function save_brand_photo_meta_data($id) {

	/* --- security verification --- */
	if( isset($_POST['brand_photo_attachment_nonce']) && !wp_verify_nonce($_POST['brand_photo_attachment_nonce'], plugin_basename(__FILE__))) {
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

	// add brand photo URL to database if exist

	if ( isset($_POST['brand_photo']) ) {
		// Build array for saving post meta
		if ( '' != $_POST['brand_photo'] ) {
			$page_brand_photo  = esc_url($_POST['brand_photo']);
		}
		if ( isset($page_brand_photo) ) {
			update_post_meta( $id, 'brand_photo_attachment', $page_brand_photo );
		}
		else
			delete_post_meta( $id, 'brand_photo_attachment' );
	}
	// Nothing received, all fields are empty, delete option
	else {
		delete_post_meta( $id, 'brand_photo_attachment' );
	}

} // end save_brand_photo_meta_data

add_action('add_meta_boxes', 'brand_photo_change');
add_action('admin_head-post.php', 'print_brand_photo_scripts' );
add_action('save_post', 'save_brand_photo_meta_data');
