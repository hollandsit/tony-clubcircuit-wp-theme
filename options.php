<?php
/**
 * Options Framework configuration.
 *
 * Defines the Theme Options used by the templates via of_get_option().
 * Only the options actually used by the theme are defined here (the original
 * theme shipped a long list of demo/example fields which have been removed).
 *
 * @package tony-clubcircuit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A unique identifier is defined to store the options in the database and
 * reference them from the theme. By default it uses the theme name (stylesheet),
 * lowercased and without spaces.
 */
function optionsframework_option_name() {
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace( '/\W/', '_', strtolower( $themename ) );

	$optionsframework_settings       = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines the options shown on the Theme Options admin page.
 *
 * @return array
 */
function optionsframework_options() {
	$options = array();

	/* Header --------------------------------------------------------- */
	$options[] = array(
		'name' => __( 'Header Settings', 'tony-clubcircuit' ),
		'type' => 'heading',
	);
	$options[] = array(
		'name' => __( 'Upload Logo', 'tony-clubcircuit' ),
		'desc' => __( 'Upload the site logo here.', 'tony-clubcircuit' ),
		'id'   => 'logo_uploader',
		'type' => 'upload',
	);

	/* Footer --------------------------------------------------------- */
	$options[] = array(
		'name' => __( 'Footer Settings', 'tony-clubcircuit' ),
		'type' => 'heading',
	);
	$options[] = array(
		'name' => __( 'Facebook URL', 'tony-clubcircuit' ),
		'desc' => __( 'Link to your Facebook page.', 'tony-clubcircuit' ),
		'id'   => 'facebook_url',
		'std'  => '',
		'type' => 'text',
	);
	$options[] = array(
		'name' => __( 'Twitter URL', 'tony-clubcircuit' ),
		'desc' => __( 'Link to your Twitter / X profile.', 'tony-clubcircuit' ),
		'id'   => 'twitter_url',
		'std'  => '',
		'type' => 'text',
	);
	$options[] = array(
		'name' => __( 'Instagram URL', 'tony-clubcircuit' ),
		'desc' => __( 'Link to your Instagram profile.', 'tony-clubcircuit' ),
		'id'   => 'instagram_url',
		'std'  => '',
		'type' => 'text',
	);
	$options[] = array(
		'name' => __( 'YouTube URL', 'tony-clubcircuit' ),
		'desc' => __( 'Link to your YouTube channel.', 'tony-clubcircuit' ),
		'id'   => 'youtube_url',
		'std'  => '',
		'type' => 'text',
	);
	$options[] = array(
		'name' => __( 'Copyright Content', 'tony-clubcircuit' ),
		'desc' => __( 'Enter the copyright text shown in the footer.', 'tony-clubcircuit' ),
		'id'   => 'copyright_textarea',
		'std'  => '',
		'type' => 'textarea',
	);

	/* Pages ---------------------------------------------------------- */
	$options[] = array(
		'name' => __( 'Page Settings', 'tony-clubcircuit' ),
		'type' => 'heading',
	);
	$options[] = array(
		'name'  => __( 'Home Page Announcements (count)', 'tony-clubcircuit' ),
		'desc'  => __( 'Number of announcement posts to show on the home page.', 'tony-clubcircuit' ),
		'id'    => 'homepage_announcement',
		'std'   => '5',
		'class' => 'mini',
		'type'  => 'text',
	);
	$options[] = array(
		'name'  => __( 'Home Page Announcement Category ID', 'tony-clubcircuit' ),
		'desc'  => __( 'Category ID used to pull announcement posts.', 'tony-clubcircuit' ),
		'id'    => 'homepage_announcement_catid',
		'std'   => '1',
		'class' => 'mini',
		'type'  => 'text',
	);
	$options[] = array(
		'name' => __( 'Member Clubs listing page intro', 'tony-clubcircuit' ),
		'desc' => __( 'Intro content shown above the member clubs listing.', 'tony-clubcircuit' ),
		'id'   => 'member_club_lisint_page_content',
		'type' => 'editor',
	);

	return $options;
}
