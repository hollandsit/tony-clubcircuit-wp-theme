<?php
/**
 * The template for displaying the Club archive (Member Clubs).
 *
 * @package tony-clubcircuit
 */

get_header(); ?>

<div class="page_top_section">
	<div class="container">
		<h2 class="page_head"><?php esc_html_e( 'Member Clubs', 'tony-clubcircuit' ); ?></h2>
		<?php if ( function_exists( 'bcn_display' ) ) : ?>
			<div class="breadcrumb_inner_pages"><?php bcn_display(); ?></div>
		<?php endif; ?>
	</div>
</div>

<div class="inner_content">
	<div class="container">
		<div class="inner_content_block">
			<?php
			$intro = function_exists( 'of_get_option' ) ? of_get_option( 'member_club_lisint_page_content' ) : '';
			if ( ! empty( $intro ) ) {
				echo '<div class="subtitletext" style="text-align:left;margin-left:0;">' . wp_kses_post( $intro ) . '</div>';
			}

			$paged     = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
			$clb_query = new WP_Query( array(
				'post_type'      => 'club',
				'paged'          => $paged,
				'posts_per_page' => 5,
				'orderby'        => 'title',
				'order'          => 'ASC',
			) );

			if ( $clb_query->have_posts() ) :
				while ( $clb_query->have_posts() ) :
					$clb_query->the_post();
					$clb_id    = get_the_ID();
					$clb_thumb = tcc_thumb_url( $clb_id, 'medium' );
					$about     = get_post_meta( $clb_id, 'about_history', true );
					?>
					<div class="club_listing">
						<div class="row">
							<div class="col-xs-12 col-md-3">
								<div class="club_thumb">
									<a href="<?php the_permalink(); ?>">
										<?php if ( $clb_thumb ) : ?>
											<img src="<?php echo esc_url( $clb_thumb ); ?>" alt="<?php the_title_attribute(); ?>">
										<?php else : ?>
											<span class="club_thumb__placeholder"><?php echo esc_html( get_the_title() ); ?></span>
										<?php endif; ?>
									</a>
								</div>
							</div>
							<div class="col-xs-12 col-md-9">
								<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
								<p><?php echo esc_html( wp_trim_words( $about, 40, '…' ) ); ?></p>
								<a href="<?php the_permalink(); ?>" class="readmore"><?php esc_html_e( 'Read more', 'tony-clubcircuit' ); ?> <?php tcc_icon( 'arrow' ); ?></a>
							</div>
						</div>
					</div>
					<?php
				endwhile;
				?>

				<div class="for-pagination">
					<?php
					echo ClbCircuitPagination( $paged, $clb_query->max_num_pages ); // phpcs:ignore WordPress.Security.EscapeOutput
					?>
				</div>

				<?php
				wp_reset_postdata();
			else :
				echo '<p>' . esc_html__( 'No clubs found.', 'tony-clubcircuit' ) . '</p>';
			endif;
			?>
		</div>
	</div>
</div>

<?php
get_footer();
