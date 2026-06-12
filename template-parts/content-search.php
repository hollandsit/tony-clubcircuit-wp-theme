<?php
/**
 * Template part for displaying results in search pages.
 *
 * @package tony-clubcircuit
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'cc-search-result' ); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<span class="blog_cont_left"><?php echo esc_html( get_the_date( 'd M, Y' ) ); ?></span>
			</div>
		<?php endif; ?>
	</header>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
		<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e( 'Read more', 'tony-clubcircuit' ); ?> <?php tcc_icon( 'arrow' ); ?></a>
	</div>
</article>
