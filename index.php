<?php
/**
 * The main template file.
 *
 * @package tony-clubcircuit
 */

get_header(); ?>

<div class="page_top_section">
	<div class="container">
		<h2 class="page_head">
			<?php
			if ( is_home() && ! is_front_page() ) {
				single_post_title();
			} else {
				esc_html_e( 'Latest Posts', 'tony-clubcircuit' );
			}
			?>
		</h2>
		<?php if ( function_exists( 'bcn_display' ) ) : ?>
			<div class="breadcrumb_inner_pages"><?php bcn_display(); ?></div>
		<?php endif; ?>
	</div>
</div>

<div class="inner_content">
	<div class="container">
		<div class="inner_content_block">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', get_post_format() );
				endwhile;

				the_posts_navigation();
			else :
				get_template_part( 'template-parts/content', 'none' );
			endif;
			?>
		</div>
	</div>
</div>

<?php
get_footer();
