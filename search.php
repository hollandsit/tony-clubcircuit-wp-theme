<?php
/**
 * The template for displaying search results pages.
 *
 * @package tony-clubcircuit
 */

get_header(); ?>

<div class="page_top_section">
	<div class="container">
		<h2 class="page_head">
			<?php printf( esc_html__( 'Search Results for: %s', 'tony-clubcircuit' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?>
		</h2>
		<?php if ( function_exists( 'bcn_display' ) ) : ?>
			<div class="breadcrumb_inner_pages"><?php bcn_display(); ?></div>
		<?php endif; ?>
	</div>
</div>

<div class="inner_content">
	<div class="container">
		<div class="inner_content_block">
			<?php if ( have_posts() ) : ?>
				<div class="blog_detail">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content', 'search' );
					endwhile;

					the_posts_navigation();
					?>
				</div>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php
get_footer();
