<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php bloginfo( 'description' ); ?>">
	<meta name="author" content="">
	<title><?php wp_title( '' ); ?></title>

	<!-- Just for debugging purposes. Don't actually copy this line! -->
	<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->


<?php wp_head(); ?>

</head>
<body class="cover" <?php body_class(); ?>>
	<header class="header-content background-color">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="col-xs-12 col-sm-6">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo pull-left"><?php if (strpos(strtolower(get_bloginfo( 'name' )), 'expatconsultancy') !== false) echo 'EXPAT<span>CONSULT</span>ANCY.com'; else bloginfo( 'name' ); ?></a>
					</div>
					<!-- Polylang language switcher -->
					<?php
					// check if plugin is active and languages added
					include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
					global $polylang;
					if ( is_plugin_active( 'polylang/polylang.php' && $polylang ) ) { ?>
					<div class="col-xs-12 col-sm-6">
						<ul class="nav navbar-nav navbar-right list-top">
							<?php
							$switcher = pll_the_languages(array('raw'=>1));
							for ($i=count($switcher); $i>0; $i--) {
								$is_current = in_array('current-lang', $switcher[$i-1]['classes']);
								$url = $switcher[$i-1]['url'];
								$slug = $switcher[$i-1]['slug'];
								?>
								<li class="text-uppercase">
									<a href="<?php echo $url; ?>"<?php if ($is_current) echo('class="custom-active"'); ?>>
										<?php echo ($slug == 'ru') ? 'rus' : $slug; ?>
									</a>
								</li>
								<?php } ?>
						</ul>
					</div>
					<?php } ?> <!-- End of language switcher -->
				</div>
				<div class="col-xs-12">
					<?php
					$currentlang = get_bloginfo('language');
					if ($currentlang !== "ru-RU") :

						// Check if the menu exists
						$menu_exists = wp_get_nav_menu_object( 'Top menu EN' );

						// If it doesn't exist, let's create it.
						if( !$menu_exists ){
							$menu_id = wp_create_nav_menu( 'Top menu EN' );

							// Set up default menu items
							$pages = ['About Us', 'Vacancies', 'For Employer', 'For Candidates', 'Contacts' ];
							for ($i=0; $i<count($pages); $i++) {
								wp_update_nav_menu_item($menu_id, 0, array(
								'menu-item-title'		=> $pages[$i],
								'menu-item-object'		=> 'page',
								'menu-item-object-id'	=> get_page_by_title($pages[$i])->ID,
								'menu-item-type'		=> 'post_type',
								'menu-item-status'		=> 'publish'));
							}
						};
						wp_nav_menu( array(
							'theme_location'	=> 'primary',
							'menu'				=> 'Top menu EN',
							'container'			=> '',
							'menu_class'		=> 'nav navbar-nav navbar-right list-bottom',
						));
					elseif ($currentlang == "ru-RU") :
						// Check if the menu exists
						$menu_exists = wp_get_nav_menu_object( 'Top menu RU' );

						// If it doesn't exist, let's create it.
						if( !$menu_exists ){
							$menu_id = wp_create_nav_menu( 'Top menu RU' );
						};

						wp_nav_menu( array(
							'theme_location'	=> 'primary',
							'menu'				=> 'Top menu RU',
							'container'			=> '',
							'menu_class'		=> 'nav navbar-nav navbar-right list-bottom',
						));
					endif; ?>
				</div>
			</div>
		</div>
	</header>
