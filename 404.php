<?php
/**
 * Not found page.
 *
 * @package Watch_Collections
 */
get_header();
?>
<main id="main" class="standard-main container not-found">
	<p class="eyebrow">404 / <?php esc_html_e( 'NOT FOUND', 'watch-collections' ); ?></p>
	<h1><?php esc_html_e( 'Looks like this moment has passed.', 'watch-collections' ); ?></h1>
	<p><?php esc_html_e( 'That page isn’t here. You can always start again.', 'watch-collections' ); ?></p>
	<a class="button button-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to the homepage', 'watch-collections' ); ?> ↗</a>
</main>
<?php get_footer(); ?>
