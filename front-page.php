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
	array( 'slug' => 'monday', 'day' => __( 'Monday', 'watch-collections' ), 'short' => __( 'MON', 'watch-collections' ), 'scene' => __( 'The first impression', 'watch-collections' ), 'style' => __( 'Classic', 'watch-collections' ) ),
	array( 'slug' => 'tuesday', 'day' => __( 'Tuesday', 'watch-collections' ), 'short' => __( 'TUE', 'watch-collections' ), 'scene' => __( 'The everyday meeting', 'watch-collections' ), 'style' => __( 'Chronograph', 'watch-collections' ) ),
	array( 'slug' => 'wednesday', 'day' => __( 'Wednesday', 'watch-collections' ), 'short' => __( 'WED', 'watch-collections' ), 'scene' => __( 'Out in the city', 'watch-collections' ), 'style' => __( 'Minimal', 'watch-collections' ) ),
	array( 'slug' => 'thursday', 'day' => __( 'Thursday', 'watch-collections' ), 'short' => __( 'THU', 'watch-collections' ), 'scene' => __( 'A little more refined', 'watch-collections' ), 'style' => __( 'Moonphase-inspired', 'watch-collections' ) ),
	array( 'slug' => 'friday', 'day' => __( 'Friday', 'watch-collections' ), 'short' => __( 'FRI', 'watch-collections' ), 'scene' => __( 'Plans after dark', 'watch-collections' ), 'style' => __( 'Dress', 'watch-collections' ) ),
	array( 'slug' => 'saturday', 'day' => __( 'Saturday', 'watch-collections' ), 'short' => __( 'SAT', 'watch-collections' ), 'scene' => __( 'The weekend begins', 'watch-collections' ), 'style' => __( 'Sport', 'watch-collections' ) ),
	array( 'slug' => 'sunday', 'day' => __( 'Sunday', 'watch-collections' ), 'short' => __( 'SUN', 'watch-collections' ), 'scene' => __( 'Room to slow down', 'watch-collections' ), 'style' => __( 'Skeleton-inspired', 'watch-collections' ) ),
);
$week_images_are_previews = false;
foreach ( $week_scenes as &$week_scene ) {
	$webp_path = '/assets/hero-days/' . $week_scene['slug'] . '.webp';
	if ( file_exists( get_template_directory() . $webp_path ) ) {
		$week_scene['image'] = get_template_directory_uri() . $webp_path;
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
				<p class="week-hero__eyebrow"><?php esc_html_e( 'SEVEN DAYS. MANY SIDES OF YOU.', 'watch-collections' ); ?></p>
				<h1 id="hero-title"><?php esc_html_e( 'Your week has', 'watch-collections' ); ?> <em><?php esc_html_e( 'seven sides.', 'watch-collections' ); ?></em></h1>
				<p class="week-hero__statement"><?php esc_html_e( 'Your watch collection should too.', 'watch-collections' ); ?></p>
				<p class="week-hero__description"><?php esc_html_e( 'From workdays to weekends, bring together watches that suit the way you dress, move and live. Choose the styles. Make the collection yours.', 'watch-collections' ); ?></p>
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
			<?php if ( $week_images_are_previews ) : ?>
				<p class="week-hero__preview-note"><?php esc_html_e( 'Illustrated concept preview. Final campaign photography will replace these scenes.', 'watch-collections' ); ?></p>
			<?php endif; ?>
			<p class="screen-reader-text" role="status" aria-live="polite" aria-atomic="true" data-hero-announcer></p>
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
