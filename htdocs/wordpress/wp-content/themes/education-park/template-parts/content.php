<?php
/**
 * The template for displaying Stardard post formats
 *
 * @package Education Park
 */
?>
<?php
global $post;
$post_format = get_post_format($post->ID);
$featured_image = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
$class = '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
    <div class="post-content entry-content">

    <?php
    if(is_archive() || is_home()):
        education_park_blog_post_format($post_format, $post->ID);
    endif;
    ?>
    <header class="entry-header">
        <?php
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;

        if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <?php education_park_posted_on(); ?>
            </div><!-- .entry-meta -->
            <?php
        endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php

        if(is_archive() || is_home()):

            echo wp_kses_post(education_park_strip_url_content($post->ID,400));
        else:
            the_content( sprintf(
                wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'education-park' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ) );
        endif;
        wp_link_pages( array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'education-park' ),
            'after'  => '</div>',
        ) );

        ?>
    </div><!-- .entry-content -->
    <?php
    if(is_archive() || is_home()):
        echo '<a class="read-more btn btn-default" href="'.esc_url(get_the_permalink()).'">'.esc_html__( 'Read More', 'education-park' ).'</a> ';
    endif;
    ?>
    </div>
    <?php if(is_single()): ?>
        <footer class="entry-footer">
            <?php education_park_entry_footer(); ?>
        </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
