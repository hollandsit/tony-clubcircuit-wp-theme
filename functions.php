<?php
/**
 * Tony Club Circuit functions and definitions.
 *
 * A modernised, dependency-free rebuild of the original "clubcircuit" theme.
 * The data layer (custom post types, ACF field names, Options Framework option
 * IDs, widget areas, nav-menu locations, plugin hooks and page-template names)
 * is preserved 1:1 so existing content keeps rendering. Only the presentation
 * (markup, CSS, JS) has been rebuilt.
 *
 * @package tony-clubcircuit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access.
}

define( 'TCC_VERSION', '1.0.0' );

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */
if ( ! function_exists( 'tcc_setup' ) ) :
	function tcc_setup() {
		load_theme_textdomain( 'tony-clubcircuit', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'custom-logo', array(
			'height'      => 90,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
		) );

		register_nav_menus( array(
			'primary'    => esc_html__( 'Primary', 'tony-clubcircuit' ),
			'footer_nav' => esc_html__( 'Footer', 'tony-clubcircuit' ),
		) );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		) );

		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		) );

		add_theme_support( 'custom-background', apply_filters( 'tcc_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
	}
endif;
add_action( 'after_setup_theme', 'tcc_setup' );

/**
 * Content width.
 */
function tcc_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tcc_content_width', 1140 );
}
add_action( 'after_setup_theme', 'tcc_content_width', 0 );

/* -------------------------------------------------------------------------
 * Widget areas (sidebar IDs preserved from the original theme)
 * ---------------------------------------------------------------------- */
function tcc_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'tony-clubcircuit' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'tony-clubcircuit' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	$bare = array(
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	);

	register_sidebar( array_merge( array(
		'name'          => esc_html__( 'Footer-1', 'tony-clubcircuit' ),
		'id'            => 'Footer-1',
		'description'   => esc_html__( 'Main footer widget area.', 'tony-clubcircuit' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) ) );

	register_sidebar( array_merge( $bare, array(
		'name' => esc_html__( 'fb-widget', 'tony-clubcircuit' ),
		'id'   => 'fb-widget',
	) ) );
	register_sidebar( array_merge( $bare, array(
		'name' => esc_html__( 'newsletter', 'tony-clubcircuit' ),
		'id'   => 'newsletter',
	) ) );
	register_sidebar( array_merge( $bare, array(
		'name' => esc_html__( 'visitorcounter', 'tony-clubcircuit' ),
		'id'   => 'visitorcounter',
	) ) );
}
add_action( 'widgets_init', 'tcc_widgets_init' );

/* -------------------------------------------------------------------------
 * Enqueue styles & scripts (replaces the hardcoded tags in the old theme)
 * ---------------------------------------------------------------------- */
function tcc_scripts() {
	$theme_dir = get_template_directory();
	$theme_uri = get_template_directory_uri();

	// Main stylesheet (style.css).
	$style_ver = file_exists( $theme_dir . '/style.css' ) ? filemtime( $theme_dir . '/style.css' ) : TCC_VERSION;
	wp_enqueue_style( 'tcc-style', get_stylesheet_uri(), array(), $style_ver );

	// Front-end JS (vanilla, no jQuery) — slider + mobile nav + sticky header.
	$js_path = $theme_dir . '/assets/js/theme.js';
	$js_ver  = file_exists( $js_path ) ? filemtime( $js_path ) : TCC_VERSION;
	wp_enqueue_script( 'tcc-theme', $theme_uri . '/assets/js/theme.js', array(), $js_ver, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tcc_scripts' );

/* -------------------------------------------------------------------------
 * Safety net: if the Options Framework plugin is ever inactive, keep the
 * theme from fatally erroring on of_get_option() calls in the templates.
 * ---------------------------------------------------------------------- */
if ( ! function_exists( 'of_get_option' ) ) {
	function of_get_option( $name, $default = false ) {
		$config = get_option( 'optionsframework' );
		if ( ! isset( $config['id'] ) ) {
			return $default;
		}
		$options = get_option( $config['id'] );
		return ( isset( $options[ $name ] ) ) ? $options[ $name ] : $default;
	}
}

/* -------------------------------------------------------------------------
 * Custom post types: Member + Club (registered by the theme, as before).
 * flush_rewrite_rules() is intentionally NOT called on every init; it runs
 * once on theme activation instead.
 * ---------------------------------------------------------------------- */
function tcc_register_member_cpt() {
	$labels = array(
		'name'               => _x( 'Member', 'post type general name', 'tony-clubcircuit' ),
		'singular_name'      => _x( 'Member', 'post type singular name', 'tony-clubcircuit' ),
		'menu_name'          => _x( 'Members', 'admin menu', 'tony-clubcircuit' ),
		'name_admin_bar'     => _x( 'Member', 'add new on admin bar', 'tony-clubcircuit' ),
		'add_new'            => _x( 'Add New Member', 'member', 'tony-clubcircuit' ),
		'add_new_item'       => __( 'Add New Member', 'tony-clubcircuit' ),
		'new_item'           => __( 'New Member', 'tony-clubcircuit' ),
		'edit_item'          => __( 'Edit Member', 'tony-clubcircuit' ),
		'view_item'          => __( 'View Member', 'tony-clubcircuit' ),
		'all_items'          => __( 'All Members', 'tony-clubcircuit' ),
		'search_items'       => __( 'Search Members', 'tony-clubcircuit' ),
		'parent_item_colon'  => __( 'Parent Members:', 'tony-clubcircuit' ),
		'not_found'          => __( 'No Members found.', 'tony-clubcircuit' ),
		'not_found_in_trash' => __( 'No Members found in Trash.', 'tony-clubcircuit' ),
	);

	register_post_type( 'member', array(
		'labels'             => $labels,
		'description'        => __( 'Club Circuit members.', 'tony-clubcircuit' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'member' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-groups',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
	) );
}
add_action( 'init', 'tcc_register_member_cpt' );

function tcc_register_club_cpt() {
	$labels = array(
		'name'               => _x( 'Club', 'post type general name', 'tony-clubcircuit' ),
		'singular_name'      => _x( 'Club', 'post type singular name', 'tony-clubcircuit' ),
		'menu_name'          => _x( 'Clubs', 'admin menu', 'tony-clubcircuit' ),
		'name_admin_bar'     => _x( 'Club', 'add new on admin bar', 'tony-clubcircuit' ),
		'add_new'            => _x( 'Add New Club', 'club', 'tony-clubcircuit' ),
		'add_new_item'       => __( 'Add New Club', 'tony-clubcircuit' ),
		'new_item'           => __( 'New Club', 'tony-clubcircuit' ),
		'edit_item'          => __( 'Edit Club', 'tony-clubcircuit' ),
		'view_item'          => __( 'View Club', 'tony-clubcircuit' ),
		'all_items'          => __( 'All Clubs', 'tony-clubcircuit' ),
		'search_items'       => __( 'Search Clubs', 'tony-clubcircuit' ),
		'parent_item_colon'  => __( 'Parent Clubs:', 'tony-clubcircuit' ),
		'not_found'          => __( 'No Clubs found.', 'tony-clubcircuit' ),
		'not_found_in_trash' => __( 'No Clubs found in Trash.', 'tony-clubcircuit' ),
	);

	register_post_type( 'club', array(
		'labels'             => $labels,
		'description'        => __( 'Club Circuit member clubs.', 'tony-clubcircuit' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'club' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => 'dashicons-location-alt',
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
	) );
}
add_action( 'init', 'tcc_register_club_cpt' );

/**
 * Flush rewrite rules once when the theme is activated so the club/member
 * permalinks work immediately (replaces the per-request flush in the old theme).
 */
function tcc_flush_rewrites() {
	tcc_register_member_cpt();
	tcc_register_club_cpt();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'tcc_flush_rewrites' );

/* -------------------------------------------------------------------------
 * Pagination helper used by the club & member archives (preserved).
 * ---------------------------------------------------------------------- */
function ClbCircuitPagination( $paged = null, $total_pages = null ) {
	$returnvars = '';

	if ( $paged != null && $total_pages != null ) {
		$args = array(
			'base'         => @add_query_arg( 'page', '%#%' ),
			'format'       => '?page=%#%',
			'total'        => $total_pages,
			'current'      => $paged,
			'show_all'     => false,
			'end_size'     => 1,
			'mid_size'     => 2,
			'prev_next'    => false,
			'prev_text'    => __( '&laquo; Previous', 'tony-clubcircuit' ),
			'next_text'    => __( 'Next &raquo;', 'tony-clubcircuit' ),
			'type'         => 'array',
			'add_args'     => false,
			'add_fragment' => '',
		);

		$custom_pagination = paginate_links( $args );

		if ( is_array( $custom_pagination ) ) {
			$returnvars .= '<ul class="cc-pagination">';
			foreach ( $custom_pagination as $page ) {
				$returnvars .= "<li>$page</li>";
			}
			$returnvars .= '</ul>';
		}
	}

	return $returnvars;
}

/* -------------------------------------------------------------------------
 * Inline SVG icon helper. Replaces the broken Font Awesome references in the
 * original theme (FA was never actually loaded) with dependency-free icons.
 * ---------------------------------------------------------------------- */
function tcc_get_icon( $name ) {
	$icons = array(
		'facebook'  => '<path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5 3.66 9.15 8.44 9.94v-7H7.9v-2.9h2.54V9.85c0-2.52 1.49-3.91 3.78-3.91 1.1 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.78-1.63 1.57v1.89h2.78l-.44 2.9h-2.34v7A10 10 0 0 0 22 12.06z"/>',
		'twitter'   => '<path d="M18.9 1.15h3.68l-8.04 9.19L24 22.85h-7.41l-5.8-7.58-6.64 7.58H.46l8.6-9.83L0 1.15h7.6l5.24 6.93 6.06-6.93zm-1.29 19.5h2.04L6.48 3.24H4.3l13.31 17.41z"/>',
		'instagram' => '<path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41a3.72 3.72 0 0 1-1.38-.9 3.72 3.72 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23C2.17 15.58 2.16 15.2 2.16 12s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41C8.42 2.17 8.8 2.16 12 2.16zM12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63c-.79.31-1.46.72-2.12 1.38A5.87 5.87 0 0 0 .63 4.14c-.3.76-.5 1.64-.56 2.91C.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.31.79.72 1.46 1.38 2.12.66.66 1.33 1.07 2.12 1.38.76.3 1.64.5 2.91.56C8.33 23.99 8.74 24 12 24s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56a5.87 5.87 0 0 0 2.12-1.38 5.87 5.87 0 0 0 1.38-2.12c.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.87 5.87 0 0 0-1.38-2.12A5.87 5.87 0 0 0 19.86.63c-.76-.3-1.64-.5-2.91-.56C15.67.01 15.26 0 12 0zm0 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zM12 16a4 4 0 1 1 4-4 4 4 0 0 1-4 4zm6.41-10.85a1.44 1.44 0 1 0 1.44 1.44 1.44 1.44 0 0 0-1.44-1.44z"/>',
		'youtube'   => '<path d="M23.5 6.2a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.51A3.02 3.02 0 0 0 .5 6.2 31.4 31.4 0 0 0 0 12a31.4 31.4 0 0 0 .5 5.8 3.02 3.02 0 0 0 2.12 2.14c1.88.51 9.38.51 9.38.51s7.5 0 9.38-.51a3.02 3.02 0 0 0 2.12-2.14A31.4 31.4 0 0 0 24 12a31.4 31.4 0 0 0-.5-5.8zM9.6 15.6V8.4l6.27 3.6L9.6 15.6z"/>',
		'map'       => '<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/>',
		'globe'     => '<path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm6.93 6h-2.95a15.7 15.7 0 0 0-1.38-3.56A8.03 8.03 0 0 1 18.93 8zM12 4.04c.83 1.2 1.48 2.53 1.91 3.96h-3.82c.43-1.43 1.08-2.76 1.91-3.96zM4.26 14a7.96 7.96 0 0 1 0-4h3.38a16.6 16.6 0 0 0 0 4H4.26zm.81 2h2.95c.32 1.25.78 2.45 1.38 3.56A7.99 7.99 0 0 1 5.07 16zm2.95-8H5.07a7.99 7.99 0 0 1 4.33-3.56A15.7 15.7 0 0 0 8.02 8zM12 19.96c-.83-1.2-1.48-2.53-1.91-3.96h3.82A13.7 13.7 0 0 1 12 19.96zM14.34 14H9.66a14.8 14.8 0 0 1 0-4h4.68a14.8 14.8 0 0 1 0 4zm.27 5.56c.6-1.11 1.06-2.31 1.38-3.56h2.95a7.99 7.99 0 0 1-4.33 3.56zM16.36 14a16.6 16.6 0 0 0 0-4h3.38a7.96 7.96 0 0 1 0 4h-3.38z"/>',
		'phone'     => '<path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2z"/>',
		'envelope'  => '<path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>',
		'search'    => '<path d="M21.71 20.29 18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42-1.42zM4 11a7 7 0 1 1 7 7 7 7 0 0 1-7-7z"/>',
		'arrow'     => '<path d="M9 6l6 6-6 6"/>',
	);

	if ( ! isset( $icons[ $name ] ) ) {
		return '';
	}

	$fill = ( 'arrow' === $name )
		? 'fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"'
		: 'fill="currentColor"';

	return '<svg class="cc-icon cc-icon--' . esc_attr( $name ) . '" viewBox="0 0 24 24" width="1em" height="1em" ' . $fill . ' aria-hidden="true" focusable="false">' . $icons[ $name ] . '</svg>';
}

/**
 * Echo helper for tcc_get_icon().
 */
function tcc_icon( $name ) {
	echo tcc_get_icon( $name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted inline SVG.
}

/**
 * Render a theme social-links list from a set of URLs.
 * Mirrors the markup the original footer/contact templates produced.
 *
 * @param array $urls Associative array of network => url.
 */
function tcc_social_links( $urls ) {
	$networks = array( 'facebook', 'twitter', 'instagram', 'youtube' );
	$has_any  = false;
	foreach ( $networks as $n ) {
		if ( ! empty( $urls[ $n ] ) ) {
			$has_any = true;
			break;
		}
	}
	if ( ! $has_any ) {
		return;
	}

	echo '<ul>';
	foreach ( $networks as $n ) {
		if ( empty( $urls[ $n ] ) ) {
			continue;
		}
		printf(
			'<li class="%1$s"><a href="%2$s" target="_blank" rel="noopener" aria-label="%3$s">%4$s</a></li>',
			esc_attr( $n ),
			esc_url( $urls[ $n ] ),
			esc_attr( ucfirst( $n ) ),
			tcc_get_icon( $n ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}
	echo '</ul>';
}

/**
 * Safely return a featured-image URL for a post, or '' if none.
 * Replaces the unguarded $thumb['0'] access scattered through the old theme.
 *
 * @param int    $post_id Post ID.
 * @param string $size    Image size.
 * @return string
 */
function tcc_thumb_url( $post_id, $size = 'large' ) {
	$id = get_post_thumbnail_id( $post_id );
	if ( ! $id ) {
		return '';
	}
	$thumb = wp_get_attachment_image_src( $id, $size );
	return ( ! empty( $thumb[0] ) ) ? $thumb[0] : '';
}
