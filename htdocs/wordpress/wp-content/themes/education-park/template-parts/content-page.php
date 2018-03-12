<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Education Park
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content clearfix">
		<?php
			education_park_post_content();

		$default =  array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:','education-park' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page','education-park' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			);
			wp_link_pages( $default );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer clearfix">
		<?php education_park_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->