<?php
/**
 * Template Name:Links & Rules
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
							<div class="col-xs-12"><?php the_content(); ?></div>
						</div>

						<div class="row">
							<div class="col-xs-12">
								<?php
								if ( have_rows( 'links_or_rules' ) ) :
									while ( have_rows( 'links_or_rules' ) ) :
										the_row();
										$lr_title = get_sub_field( 'title' );
										$lr_desc  = get_sub_field( 'description' );
										if ( ! empty( $lr_title ) ) :
											?>
											<div class="rules_links">
												<h3><?php echo esc_html( $lr_title ); ?></h3>
												<p><?php echo wp_kses_post( $lr_desc ); ?></p>
											</div>
											<?php
										endif;
									endwhile;
								endif;
								?>
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
