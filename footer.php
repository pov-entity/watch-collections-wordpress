<?php
/**
 * Global site footer.
 *
 * @package Watch_Collections
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
	<footer class="site-footer">
		<div class="container footer-main">
			<div>
				<a class="footer-wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>">WATCH<span>COLLECTIONS</span></a>
				<p><?php esc_html_e( 'For the workdays, the weekends, and everything in between.', 'watch-collections' ); ?></p>
			</div>
			<div class="footer-links">
				<a href="<?php echo esc_url( home_url( '/#collection-options' ) ); ?>"><?php esc_html_e( 'Collections', 'watch-collections' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/#quality' ) ); ?>"><?php esc_html_e( 'The details', 'watch-collections' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/#fulfillment' ) ); ?>"><?php esc_html_e( 'Delivery journey', 'watch-collections' ); ?></a>
			</div>
		</div>
		<div class="container footer-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.</span>
			<span><?php esc_html_e( 'Prototype store · Shipping, returns and policies will be published before launch.', 'watch-collections' ); ?></span>
		</div>
	</footer>
</div><!-- .site-shell -->
<?php wp_footer(); ?>
</body>
</html>
