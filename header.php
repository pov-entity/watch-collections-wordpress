<?php
/**
 * Global site header.
 *
 * @package Watch_Collections
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'watch-collections' ); ?></a>
<div class="site-shell">
	<div class="announcement-bar"><span class="announcement-dot" aria-hidden="true"></span><?php esc_html_e( 'A rotation for real life. One watch at a time.', 'watch-collections' ); ?></div>
	<header class="site-header" id="top">
		<div class="container header-inner">
			<div class="brand">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a class="brand-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Watch Collections home', 'watch-collections' ); ?>">
						<span class="brand-symbol" aria-hidden="true"><span></span></span>
						<span class="brand-text">WATCH<span>COLLECTIONS</span></span>
					</a>
				<?php endif; ?>
			</div>
			<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-navigation" aria-label="<?php esc_attr_e( 'Toggle navigation', 'watch-collections' ); ?>">
				<span></span><span></span><span></span>
			</button>
			<nav class="site-nav" id="site-navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'watch-collections' ); ?>">
				<?php if ( has_nav_menu( 'primary' ) ) : ?>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-list', 'depth' => 2 ) ); ?>
				<?php else : ?>
					<ul class="nav-list">
						<li><a href="<?php echo esc_url( home_url( '/#collections' ) ); ?>"><?php esc_html_e( 'The collections', 'watch-collections' ); ?></a></li>
						<li><a href="<?php echo esc_url( home_url( '/#how-it-works' ) ); ?>"><?php esc_html_e( 'The idea', 'watch-collections' ); ?></a></li>
						<li><a href="<?php echo esc_url( watch_collections_shop_url() ); ?>"><?php esc_html_e( 'Shop', 'watch-collections' ); ?></a></li>
					</ul>
				<?php endif; ?>
			</nav>
			<a class="header-action" href="<?php echo esc_url( watch_collections_shop_url() ); ?>">
				<?php esc_html_e( 'Explore watches', 'watch-collections' ); ?><span aria-hidden="true"> ↗</span>
			</a>
		</div>
	</header>
