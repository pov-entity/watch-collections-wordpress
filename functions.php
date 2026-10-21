<?php
/**
 * Watch Collections theme setup.
 *
 * @package Watch_Collections
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/collection-studio.php';

function watch_collections_setup() {
	load_theme_textdomain( 'watch-collections', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'custom-logo', array( 'height' => 90, 'width' => 290, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	register_nav_menus( array(
		'primary' => __( 'Primary navigation', 'watch-collections' ),
		'footer'  => __( 'Footer navigation', 'watch-collections' ),
	) );
}
add_action( 'after_setup_theme', 'watch_collections_setup' );

function watch_collections_assets() {
	$version = wp_get_theme()->get( 'Version' );
	// Handpicked families from the founder's typography reference.
	// Load only fonts actually used by the storefront to limit network weight.
	wp_enqueue_style(
		'watch-collections-font-families',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Lora:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Montserrat:wght@500;600;700&family=Space+Mono:wght@400;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'watch-collections-style', get_stylesheet_uri(), array(), $version );
	wp_enqueue_style( 'watch-collections-site', get_template_directory_uri() . '/assets/css/site.css', array( 'watch-collections-style' ), $version );
	wp_enqueue_script( 'watch-collections-site', get_template_directory_uri() . '/assets/js/site.js', array(), $version, true );
	if ( is_front_page() && ! watch_collections_is_studio() ) {
		wp_enqueue_style(
			'watch-collections-week-hero',
			get_template_directory_uri() . '/assets/css/week-hero.css',
			array( 'watch-collections-site' ),
			$version
		);
		wp_enqueue_script(
			'watch-collections-week-hero',
			get_template_directory_uri() . '/assets/js/week-hero.js',
			array(),
			$version,
			true
		);
		wp_enqueue_style(
			'watch-collections-editorial-home',
			get_template_directory_uri() . '/assets/css/editorial-home.css',
			array( 'watch-collections-week-hero' ),
			$version
		);
	}
	// Load last: these are deliberate typography overrides on the entire site.
	wp_enqueue_style(
		'watch-collections-typography',
		get_template_directory_uri() . '/assets/css/typography.css',
		is_front_page() && ! watch_collections_is_studio() ? array( 'watch-collections-editorial-home', 'watch-collections-font-families' ) : array( 'watch-collections-site', 'watch-collections-font-families' ),
		$version
	);
	if ( watch_collections_is_studio() ) {
		wp_enqueue_style( 'watch-collections-studio', get_template_directory_uri() . '/assets/css/collection-studio.css', array( 'watch-collections-typography' ), $version );
		wp_enqueue_script( 'watch-collections-state', get_template_directory_uri() . '/assets/js/collection-state.js', array(), $version, true );
		wp_enqueue_script( 'watch-collections-studio', get_template_directory_uri() . '/assets/js/collection-studio.js', array( 'watch-collections-state' ), $version, true );
	}
}
add_action( 'wp_enqueue_scripts', 'watch_collections_assets' );

/**
 * Safe shop URL for a prototype that may not yet have WooCommerce installed.
 */
function watch_collections_shop_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$url = wc_get_page_permalink( 'shop' );
		if ( $url ) {
			return $url;
		}
	}
	return home_url( '/#collection-options' );
}

/**
 * Use the native WordPress body class on all views.
 */
function watch_collections_body_classes( $classes ) {
	$classes[] = 'watch-collections-theme';
	if ( watch_collections_is_studio() ) {
		$classes   = array_diff( $classes, array( 'home', 'blog' ) );
		$classes[] = 'collection-studio-page';
	}
	return $classes;
}
add_filter( 'body_class', 'watch_collections_body_classes' );

/**
 * Versioned assets from the founder's DialByDay brand kit.
 */
function watch_collections_brand_asset_url( $filename ) {
	return add_query_arg(
		'ver',
		wp_get_theme()->get( 'Version' ),
		get_template_directory_uri() . '/assets/brand/' . $filename
	);
}

/**
 * Use the approved mark through WordPress's native icon output, including
 * installations with no uploaded Site Icon or a previous prototype icon.
 * Leave another site's icons alone when queried from a multisite installation.
 */
function watch_collections_site_icon_url( $url, $size, $blog_id ) {
	if ( $blog_id && get_current_blog_id() !== (int) $blog_id ) {
		return $url;
	}
	$size = in_array( (int) $size, array( 32, 180, 192, 270 ), true ) ? (int) $size : 512;
	return watch_collections_brand_asset_url( 'favicon-' . $size . '.png' );
}
add_filter( 'get_site_icon_url', 'watch_collections_site_icon_url', 10, 3 );

/**
 * Supplement native PNG and Apple icons with a scalable favicon and ICO fallback.
 */
function watch_collections_site_icon_tags( $tags ) {
	array_unshift( $tags, '<link rel="icon" href="' . esc_url( watch_collections_brand_asset_url( 'favicon.ico' ) ) . '" sizes="16x16 32x32 48x48" type="image/x-icon">' );
	$tags[] = '<link rel="icon" href="' . esc_url( watch_collections_brand_asset_url( 'favicon.svg' ) ) . '" sizes="any" type="image/svg+xml">';
	return $tags;
}
add_filter( 'site_icon_meta_tags', 'watch_collections_site_icon_tags' );
