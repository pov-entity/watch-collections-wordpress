<?php
/**
 * Watch Collections theme setup.
 *
 * @package Watch_Collections
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
	wp_enqueue_style( 'watch-collections-style', get_stylesheet_uri(), array(), $version );
	wp_enqueue_style( 'watch-collections-site', get_template_directory_uri() . '/assets/css/site.css', array( 'watch-collections-style' ), $version );
	wp_enqueue_script( 'watch-collections-site', get_template_directory_uri() . '/assets/js/site.js', array(), $version, true );
	if ( is_front_page() ) {
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
	return $classes;
}
add_filter( 'body_class', 'watch_collections_body_classes' );
