<?php
/**
 * Template Name:Insurance
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
						<div class="row">
							<div class="col-xs-12 col-md-6 insurance_content">
								<?php the_content(); ?>
							</div>

							<?php if ( have_rows( 'additional_images' ) ) : ?>
								<div class="col-xs-12 col-md-6">
									<div class="row">
										<?php
										while ( have_rows( 'additional_images' ) ) :
											the_row();
											$image = get_sub_field( 'upload_images' );
											if ( ! empty( $image ) ) :
												?>
												<div class="col-xs-6 col-md-4"><img src="<?php echo esc_url( $image ); ?>" alt=""></div>
												<?php
											endif;
										endwhile;
										?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( have_rows( 'upload_documents' ) ) : ?>
								<div class="col-xs-12 col-md-6">
									<div class="pdf_bx clearfix">
										<?php
										while ( have_rows( 'upload_documents' ) ) :
											the_row();
											$document_name        = get_sub_field( 'document_name' );
											$upload_doc           = get_sub_field( 'upload_insurance_document' );
											if ( ! empty( $upload_doc ) ) :
												?>
												<div class="insurance_pdf">
													<img src="<?php echo esc_url( get_template_directory_uri() . '/images/pdf.png' ); ?>" alt="PDF">
													<h4><a href="<?php echo esc_url( $upload_doc ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $document_name ); ?></a></h4>
												</div>
												<?php
											endif;
										endwhile;
										?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
endwhile;

get_footer();
