<?php
/**
 * Fallback template for posts and archives.
 *
 * @package Watch_Collections
 */
get_header();
?>
<main id="main" class="standard-main container">
	<header class="standard-heading"><p class="eyebrow"><?php esc_html_e( 'JOURNAL', 'watch-collections' ); ?></p><h1><?php echo esc_html( is_home() ? __( 'Stories for the everyday', 'watch-collections' ) : wp_get_document_title() ); ?></h1></header>
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
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing to show yet. Check back as we build the collection.', 'watch-collections' ); ?></p>
	<?php endif; ?>
</main>
<?php get_footer(); ?>
