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
		<header class="studio-intro">
			<h1><?php esc_html_e( 'Build your collection', 'watch-collections' ); ?></h1>
			<span class="studio-preview-tag"><?php esc_html_e( 'Preview · No checkout', 'watch-collections' ); ?></span>
		</header>
		<noscript><p class="studio-notice"><?php esc_html_e( 'Enable JavaScript to use the Collection Studio. The planned box sizes and prices are listed below.', 'watch-collections' ); ?></p></noscript>
		<section class="studio-size" aria-labelledby="studio-size-title">
			<div class="studio-section-label"><h2 id="studio-size-title"><?php esc_html_e( 'Choose a box', 'watch-collections' ); ?></h2></div>
			<div class="studio-size-options" role="group" aria-label="<?php esc_attr_e( 'Choose your collection size', 'watch-collections' ); ?>">
			<?php foreach ( $packages as $package ) : ?>
				<button type="button" class="studio-size-option" data-action="size" data-size="<?php echo esc_attr( $package['count'] ); ?>" aria-pressed="false">
					<span class="studio-size-option__photo" aria-hidden="true"><?php watch_collections_box_image( $package['count'], 'studio-box-photo', '(max-width: 700px) 28vw, 112px' ); ?></span>
					<span class="studio-size-option__copy"><strong><?php echo esc_html( sprintf( _n( '%d watch', '%d watches', $package['count'], 'watch-collections' ), $package['count'] ) ); ?></strong></span>
					<span class="studio-size-option__price"><?php if ( null !== $package['price'] ) : ?>$<?php echo esc_html( $package['price'] ); ?><small>USD / <?php esc_html_e( 'planned', 'watch-collections' ); ?></small><?php else : ?><span class="studio-price-pending"><?php esc_html_e( 'Price to be confirmed', 'watch-collections' ); ?></span><?php endif; ?></span><span class="studio-radio" aria-hidden="true"></span>
				</button>
			<?php endforeach; ?>
			</div>
		</section>
		<div class="studio-workspace">
			<section class="studio-catalog" aria-labelledby="studio-catalog-title">
				<div class="studio-section-label"><h2 id="studio-catalog-title" tabindex="-1"><?php esc_html_e( 'Choose your watches', 'watch-collections' ); ?></h2><button type="button" class="studio-quiet-button" data-action="motion" aria-pressed="true"><?php esc_html_e( 'Motion on', 'watch-collections' ); ?></button></div>
				<div class="studio-filters">
					<div class="studio-search-row"><label class="studio-search"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m16 16 4.5 4.5"/></svg><span class="screen-reader-text"><?php esc_html_e( 'Search concept watches', 'watch-collections' ); ?></span><input type="search" data-studio-search placeholder="<?php esc_attr_e( 'Search watches…', 'watch-collections' ); ?>" maxlength="100" autocomplete="off"></label><label class="studio-strap-select"><span class="screen-reader-text"><?php esc_html_e( 'Filter by strap design', 'watch-collections' ); ?></span><select data-studio-strap><option value="all"><?php esc_html_e( 'All straps', 'watch-collections' ); ?></option><option value="bracelet"><?php esc_html_e( 'Metal bracelet', 'watch-collections' ); ?></option><option value="leather-look"><?php esc_html_e( 'Leather-look', 'watch-collections' ); ?></option><option value="sport"><?php esc_html_e( 'Sport strap', 'watch-collections' ); ?></option></select></label></div>
					<div class="studio-style-filters" role="group" aria-label="<?php esc_attr_e( 'Filter by watch style', 'watch-collections' ); ?>"><?php foreach ( array( 'all' => __( 'All watches', 'watch-collections' ), 'classic' => __( 'Classic', 'watch-collections' ), 'chronograph' => __( 'Chronograph', 'watch-collections' ), 'moonphase' => __( 'Moonphase style', 'watch-collections' ), 'sport' => __( 'Sport', 'watch-collections' ), 'skeleton' => __( 'Skeleton style', 'watch-collections' ) ) as $key => $label ) : ?><button type="button" data-action="filter" data-style="<?php echo esc_attr( $key ); ?>" aria-pressed="<?php echo 'all' === $key ? 'true' : 'false'; ?>"><span class="studio-style-image" data-style-preview aria-hidden="true"></span><span class="studio-style-name"><?php echo esc_html( $label ); ?></span></button><?php endforeach; ?></div>
				</div>
				<div class="studio-results-bar"><p data-result-count role="status"></p><button type="button" class="studio-quiet-button" data-action="reset-filters" hidden><?php esc_html_e( 'Clear filters', 'watch-collections' ); ?></button></div>
				<div class="studio-replace-notice" data-replace-notice hidden></div>
				<section class="studio-mobile-box" data-mobile-box aria-labelledby="studio-mobile-box-title">
					<div class="studio-mobile-box-heading"><h2 id="studio-mobile-box-title"><?php esc_html_e( 'Your box', 'watch-collections' ); ?></h2><span data-mobile-count></span></div>
					<div class="studio-mobile-box-body"><div class="studio-mobile-box-display" data-mobile-box-display></div><div class="studio-mobile-box-summary"><p data-mobile-price></p><button type="button" class="studio-primary" data-action="review"><?php esc_html_e( 'View box', 'watch-collections' ); ?><span aria-hidden="true">↗</span></button></div></div>
				</section>
				<div class="studio-carousel" data-watch-carousel role="region" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Watch collection', 'watch-collections' ); ?>">
					<div class="studio-carousel-stage">
						<div id="studio-watch-track" class="studio-carousel-track" data-watch-track tabindex="0" role="group" aria-label="<?php esc_attr_e( 'Browse watch designs', 'watch-collections' ); ?>" aria-describedby="studio-carousel-help"></div>
						<div class="studio-carousel-selection" data-watch-selection></div>
						<div class="studio-carousel-navigation">
							<button type="button" class="studio-carousel-arrow" data-action="previous-watch" aria-label="<?php esc_attr_e( 'Previous watch', 'watch-collections' ); ?>" aria-controls="studio-watch-track"><span aria-hidden="true">←</span></button>
							<p class="studio-carousel-position" role="status" aria-live="polite" aria-atomic="true"><span data-carousel-position></span><span class="screen-reader-text" data-carousel-announcement></span></p>
							<button type="button" class="studio-carousel-arrow" data-action="next-watch" aria-label="<?php esc_attr_e( 'Next watch', 'watch-collections' ); ?>" aria-controls="studio-watch-track"><span aria-hidden="true">→</span></button>
						</div>
						<div class="studio-carousel-progress" aria-hidden="true"><span data-carousel-progress></span></div>
						<p id="studio-carousel-help" class="screen-reader-text"><?php esc_html_e( 'Swipe to browse, or use the arrows and left and right keys.', 'watch-collections' ); ?></p>
					</div>
					<div class="studio-feature" data-watch-feature aria-labelledby="studio-feature-title"></div>
				</div>
				<div class="studio-empty" data-catalog-empty hidden><span aria-hidden="true">↗</span><h3><?php esc_html_e( 'A fresh look?', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'No watches match those filters. Try another style or open up the selection.', 'watch-collections' ); ?></p><button type="button" class="studio-primary" data-action="reset-filters"><?php esc_html_e( 'Show all watches', 'watch-collections' ); ?></button></div>
			</section>
			<aside class="studio-box-panel" aria-labelledby="studio-box-title">
				<div class="studio-box-heading"><h2 id="studio-box-title"><?php esc_html_e( 'Your box', 'watch-collections' ); ?></h2><span data-box-count></span></div>
				<div class="studio-box-display" data-box-display></div>
				<div class="studio-box-progress"><span data-box-progress></span></div><p class="studio-box-hint" data-box-hint></p>
				<div class="studio-box-price"><div><span><?php esc_html_e( 'Planned total', 'watch-collections' ); ?></span><small data-box-inclusions></small></div><strong data-box-price></strong></div>
				<button type="button" class="studio-primary studio-review-button" data-action="review"><?php esc_html_e( 'Review box', 'watch-collections' ); ?><span aria-hidden="true">↗</span></button>
				<div class="studio-box-meta"><span class="screen-reader-text" data-save-status></span><button type="button" class="studio-quiet-button" data-action="clear"><?php esc_html_e( 'Clear box', 'watch-collections' ); ?></button></div>
			</aside>
		</div>
		<details class="studio-preview-details"><summary><?php esc_html_e( 'About this preview', 'watch-collections' ); ?></summary><p><?php esc_html_e( 'Concept watches and AI-generated box visuals. Final products, specifications, prices and availability are to be confirmed. Dial designs do not verify their functions or materials. No orders or payments are accepted.', 'watch-collections' ); ?></p></details>
	</div>
	<div class="studio-toast" data-studio-toast role="status" aria-live="polite" aria-atomic="true"></div>
	<dialog class="studio-dialog" data-studio-dialog aria-labelledby="studio-dialog-title"><button type="button" class="studio-dialog-close" data-action="close-dialog" aria-label="<?php esc_attr_e( 'Close dialog', 'watch-collections' ); ?>">×</button><div data-dialog-content></div></dialog>
	<script type="application/json" data-studio-config><?php echo wp_json_encode( $config, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ); // Safe JSON for an HTML script element. ?></script>
</main>
<?php get_footer(); ?>
