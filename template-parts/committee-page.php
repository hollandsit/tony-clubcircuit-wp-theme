<?php
/**
 * Template Name:Commitee
 *
 * @package tony-clubcircuit
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<div class="page_top_section">
		<div class="container">
			<h2 class="page_head"><?php the_title(); ?></h2>
			<?php if ( function_exists( 'bcn_display' ) ) : ?>
				<div class="breadcrumb_inner_pages"><?php bcn_display(); ?></div>
			<?php endif; ?>
		</div>
	</div>

	<div class="inner_content about_us">
		<div class="container">
			<div class="inner_content_block">
				<div class="blog_detail">
					<div class="main_blog_detail">
						<div class="row">
							<div class="col-md-12">
								<h3 class="blue_txt"><?php the_title(); ?></h3>
							</div>
						</div>

						<?php
						$choose_member = get_field( 'choose_member' );
						if ( is_array( $choose_member ) && ! empty( $choose_member ) ) :
							?>
							<div class="row">
								<?php
								foreach ( $choose_member as $singlemember ) :
									$member_obj_id = is_object( $singlemember ) ? $singlemember->ID : $singlemember;
									$member_title  = get_the_title( $member_obj_id );
									$position      = get_post_meta( $member_obj_id, 'committee_position_for_members', true );
									$position      = ( '' !== trim( $position ) ) ? $position : '&nbsp;';
									$thumb_url     = tcc_thumb_url( $member_obj_id, 'medium' );
									$permalink     = get_permalink( $member_obj_id );
									?>
									<div class="col-xs-6 col-sm-4 col-md-3 team_members">
										<div class="thumbnail_team">
											<div class="team_image">
												<a href="<?php echo esc_url( $permalink ); ?>">
													<?php if ( $thumb_url ) : ?>
														<img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $member_title ); ?>">
													<?php endif; ?>
												</a>
											</div>
											<div class="team_caption">
												<h3><?php echo esc_html( $member_title ); ?></h3>
												<p><?php echo wp_kses_post( $position ); ?></p>
											</div>
										</div>
									</div>
									<?php
								endforeach;
								?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
endwhile;

get_footer();
