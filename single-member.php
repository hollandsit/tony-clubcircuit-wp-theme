<?php
/**
 * The template for displaying a single Member.
 *
 * @package tony-clubcircuit
 */

get_header();

while ( have_posts() ) :
	the_post();
	$member_id = get_the_ID();
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
				<div class="member_detail clearfix">
					<div class="row">
						<div class="col-xs-12 col-md-3">
							<div class="club_header">
								<?php $member_thumb = tcc_thumb_url( $member_id, 'medium' ); ?>
								<?php if ( $member_thumb ) : ?>
									<div class="club_header_logo">
										<img src="<?php echo esc_url( $member_thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
									</div>
								<?php endif; ?>
								<div class="club_header_title">
									<h2><?php the_title(); ?></h2>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-md-9">
							<?php if ( has_excerpt() ) : ?>
								<div class="club_header_excerpt"><p><?php the_excerpt(); ?></p></div>
							<?php endif; ?>

							<div class="club_header_detail"><?php the_content(); ?></div>

							<div class="member_detail">
								<?php
								$committee_position = get_field( 'committee_position_for_members' );
								$contact_number     = get_field( 'contact_number' );
								$email              = get_field( 'email' );
								?>
								<?php if ( $committee_position ) : ?>
									<h3><?php esc_html_e( 'Committee Position', 'tony-clubcircuit' ); ?> : <span><?php echo esc_html( $committee_position ); ?></span></h3>
								<?php endif; ?>
								<?php if ( $contact_number ) : ?>
									<h3><?php esc_html_e( 'Contact Number', 'tony-clubcircuit' ); ?> : <span><?php echo esc_html( $contact_number ); ?></span></h3>
								<?php endif; ?>
								<?php if ( $email ) : ?>
									<h3><?php esc_html_e( 'Email', 'tony-clubcircuit' ); ?> : <span><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span></h3>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
endwhile;

get_footer();
