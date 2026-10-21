<?php
/**
 * Archive template.
 *
 * @package Watch_Collections
 */
get_header();
?>
<main id="main" class="standard-main container">
	<header class="standard-heading"><p class="eyebrow"><?php esc_html_e( 'EXPLORE', 'watch-collections' ); ?></p><h1><?php the_archive_title(); ?></h1><?php the_archive_description( '<div class="archive-description">', '</div>' ); ?></header>
	<?php if ( have_posts() ) : ?>
		<div class="journal-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class( 'journal-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a><?php endif; ?>
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<div class="entry-excerpt"><?php the_excerpt(); ?></div>
				</article>
			<?php endwhile; ?>
		</div>
		<?php the_posts_pagination(); ?>
	<?php else : ?><p><?php esc_html_e( 'No items found.', 'watch-collections' ); ?></p><?php endif; ?>
</main>
<?php get_footer(); ?>
