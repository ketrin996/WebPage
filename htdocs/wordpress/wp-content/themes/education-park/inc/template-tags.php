<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Education Park
 */


if ( ! function_exists( 'education_park_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function education_park_posted_on() {

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		} else {
			$time_string = '<time class="entry-date published updated" datetime="%3$s">%4$s</time>';
		}

		$time_strings = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

			$archive_year  = get_the_time( 'Y' );
			$archive_month = get_the_time( 'm' );
			$archive_day   = get_the_time( 'd' );

		$posted_on = sprintf(
			_x( 'On%s', 'post date','education-park' ),
			'<a href="' . esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ) . '" rel="bookmark"> ' . $time_strings . '</a>'
		);

		$byline = sprintf(
			_x( 'by %s', 'post author','education-park' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '"> ' . esc_html( get_the_author() ) . '</a></span>'
		);

if (  'post' == get_post_type() ) {
		echo '<span class="byline"> ' . ($byline) . '</span><span class="meta-sep"> / </span><span class="posted-on">' . ($posted_on). '</span>';
}
		if ( true == get_post_format() &&  'post' == get_post_type() ) {
			echo '<span class="meta-sep"> / </span><span class="post-format">
						<span class="cat-links">In <a class="entry-format" href="' .esc_url( get_post_format_link( get_post_format() ) ) .'">'. esc_html(get_post_format_string( get_post_format() )) .'</span></a>
					</span>';
			}
		if ( 'post' == get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ','education-park' ) );
			if ( $categories_list && education_park_categorized_blog() ) {
				printf( '<span class="meta-sep"> / </span><span class="cat-links"> In ' .esc_html__( ' %1$s','education-park' ) . '</span>', wp_kses_post($categories_list) );
			}
		}
	}
endif;

if ( ! function_exists( 'education_park_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function education_park_entry_footer() {
		// Hide category and tag text for pages.
		?><div class="footer-meta-wrap clearfix"><?php
		if ( 'post' == get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ' ','education-park' ) );
			if ( $tags_list ) {
				if ( is_singular() ) {
					printf( '<span class="tags-links tagcloud">' . esc_html__( 'Posted in %1$s','education-park' ) . '</span>', wp_kses_post($tags_list) );
				}
			}
		}

		if ( ! is_single() && ! is_page() &&  ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( __( 'Leave a comment','education-park' ), __( '<i class="fa fa-comments-o"></i> 1 Comment','education-park' ), __( '<i class="fa fa-comments-o"></i> % Comments','education-park' ) );
			echo '</span>';
		}

		edit_post_link( __( 'Edit','education-park' ), '<span class="edit-link btn"><i class="fa fa-pencil"></i> ', '</span>' );
		?></div>

		<?php
		if ( is_single() ){ ?>
			<div class="post-author">
				<div class="author-img text-center">
					<?php echo (get_avatar( get_the_author_meta( 'ID' ), 60 ));?>
				</div>
				<div class="author-desc">
					<h5><?php esc_html_e('Article By','education-park'); ?> <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' ))); ?>"><?php the_author_meta('display_name'); ?></a></h5>
					<p><?php the_author_meta('description'); ?></p>

					<div class="author-links">
						<a class="author-link-posts upper" title="<?php esc_html_e('Author archive','education-park'); ?>" href="<?php echo esc_url( get_author_posts_url(get_the_author_meta( 'ID' )) ); ?>"><i class="fa fa-archive"></i> <?php esc_html_e('Author archive','education-park'); ?></a>

								<?php $author_url = get_the_author_meta('user_url');

								$author_url = preg_replace('#^https?://#', '', rtrim($author_url,'/'));

								if (!empty($author_url)) : ?>

									<a class="upper author-link-website" title="<?php esc_html_e('Author website','education-park'); ?>" href="<?php echo esc_url( get_the_author_meta('user_url') ); ?>"><i class="fa fa-globe"></i> <?php esc_html_e('Author website','education-park'); ?></a>

								<?php endif;

								$author_mail = get_the_author_meta('email');

								$show_mail = get_the_author_meta('showemail');

								if ( !empty($author_mail) && ($show_mail == "yes") ) : ?>

									<a class="upper author-link-mail" title="<?php echo esc_attr($author_mail); ?>" href="mailto:<?php echo esc_url(antispambot($author_mail)); ?>"><?php echo esc_html($author_mail); ?></a>

								<?php endif; ?>
					</div>
					<!-- Author-links -->

				</div>
				<!-- Author Desc -->
			</div>
			<!-- Post Author -->
		<?php }

		//RELATED POSTS
	
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function education_park_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'education_park_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'education_park_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so education_park_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so education_park_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in education_park_categorized_blog.
 */
function education_park_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'education_park_categories' );
}
add_action( 'edit_category', 'education_park_category_transient_flusher' );
add_action( 'save_post', 'education_park_category_transient_flusher' );


if( !function_exists( 'education_park_post_thumbnail' ) ) :
	/***
	* Display post thumbnail
	*
	* Warp post thumbnail in index view in an anchor element, or a div element
	* on a single view
	*
	*/
	function education_park_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}
		if( is_singular() ) :
			?>
				<div class="featured-image">
						<?php the_post_thumbnail( 'post-thumbnail' ); ?>
				</div>
			<?php else : ?>
				<?php if ( has_post_thumbnail() ) :?>
					<div class="featured-image archive-thumb">
						<a title="<?php the_title(); ?>" href="<?php echo esc_url( get_permalink() ); ?>" class="post-thumbnail">
							<?php the_post_thumbnail( 'custom_post_size' ); ?>
							<div class="share-mask">
					        	<div class="share-wrap">

					        	</div>
					      	</div>
						</a>
					</div>
				<?php endif; ?>
			<?php
		endif;
	}
endif;


if ( !function_exists( 'education_park_post_content' ) ) :
	/*
	* Displays the post content on single page or
	* excerpt on index page
	*
	*
	*/
	
	function education_park_post_content() {
		if ( !get_the_content() ) {
			return;
		}
		if ( is_singular() || is_page() ) :
			the_content();
			else :
				if ( has_post_format( array( 'video', 'audio' ) ) ) :
					the_content();
					else :
						the_excerpt();
				endif;
		endif;
	}
endif;