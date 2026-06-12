<?php
/**
 * Template Name:About Us
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
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
endwhile;

get_footer();
