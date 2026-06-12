<?php
/**
 * Template Name:Contact
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
				<div class="blog_detail">
					<div class="main_blog_detail">
						<?php the_content(); ?>
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="contact_left">
									<?php $map_iframe = get_field( 'map_iframe' ); ?>
									<?php if ( $map_iframe ) : ?>
										<div class="map_contact"><?php echo $map_iframe; // phpcs:ignore WordPress.Security.EscapeOutput -- map iframe. ?></div>
									<?php endif; ?>

									<div class="map_address">
										<ul>
											<?php $address = get_field( 'address' ); ?>
											<?php if ( $address ) : ?>
												<li><?php tcc_icon( 'map' ); ?> <span><?php echo esc_html( $address ); ?></span></li>
											<?php endif; ?>
											<?php $phone = get_field( 'phone' ); ?>
											<?php if ( $phone ) : ?>
												<li><?php tcc_icon( 'phone' ); ?> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
											<?php endif; ?>
											<?php $email = get_field( 'email' ); ?>
											<?php if ( $email ) : ?>
												<li><?php tcc_icon( 'envelope' ); ?> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
											<?php endif; ?>
										</ul>
									</div>

									<?php
									$contact_social = array(
										'facebook'  => function_exists( 'of_get_option' ) ? of_get_option( 'facebook_url' ) : '',
										'twitter'   => function_exists( 'of_get_option' ) ? of_get_option( 'twitter_url' ) : '',
										'instagram' => function_exists( 'of_get_option' ) ? of_get_option( 'instagram_url' ) : '',
										'youtube'   => function_exists( 'of_get_option' ) ? of_get_option( 'youtube_url' ) : '',
									);
									?>
									<div class="contact_social">
										<?php tcc_social_links( $contact_social ); ?>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="contact_right">
									<?php
									$contact_form = get_field( 'contact_form_shortocode' );
									echo do_shortcode( $contact_form );
									?>
								</div>
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
