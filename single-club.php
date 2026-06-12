<?php
/**
 * The template for displaying a single Club.
 *
 * @package tony-clubcircuit
 */

get_header();

while ( have_posts() ) :
	the_post();
	$club_id = get_the_ID();
	?>

	<div class="page_top_section">
		<div class="container">
			<h2 class="page_head"><?php the_title(); ?></h2>
			<?php if ( function_exists( 'bcn_display' ) ) : ?>
				<div class="breadcrumb_inner_pages"><?php bcn_display(); ?></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="inner_content">
		<div class="container">
			<div class="inner_content_block">
				<div class="club_detail">

					<div class="club_header clearfix">
						<?php $club_logo = tcc_thumb_url( $club_id, 'medium' ); ?>
						<?php if ( $club_logo ) : ?>
							<div class="club_header_logo">
								<img src="<?php echo esc_url( $club_logo ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
							</div>
						<?php endif; ?>
						<div class="club_header_title">
							<h2 class="page_head"><?php the_title(); ?></h2>
						</div>
					</div>

					<?php $about_history = get_post_meta( $club_id, 'about_history', true ); ?>
					<?php if ( ! empty( $about_history ) ) : ?>
						<div class="club_header_excerpt">
							<p><?php echo nl2br( wp_kses_post( $about_history ) ); ?></p>
						</div>
					<?php endif; ?>

					<div class="club_header_detail">
						<?php
						if ( have_rows( 'description' ) ) :
							while ( have_rows( 'description' ) ) :
								the_row();
								$d_title = get_sub_field( 'title' );
								$d_img   = get_sub_field( 'image' );
								$d_desc  = get_sub_field( 'short_description' );
								?>
								<div class="col-md-12 nopadding">
									<?php if ( $d_title ) : ?><h4><?php echo esc_html( $d_title ); ?></h4><?php endif; ?>
									<p>
										<?php if ( ! empty( $d_img ) ) : ?>
											<img class="alignleft" src="<?php echo esc_url( $d_img ); ?>" alt="<?php echo esc_attr( $d_title ); ?>">
										<?php endif; ?>
										<?php echo wp_kses_post( $d_desc ); ?>
									</p>
								</div>
								<?php
							endwhile;
						endif;
						?>
					</div>

					<div class="club_location_detail clearfix row">
						<div class="clob_location_left col-xs-12 col-md-5">
							<?php $location_text = get_field( 'location_text' ); ?>
							<?php if ( $location_text ) : ?>
								<div class="location_text">
									<h2><?php esc_html_e( 'Location', 'tony-clubcircuit' ); ?></h2>
									<p><?php tcc_icon( 'map' ); ?><strong><?php echo esc_html( $location_text ); ?></strong></p>
								</div>
							<?php endif; ?>

							<?php $website = get_field( 'website' ); ?>
							<?php if ( $website ) : ?>
								<div class="location_text">
									<h2><?php esc_html_e( 'Website', 'tony-clubcircuit' ); ?></h2>
									<p><?php tcc_icon( 'globe' ); ?><strong><a href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $website ); ?></a></strong></p>
								</div>
							<?php endif; ?>

							<div class="location_keypeople">
								<?php if ( have_rows( 'key_people' ) ) : ?>
									<h2><?php esc_html_e( 'Key People', 'tony-clubcircuit' ); ?></h2>
									<?php
									while ( have_rows( 'key_people' ) ) :
										the_row();
										$kp_title = get_sub_field( 'title' );
										$kp_value = get_sub_field( 'value' );
										?>
										<div class="item">
											<p><strong><?php echo esc_html( $kp_title ); ?> :</strong> <?php echo esc_html( $kp_value ); ?></p>
										</div>
										<?php
									endwhile;
								endif;
								?>

								<?php
								$club_social = array(
									'facebook'  => get_field( 'facebook_url' ),
									'twitter'   => get_field( 'twitter_url' ),
									'instagram' => get_field( 'instagram_url' ),
									'youtube'   => get_field( 'youtube_url' ),
								);
								?>
								<div class="contact_social">
									<?php tcc_social_links( $club_social ); ?>
								</div>
							</div>
						</div>

						<div class="clob_location_right col-xs-12 col-md-7">
							<?php echo get_field( 'map_embed_code' ); // phpcs:ignore WordPress.Security.EscapeOutput -- map embed iframe. ?>
						</div>
					</div>

					<?php
					/* Announcements (optional, selected per club) */
					$select_announcement = get_field( 'select_announcement' );
					if ( ! empty( $select_announcement ) ) :
						$ann_catid = function_exists( 'of_get_option' ) ? of_get_option( 'homepage_announcement_catid' ) : 1;
						?>
						<div class="section_content">
							<div class="container">
								<div class="row">
									<div class="col-xs-12">
										<h2 class="common_heading"><?php echo esc_html( get_cat_name( $ann_catid ) ); ?></h2>
										<div class="subtitletext"><?php echo wp_kses_post( category_description( $ann_catid ) ); ?></div>
									</div>
									<div class="col-xs-12">
										<div class="announcement-owl-carousel anouncement_list">
											<?php
											foreach ( $select_announcement as $singlepost ) :
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
											<?php endforeach; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>

	<?php
endwhile;

get_footer();
