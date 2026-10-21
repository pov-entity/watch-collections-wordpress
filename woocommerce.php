<?php
/**
 * WooCommerce wrapper. WooCommerce supplies archive and single-product output.
 *
 * @package Watch_Collections
 */
get_header();
?>
<main id="main" class="standard-main shop-main container">
	<?php if ( function_exists( 'woocommerce_content' ) ) : ?>
		<?php woocommerce_content(); ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Install and activate WooCommerce to display the shop.', 'watch-collections' ); ?></p>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
