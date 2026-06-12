<?php
/**
 * Template Name:Marketplace
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

	<div class="inner_content">
		<div class="container">
			<div class="inner_content_block">
				<div class="row">
					<div class="col-xs-12"><?php the_content(); ?></div>
				</div>

				<div class="row">
					<?php
					if ( have_rows( 'marketplace' ) ) :
						while ( have_rows( 'marketplace' ) ) :
							the_row();
							$mp_name    = get_sub_field( 'name' );
							$mp_desc    = get_sub_field( 'description' );
							$mp_contact = get_sub_field( 'contact_details' );
							$mp_image   = get_sub_field( 'image' );
							?>
							<div class="col-xs-12 col-md-6">
								<div class="profilebox">
									<?php if ( $mp_image ) : ?>
										<div class="profile_image"><img src="<?php echo esc_url( $mp_image ); ?>" alt="<?php echo esc_attr( $mp_name ); ?>"></div>
									<?php endif; ?>
									<?php if ( $mp_name ) : ?><h4><?php echo esc_html( $mp_name ); ?></h4><?php endif; ?>
									<?php if ( $mp_contact ) : ?><p><?php echo wp_kses_post( $mp_contact ); ?></p><?php endif; ?>
									<?php if ( $mp_desc ) : ?><p><?php echo wp_kses_post( $mp_desc ); ?></p><?php endif; ?>
								</div>
							</div>
							<?php
						endwhile;
					endif;
					?>
				</div>
			</div>
		</div>
	</div>

	<?php
endwhile;

get_footer();
