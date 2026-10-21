<?php
/**
 * Homepage: explain the watch-collection value proposition before the studio.
 * This is a brand/education page, not the interactive collection builder.
 *
 * @package Watch_Collections
 */
get_header();

$collection_options = array(
	array( 'count' => 1, 'price' => 160, 'name' => __( 'Start with one', 'watch-collections' ), 'detail' => __( 'One watch you choose, in its presentation box.', 'watch-collections' ) ),
	array( 'count' => 3, 'price' => 299, 'name' => __( 'Room for variety', 'watch-collections' ), 'detail' => __( 'Three watches you choose, together in one box.', 'watch-collections' ) ),
	array( 'count' => 5, 'price' => 499, 'name' => __( 'Your wider rotation', 'watch-collections' ), 'detail' => __( 'Five watches you choose, together in one box.', 'watch-collections' ) ),
	array( 'count' => 7, 'price' => 639, 'name' => __( 'The full collection', 'watch-collections' ), 'detail' => __( 'Seven watches you choose, together in one box.', 'watch-collections' ) ),
);
?>
<main id="main">
	<section class="hero home-story-hero" aria-labelledby="hero-title">
		<div class="container hero-grid">
			<div class="hero-content">
				<p class="eyebrow"><span class="eyebrow-line" aria-hidden="true"></span><?php esc_html_e( 'A WATCH FOR MORE THAN ONE KIND OF DAY', 'watch-collections' ); ?></p>
				<h1 id="hero-title"><?php esc_html_e( 'Your days change.', 'watch-collections' ); ?> <em><?php esc_html_e( 'Your watch can too.', 'watch-collections' ); ?></em></h1>
				<p class="hero-description"><?php esc_html_e( 'For the workday, the weekend, and the plans worth dressing up for. Build a collection of watches that feels like your life—not someone else’s definition of luxury.', 'watch-collections' ); ?></p>
				<div class="hero-actions">
					<a class="button button-primary" href="#the-idea"><?php esc_html_e( 'Discover the idea', 'watch-collections' ); ?><span aria-hidden="true"> ↗</span></a>
					<a class="text-link" href="#collection-options"><?php esc_html_e( 'See collection options', 'watch-collections' ); ?> <span aria-hidden="true"> ↓</span></a>
				</div>
				<p class="hero-footnote"><?php esc_html_e( 'Because one style doesn’t have to do it all.', 'watch-collections' ); ?></p>
			</div>
			<div class="hero-art" role="img" aria-label="<?php esc_attr_e( 'Illustration of three complementary watches, representing everyday, off-duty and occasion styles', 'watch-collections' ); ?>">
				<div class="hero-art-heading"><span>01 / 03</span><span><?php esc_html_e( 'THE DAYS THAT MAKE YOU', 'watch-collections' ); ?></span></div>
				<div class="hero-art-frame">
					<div class="illustration-watch illustration-watch--cream watch-hero-left" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div>
					<div class="illustration-watch illustration-watch--night watch-hero-main" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div>
					<div class="illustration-watch illustration-watch--olive watch-hero-right" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div>
				</div>
				<div class="hero-art-footer"><span><?php esc_html_e( 'EVERYDAY / OFF-DUTY / OCCASIONS', 'watch-collections' ); ?></span><span aria-hidden="true">↗</span></div>
			</div>
		</div>
	</section>

	<section class="principle-bar" aria-label="<?php esc_attr_e( 'What makes the collection different', 'watch-collections' ); ?>">
		<div class="container principle-inner">
			<span>01 <strong><?php esc_html_e( 'Your styles', 'watch-collections' ); ?></strong></span>
			<span>02 <strong><?php esc_html_e( 'One presentation box', 'watch-collections' ); ?></strong></span>
			<span>03 <strong><?php esc_html_e( 'A clear collection price', 'watch-collections' ); ?></strong></span>
		</div>
	</section>

	<section class="section empathy-section" id="the-idea" aria-labelledby="the-idea-title">
		<div class="container">
			<div class="section-heading">
				<div>
					<p class="eyebrow"><?php esc_html_e( 'THE IDEA IS SIMPLE', 'watch-collections' ); ?></p>
					<h2 id="the-idea-title"><?php esc_html_e( 'You’re not the same person', 'watch-collections' ); ?> <em><?php esc_html_e( 'every hour of the day.', 'watch-collections' ); ?></em></h2>
				</div>
				<p><?php esc_html_e( 'Some days call for understated. Others deserve something different. Your watches can match the moment without needing to be extravagant.', 'watch-collections' ); ?></p>
			</div>
			<div class="collection-grid occasion-grid">
				<article class="collection-card collection-card--day">
					<div class="collection-art"><div class="illustration-watch illustration-watch--cream" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div><span class="art-index">01 / 03</span></div>
					<div class="collection-body">
						<span class="collection-kicker"><?php esc_html_e( 'THE EVERYDAY', 'watch-collections' ); ?></span>
						<h3><?php esc_html_e( 'For the usual rhythm.', 'watch-collections' ); ?></h3>
						<p><?php esc_html_e( 'Something you can wear without thinking twice.', 'watch-collections' ); ?></p>
					</div>
				</article>
				<article class="collection-card collection-card--weekend">
					<div class="collection-art"><div class="illustration-watch illustration-watch--olive" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div><span class="art-index">02 / 03</span></div>
					<div class="collection-body">
						<span class="collection-kicker"><?php esc_html_e( 'THE OFF-DUTY', 'watch-collections' ); ?></span>
						<h3><?php esc_html_e( 'For a change of pace.', 'watch-collections' ); ?></h3>
						<p><?php esc_html_e( 'Another side of your style, without a whole new wardrobe.', 'watch-collections' ); ?></p>
					</div>
				</article>
				<article class="collection-card collection-card--evening">
					<div class="collection-art"><div class="illustration-watch illustration-watch--night" aria-hidden="true"><span class="illustration-strap"></span><span class="illustration-dial"><i></i><b></b></span></div><span class="art-index">03 / 03</span></div>
					<div class="collection-body">
						<span class="collection-kicker"><?php esc_html_e( 'THE OCCASION', 'watch-collections' ); ?></span>
						<h3><?php esc_html_e( 'For the extra thought.', 'watch-collections' ); ?></h3>
						<p><?php esc_html_e( 'When the details matter just a little more.', 'watch-collections' ); ?></p>
					</div>
				</article>
			</div>
			<p class="concept-caption"><?php esc_html_e( 'Concept illustrations. Final collections will feature actual watch photography and specifications.', 'watch-collections' ); ?></p>
		</div>
	</section>

	<section class="section concept-section" id="how-it-works" aria-labelledby="concept-title">
		<div class="container concept-grid">
			<div class="concept-copy">
				<p class="eyebrow"><?php esc_html_e( 'MORE INTENTIONAL. LESS COMPLICATED.', 'watch-collections' ); ?></p>
				<h2 id="concept-title"><?php esc_html_e( 'Not just another watch.', 'watch-collections' ); ?><br><em><?php esc_html_e( 'Your own rotation.', 'watch-collections' ); ?></em></h2>
				<p><?php esc_html_e( 'Instead of choosing one watch and hoping it goes with everything, choose the styles that belong in your life. We bring them together in a presentation box designed for your collection.', 'watch-collections' ); ?></p>
				<p class="concept-emphasis"><?php esc_html_e( 'You choose the watches. You know the price. You see the whole collection before deciding.', 'watch-collections' ); ?></p>
				<a class="text-link" href="#collection-options"><?php esc_html_e( 'Understand the collection options', 'watch-collections' ); ?> <span aria-hidden="true"> ↗</span></a>
			</div>
			<div class="steps-card">
				<div class="steps-top"><span><?php esc_html_e( 'THE COLLECTION EXPERIENCE', 'watch-collections' ); ?></span><span><?php esc_html_e( 'IN THREE STEPS', 'watch-collections' ); ?></span></div>
				<div class="step"><span>01</span><div><h3><?php esc_html_e( 'Choose the size', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Start with a box for 1, 3, 5 or 7 watches, with its collection price shown upfront.', 'watch-collections' ); ?></p></div></div>
				<div class="step"><span>02</span><div><h3><?php esc_html_e( 'Make it yours', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Pick the eligible watches you like. Swap styles and review the choices before checkout.', 'watch-collections' ); ?></p></div></div>
				<div class="step"><span>03</span><div><h3><?php esc_html_e( 'See what you’re getting', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Review every watch, the box, the price and available delivery terms before confirming an order.', 'watch-collections' ); ?></p></div></div>
				<p class="steps-note"><?php esc_html_e( 'The interactive Collection Studio is being developed separately.', 'watch-collections' ); ?></p>
			</div>
		</div>
	</section>

	<section class="section collection-value" id="collection-options" aria-labelledby="collection-options-title">
		<div class="container">
			<div class="section-heading">
				<div><p class="eyebrow"><?php esc_html_e( 'ONE BOX. YOUR CHOICES.', 'watch-collections' ); ?></p><h2 id="collection-options-title"><?php esc_html_e( 'Start with the collection', 'watch-collections' ); ?> <em><?php esc_html_e( 'that fits you.', 'watch-collections' ); ?></em></h2></div>
				<p><?php esc_html_e( 'Each option includes a presentation box and the number of watches you choose from the eligible collection.', 'watch-collections' ); ?></p>
			</div>
			<div class="collection-price-grid">
				<?php foreach ( $collection_options as $option ) : ?>
					<article class="collection-price-card">
						<div class="price-card-top"><span><?php echo esc_html( sprintf( _n( '%s WATCH', '%s WATCHES', $option['count'], 'watch-collections' ), number_format_i18n( $option['count'] ) ) ); ?></span><span aria-hidden="true">↗</span></div>
						<h3><?php echo esc_html( $option['name'] ); ?></h3>
						<p class="price-card-desc"><?php echo esc_html( $option['detail'] ); ?></p>
						<p class="collection-price"><span aria-label="<?php esc_attr_e( 'US dollars', 'watch-collections' ); ?>">$</span><?php echo esc_html( number_format_i18n( $option['price'] ) ); ?></p>
						<p class="price-card-includes"><?php esc_html_e( 'Includes the box + chosen eligible watches', 'watch-collections' ); ?></p>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="prototype-price-note"><?php esc_html_e( 'Development preview prices in USD. Final product eligibility, stock, taxes, delivery costs and purchase terms will be confirmed before launch. No orders are being accepted yet.', 'watch-collections' ); ?></p>
		</div>
	</section>

	<section class="section trust-section" id="why-trust-us" aria-labelledby="trust-title">
		<div class="container trust-layout">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'NO GUESSWORK REQUIRED', 'watch-collections' ); ?></p>
				<h2 id="trust-title"><?php esc_html_e( 'Good choices begin', 'watch-collections' ); ?> <em><?php esc_html_e( 'with clear details.', 'watch-collections' ); ?></em></h2>
				<p class="trust-intro"><?php esc_html_e( 'A purchase should feel exciting because you understand it—not because something important was left out.', 'watch-collections' ); ?></p>
			</div>
			<div class="trust-points">
				<div class="trust-point"><span class="trust-index">01</span><div><h3><?php esc_html_e( 'No mystery selections', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'You’ll choose your watches and see the complete lineup before buying.', 'watch-collections' ); ?></p></div></div>
				<div class="trust-point"><span class="trust-index">02</span><div><h3><?php esc_html_e( 'The details, not just the dial', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'We intend to show verified specifications, materials and functional features for every model.', 'watch-collections' ); ?></p></div></div>
				<div class="trust-point"><span class="trust-index">03</span><div><h3><?php esc_html_e( 'Clear before checkout', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'What’s included, shipping costs and timelines, and return terms should be available before you pay.', 'watch-collections' ); ?></p></div></div>
			</div>
		</div>
	</section>

	<section class="closing-section" aria-labelledby="closing-title">
		<div class="container closing-inner">
			<p class="eyebrow"><?php esc_html_e( 'A COLLECTION THAT FEELS LIKE YOU', 'watch-collections' ); ?></p>
			<h2 id="closing-title"><?php esc_html_e( 'Different moments.', 'watch-collections' ); ?><br><em><?php esc_html_e( 'One collection. Yours.', 'watch-collections' ); ?></em></h2>
			<p class="closing-description"><?php esc_html_e( 'The collection-building experience is coming together. For now, see how the options work and what’s planned.', 'watch-collections' ); ?></p>
			<a class="button button-light" href="#collection-options"><?php esc_html_e( 'See your options', 'watch-collections' ); ?><span aria-hidden="true"> ↑</span></a>
		</div>
	</section>
</main>
<?php get_footer(); ?>
