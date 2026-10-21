<?php
/**
 * Template Name: Collection Studio
 * A browser-local selection prototype, separate from real commerce.
 *
 * @package Watch_Collections
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$packages = watch_collections_packages();
$box_views = array(
	1 => array( 'width' => 1024, 'height' => 1536, 'frame' => array( 128, 64, 768, 1414 ), 'area' => array( 250, 270, 524, 1050 ), 'gap' => 0, 'smallWidth' => 384 ),
	3 => array( 'width' => 1536, 'height' => 1024, 'frame' => array( 60, 100, 1416, 850 ), 'area' => array( 163, 270, 1206, 550 ), 'gap' => 33, 'smallWidth' => 768 ),
	6 => array( 'width' => 2172, 'height' => 724, 'frame' => array( 48, 48, 2076, 632 ), 'area' => array( 130, 170, 1925, 410 ), 'gap' => 25, 'smallWidth' => 1024 ),
);
foreach ( $box_views as $count => &$box_view ) {
	$base              = get_template_directory_uri() . '/assets/boxes/box-' . $count . '-overhead';
	$box_view['src']    = add_query_arg( 'ver', wp_get_theme()->get( 'Version' ), $base . '.webp' );
	$box_view['small']  = add_query_arg( 'ver', wp_get_theme()->get( 'Version' ), $base . '-small.webp' );
}
unset( $box_view );
$config = array( 'watches' => watch_collections_studio_catalog(), 'packages' => $packages, 'defaultSize' => 3, 'boxes' => $box_views );
?>
<main id="main" class="studio" data-collection-studio>
	<div class="container studio-container">
		<div class="studio-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'watch-collections' ); ?></a><span aria-hidden="true">/</span><span><?php esc_html_e( 'Collection Studio', 'watch-collections' ); ?></span></div>
		<header class="studio-intro">
			<div><p class="studio-kicker"><span></span><?php esc_html_e( 'THE COLLECTION STUDIO', 'watch-collections' ); ?></p><h1><?php esc_html_e( 'Make room for', 'watch-collections' ); ?> <em><?php esc_html_e( 'every side of you.', 'watch-collections' ); ?></em></h1><p class="studio-lede"><?php esc_html_e( 'One for the everyday. Something for the unexpected. Choose the watches that belong in your life, and bring them together in one box.', 'watch-collections' ); ?></p></div>
			<ol class="studio-steps" aria-label="<?php esc_attr_e( 'Build your collection steps', 'watch-collections' ); ?>"><li><span>01</span><?php esc_html_e( 'Choose your box', 'watch-collections' ); ?></li><li aria-current="step"><span>02</span><?php esc_html_e( 'Find your watches', 'watch-collections' ); ?></li><li><span>03</span><?php esc_html_e( 'See it together', 'watch-collections' ); ?></li></ol>
		</header>
		<div class="studio-prototype"><span class="studio-prototype__label"><?php esc_html_e( 'DESIGN PREVIEW', 'watch-collections' ); ?></span><p><?php esc_html_e( 'Explore with illustrated concept watches. Final models, specifications and availability will be confirmed before launch. No orders or payments are taken here.', 'watch-collections' ); ?></p></div>
		<noscript><p class="studio-notice"><?php esc_html_e( 'Enable JavaScript to use the Collection Studio. The planned box sizes and prices are listed below.', 'watch-collections' ); ?></p></noscript>
		<section class="studio-size" aria-labelledby="studio-size-title">
			<div class="studio-section-label"><h2 id="studio-size-title"><span>01</span><?php esc_html_e( 'Start with your number.', 'watch-collections' ); ?></h2><p><?php esc_html_e( 'Every box starts with your choice.', 'watch-collections' ); ?></p></div>
			<div class="studio-size-options" role="group" aria-label="<?php esc_attr_e( 'Choose your collection size', 'watch-collections' ); ?>">
			<?php foreach ( $packages as $package ) : ?>
				<button type="button" class="studio-size-option" data-action="size" data-size="<?php echo esc_attr( $package['count'] ); ?>" aria-pressed="false">
					<span class="studio-size-option__photo" aria-hidden="true"><?php watch_collections_box_image( $package['count'], 'studio-box-photo', '(max-width: 700px) 28vw, 112px' ); ?></span>
					<span class="studio-size-option__copy"><strong><?php echo esc_html( sprintf( _n( '%d watch', '%d watches', $package['count'], 'watch-collections' ), $package['count'] ) ); ?></strong><small><?php echo esc_html( $package['name'] ); ?></small></span>
					<span class="studio-size-option__price"><?php if ( null !== $package['price'] ) : ?>$<?php echo esc_html( $package['price'] ); ?><small>USD / <?php esc_html_e( 'planned', 'watch-collections' ); ?></small><?php else : ?><span class="studio-price-pending"><?php esc_html_e( 'Price to be confirmed', 'watch-collections' ); ?></span><?php endif; ?></span><span class="studio-radio" aria-hidden="true"></span>
				</button>
			<?php endforeach; ?>
			</div>
			<p class="studio-box-visual-note"><?php esc_html_e( 'AI-generated box visuals based on supplier references. The single-watch box is a concept; final box details are to be confirmed.', 'watch-collections' ); ?></p>
		</section>
		<div class="studio-workspace">
			<section class="studio-catalog" aria-labelledby="studio-catalog-title">
				<div class="studio-section-label"><h2 id="studio-catalog-title" tabindex="-1"><span>02</span><?php esc_html_e( 'Find your kind of watch.', 'watch-collections' ); ?></h2><button type="button" class="studio-quiet-button" data-action="motion" aria-pressed="true"><?php esc_html_e( 'Motion on', 'watch-collections' ); ?></button></div>
				<div class="studio-filters">
					<div class="studio-search-row"><label class="studio-search"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 4.5 4.5"/></svg><span class="screen-reader-text"><?php esc_html_e( 'Search concept watches', 'watch-collections' ); ?></span><input type="search" data-studio-search placeholder="<?php esc_attr_e( 'Search a style, colour or name…', 'watch-collections' ); ?>" maxlength="100" autocomplete="off"></label><label class="studio-strap-select"><span class="screen-reader-text"><?php esc_html_e( 'Filter by strap design', 'watch-collections' ); ?></span><select data-studio-strap><option value="all"><?php esc_html_e( 'All strap designs', 'watch-collections' ); ?></option><option value="bracelet"><?php esc_html_e( 'Metal bracelet', 'watch-collections' ); ?></option><option value="leather-look"><?php esc_html_e( 'Leather-look', 'watch-collections' ); ?></option><option value="sport"><?php esc_html_e( 'Sport strap', 'watch-collections' ); ?></option></select></label></div>
					<div class="studio-style-filters" role="group" aria-label="<?php esc_attr_e( 'Filter by watch style', 'watch-collections' ); ?>"><?php foreach ( array( 'all' => __( 'All watches', 'watch-collections' ), 'classic' => __( 'Classic', 'watch-collections' ), 'chronograph' => __( 'Chronograph', 'watch-collections' ), 'moonphase' => __( 'Moonphase style', 'watch-collections' ), 'sport' => __( 'Sport', 'watch-collections' ), 'skeleton' => __( 'Skeleton style', 'watch-collections' ) ) as $key => $label ) : ?><button type="button" data-action="filter" data-style="<?php echo esc_attr( $key ); ?>" aria-pressed="<?php echo 'all' === $key ? 'true' : 'false'; ?>"><?php echo esc_html( $label ); ?></button><?php endforeach; ?></div>
				</div>
				<div class="studio-results-bar"><p data-result-count role="status"></p><button type="button" class="studio-quiet-button" data-action="reset-filters" hidden><?php esc_html_e( 'Clear filters', 'watch-collections' ); ?></button></div>
				<div class="studio-replace-notice" data-replace-notice hidden></div>
				<div class="studio-watch-grid" data-watch-grid></div>
				<div class="studio-empty" data-catalog-empty hidden><span aria-hidden="true">↗</span><h3><?php esc_html_e( 'A fresh look?', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'No watches match those filters. Try another style or open up the selection.', 'watch-collections' ); ?></p><button type="button" class="studio-primary" data-action="reset-filters"><?php esc_html_e( 'Show all watches', 'watch-collections' ); ?></button></div>
				<p class="studio-catalog-footnote"><?php esc_html_e( 'Original concept illustrations. Dial designs do not confirm functional chronographs, moonphases, materials or water resistance.', 'watch-collections' ); ?></p>
			</section>
			<aside class="studio-box-panel" aria-labelledby="studio-box-title">
				<div class="studio-box-heading"><div><p class="studio-kicker">03 / <?php esc_html_e( 'COMING TOGETHER', 'watch-collections' ); ?></p><h2 id="studio-box-title"><?php esc_html_e( 'Your collection.', 'watch-collections' ); ?></h2></div><span data-box-count></span></div>
				<div class="studio-box-display" data-box-display></div>
				<div class="studio-box-progress"><span data-box-progress></span></div><p class="studio-box-hint" data-box-hint></p>
				<div class="studio-box-price"><div><span><?php esc_html_e( 'Planned collection price', 'watch-collections' ); ?></span><small data-box-inclusions></small></div><strong data-box-price></strong></div>
				<button type="button" class="studio-primary studio-review-button" data-action="review"><?php esc_html_e( 'See my collection', 'watch-collections' ); ?><span aria-hidden="true">↗</span></button>
				<div class="studio-box-meta"><span data-save-status></span><button type="button" class="studio-quiet-button" data-action="clear"><?php esc_html_e( 'Start again', 'watch-collections' ); ?></button></div>
				<p class="studio-box-note"><?php esc_html_e( 'Box illustration only. Shipping, taxes and final specifications are to be confirmed before launch.', 'watch-collections' ); ?></p>
			</aside>
		</div>
	</div>
	<div class="studio-mobile-tray"><div class="studio-mobile-thumbs" data-mobile-thumbs aria-hidden="true"></div><div class="studio-mobile-summary"><strong data-mobile-count></strong><span data-mobile-price></span></div><button type="button" class="studio-primary" data-action="review"><?php esc_html_e( 'View box', 'watch-collections' ); ?><span aria-hidden="true">↗</span></button></div>
	<div class="studio-toast" data-studio-toast role="status" aria-live="polite" aria-atomic="true"></div>
	<dialog class="studio-dialog" data-studio-dialog aria-labelledby="studio-dialog-title"><button type="button" class="studio-dialog-close" data-action="close-dialog" aria-label="<?php esc_attr_e( 'Close dialog', 'watch-collections' ); ?>">×</button><div data-dialog-content></div></dialog>
	<script type="application/json" data-studio-config><?php echo wp_json_encode( $config, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ); // Safe JSON for an HTML script element. ?></script>
</main>
<?php get_footer(); ?>
