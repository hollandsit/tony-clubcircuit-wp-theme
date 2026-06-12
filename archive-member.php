<?php
/**
 * The template for displaying the Member archive.
 *
 * @package tony-clubcircuit
 */

get_header(); ?>

<div class="page_top_section">
	<div class="container">
		<h2 class="page_head"><?php esc_html_e( 'Members', 'tony-clubcircuit' ); ?></h2>
		<?php if ( function_exists( 'bcn_display' ) ) : ?>
			<div class="breadcrumb_inner_pages"><?php bcn_display(); ?></div>
		<?php endif; ?>
	</div>
</div>

<div class="inner_content">
	<div class="container">
		<div class="inner_content_block">
			<?php
			$paged        = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
			$member_query = new WP_Query( array(
				'post_type'      => 'member',
				'paged'          => $paged,
				'posts_per_page' => 5,
			) );

			if ( $member_query->have_posts() ) :
				while ( $member_query->have_posts() ) :
					$member_query->the_post();
					$member_id    = get_the_ID();
					$member_thumb = tcc_thumb_url( $member_id, 'medium' );
					$excerpt      = get_the_excerpt();
					if ( empty( $excerpt ) ) {
						$excerpt = wp_strip_all_tags( get_the_content() );
					}
					?>
					<div class="club_listing">
						<div class="row">
							<div class="col-xs-12 col-md-3">
								<div class="club_thumb">
									<a href="<?php the_permalink(); ?>">
										<?php if ( $member_thumb ) : ?>
											<img src="<?php echo esc_url( $member_thumb ); ?>" alt="<?php the_title_attribute(); ?>">
										<?php else : ?>
											<span class="club_thumb__placeholder"><?php echo esc_html( get_the_title() ); ?></span>
										<?php endif; ?>
									</a>
								</div>
							</div>
							<div class="col-xs-12 col-md-9">
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p><?php echo esc_html( wp_trim_words( $excerpt, 40, '…' ) ); ?></p>
								<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e( 'Read more', 'tony-clubcircuit' ); ?> <?php tcc_icon( 'arrow' ); ?></a>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				?>

				<div class="for-pagination">
					<?php
					echo ClbCircuitPagination( $paged, $member_query->max_num_pages ); // phpcs:ignore WordPress.Security.EscapeOutput
					?>
				</div>

				<?php
				wp_reset_postdata();
			else :
				echo '<p>' . esc_html__( 'No members found.', 'tony-clubcircuit' ) . '</p>';
			endif;
			?>
		</div>
	</div>
</div>

<?php
get_footer();
