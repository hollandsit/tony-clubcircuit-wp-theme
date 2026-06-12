<?php
/**
 * Template Name:Club Circuit Rules Page
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

						<?php if ( have_rows( 'cc_rules' ) ) : ?>
							<?php $cc_rules = get_field_object( 'cc_rules' ); ?>
							<div class="row panel_bx">
								<div class="col-md-12">
									<div class="panel panel-primary">
										<div class="panel-heading"><?php echo esc_html( $cc_rules['label'] ); ?></div>
										<div class="panel-body">
											<div class="row">
												<?php
												while ( have_rows( 'cc_rules' ) ) :
													the_row();
													$cc_title = get_sub_field( 'title' );
													$cc_file  = get_sub_field( 'upload_file' );
													?>
													<div class="col-xs-12 col-md-6">
														<div class="icon_bx">
															<img src="<?php echo esc_url( get_template_directory_uri() . '/images/pdf.png' ); ?>" alt="PDF">
															<h4><a href="<?php echo esc_url( $cc_file ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $cc_title ); ?></a></h4>
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
