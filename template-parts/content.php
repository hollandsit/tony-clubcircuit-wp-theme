<?php
/**
 * Template part for displaying posts.
 *
 * @package tony-clubcircuit
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'cc-post-card' ); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<span class="blog_cont_left"><?php echo esc_html( get_the_date( 'd M, Y' ) ); ?></span>
				<span class="blog_cont_right"><?php printf( esc_html__( 'Posted by %s', 'tony-clubcircuit' ), esc_html( get_the_author() ) ); ?></span>
			</div>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'tony-clubcircuit' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'tony-clubcircuit' ),
			'after'  => '</div>',
		) );
		?>
	</div>
</article>
