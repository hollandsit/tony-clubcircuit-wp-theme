<?php
/**
 * The template for displaying the footer.
 *
 * Closes #main-content and outputs the site footer.
 *
 * @package tony-clubcircuit
 */

$cc_copyright = function_exists( 'of_get_option' ) ? of_get_option( 'copyright_textarea' ) : '';
$cc_social    = array(
	'facebook'  => function_exists( 'of_get_option' ) ? of_get_option( 'facebook_url' ) : '',
	'twitter'   => function_exists( 'of_get_option' ) ? of_get_option( 'twitter_url' ) : '',
	'instagram' => function_exists( 'of_get_option' ) ? of_get_option( 'instagram_url' ) : '',
	'youtube'   => function_exists( 'of_get_option' ) ? of_get_option( 'youtube_url' ) : '',
);
?>
</main><!-- #main-content -->

<footer class="site-footer" role="contentinfo">
	<div class="container">

		<?php if ( is_active_sidebar( 'newsletter' ) || is_active_sidebar( 'visitorcounter' ) ) : ?>
			<div class="footer-top row">
				<div class="col-xs-12 col-md-9">
					<?php dynamic_sidebar( 'newsletter' ); ?>
				</div>
				<div class="col-xs-12 col-md-3">
					<div class="visitorcounter">
						<?php dynamic_sidebar( 'visitorcounter' ); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="footer-main row">
			<div class="col-xs-12 col-md-8">
				<?php if ( is_active_sidebar( 'Footer-1' ) ) : ?>
					<div class="footer-widgets"><?php dynamic_sidebar( 'Footer-1' ); ?></div>
				<?php endif; ?>

				<?php
				if ( has_nav_menu( 'footer_nav' ) ) :
					?>
					<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer menu', 'tony-clubcircuit' ); ?>">
						<?php
						wp_nav_menu( array(
							'theme_location' => 'footer_nav',
							'menu_class'     => 'menu',
							'container'      => false,
							'depth'          => 1,
						) );
						?>
					</nav>
					<?php
				endif;
				?>

				<?php if ( ! empty( $cc_copyright ) ) : ?>
					<p class="ftr_copyright"><?php echo wp_kses_post( $cc_copyright ); ?></p>
				<?php endif; ?>
			</div>

			<div class="col-xs-12 col-md-4">
				<div class="ftr_social">
					<?php tcc_social_links( $cc_social ); ?>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<p>&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'tony-clubcircuit' ); ?></p>
		</div>

	</div><!-- .container -->
</footer><!-- .site-footer -->

<?php wp_footer(); ?>
</body>
</html>
