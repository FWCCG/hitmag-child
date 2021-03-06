<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package HitMag
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="pgjN-TE1a98a2OyZJiCKb6GQ9-4NovstW_WBgrAZkwE" />
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(  );?>/inc/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri(  );?>/inc/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri(  );?>/inc/favicon/favicon-16x16.png">
<link rel="manifest" href="<?php echo get_stylesheet_directory_uri(  );?>/inc/favicon/site.webmanifest">
<link rel="mask-icon" href="<?php echo get_stylesheet_directory_uri(  );?>/inc/favicon/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#ffc40d">
<meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri(  );?>/inc/favicon/mstile-144x144.png">
<meta name="theme-color" content="#ffffff">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="site hitmag-wrapper">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'hitmag' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<?php if ( true == get_theme_mod( 'display_topbar', 'true' ) ) : ?>

			<?php if ( has_nav_menu( 'menu-2' ) ) : ?>
				<div class="hm-topnavbutton" aria-hidden="true">
					<div class="hm-nwrap">
						<a href="#" class="navbutton" id="top-nav-button" aria-label="Button to activate the mobile friendly navigation menu"><?php esc_html_e( 'Top Menu', 'hitmag' ); ?></a>
					</div>	
				</div>
				<div class="responsive-topnav"></div>					
			<?php endif; ?>

			<div class="hm-top-bar">
				<div class="hm-container">
					
					<?php if ( true == get_theme_mod( 'show_topbar_date', 'true' ) ) : ?>
						<div class="hm-date"><?php echo date( get_option( 'date_format' ) ); ?></div>
					<?php endif; ?>

					<?php if ( has_nav_menu( 'menu-2' ) ) : ?>
						<div id="top-navigation" class="top-navigation">
							<?php wp_nav_menu( array( 'theme_location' => 'menu-2', 'menu_id' => 'top-menu' ) ); ?>					
						</div>		
					<?php endif; ?>

					<?php get_template_part( 'template-parts/menu', 'social' ); ?>

				</div><!-- .hm-container -->
			</div><!-- .hm-top-bar -->

		<?php endif; ?>

		<?php if ( get_theme_mod( 'header_image_position', 'after-site-title' ) == 'before-site-title' ) { hitmag_header_image(); } ?>

		<div class="header-main-area">
			<div class="hm-container">
			<div class="intranet-logo">
						
					</div>
			<div class="site-branding">
				<div class="site-branding-content">
				<!-- .hm-logo -->
										<div class="hm-logo">
						<?php hitmag_the_custom_logo(); ?>
					</div><!-- .hm-logo -->

					<div class="hm-site-title">
						<?php
						if ( is_front_page() || is_home() ) : ?>
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php else : ?>
							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
						endif;

						$description = get_bloginfo( 'description', 'display' );
						if ( $description || is_customize_preview() ) : ?>
							<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
						<?php
						endif; ?>
					</div><!-- .hm-site-title -->
				</div><!-- .site-branding-content -->
			</div><!-- .site-branding -->

			<?php 
				if ( is_active_sidebar( 'sidebar-header' ) ) {
					echo '<div class="hm-header-sidebar">';
					dynamic_sidebar( 'sidebar-header' );
					echo '</div>';
				} 
			?>
			</div><!-- .hm-container -->
		</div><!-- .header-main-area -->

		<?php if ( get_theme_mod( 'header_image_position', 'after-site-title' ) == 'after-site-title' ) { hitmag_header_image(); } ?>

		<div class="hm-nav-container">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<div class="hm-container">
					<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
					
					<?php if ( true == get_theme_mod( 'show_nav_search', true ) ) : ?>
						<div class="hm-search-button-icon search-trigger js-search-trigger"></div>
					<?php endif; ?>
				</div><!-- .hm-container -->
			</nav><!-- #site-navigation -->
			<div class="hm-nwrap">
				<a href="#" class="navbutton" id="main-nav-button"><?php esc_html_e( 'Main Menu', 'hitmag' ); ?></a>
			</div>
			<div class="responsive-mainnav"></div>
		</div><!-- .hm-nav-container -->

		<?php if ( get_theme_mod( 'header_image_position', 'after-site-title' ) == 'after-main-nav' ) { hitmag_header_image(); } ?>
	</header><!-- #masthead -->

	<div id="content" class="site-content">
		<div class="hm-container">
			<div id="breadcrumb"><?php custom_breadcrumbs(); ?></div>
