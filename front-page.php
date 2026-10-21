<?php
/**
 * Homepage: brand foundation, collection concept and WooCommerce product feed.
 *
 * @package Watch_Collections
 */
get_header();
?>
<main id="main">
	<section class="hero" aria-labelledby="hero-title">
		<div class="container hero-grid">
			<div class="hero-content">
				<p class="eyebrow"><span class="eyebrow-line" aria-hidden="true"></span><?php esc_html_e( 'EVERYDAY, WITH OPTIONS', 'watch-collections' ); ?></p>
				<h1 id="hero-title"><?php esc_html_e( 'A different watch.', 'watch-collections' ); ?> <em><?php esc_html_e( 'For every side of you.', 'watch-collections' ); ?></em></h1>
				<p class="hero-description"><?php esc_html_e( 'The early meeting. The slow Sunday. The night out. Your days never look the same—your watch doesn’t have to either.', 'watch-collections' ); ?></p>
				<div class="hero-actions">
					<a class="button button-primary" href="#collections"><?php esc_html_e( 'Explore the collections', 'watch-collections' ); ?><span aria-hidden="true"> ↗</span></a>
					<a class="text-link" href="#how-it-works"><?php esc_html_e( 'Get to know the idea', 'watch-collections' ); ?> <span aria-hidden="true">↓</span></a>
				</div>
				<p class="hero-footnote"><?php esc_html_e( 'Not a status symbol. A daily choice.', 'watch-collections' ); ?></p>
			</div>
			<div class="hero-art" aria-label="<?php esc_attr_e( 'Stylized illustration of a three-watch rotation', 'watch-collections' ); ?>" role="img">
				<div class="hero-art-heading"><span>01 / 03</span><span>YOUR ROTATION, REIMAGINED</span></div>
				<div class="hero-art-frame">
					<div class="illustration-watch illustration-watch--cream watch-hero-left" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div>
					<div class="illustration-watch illustration-watch--night watch-hero-main" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div>
					<div class="illustration-watch illustration-watch--olive watch-hero-right" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div>
				</div>
				<div class="hero-art-footer"><span>THE WEEK / THE WEEKEND / THE OCCASION</span><span aria-hidden="true">↗</span></div>
			</div>
		</div>
	</section>

	<section class="principle-bar" aria-label="<?php esc_attr_e( 'Our approach', 'watch-collections' ); ?>">
		<div class="container principle-inner">
			<span>01 <strong><?php esc_html_e( 'Built for real days', 'watch-collections' ); ?></strong></span>
			<span>02 <strong><?php esc_html_e( 'Collected your way', 'watch-collections' ); ?></strong></span>
			<span>03 <strong><?php esc_html_e( 'No luxury performance', 'watch-collections' ); ?></strong></span>
		</div>
	</section>

	<section class="section collections-section" id="collections" aria-labelledby="collections-title">
		<div class="container">
			<div class="section-heading">
				<div><p class="eyebrow"><?php esc_html_e( 'THE WATCH WARDROBE', 'watch-collections' ); ?></p><h2 id="collections-title"><?php esc_html_e( 'Which day are you dressing for?', 'watch-collections' ); ?></h2></div>
				<p><?php esc_html_e( 'Think of your watches like the rest of your wardrobe. A little variety makes every choice easier.', 'watch-collections' ); ?></p>
			</div>
			<div class="collection-grid">
				<article class="collection-card collection-card--day">
					<div class="collection-art"><div class="illustration-watch illustration-watch--cream" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div><span class="art-index">01 / 03</span></div>
					<div class="collection-body"><span class="collection-kicker"><?php esc_html_e( 'THE EVERYDAY', 'watch-collections' ); ?></span><h3><?php esc_html_e( 'Your usual, upgraded.', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Easy to reach for. Easy to wear again tomorrow.', 'watch-collections' ); ?></p></div>
				</article>
				<article class="collection-card collection-card--weekend">
					<div class="collection-art"><div class="illustration-watch illustration-watch--olive" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div><span class="art-index">02 / 03</span></div>
					<div class="collection-body"><span class="collection-kicker"><?php esc_html_e( 'THE OFF-DUTY', 'watch-collections' ); ?></span><h3><?php esc_html_e( 'A change of pace.', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'For the plans you make and the ones you don’t.', 'watch-collections' ); ?></p></div>
				</article>
				<article class="collection-card collection-card--evening">
					<div class="collection-art"><div class="illustration-watch illustration-watch--night" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div><span class="art-index">03 / 03</span></div>
					<div class="collection-body"><span class="collection-kicker"><?php esc_html_e( 'THE OCCASION', 'watch-collections' ); ?></span><h3><?php esc_html_e( 'When it matters.', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'An extra detail that quietly completes the look.', 'watch-collections' ); ?></p></div>
				</article>
			</div>
			<p class="concept-caption"><?php esc_html_e( 'Concept illustrations — not actual product photos. Product selections will be added as the catalogue is finalized.', 'watch-collections' ); ?></p>
		</div>
	</section>

	<section class="section concept-section" id="how-it-works" aria-labelledby="concept-title">
		<div class="container concept-grid">
			<div class="concept-copy">
				<p class="eyebrow"><?php esc_html_e( 'THE COLLECTION IDEA', 'watch-collections' ); ?></p>
				<h2 id="concept-title"><?php esc_html_e( 'One box.', 'watch-collections' ); ?><br><em><?php esc_html_e( 'Many moments.', 'watch-collections' ); ?></em></h2>
				<p><?php esc_html_e( 'We’re building a simpler way to choose a watch for every part of your life. Bring together the styles you love, make the lineup your own, and keep them in one place.', 'watch-collections' ); ?></p>
				<a class="text-link" href="<?php echo esc_url( watch_collections_shop_url() ); ?>"><?php esc_html_e( 'See the collection', 'watch-collections' ); ?> <span aria-hidden="true"> ↗</span></a>
			</div>
			<div class="steps-card" aria-label="<?php esc_attr_e( 'Planned collection experience', 'watch-collections' ); ?>">
				<div class="steps-top"><span><?php esc_html_e( 'YOUR COLLECTION', 'watch-collections' ); ?></span><span><?php esc_html_e( 'THE PLAN', 'watch-collections' ); ?></span></div>
				<div class="step"><span>01</span><div><h3><?php esc_html_e( 'Find your styles', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Choose watches that fit your days, not someone else’s idea of status.', 'watch-collections' ); ?></p></div></div>
				<div class="step"><span>02</span><div><h3><?php esc_html_e( 'Build your rotation', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Mix everyday, weekend and occasion pieces in your own box.', 'watch-collections' ); ?></p></div></div>
				<div class="step"><span>03</span><div><h3><?php esc_html_e( 'Make it yours', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'See the watches together before deciding what belongs in your collection.', 'watch-collections' ); ?></p></div></div>
				<p class="steps-note"><?php esc_html_e( 'Interactive box builder coming during development.', 'watch-collections' ); ?></p>
			</div>
		</div>
	</section>

	<section class="section shop-section" id="shop" aria-labelledby="shop-title">
		<div class="container">
			<div class="section-heading">
				<div><p class="eyebrow"><?php esc_html_e( 'TAKE A LOOK', 'watch-collections' ); ?></p><h2 id="shop-title"><?php esc_html_e( 'The lineup starts here.', 'watch-collections' ); ?></h2></div>
				<p><?php esc_html_e( 'Actual watch listings will appear here as we add verified products and details.', 'watch-collections' ); ?></p>
			</div>
			<?php
			$has_products = function_exists( 'wc_get_products' ) && ! empty( wc_get_products( array( 'limit' => 1, 'status' => 'publish', 'return' => 'ids' ) ) );
			if ( $has_products ) {
				echo do_shortcode( '[products limit="4" columns="4" orderby="date" order="DESC"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			} else {
				?>
				<div class="coming-soon"><span aria-hidden="true">✳</span><div><h3><?php esc_html_e( 'Our first watches are being selected.', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Once product information is ready, this space will become a real, shoppable collection.', 'watch-collections' ); ?></p></div><span class="coming-tag"><?php esc_html_e( 'IN DEVELOPMENT', 'watch-collections' ); ?></span></div>
				<?php
			}
			?>
		</div>
	</section>

	<section class="closing-section">
		<div class="container closing-inner">
			<p class="eyebrow"><?php esc_html_e( 'A WATCH FOR THE WAY YOU LIVE', 'watch-collections' ); ?></p>
			<h2><?php esc_html_e( 'Your days change.', 'watch-collections' ); ?><br><em><?php esc_html_e( 'Your choices can too.', 'watch-collections' ); ?></em></h2>
			<a class="button button-light" href="#collections"><?php esc_html_e( 'Explore the idea', 'watch-collections' ); ?><span aria-hidden="true"> ↑</span></a>
		</div>
	</section>
</main>
<?php get_footer(); ?>
