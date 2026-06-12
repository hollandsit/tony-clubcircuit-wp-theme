<?php
/**
 * The template for displaying archive pages.
 *
 * @package tony-clubcircuit
 */

get_header(); ?>

<div class="page_top_section">
	<div class="container">
		<?php the_archive_title( '<h2 class="page_head">', '</h2>' ); ?>
		<?php if ( function_exists( 'bcn_display' ) ) : ?>
			<div class="breadcrumb_inner_pages"><?php bcn_display(); ?></div>
		<?php endif; ?>
	</div>
</div>

<div class="inner_content">
	<div class="container">
		<?php the_archive_description( '<div class="subtitletext" style="text-align:left;margin-left:0;">', '</div>' ); ?>

		<?php if ( have_posts() ) : ?>
			<div class="row">
				<div class="col-xs-12 col-md-4 content_left">
					<div class="blog_cate">
						<h3><?php esc_html_e( 'All Posts', 'tony-clubcircuit' ); ?></h3>
						<ul>
							<?php
							global $wp_query;
							$cc_posts = $wp_query->posts;
							foreach ( $cc_posts as $cc_p ) :
								?>
								<li><a href="<?php echo esc_url( get_permalink( $cc_p->ID ) ); ?>"><?php echo esc_html( get_the_title( $cc_p->ID ) ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>

				<div class="col-xs-12 col-md-8 content_right">
					<div class="blog_list_hold">
						<?php
						while ( have_posts() ) :
							the_post();
							$cc_thumb = tcc_thumb_url( get_the_ID(), 'medium' );
							$cc_excerpt = get_the_excerpt();
							if ( empty( $cc_excerpt ) ) {
								$cc_excerpt = wp_strip_all_tags( get_the_content() );
							}
							?>
							<div class="blog_list">
								<?php if ( $cc_thumb ) : ?>
									<div class="blog_img"><a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $cc_thumb ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"></a></div>
								<?php endif; ?>
								<div class="blog_list_cont">
									<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
									<span class="blog_cont_left"><?php echo esc_html( get_the_date( 'd M, Y' ) ); ?></span>
									<span class="blog_cont_right"><?php printf( esc_html__( 'Posted by %s', 'tony-clubcircuit' ), esc_html( get_the_author() ) ); ?></span>
									<p><?php echo esc_html( wp_trim_words( $cc_excerpt, 24, '…' ) ); ?></p>
									<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e( 'Read more', 'tony-clubcircuit' ); ?> <?php tcc_icon( 'arrow' ); ?></a>
								</div>
							</div>
						<?php endwhile; ?>

						<?php the_posts_navigation(); ?>
					</div>
				</div>
			</div>
		<?php else : ?>
			<?php get_template_part( 'template-parts/content', 'none' ); ?>
		<?php endif; ?>
	</div>
</div>

<?php
get_footer();
