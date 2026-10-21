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

$week_scenes = array(
	array( 'slug' => 'monday', 'day' => __( 'Monday', 'watch-collections' ), 'short' => __( 'MON', 'watch-collections' ), 'scene' => __( 'Ready for the day', 'watch-collections' ), 'style' => __( 'Blue-dial moonphase style', 'watch-collections' ) ),
	array( 'slug' => 'tuesday', 'day' => __( 'Tuesday', 'watch-collections' ), 'short' => __( 'TUE', 'watch-collections' ), 'scene' => __( 'An easy afternoon', 'watch-collections' ), 'style' => __( 'Ice-blue chronograph style', 'watch-collections' ) ),
	array( 'slug' => 'wednesday', 'day' => __( 'Wednesday', 'watch-collections' ), 'short' => __( 'WED', 'watch-collections' ), 'scene' => __( 'A change of pace', 'watch-collections' ), 'style' => __( 'Blue-dial sport style', 'watch-collections' ), 'position' => '50% center' ),
	array( 'slug' => 'thursday', 'day' => __( 'Thursday', 'watch-collections' ), 'short' => __( 'THU', 'watch-collections' ), 'scene' => __( 'The evening shift', 'watch-collections' ), 'style' => __( 'Gold day-date style', 'watch-collections' ) ),
	array( 'slug' => 'friday', 'day' => __( 'Friday', 'watch-collections' ), 'short' => __( 'FRI', 'watch-collections' ), 'scene' => __( 'Plans after dark', 'watch-collections' ), 'style' => __( 'Gold chronograph style', 'watch-collections' ), 'position' => '64% center' ),
	array( 'slug' => 'saturday', 'day' => __( 'Saturday', 'watch-collections' ), 'short' => __( 'SAT', 'watch-collections' ), 'scene' => __( 'Out and about', 'watch-collections' ), 'style' => __( 'Sport diver style', 'watch-collections' ) ),
	array( 'slug' => 'sunday', 'day' => __( 'Sunday', 'watch-collections' ), 'short' => __( 'SUN', 'watch-collections' ), 'scene' => __( 'Room to slow down', 'watch-collections' ), 'style' => __( 'Casual chronograph style', 'watch-collections' ) ),
);
$week_images_are_previews = false;
foreach ( $week_scenes as &$week_scene ) {
	$webp_path = '/assets/hero-days/' . $week_scene['slug'] . '.webp';
	if ( file_exists( get_template_directory() . $webp_path ) ) {
		$week_scene['image'] = add_query_arg( 'ver', (string) filemtime( get_template_directory() . $webp_path ), get_template_directory_uri() . $webp_path );
	} else {
		$week_scene['image'] = get_template_directory_uri() . '/assets/hero-days/' . $week_scene['slug'] . '.svg';
		$week_images_are_previews = true;
	}
}
unset( $week_scene );
?>
<main id="main">
	<section class="week-hero" aria-labelledby="hero-title" data-week-hero data-duration="3000">
		<div class="week-hero__visual" aria-hidden="true">
			<?php foreach ( $week_scenes as $index => $scene ) : ?>
				<div class="week-hero__scene<?php echo 0 === $index ? ' is-active' : ''; ?>" data-hero-scene="<?php echo esc_attr( $index ); ?>" style="--day-index:<?php echo esc_attr( $index ); ?>">
					<img
						src="<?php echo esc_url( $scene['image'] ); ?>"
						alt=""
						<?php if ( isset( $scene['position'] ) ) : ?>style="object-position:<?php echo esc_attr( $scene['position'] ); ?>"<?php endif; ?>
						<?php echo 0 === $index ? 'fetchpriority="high" loading="eager"' : 'loading="lazy"'; ?>
						decoding="async"
						width="1600"
						height="900"
					>
				</div>
			<?php endforeach; ?>
			<div class="week-hero__shade"></div>
		</div>
		<div class="container week-hero__layout">
			<div class="week-hero__copy">
				<p class="week-hero__eyebrow"><?php esc_html_e( 'A COLLECTION FOR REAL LIFE', 'watch-collections' ); ?></p>
				<h1 id="hero-title"><?php esc_html_e( 'Seven days.', 'watch-collections' ); ?> <em><?php esc_html_e( 'Seven sides of you.', 'watch-collections' ); ?></em></h1>
				<p class="week-hero__statement"><?php esc_html_e( 'A watch for every moment. A collection that’s yours.', 'watch-collections' ); ?></p>
				<p class="week-hero__description"><?php esc_html_e( 'From the everyday routine to the moments worth dressing for, your style changes with the occasion. Your watches should feel just as natural.', 'watch-collections' ); ?></p>
				<p class="week-hero__description week-hero__description--closing"><?php esc_html_e( 'Choose the pieces that speak to you. Bring them together in one collection, made to fit your life.', 'watch-collections' ); ?></p>
				<div class="week-hero__actions">
					<a href="#collection-options" class="week-hero__cta"><?php esc_html_e( 'Explore collection options', 'watch-collections' ); ?><span aria-hidden="true">↗</span></a>
					<a href="#how-it-works" class="week-hero__secondary"><?php esc_html_e( 'How it works', 'watch-collections' ); ?><span aria-hidden="true">↘</span></a>
				</div>
				<p class="week-hero__promise"><?php esc_html_e( 'Your watches. One presentation box. The choice is yours.', 'watch-collections' ); ?></p>
			</div>

			<div class="week-hero__day-card" aria-hidden="true">
				<div class="week-hero__day-count"><span data-hero-count>01</span><span> / 07</span></div>
				<p class="week-hero__current" data-hero-day><?php echo esc_html( $week_scenes[0]['day'] ); ?></p>
				<p class="week-hero__moment" data-hero-moment><?php echo esc_html( $week_scenes[0]['scene'] ); ?></p>
				<div class="week-hero__watch"><span class="week-hero__watch-line"></span><span data-hero-style><?php echo esc_html( $week_scenes[0]['style'] ); ?></span></div>
			</div>

			<div class="week-hero__bottom">
				<div class="week-hero__selector" role="group" aria-label="<?php esc_attr_e( 'Choose a day of the week', 'watch-collections' ); ?>">
					<?php foreach ( $week_scenes as $index => $scene ) : ?>
						<button type="button" class="week-hero__tab<?php echo 0 === $index ? ' is-current' : ''; ?>" data-hero-tab="<?php echo esc_attr( $index ); ?>" data-day="<?php echo esc_attr( $scene['day'] ); ?>" data-moment="<?php echo esc_attr( $scene['scene'] ); ?>" data-style="<?php echo esc_attr( $scene['style'] ); ?>" aria-pressed="<?php echo 0 === $index ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Show %s outfit and watch', 'watch-collections' ), $scene['day'] ) ); ?>">
							<span class="week-hero__tab-number">0<?php echo esc_html( $index + 1 ); ?></span>
							<span class="week-hero__tab-name"><?php echo esc_html( $scene['short'] ); ?></span>
							<span class="week-hero__tab-track"><span></span></span>
						</button>
					<?php endforeach; ?>
				</div>
				<button type="button" class="week-hero__motion" data-hero-motion aria-pressed="false" aria-label="<?php esc_attr_e( 'Pause the seven-day animation', 'watch-collections' ); ?>">
					<span class="week-hero__pause-icon" aria-hidden="true"></span>
					<span data-hero-motion-label><?php esc_html_e( 'Pause', 'watch-collections' ); ?></span>
				</button>
			</div>
			<p class="week-hero__preview-note"><?php esc_html_e( 'AI-generated lifestyle concepts. Actual watch models and specifications will be confirmed in the catalog.', 'watch-collections' ); ?></p>
			<?php if ( $week_images_are_previews ) : ?>
				<p class="week-hero__preview-note"><?php esc_html_e( 'Illustrated concept preview. Final campaign photography will replace these scenes.', 'watch-collections' ); ?></p>
			<?php endif; ?>
			<p class="screen-reader-text" role="status" aria-live="polite" aria-atomic="true" data-hero-announcer></p>
		</div>
	</section>


	<section class="editorial-quality" id="quality" aria-labelledby="quality-title">
		<div class="container editorial-quality__layout">
			<div class="editorial-quality__intro">
				<p class="editorial-tag"><span></span><?php esc_html_e( '01 / THE DETAILS', 'watch-collections' ); ?></p>
				<h2 id="quality-title"><?php esc_html_e( 'A beautiful dial catches your eye.', 'watch-collections' ); ?> <em><?php esc_html_e( 'The details deserve a closer look.', 'watch-collections' ); ?></em></h2>
				<p><?php esc_html_e( 'There is more to a watch than the way it photographs. We are building product listings around the details that matter for real ownership.', 'watch-collections' ); ?></p>
				<div class="editorial-quality__visual" role="img" aria-label="<?php esc_attr_e( 'Decorative illustration of a watch movement and dial', 'watch-collections' ); ?>">
					<div class="editorial-quality__ring"><div class="editorial-quality__dial"><i></i><b></b></div></div>
					<span><?php esc_html_e( 'FORM / FUNCTION / FIT', 'watch-collections' ); ?></span>
				</div>
			</div>
			<div class="editorial-quality__details">
				<article><span>01</span><div><h3><?php esc_html_e( 'Movement', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Quartz, automatic or hand-wound. You should know what powers each model and what care it requires.', 'watch-collections' ); ?></p></div></article>
				<article><span>02</span><div><h3><?php esc_html_e( 'Materials & finishing', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Understand the case, strap and clasp materials, plus the details that affect feel and appearance.', 'watch-collections' ); ?></p></div></article>
				<article><span>03</span><div><h3><?php esc_html_e( 'Crystal & durability', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Crystal type, water-resistance rating and practical wearing limits matter more than broad durability claims.', 'watch-collections' ); ?></p></div></article>
				<article><span>04</span><div><h3><?php esc_html_e( 'Fit & comfort', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Case diameter, thickness, weight and strap details help you choose a watch for your wrist.', 'watch-collections' ); ?></p></div></article>
				<article><span>05</span><div><h3><?php esc_html_e( 'Real functions', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Functional chronographs and moonphases should be distinguished from decorative subdials and day-night designs.', 'watch-collections' ); ?></p></div></article>
				<p class="editorial-quality__note"><?php esc_html_e( 'Exact specifications will be published per verified model. We do not claim identical materials or performance across every watch.', 'watch-collections' ); ?></p>
			</div>
		</div>
	</section>


	<section class="editorial-intro" id="the-idea" aria-labelledby="intro-title">
		<div class="container editorial-intro__grid">
			<div class="editorial-montage">
				<div class="editorial-montage__tile editorial-montage__tile--main">
					<img src="<?php echo esc_url( $week_scenes[0]['image'] ); ?>" alt="<?php esc_attr_e( 'Illustrated weekday outfit with a classic wristwatch', 'watch-collections' ); ?>" loading="lazy" width="1600" height="900" decoding="async">
				</div>
				<div class="editorial-montage__tile editorial-montage__tile--top">
					<img src="<?php echo esc_url( $week_scenes[4]['image'] ); ?>" alt="<?php esc_attr_e( 'Illustrated evening look paired with a dress watch', 'watch-collections' ); ?>" loading="lazy" width="1600" height="900" decoding="async">
				</div>
				<div class="editorial-montage__tile editorial-montage__tile--bottom">
					<img src="<?php echo esc_url( $week_scenes[5]['image'] ); ?>" alt="<?php esc_attr_e( 'Illustrated weekend outfit with a sporty watch', 'watch-collections' ); ?>" loading="lazy" width="1600" height="900" decoding="async">
				</div>
				<div class="editorial-montage__label" aria-hidden="true"><strong>7</strong><span><?php esc_html_e( 'days to dress for', 'watch-collections' ); ?></span></div>
				<span class="editorial-montage__caption"><?php esc_html_e( 'Concept visuals • final watch photography to follow', 'watch-collections' ); ?></span>
			</div>
			<div class="editorial-intro__content">
				<p class="editorial-tag"><span></span><?php esc_html_e( '02 / THE IDEA', 'watch-collections' ); ?></p>
				<h2 id="intro-title"><?php esc_html_e( 'Not one watch for everything.', 'watch-collections' ); ?> <em><?php esc_html_e( 'A choice for every moment.', 'watch-collections' ); ?></em></h2>
				<p class="editorial-lede"><?php esc_html_e( 'What feels right for Monday morning might not be what you want on Saturday night. A collection gives you the freedom to choose.', 'watch-collections' ); ?></p>
				<p><?php esc_html_e( 'We bring different watch styles together through one simple idea: you choose the watches you want, we present them as a collection in a dedicated box. No mystery assortment. No pressure to dress the same way every day.', 'watch-collections' ); ?></p>
				<div class="editorial-intro__facts">
					<div><span aria-hidden="true">✓</span><?php esc_html_e( 'Choose every eligible watch', 'watch-collections' ); ?></div>
					<div><span aria-hidden="true">✓</span><?php esc_html_e( 'One box for the collection', 'watch-collections' ); ?></div>
					<div><span aria-hidden="true">✓</span><?php esc_html_e( 'Review the price and contents before buying', 'watch-collections' ); ?></div>
				</div>
				<a class="editorial-button" href="#collection-options"><?php esc_html_e( 'See collection options', 'watch-collections' ); ?><span aria-hidden="true">↗</span></a>
			</div>
		</div>
	</section>

	<section class="editorial-feature-band" aria-labelledby="features-title">
		<div class="container">
			<div class="editorial-feature-band__heading"><p class="editorial-tag editorial-tag--light"><?php esc_html_e( 'WHY A COLLECTION', 'watch-collections' ); ?></p><h2 id="features-title" class="screen-reader-text"><?php esc_html_e( 'The collection advantages', 'watch-collections' ); ?></h2></div>
			<div class="editorial-features">
				<article class="editorial-feature">
					<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="17"/><circle cx="24" cy="24" r="12"/><path d="M24 16v9l7 4M24 2v5M24 41v5"/></svg>
					<h3><?php esc_html_e( 'Understand the watch', 'watch-collections' ); ?></h3>
					<p><?php esc_html_e( 'Movement, materials and real functions should be clearly explained—not hidden behind attractive images.', 'watch-collections' ); ?></p>
				</article>
				<article class="editorial-feature">
					<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M7 10h34M7 24h34M7 38h34"/><circle cx="18" cy="10" r="5"/><circle cx="31" cy="24" r="5"/><circle cx="15" cy="38" r="5"/></svg>
					<h3><?php esc_html_e( 'Your own selection', 'watch-collections' ); ?></h3>
					<p><?php esc_html_e( 'A curated choice of styles. You decide what belongs in your box, subject to the available collection.', 'watch-collections' ); ?></p>
				</article>
				<article class="editorial-feature">
					<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><rect x="6" y="13" width="36" height="27" rx="2"/><path d="M6 21h36M12 13V8h24v5M12 29l7 6 16-17"/></svg>
					<h3><?php esc_html_e( 'An order you can check', 'watch-collections' ); ?></h3>
					<p><?php esc_html_e( 'Your chosen models, quantities and box will be summarized before checkout; packing checks are part of our launch plan.', 'watch-collections' ); ?></p>
				</article>
				<article class="editorial-feature">
					<svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M5 14h25v22H5zM30 21h7l7 9v6H30z"/><circle cx="14" cy="37" r="4"/><circle cx="36" cy="37" r="4"/><path d="M9 8h18"/></svg>
					<h3><?php esc_html_e( 'Clarity through delivery', 'watch-collections' ); ?></h3>
					<p><?php esc_html_e( 'See available shipping terms before payment, including estimated timing and applicable delivery charges.', 'watch-collections' ); ?></p>
				</article>
			</div>
		</div>
	</section>

	<section class="editorial-process" id="how-it-works" aria-labelledby="process-title">
		<div class="container">
			<div class="editorial-section-top">
				<div><p class="editorial-tag"><span></span><?php esc_html_e( '03 / THE EXPERIENCE', 'watch-collections' ); ?></p><h2 id="process-title"><?php esc_html_e( 'Choose the watches.', 'watch-collections' ); ?> <em><?php esc_html_e( 'We bring the box together.', 'watch-collections' ); ?></em></h2></div>
				<p><?php esc_html_e( 'The Collection Studio is being developed separately. This is the intended ordering experience.', 'watch-collections' ); ?></p>
			</div>
			<div class="editorial-process__steps">
				<div><span>01</span><h3><?php esc_html_e( 'Choose your box', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Pick space for 1, 3, 5 or 7 watches and see the planned price upfront.', 'watch-collections' ); ?></p></div>
				<div><span>02</span><h3><?php esc_html_e( 'Find your watches', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Mix eligible styles, check their details and change your selection before confirming.', 'watch-collections' ); ?></p></div>
				<div><span>03</span><h3><?php esc_html_e( 'Review every detail', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'See the exact watch models, quantities, box and order total before any payment.', 'watch-collections' ); ?></p></div>
			</div>
		</div>
	</section>

	<section class="editorial-packages" id="collection-options" aria-labelledby="collection-options-title">
		<div class="container">
			<div class="editorial-section-top">
				<div><p class="editorial-tag"><span></span><?php esc_html_e( '04 / YOUR COLLECTION', 'watch-collections' ); ?></p><h2 id="collection-options-title"><?php esc_html_e( 'A place for every piece.', 'watch-collections' ); ?> <em><?php esc_html_e( 'Start with your number.', 'watch-collections' ); ?></em></h2></div>
				<p><?php esc_html_e( 'Choose the size of your collection. Each package pairs the specified number of eligible watches with a presentation box.', 'watch-collections' ); ?></p>
			</div>
			<div class="editorial-packages__grid">
				<?php foreach ( $collection_options as $option ) : ?>
				<article class="editorial-package">
					<div class="editorial-package__top"><span><?php echo esc_html( sprintf( _n( '%s WATCH', '%s WATCHES', $option['count'], 'watch-collections' ), number_format_i18n( $option['count'] ) ) ); ?></span><span aria-hidden="true">↗</span></div>
					<div class="editorial-package__box" aria-hidden="true"><div class="editorial-package__wood"><?php for ( $n = 0; $n < $option['count']; $n++ ) : ?><span class="editorial-package__compartment"><i></i></span><?php endfor; ?></div></div>
					<h3><?php echo esc_html( $option['name'] ); ?></h3>
					<p><?php echo esc_html( $option['detail'] ); ?></p>
					<p class="editorial-package__price">$<?php echo esc_html( number_format_i18n( $option['price'] ) ); ?> <span><?php esc_html_e( 'USD / collection', 'watch-collections' ); ?></span></p>
				</article>
				<?php endforeach; ?>
			</div>
			<p class="editorial-caption"><?php esc_html_e( 'Package boxes are illustrative diagrams, not final product photographs. Prices are provisional; eligible watches, final box specifications, stock, taxes, shipping charges and purchase terms will be confirmed before launch. Orders are not being accepted.', 'watch-collections' ); ?></p>
		</div>
	</section>

	<section class="editorial-fulfillment" id="fulfillment" aria-labelledby="fulfillment-title">
		<div class="container">
			<div class="editorial-fulfillment__intro">
				<p class="editorial-tag editorial-tag--light"><?php esc_html_e( '05 / BEYOND CHECKOUT', 'watch-collections' ); ?></p>
				<h2 id="fulfillment-title"><?php esc_html_e( 'Your choices deserve', 'watch-collections' ); ?> <em><?php esc_html_e( 'a careful journey.', 'watch-collections' ); ?></em></h2>
				<p><?php esc_html_e( 'Your collection should arrive with the models you selected, not unexplained substitutions. We are designing our fulfillment around order matching, item checks, protective packing and clear delivery information.', 'watch-collections' ); ?></p>
			</div>
			<div class="editorial-fulfillment__timeline">
				<article><span>01</span><h3><?php esc_html_e( 'Your order', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Selected models and the box size recorded together.', 'watch-collections' ); ?></p></article>
				<article><span>02</span><h3><?php esc_html_e( 'Verification & packing', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Our planned checks cover matching items, condition and secure packing.', 'watch-collections' ); ?></p></article>
				<article><span>03</span><h3><?php esc_html_e( 'Shipping & customs', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Carrier transport and any cross-border processing; estimates depend on destination.', 'watch-collections' ); ?></p></article>
				<article><span>04</span><h3><?php esc_html_e( 'Final delivery', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Delivery to your address, with tracking when supported by the service.', 'watch-collections' ); ?></p></article>
			</div>
			<div class="editorial-fulfillment__foot"><span><?php esc_html_e( 'Shipping timelines, costs and returns will be published by destination before launch.', 'watch-collections' ); ?></span><a href="#confidence"><?php esc_html_e( 'What you will know before paying', 'watch-collections' ); ?> ↗</a></div>
		</div>
	</section>

	<section class="editorial-assurance" id="confidence" aria-labelledby="assurance-title">
		<div class="container editorial-assurance__grid">
			<div><p class="editorial-tag"><span></span><?php esc_html_e( '06 / NO GUESSWORK', 'watch-collections' ); ?></p><h2 id="assurance-title"><?php esc_html_e( 'A purchase should make sense', 'watch-collections' ); ?> <em><?php esc_html_e( 'before you make it.', 'watch-collections' ); ?></em></h2></div>
			<div class="editorial-assurance__copy">
				<p><?php esc_html_e( 'You deserve to know what is inside your box, what each watch is made from, what the full order costs and what happens if something goes wrong.', 'watch-collections' ); ?></p>
				<ul>
					<li><?php esc_html_e( 'An item-by-item order summary', 'watch-collections' ); ?></li>
					<li><?php esc_html_e( 'Verified specifications and limitations', 'watch-collections' ); ?></li>
					<li><?php esc_html_e( 'Applicable delivery costs and estimates', 'watch-collections' ); ?></li>
					<li><?php esc_html_e( 'Published warranty, returns and support terms', 'watch-collections' ); ?></li>
				</ul>
				<p class="editorial-assurance__fine"><?php esc_html_e( 'These are the standards we are building toward. Final policies and the ordering experience are not live yet.', 'watch-collections' ); ?></p>
			</div>
		</div>
	</section>

	<section class="editorial-closing" aria-labelledby="closing-title">
		<div class="container">
			<p class="editorial-tag editorial-tag--light"><?php esc_html_e( 'A WEEK FULL OF POSSIBILITIES', 'watch-collections' ); ?></p>
			<h2 id="closing-title"><?php esc_html_e( 'Different days. Different watches.', 'watch-collections' ); ?><br><em><?php esc_html_e( 'One collection. Yours.', 'watch-collections' ); ?></em></h2>
			<a class="editorial-button editorial-button--light" href="#collection-options"><?php esc_html_e( 'Explore the collection options', 'watch-collections' ); ?> <span aria-hidden="true">↗</span></a>
			<p><?php esc_html_e( 'Collection Studio preview in development. No live checkout yet.', 'watch-collections' ); ?></p>
		</div>
	</section>
</main>
<?php get_footer(); ?>
