<?php
/**
 * Template Name:Past Years Pennant Results
 *
 * @package tony-clubcircuit
 */

get_header();

while ( have_posts() ) :
	the_post();
	$post_id = get_the_ID();
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
					<div class="col-xs-12"><?php the_content(); ?></div>
				</div>

				<div class="row">
					<?php
					if ( have_rows( 'past_pennant_result_links' ) ) :
						while ( have_rows( 'past_pennant_result_links' ) ) :
							the_row();
							$ppr_title = get_sub_field( 'title' );
							$ppr_link  = get_sub_field( 'link' );
							?>
							<div class="col-xs-12 col-sm-6 col-md-4">
								<div class="rules_links">
									<h4><a href="<?php echo esc_url( $ppr_link ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $ppr_title ); ?></a></h4>
								</div>
							</div>
							<?php
						endwhile;
					endif;
					?>
				</div>

				<?php $post_description = get_post_meta( $post_id, 'post_description', true ); ?>
				<?php if ( ! empty( $post_description ) ) : ?>
					<div class="row">
						<div class="col-xs-12"><?php echo nl2br( wp_kses_post( $post_description ) ); ?></div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<?php
endwhile;

get_footer();
