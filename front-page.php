<?php
/**
 * Homepage: explain the watch-collection value proposition before the studio.
 * This is a brand/education page, not the interactive collection builder.
 *
 * @package Watch_Collections
 */
get_header();

$collection_options = watch_collections_packages();

$week_scenes = array(
	array( 'slug' => 'monday', 'day' => __( 'Monday', 'watch-collections' ), 'short' => __( 'MON', 'watch-collections' ), 'scene' => __( 'Composed. Polished. Ready for the week.', 'watch-collections' ), 'style' => __( 'Business / Classic', 'watch-collections' ) ),
	array( 'slug' => 'tuesday', 'day' => __( 'Tuesday', 'watch-collections' ), 'short' => __( 'TUE', 'watch-collections' ), 'scene' => __( 'Everyday essentials, with a warm metallic edge.', 'watch-collections' ), 'style' => __( 'Everyday / Casual', 'watch-collections' ) ),
	array( 'slug' => 'wednesday', 'day' => __( 'Wednesday', 'watch-collections' ), 'short' => __( 'WED', 'watch-collections' ), 'scene' => __( 'Made for the days that move differently.', 'watch-collections' ), 'style' => __( 'Active / Sport', 'watch-collections' ) ),
	array( 'slug' => 'thursday', 'day' => __( 'Thursday', 'watch-collections' ), 'short' => __( 'THU', 'watch-collections' ), 'scene' => __( 'Dark tones. A confident gold accent.', 'watch-collections' ), 'style' => __( 'Smart / Refined', 'watch-collections' ) ),
	array( 'slug' => 'friday', 'day' => __( 'Friday', 'watch-collections' ), 'short' => __( 'FRI', 'watch-collections' ), 'scene' => __( 'A little sharper when the evening begins.', 'watch-collections' ), 'style' => __( 'Evening / Classy', 'watch-collections' ) ),
	array( 'slug' => 'saturday', 'day' => __( 'Saturday', 'watch-collections' ), 'short' => __( 'SAT', 'watch-collections' ), 'scene' => __( 'Relaxed layers. An expressive blue dial.', 'watch-collections' ), 'style' => __( 'Weekend / Social', 'watch-collections' ) ),
	array( 'slug' => 'sunday', 'day' => __( 'Sunday', 'watch-collections' ), 'short' => __( 'SUN', 'watch-collections' ), 'scene' => __( 'A quieter look for a slower kind of day.', 'watch-collections' ), 'style' => __( 'Relaxed / Minimal', 'watch-collections' ) ),
);
$week_images_are_previews = false;
foreach ( $week_scenes as &$week_scene ) {
	$frame_path = '/assets/hero-days/' . $week_scene['slug'] . '-hold.jpg';
	$week_scene['image'] = add_query_arg( 'ver', wp_get_theme()->get( 'Version' ), get_template_directory_uri() . $frame_path );
}
unset( $week_scene );
$hero_video_url = watch_collections_hero_video_url();
?>
<main id="main">
	<section class="week-hero week-hero--interactive<?php echo $hero_video_url ? '' : ' has-video-error'; ?>" aria-labelledby="hero-title" data-week-hero>
		<div class="week-hero__experience">
			<div class="week-hero__film" aria-hidden="true">
				<div class="week-hero__fallback-scenes">
					<?php foreach ( $week_scenes as $index => $scene ) : ?>
						<img class="week-hero__fallback-image<?php echo 0 === $index ? ' is-active' : ''; ?>" data-hero-fallback-image="<?php echo esc_attr( $index ); ?>" src="<?php echo esc_url( $scene['image'] ); ?>" alt="" loading="eager" decoding="async" width="1600" height="900">
					<?php endforeach; ?>
				</div>
				<video
					class="week-hero__video"
					data-hero-video
					data-video-available="<?php echo $hero_video_url ? '1' : '0'; ?>"
					autoplay
					muted
					loop
					playsinline
					webkit-playsinline
					disablepictureinpicture
					preload="auto"
					poster="<?php echo esc_url( $week_scenes[0]['image'] ); ?>"
					width="1280"
					height="720"
				>
					<?php if ( $hero_video_url ) : ?>
					<source src="<?php echo esc_url( $hero_video_url ); ?>" type="video/mp4">
				<?php endif; ?>
				</video>
				<div class="week-hero__film-shade"></div>
			</div>

			<div class="week-hero__rail">
				<p class="week-hero__eyebrow"><?php esc_html_e( 'THE SEVEN-DAY EDIT', 'watch-collections' ); ?></p>

				<div class="week-hero__day-card">
					<div class="week-hero__day-count" aria-hidden="true"><span data-hero-count>01</span><span> / 07</span></div>
					<h1 id="hero-title" class="week-hero__current" data-hero-day><?php echo esc_html( $week_scenes[0]['day'] ); ?></h1>
					<p class="week-hero__watch"><span class="week-hero__watch-line"></span><span data-hero-style><?php echo esc_html( $week_scenes[0]['style'] ); ?></span></p>
					<p class="week-hero__moment" data-hero-moment><?php echo esc_html( $week_scenes[0]['scene'] ); ?></p>
					<p class="screen-reader-text" aria-hidden="true" data-hero-status><?php esc_html_e( 'Playing the week', 'watch-collections' ); ?></p>
				</div>

				<p class="screen-reader-text"><?php esc_html_e( 'Choose a day to pause', 'watch-collections' ); ?></p>
				<div class="week-hero__selector" role="group" aria-label="<?php esc_attr_e( 'Choose a day to play to and pause', 'watch-collections' ); ?>">
					<?php foreach ( $week_scenes as $index => $scene ) : ?>
						<button type="button" class="week-hero__tab<?php echo 0 === $index ? ' is-current' : ''; ?>" data-hero-tab="<?php echo esc_attr( $index ); ?>" data-day="<?php echo esc_attr( $scene['day'] ); ?>" data-moment="<?php echo esc_attr( $scene['scene'] ); ?>" data-style="<?php echo esc_attr( $scene['style'] ); ?>" aria-pressed="<?php echo 0 === $index ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Play to %s and pause on the watch', 'watch-collections' ), $scene['day'] ) ); ?>">
							<span class="week-hero__tab-number" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
							<span class="week-hero__tab-name"><?php echo esc_html( $scene['short'] ); ?></span>
							<span class="week-hero__tab-indicator" aria-hidden="true"></span>
						</button>
					<?php endforeach; ?>
				</div>

				<div class="week-hero__rail-actions">
					<a href="<?php echo esc_url( watch_collections_studio_url() ); ?>" class="week-hero__cta"><?php esc_html_e( 'Build your collection', 'watch-collections' ); ?><span aria-hidden="true"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></span></a>
					<button type="button" class="week-hero__motion" data-hero-motion aria-pressed="false" aria-label="<?php esc_attr_e( 'Pause the weekly video', 'watch-collections' ); ?>">
						<span class="week-hero__pause-icon" aria-hidden="true"></span>
						<span data-hero-motion-label><?php esc_html_e( 'Pause', 'watch-collections' ); ?></span>
					</button>
				</div>
			</div>
		</div>
		<p class="screen-reader-text" role="status" aria-live="polite" aria-atomic="true" data-hero-announcer></p>
	</section>


	<section class="editorial-quality" id="quality" aria-labelledby="quality-title">
		<div class="container editorial-quality__layout">
			<div class="editorial-quality__story">
			<div class="editorial-quality__intro">
				<p class="editorial-tag"><span></span><?php esc_html_e( '01 / THE DETAILS', 'watch-collections' ); ?></p>
				<h2 id="quality-title"><?php esc_html_e( 'A beautiful dial catches your eye.', 'watch-collections' ); ?> <em><?php esc_html_e( 'The details deserve a closer look.', 'watch-collections' ); ?></em></h2>
				<p><?php esc_html_e( 'There is more to a watch than the way it photographs. We are building product listings around the details that matter for real ownership.', 'watch-collections' ); ?></p>
			</div>
			<figure class="editorial-quality__visual">
				<video class="editorial-quality__assembly" data-assembly-video autoplay muted loop playsinline webkit-playsinline preload="metadata" poster="<?php echo esc_url( get_template_directory_uri() . '/assets/assembly/poster.jpg' ); ?>" width="1920" height="1080" aria-label="<?php esc_attr_e( 'Animated exploded watch assembly', 'watch-collections' ); ?>">
					<source src="<?php echo esc_url( get_template_directory_uri() . '/assets/assembly/watch-assembly-loop.mp4' ); ?>" type="video/mp4">
				</video>
				<button class="editorial-quality__motion" type="button" data-assembly-motion aria-pressed="false" aria-label="<?php esc_attr_e( 'Pause watch assembly animation', 'watch-collections' ); ?>"><?php esc_html_e( 'Pause animation', 'watch-collections' ); ?></button>
				<figcaption><?php esc_html_e( 'Illustrative watch assembly', 'watch-collections' ); ?></figcaption>
			</figure>
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
				<p><?php esc_html_e( 'Try the Collection Studio with concept watches. Choose a box, explore styles and see your selection together.', 'watch-collections' ); ?></p>
			</div>
			<div class="editorial-process__steps">
				<div><span>01</span><h3><?php esc_html_e( 'Choose your box', 'watch-collections' ); ?></h3><p><?php esc_html_e( 'Pick space for 1, 3 or 6 watches and see the planned pricing status upfront.', 'watch-collections' ); ?></p></div>
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
			<div class="editorial-packages__grid editorial-packages__grid--three">
				<?php foreach ( $collection_options as $option ) : ?>
				<article class="editorial-package">
					<div class="editorial-package__top"><span><?php echo esc_html( sprintf( _n( '%s WATCH', '%s WATCHES', $option['count'], 'watch-collections' ), number_format_i18n( $option['count'] ) ) ); ?></span><span aria-hidden="true">↗</span></div>
					<div class="editorial-package__box editorial-package__box--photo" aria-hidden="true"><?php watch_collections_box_image( $option['count'], 'editorial-package__photo', '(max-width: 700px) 90vw, 420px' ); ?></div>
					<h3><?php echo esc_html( $option['name'] ); ?></h3>
					<p><?php echo esc_html( $option['detail'] ); ?></p>
					<?php if ( null !== $option['price'] ) : ?>
					<p class="editorial-package__price">$<?php echo esc_html( number_format_i18n( $option['price'] ) ); ?> <span><?php esc_html_e( 'USD / collection', 'watch-collections' ); ?></span></p>
					<?php else : ?>
					<p class="editorial-package__price editorial-package__price--pending"><?php esc_html_e( 'Price to be confirmed', 'watch-collections' ); ?></p>
					<?php endif; ?>
					<a class="editorial-package__choose" href="<?php echo esc_url( watch_collections_studio_url( $option['count'] ) ); ?>"><?php echo esc_html( sprintf( _n( 'Choose my %d watch', 'Choose my %d watches', $option['count'], 'watch-collections' ), $option['count'] ) ); ?><span aria-hidden="true">↗</span></a>
				</article>
				<?php endforeach; ?>
			</div>
			<p class="editorial-caption"><?php esc_html_e( 'Box images are AI-generated visuals based on supplier references; the single-watch box is a concept. Prices are provisional. Eligible watches, final box specifications, stock, taxes, shipping charges and purchase terms will be confirmed before launch. Orders are not being accepted.', 'watch-collections' ); ?></p>
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
			<a class="editorial-button editorial-button--light" href="<?php echo esc_url( watch_collections_studio_url() ); ?>"><?php esc_html_e( 'Build your collection', 'watch-collections' ); ?> <span aria-hidden="true">↗</span></a>
			<p><?php esc_html_e( 'Try the Collection Studio preview. No live checkout yet.', 'watch-collections' ); ?></p>
		</div>
	</section>
</main>
<?php get_footer(); ?>



