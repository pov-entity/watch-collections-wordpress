<?php
/**
 * Default page template.
 *
 * @package Watch_Collections
 */
get_header();
?>
<main id="main" class="standard-main container">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'page-content' ); ?>>
			<header class="standard-heading"><h1><?php the_title(); ?></h1></header>
			<div class="prose"><?php the_content(); wp_link_pages(); ?></div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
