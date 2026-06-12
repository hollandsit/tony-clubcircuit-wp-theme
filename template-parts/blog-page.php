<?php
/**
 * Template Name:Blog
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
					<div class="col-xs-12 col-md-3 content_left_blog">
						<div class="blog_cate">
							<h3><?php esc_html_e( 'Select Topic', 'tony-clubcircuit' ); ?></h3>
							<ul>
								<?php wp_list_pages( 'child_of=479&title_li=' ); ?>
							</ul>
						</div>
					</div>

					<div class="col-xs-12 col-md-9">
						<div class="blog_list_hold">
							<?php
							$blog_posts = new WP_Query( array(
								'post_type'      => 'post',
								'posts_per_page' => -1,
								'orderby'        => 'ID',
							) );

							if ( $blog_posts->have_posts() ) :
								while ( $blog_posts->have_posts() ) :
									$blog_posts->the_post();
									?>
									<div class="blog_list">
										<div class="blog_list_cont">
											<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
											<span class="blog_cont_left"><?php echo esc_html( get_the_date( 'd M, Y' ) ); ?></span>
											<span class="blog_cont_right"><?php printf( esc_html__( 'Posted by %s', 'tony-clubcircuit' ), esc_html( get_the_author() ) ); ?></span>
										</div>
									</div>
									<?php
								endwhile;
								wp_reset_postdata();
							endif;
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php
endwhile;

get_footer();
