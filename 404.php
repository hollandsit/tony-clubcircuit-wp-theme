<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package tony-clubcircuit
 */

get_header(); ?>

<div class="page_top_section">
	<div class="container">
		<h2 class="page_head"><?php esc_html_e( 'Oops! That page can’t be found.', 'tony-clubcircuit' ); ?></h2>
	</div>
</div>

<div class="inner_content">
	<div class="container">
		<div class="inner_content_block">
			<div class="blog_detail">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search, or head back home?', 'tony-clubcircuit' ); ?></p>

				<?php get_search_form(); ?>

				<p style="margin-top:1.5rem;">
					<a class="cc-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'tony-clubcircuit' ); ?></a>
				</p>
			</div>
		</div>
	</div>
</div>

<?php
get_footer();
