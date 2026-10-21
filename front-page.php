<?php
/**
 * Editorial homepage and interactive (non-transactional) collection-box preview.
 *
 * @package Watch_Collections
 */
get_header();

$watch_packages = array(
	array( 'count' => 1, 'price' => 160, 'name' => __( 'The Essential', 'watch-collections' ) ),
	array( 'count' => 3, 'price' => 299, 'name' => __( 'The Rotation', 'watch-collections' ) ),
	array( 'count' => 5, 'price' => 499, 'name' => __( 'The Wardrobe', 'watch-collections' ) ),
	array( 'count' => 7, 'price' => 639, 'name' => __( 'The Full Week', 'watch-collections' ) ),
);
$watch_styles = array(
	array( 'name' => __( 'Classic', 'watch-collections' ), 'detail' => __( 'Understated, reliable-looking pieces for every ordinary day.', 'watch-collections' ), 'slug' => 'classic', 'number' => '01' ),
	array( 'name' => __( 'Chronograph', 'watch-collections' ), 'detail' => __( 'The layered look of timing-inspired dials.', 'watch-collections' ), 'slug' => 'chrono', 'number' => '02' ),
	array( 'name' => __( 'Sport', 'watch-collections' ), 'detail' => __( 'A bolder choice when the day moves differently.', 'watch-collections' ), 'slug' => 'sport', 'number' => '03' ),
	array( 'name' => __( 'Moonphase', 'watch-collections' ), 'detail' => __( 'An expressive dial, pending confirmation of the actual movement.', 'watch-collections' ), 'slug' => 'moon', 'number' => '04' ),
	array( 'name' => __( 'Skeleton', 'watch-collections' ), 'detail' => __( 'A mechanical-inspired look with details worth a closer look.', 'watch-collections' ), 'slug' => 'skeleton', 'number' => '05' ),
);
?>
<main id="main" class="wc-home">
	<section class="wc-hero" aria-labelledby="wc-hero-title">
		<div class="container wc-hero__grid">
			<div class="wc-hero__copy">
				<p class="wc-kicker"><span class="wc-rule" aria-hidden="true"></span><?php esc_html_e( 'THE WATCH COLLECTION STUDIO', 'watch-collections' ); ?></p>
				<h1 id="wc-hero-title"><?php esc_html_e( 'Your days change.', 'watch-collections' ); ?><br><em><?php esc_html_e( 'Your watch can too.', 'watch-collections' ); ?></em></h1>
				<p class="wc-hero__lead"><?php esc_html_e( 'One for work. One for the weekend. One for those nights that call for something different. Choose the watches that fit your life, together in your own collection box.', 'watch-collections' ); ?></p>
				<div class="wc-hero__actions">
					<a class="wc-button wc-button--dark" href="#build-preview"><?php esc_html_e( 'Build your collection', 'watch-collections' ); ?><span aria-hidden="true">↗</span></a>
					<a class="wc-simple-link" href="#how-it-works"><?php esc_html_e( 'See how it works', 'watch-collections' ); ?><span aria-hidden="true">↓</span></a>
				</div>
				<div class="wc-hero__quiet"><span class="wc-quiet-mark" aria-hidden="true">✳</span><?php esc_html_e( 'Not about having more. About having the right choice.', 'watch-collections' ); ?></div>
			</div>
			<div class="wc-hero__visual" role="img" aria-label="<?php esc_attr_e( 'Concept illustration of a walnut watch box containing three different watches', 'watch-collections' ); ?>">
				<div class="wc-visual__top"><span><?php esc_html_e( 'THE COLLECTION / CONCEPT 01', 'watch-collections' ); ?></span><span aria-hidden="true">✧</span></div>
				<div class="wc-displaybox">
					<div class="wc-displaybox__lid"><span>YOUR DAILY ROTATION</span><span class="wc-displaybox__line"></span></div>
					<div class="wc-displaybox__tray">
						<div class="wc-displaybox__slot">
							<div class="illustration-watch illustration-watch--cream wc-display-watch wc-display-watch--one" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div>
						</div>
						<div class="wc-displaybox__slot">
							<div class="illustration-watch illustration-watch--night wc-display-watch wc-display-watch--two" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div>
						</div>
						<div class="wc-displaybox__slot">
							<div class="illustration-watch illustration-watch--olive wc-display-watch wc-display-watch--three" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div>
						</div>
					</div>
				</div>
				<div class="wc-visual__bottom"><span><?php esc_html_e( 'THE WEEKDAY. THE WEEKEND. THE OCCASION.', 'watch-collections' ); ?></span><span><?php esc_html_e( '01 / 03', 'watch-collections' ); ?></span></div>
			</div>
		</div>
	</section>

	<div class="wc-pledge"><div class="container wc-pledge__grid">
		<div><span>01</span><?php esc_html_e( 'Choose your box size', 'watch-collections' ); ?></div>
		<div><span>02</span><?php esc_html_e( 'Choose every watch', 'watch-collections' ); ?></div>
		<div><span>03</span><?php esc_html_e( 'See the complete collection', 'watch-collections' ); ?></div>
	</div></div>

	<section class="wc-section wc-builder-section" id="build-preview" aria-labelledby="wc-builder-title">
		<div class="container">
			<div class="wc-section__heading">
				<div><p class="wc-kicker"><?php esc_html_e( '01 / THE COLLECTION BUILDER', 'watch-collections' ); ?></p>
					<h2 id="wc-builder-title"><?php esc_html_e( 'Start with the box.', 'watch-collections' ); ?><br><em><?php esc_html_e( 'Make the rest yours.', 'watch-collections' ); ?></em></h2>
				</div>
				<p><?php esc_html_e( 'Pick the number of watches you want in your rotation. Every proposed package includes a presentation box and your choice of eligible watches.', 'watch-collections' ); ?></p>
			</div>
			<div class="wc-builder">
				<div class="wc-builder__controls">
					<div class="wc-builder__label"><span class="wc-eyebrow"><?php esc_html_e( 'SELECT A COLLECTION', 'watch-collections' ); ?></span><span class="wc-builder__step"><?php esc_html_e( 'STEP 01 OF 03', 'watch-collections' ); ?></span></div>
					<div class="wc-tiers" role="group" aria-label="<?php esc_attr_e( 'Choose your watch package', 'watch-collections' ); ?>">
						<?php foreach ( $watch_packages as $package ) : ?>
							<button type="button" class="wc-tier<?php echo 3 === $package['count'] ? ' is-selected' : ''; ?>" data-count="<?php echo esc_attr( $package['count'] ); ?>" data-price="<?php echo esc_attr( $package['price'] ); ?>" data-name="<?php echo esc_attr( $package['name'] ); ?>" aria-pressed="<?php echo 3 === $package['count'] ? 'true' : 'false'; ?>">
								<span class="wc-tier__check" aria-hidden="true"></span>
								<span class="wc-tier__name"><strong><?php echo esc_html( $package['count'] ); ?> <?php echo esc_html( 1 === $package['count'] ? __( 'watch', 'watch-collections' ) : __( 'watches', 'watch-collections' ) ); ?></strong><small><?php echo esc_html( $package['name'] ); ?></small></span>
								<span class="wc-tier__price">$<?php echo esc_html( $package['price'] ); ?></span>
							</button>
						<?php endforeach; ?>
					</div>
					<div class="wc-builder__summary" aria-live="polite" aria-atomic="true">
						<div class="wc-summary__label"><span><?php esc_html_e( 'PROPOSED PACKAGE PRICE', 'watch-collections' ); ?></span><strong id="wc-selection-price">$299</strong></div>
						<p id="wc-selection-includes"><?php esc_html_e( '3 watches of your choice + 3-slot presentation box', 'watch-collections' ); ?></p>
					</div>
					<a href="#styles" class="wc-button wc-button--dark wc-builder__next"><?php esc_html_e( 'Explore the watch styles', 'watch-collections' ); ?><span aria-hidden="true">→</span></a>
					<p class="wc-builder__disclaimer"><?php esc_html_e( 'Interactive concept only. Packages and prices are proposed, not yet available for purchase. Shipping, tax, stock and final inclusions are not confirmed.', 'watch-collections' ); ?></p>
				</div>
				<div class="wc-builder__display">
					<div class="wc-builder__display-head"><span><?php esc_html_e( 'YOUR BOX / PREVIEW', 'watch-collections' ); ?></span><span class="wc-swatch"><i aria-hidden="true"></i><?php esc_html_e( 'WALNUT-STYLE CONCEPT', 'watch-collections' ); ?></span></div>
					<div class="wc-case-scene">
						<div class="wc-case-scene__glow" aria-hidden="true"></div>
						<div class="wc-case" id="wc-case" data-count="3" aria-label="<?php esc_attr_e( 'Preview of three empty watch compartments', 'watch-collections' ); ?>">
							<div class="wc-case__inner" id="wc-case-slots">
								<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
									<div class="wc-case__slot"><span class="wc-case__cushion" aria-hidden="true"></span><span class="wc-case__number"><?php echo esc_html( sprintf( '%02d', $i ) ); ?></span></div>
								<?php endfor; ?>
							</div>
						</div>
					</div>
					<div class="wc-builder__display-foot"><span id="wc-slot-caption" aria-live="polite"><?php esc_html_e( '03 EMPTY COMPARTMENTS', 'watch-collections' ); ?></span><span><?php esc_html_e( 'EVERY SLOT IS YOUR CHOICE', 'watch-collections' ); ?></span></div>
					<p class="wc-image-note"><?php esc_html_e( 'Illustrative case design, not a supplier product photograph.', 'watch-collections' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="wc-section wc-styles-section" id="styles" aria-labelledby="wc-styles-title">
		<div class="container">
			<div class="wc-section__heading">
				<div><p class="wc-kicker"><?php esc_html_e( '02 / FIND YOUR STYLE', 'watch-collections' ); ?></p>
					<h2 id="wc-styles-title"><?php esc_html_e( 'Different moments.', 'watch-collections' ); ?><br><em><?php esc_html_e( 'Different details.', 'watch-collections' ); ?></em></h2>
				</div>
				<p><?php esc_html_e( 'Five directions to explore. The final lineup will be curated from verified watches, with real specifications and photographs.', 'watch-collections' ); ?></p>
			</div>
			<div class="wc-styles-grid">
				<?php foreach ( $watch_styles as $style ) : ?>
					<article class="wc-style-card wc-style-card--<?php echo esc_attr( $style['slug'] ); ?>">
						<div class="wc-style-card__art" aria-hidden="true">
							<div class="illustration-watch wc-style-watch<?php echo 'classic' === $style['slug'] ? ' illustration-watch--cream' : ( 'sport' === $style['slug'] ? ' illustration-watch--olive' : ' illustration-watch--night' ); ?>"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div>
							<span class="wc-style-card__number"><?php echo esc_html( $style['number'] ); ?> / 05</span>
						</div>
						<div class="wc-style-card__body">
							<h3><?php echo esc_html( $style['name'] ); ?> <span aria-hidden="true">↗</span></h3>
							<p><?php echo esc_html( $style['detail'] ); ?></p>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="wc-styles__footnote"><?php esc_html_e( 'These are style illustrations, not confirmed inventory. Chronograph, moonphase and skeleton functions will be described accurately after supplier verification.', 'watch-collections' ); ?></p>
		</div>
	</section>

	<section class="wc-how-section wc-section" id="how-it-works" aria-labelledby="wc-how-title">
		<div class="container wc-how-grid">
			<div class="wc-how-intro"><p class="wc-kicker"><?php esc_html_e( '03 / THE IDEA', 'watch-collections' ); ?></p><h2 id="wc-how-title"><?php esc_html_e( 'Build a rotation.', 'watch-collections' ); ?><br><em><?php esc_html_e( 'Not a random bundle.', 'watch-collections' ); ?></em></h2>
				<p><?php esc_html_e( 'A good collection is personal. You decide what belongs in each compartment, with one clear package price and a box that brings it all together.', 'watch-collections' ); ?></p>
				<a class="wc-simple-link wc-simple-link--light" href="#build-preview"><?php esc_html_e( 'Preview your box', 'watch-collections' ); ?> <span aria-hidden="true">↑</span></a>
			</div>
			<div class="wc-how-steps">
				<div><span>01</span><div><h3><?php esc_html_e( 'Choose your size.', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Start with a box for 1, 3, 5 or 7 watches and see the proposed price immediately.', 'watch-collections' ); ?></p></div></div>
				<div><span>02</span><div><h3><?php esc_html_e( 'Make every pick yours.', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Our planned builder will let you browse, add, swap and rearrange eligible models.', 'watch-collections' ); ?></p></div></div>
				<div><span>03</span><div><h3><?php esc_html_e( 'See it together.', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Review the complete box, its contents and total before committing to an order.', 'watch-collections' ); ?></p></div></div>
			</div>
		</div>
	</section>

	<section class="wc-section wc-real-section" id="shop" aria-labelledby="wc-real-title">
		<div class="container wc-real-grid">
			<div><p class="wc-kicker"><?php esc_html_e( 'NO MYSTERY WATCHES', 'watch-collections' ); ?></p>
				<h2 id="wc-real-title"><?php esc_html_e( 'Know what', 'watch-collections' ); ?><br><em><?php esc_html_e( 'you are choosing.', 'watch-collections' ); ?></em></h2>
				<p><?php esc_html_e( 'We want every model to have clear photos, an accurate specification sheet and a straightforward explanation of what it does. The watches and presentation cases are still being sourced and checked.', 'watch-collections' ); ?></p>
			</div>
			<div class="wc-real-panel">
				<?php
				$has_products = function_exists( 'wc_get_products' ) && ! empty( wc_get_products( array( 'limit' => 1, 'status' => 'publish', 'return' => 'ids' ) ) );
				if ( $has_products ) {
					echo do_shortcode( '[products limit="4" columns="2" orderby="date" order="DESC"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} else {
					?>
					<span class="wc-real-panel__mark" aria-hidden="true">◎</span>
					<h3><?php esc_html_e( 'The catalogue is in progress.', 'watch-collections' ); ?></h3>
					<p><?php esc_html_e( 'No invented watches, no unverified movement claims and no pretend stock. Real models will appear here once they are selected and checked.', 'watch-collections' ); ?></p>
					<span class="wc-real-panel__caption"><?php esc_html_e( 'PRODUCTS / PENDING VALIDATION', 'watch-collections' ); ?></span>
					<?php
				}
				?>
			</div>
		</div>
	</section>

	<section class="wc-closing" aria-labelledby="wc-closing-title">
		<div class="container">
			<p class="wc-kicker"><?php esc_html_e( 'A DIFFERENT WAY TO COLLECT', 'watch-collections' ); ?></p>
			<h2 id="wc-closing-title"><?php esc_html_e( 'One watch never had to', 'watch-collections' ); ?><br><em><?php esc_html_e( 'do it all.', 'watch-collections' ); ?></em></h2>
			<a class="wc-button wc-button--light" href="#build-preview"><?php esc_html_e( 'Find your collection size', 'watch-collections' ); ?><span aria-hidden="true">↑</span></a>
		</div>
	</section>
</main>
<?php get_footer(); ?>
