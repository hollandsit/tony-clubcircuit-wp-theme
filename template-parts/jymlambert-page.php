<?php
/**
 * Template Name:JIM Lambert Medal Page
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
							<div class="col-md-12 about_us_left_content"><?php the_content(); ?></div>
						</div>

						<?php if ( have_rows( 'jim' ) ) : ?>
							<?php $jim = get_field_object( 'jim' ); ?>
							<div class="row panel_bx">
								<div class="col-md-12">
									<div class="panel panel-primary">
										<div class="panel-heading"><?php echo esc_html( $jim['label'] ); ?></div>
										<div class="panel-body">
											<div class="row">
												<?php
												while ( have_rows( 'jim' ) ) :
													the_row();
													$gym_title     = get_sub_field( 'title' );
													$gym_file      = get_sub_field( 'upload_file' );
													$gym_file_icon = get_sub_field( 'file_icon' );
													$icon_path     = get_template_directory() . '/images/' . $gym_file_icon . '.png';
													$icon_src      = file_exists( $icon_path )
														? get_template_directory_uri() . '/images/' . $gym_file_icon . '.png'
														: get_template_directory_uri() . '/images/pdf.png';
													?>
													<div class="col-xs-12 col-md-6">
														<div class="icon_bx">
															<img src="<?php echo esc_url( $icon_src ); ?>" alt="">
															<h4><a href="<?php echo esc_url( $gym_file ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $gym_title ); ?></a></h4>
														</div>
													</div>
													<?php
												endwhile;
												?>
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
	</div>

	<?php
endwhile;

get_footer();
