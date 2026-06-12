<?php
/**
 * The header for our theme.
 *
 * Displays the <head> section and the opening site header / navigation.
 *
 * @package tony-clubcircuit
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) { wp_body_open(); } ?>

<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'tony-clubcircuit' ); ?></a>

<header class="site-header" role="banner">
	<div class="container">
		<div class="site-header__inner">

			<div class="site-branding">
				<?php
				$logo_url = function_exists( 'of_get_option' ) ? of_get_option( 'logo_uploader' ) : '';

				if ( ! empty( $logo_url ) ) :
					?>
					<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					</a>
					<?php
				elseif ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) :
					the_custom_logo();
				else :
					?>
					<a class="site-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo.png' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
					</a>
					<?php
				endif;
				?>
			</div><!-- .site-branding -->

			<button class="cc-nav-toggle" aria-controls="site-navigation" aria-expanded="false">
				<span class="cc-nav-toggle__bars"><span></span></span>
				<span class="cc-nav-toggle__label"><?php esc_html_e( 'Menu', 'tony-clubcircuit' ); ?></span>
			</button>

			<div class="header-search">
				<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text" for="cc-header-search"><?php esc_html_e( 'Search for:', 'tony-clubcircuit' ); ?></label>
					<input type="search" id="cc-header-search" class="search-field" placeholder="<?php esc_attr_e( 'Search…', 'tony-clubcircuit' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
					<button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'Search', 'tony-clubcircuit' ); ?>"><?php tcc_icon( 'search' ); ?></button>
				</form>
			</div><!-- .header-search -->

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'tony-clubcircuit' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_class'     => 'menu nav',
					'container'      => false,
					'depth'          => 3,
					'fallback_cb'    => 'wp_page_menu',
				) );
				?>
			</nav><!-- #site-navigation -->

		</div><!-- .site-header__inner -->
	</div><!-- .container -->
</header><!-- .site-header -->

<main id="main-content" class="site-main">
