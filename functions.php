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
