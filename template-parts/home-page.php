<?php
/**
 * Template Name:Homepage
 *
 * @package tony-clubcircuit
 */

get_header();
global $post;
?>

<!-- Banner -->
<div class="banner">
	<div class="owl-carousel-home" id="banner">
		<?php
		if ( have_rows( 'slider' ) ) :
			while ( have_rows( 'slider' ) ) :
				the_row();
				$slider_image = get_sub_field( 'slider_image' );
				$title        = get_sub_field( 'title' );
				$sub_title    = get_sub_field( 'sub_title' );
				$button_label = get_sub_field( 'button_label' );
				$button_url   = get_sub_field( 'button_url' );
				?>
				<div class="item">
					<?php if ( $slider_image ) : ?>
						<img src="<?php echo esc_url( $slider_image ); ?>" alt="<?php echo esc_attr( $title ); ?>">
					<?php endif; ?>
					<div class="caption">
						<div class="container">
							<div class="caption_inr">
								<?php if ( $title ) : ?><h2><?php echo esc_html( $title ); ?></h2><?php endif; ?>
								<?php if ( $sub_title ) : ?><h3><?php echo esc_html( $sub_title ); ?></h3><?php endif; ?>
								<?php if ( $button_label && $button_url ) : ?>
									<div class="btns"><a href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_label ); ?></a></div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php
			endwhile;
		endif;
		?>
	</div>
</div>

<?php
/* Sponsored by */
$sponserd_by              = get_post_meta( $post->ID, 'sponserd_by', true );
$sponsored_by_description = get_post_meta( $post->ID, 'sponsored_by_descrpition', true );
if ( '' !== $sponserd_by && '' !== $sponsored_by_description ) :
	?>
	<div class="section_content sponserd_by">
		<div class="container">
			<h2 class="common_heading"><?php echo esc_html( $sponserd_by ); ?></h2>
			<div class="subtitletext"><?php echo wp_kses_post( $sponsored_by_description ); ?></div>
		</div>
	</div>
<?php endif; ?>

<!-- Hero intro -->
<div class="section_content">
	<div class="container">
		<h2 class="common_heading"><?php the_field( 'hero_title' ); ?></h2>
		<div class="subtitletext"><?php the_field( 'hero_short_description' ); ?></div>
	</div>
</div>

<!-- 3 column box layout -->
<div class="boxcolumn">
	<div class="container">
		<div class="row">
			<?php
			if ( have_rows( 'box_layout' ) ) :
				$count = 1;
				while ( have_rows( 'box_layout' ) ) :
					the_row();
					$bl_title = get_sub_field( 'title' );
					$bl_desc  = get_sub_field( 'description' );
					$bl_more  = get_sub_field( 'read_more' );
					$bl_logo  = get_sub_field( 'box_logo' );
					?>
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="serv_inr">
							<?php if ( $bl_logo ) : ?>
								<div class="serv_icon"><img src="<?php echo esc_url( $bl_logo ); ?>" alt="<?php echo esc_attr( $bl_title ); ?>"></div>
							<?php endif; ?>
							<h3 class="icon_1"><?php echo esc_html( $bl_title ); ?></h3>
							<p><?php echo wp_kses_post( $bl_desc ); ?></p>
							<?php if ( $bl_more ) : ?>
								<a href="<?php echo esc_url( $bl_more ); ?>"><?php esc_html_e( 'Read More', 'tony-clubcircuit' ); ?> <?php tcc_icon( 'arrow' ); ?></a>
							<?php endif; ?>
						</div>
					</div>
					<?php
					if ( 0 === $count % 3 ) {
						echo '</div><div class="row">';
					}
					$count++;
				endwhile;
			endif;
			?>
		</div>
	</div>
</div>

<?php
/* Announcements */
$numberof_announcement       = function_exists( 'of_get_option' ) ? of_get_option( 'homepage_announcement' ) : 5;
$numberof_announcement_catid = function_exists( 'of_get_option' ) ? of_get_option( 'homepage_announcement_catid' ) : 1;
?>
<div class="section_content">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h2 class="common_heading"><?php echo esc_html( get_cat_name( $numberof_announcement_catid ) ); ?></h2>
				<div class="subtitletext"><?php echo wp_kses_post( category_description( $numberof_announcement_catid ) ); ?></div>
			</div>
			<div class="col-xs-12">
				<div class="announcement-owl-carousel anouncement_list">
					<?php
					$postslist = get_posts( array(
						'numberposts' => $numberof_announcement,
						'post_status' => 'publish',
						'post_type'   => 'post',
						'orderby'     => 'post_date',
						'category'    => $numberof_announcement_catid,
					) );

					foreach ( $postslist as $singlepost ) :
						$ann_thumb   = tcc_thumb_url( $singlepost->ID, 'medium' );
						$ann_content = wp_trim_words( $singlepost->post_content, 16, '…' );
						?>
						<div class="item">
							<div class="announcement_card">
								<?php if ( $ann_thumb ) : ?>
									<div class="anouncement_img"><img src="<?php echo esc_url( $ann_thumb ); ?>" alt="<?php echo esc_attr( $singlepost->post_title ); ?>"></div>
								<?php endif; ?>
								<div class="announcement_content">
									<h2><?php echo esc_html( $singlepost->post_title ); ?></h2>
									<p><?php echo esc_html( $ann_content ); ?></p>
									<p><a href="<?php echo esc_url( get_permalink( $singlepost->ID ) ); ?>" class="readmore"><?php esc_html_e( 'Read More', 'tony-clubcircuit' ); ?></a></p>
								</div>
							</div>
						</div>
						<?php
					endforeach;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Facebook & Instagram -->
<?php
$instagram_short_code = get_field( 'instagram_short_code' );
$has_fb               = is_active_sidebar( 'fb-widget' );
if ( $has_fb || ! empty( $instagram_short_code ) ) :
	?>
	<div class="section_content">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-6">
					<div class="facebook_feeds"><?php dynamic_sidebar( 'fb-widget' ); ?></div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="instagram_feeds">
						<?php
						if ( ! empty( $instagram_short_code ) ) {
							echo do_shortcode( $instagram_short_code );
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php
get_footer();
