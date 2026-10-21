<?php
/**
 * Single blog post template.
 *
 * @package Watch_Collections
 */
get_header();
?>
<main id="main" class="standard-main container">
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'page-content' ); ?>>
			<header class="standard-heading"><p class="eyebrow"><?php echo esc_html( get_the_date() ); ?></p><h1><?php the_title(); ?></h1></header>
			<?php if ( has_post_thumbnail() ) : ?><div class="single-featured"><?php the_post_thumbnail( 'large' ); ?></div><?php endif; ?>
			<div class="prose"><?php the_content(); wp_link_pages(); ?></div>
		</article>
	<?php endwhile; ?>
</main>
<?php get_footer(); ?>
