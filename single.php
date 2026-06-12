<?php
/**
 * The template for displaying all single posts.
 *
 * @package tony-clubcircuit
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

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

				<div class="next_prev_blog">
					<?php previous_post_link( '%link', '&laquo; ' . esc_html__( 'Previous Post', 'tony-clubcircuit' ) ); ?>
					<?php next_post_link( '%link', esc_html__( 'Next Post', 'tony-clubcircuit' ) . ' &raquo;' ); ?>
				</div>

				<div class="blog_detail">
					<?php if ( has_excerpt() ) : ?>
						<p class="entry-summary"><?php the_excerpt(); ?></p>
					<?php endif; ?>

					<div class="main_blog_detail">
						<?php
						$cc_thumb = tcc_thumb_url( get_the_ID(), 'large' );
						if ( $cc_thumb ) :
							?>
							<div class="blog_detail_img">
								<img src="<?php echo esc_url( $cc_thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
							</div>
						<?php endif; ?>

						<?php
						the_content();

						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tony-clubcircuit' ),
							'after'  => '</div>',
						) );
						?>
					</div>

					<?php if ( function_exists( 'display_social4i' ) ) : ?>
						<div class="social_share">
							<?php echo display_social4i( 'small', 'float-left' ); // phpcs:ignore ?>
						</div>
					<?php endif; ?>

					<?php
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
					?>
				</div>

			</div>
		</div>
	</div>

<?php endwhile; ?>

<?php
get_footer();
