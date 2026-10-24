<?php
/**
 * Collection Studio prototype. No inventory, cart, or payment mutations.
 *
 * @package Watch_Collections
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Founder-approved sizes. A null price must never become a zero-dollar offer. */
function watch_collections_packages() {
	return array(
		array( 'count' => 1, 'price' => 179, 'name' => __( 'Start with one', 'watch-collections' ), 'detail' => __( 'One watch you choose, in its presentation box.', 'watch-collections' ) ),
		array( 'count' => 3, 'price' => 333, 'name' => __( 'Room for variety', 'watch-collections' ), 'detail' => __( 'Three watches you choose, together in one box.', 'watch-collections' ) ),
		array( 'count' => 6, 'price' => 579, 'name' => __( 'Your full rotation', 'watch-collections' ), 'detail' => __( 'Six watches you choose, together in one box.', 'watch-collections' ) ),
	);
}

/** Responsive generated box visuals; the one-slot version is a concept. */
function watch_collections_box_image( $count, $class, $sizes ) {
	if ( ! in_array( (int) $count, array( 1, 3, 6 ), true ) ) {
		return;
	}
	$base    = get_template_directory_uri() . '/assets/boxes/box-' . (int) $count;
	$version = wp_get_theme()->get( 'Version' );
	$full    = add_query_arg( 'ver', $version, $base . '.webp' );
	$small   = add_query_arg( 'ver', $version, $base . '-480.webp' );
	// The adjacent package label supplies the image's accessible description.
	echo '<img class="' . esc_attr( $class ) . '" src="' . esc_url( $full ) . '" srcset="' . esc_url( $small ) . ' 480w, ' . esc_url( $full ) . ' 1448w" sizes="' . esc_attr( $sizes ) . '" width="1448" height="1086" alt="" loading="lazy" decoding="async">';
}

/** Portable even in Playground installations without pretty permalinks. */
function watch_collections_studio_url( $size = 0 ) {
	$args = array( 'collection-studio' => 1 );
	if ( in_array( (int) $size, array( 1, 3, 6 ), true ) ) {
		$args['box'] = (int) $size;
	}
	return add_query_arg( $args, home_url( '/' ) );
}

function watch_collections_studio_query_vars( $vars ) {
	$vars[] = 'collection-studio';
	return $vars;
}
add_filter( 'query_vars', 'watch_collections_studio_query_vars' );

function watch_collections_is_studio() {
	return '1' === get_query_var( 'collection-studio', '' ) || 1 === get_query_var( 'collection-studio', '' ) || is_page_template( 'page-collection-studio.php' );
}

function watch_collections_studio_template( $template ) {
	if ( watch_collections_is_studio() && ! is_feed() && ! is_embed() ) {
		return get_template_directory() . '/page-collection-studio.php';
	}
	return $template;
}
add_filter( 'template_include', 'watch_collections_studio_template', 99 );

function watch_collections_studio_title( $parts ) {
	if ( watch_collections_is_studio() ) {
		$parts['title'] = __( 'Build Your Collection', 'watch-collections' );
		unset( $parts['tagline'] );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'watch_collections_studio_title' );

/** Public concept data only. Replace through this filter when a catalog API exists. */
function watch_collections_studio_catalog() {
	$path = get_template_directory() . '/assets/data/studio-catalog.json';
	$data = is_readable( $path ) ? json_decode( file_get_contents( $path ), true ) : array();
	return apply_filters( 'watch_collections_studio_catalog', is_array( $data ) ? $data : array() );
}
