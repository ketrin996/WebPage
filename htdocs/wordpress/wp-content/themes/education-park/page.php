<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Education Park
 */

get_header();
// Boxed or Fullwidth
$boxedornot = education_park_boxedornot();

$sidebar_layout = get_theme_mod('layout_picker');
$content_class = "";
$sidebar_class = education_park_check_sidebar();
if ($sidebar_class == 'pull-left'):
    $content_class = 'pull-right';
elseif ($sidebar_class == 'pull-right'):
    $content_class = 'pull-left';
elseif ($sidebar_class == 'no-sidebar'):
    $content_class = 'no-sidebar';
endif;

?>

<?php education_park_breadcrumb(); ?>
    <!-- End the breadcrumb -->

<?php if ($boxedornot == 'fullwidth') { ?>
    <!-- Start the container. If full width layout is selected in the Customizer.-->
    <div class="container full-width-container">
<?php } ?>

    <div id="primary" class="content-area <?php echo esc_attr($content_class); ?>">

        <main id="main" class="site-main" role="main">

            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    if (has_post_thumbnail()) {
                        // check if the post has a Post Thumbnail assigned to it.
                        ?>
                        <div class="featured-image">
                            <div class="media-wrap ">
                                <?php the_post_thumbnail(); ?>
                            </div>
                        </div>

                    <?php }

                    get_template_part('template-parts/content', 'page');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;

                endwhile;

            endif; ?>

        </main>
        <!-- End the #main -->
    </div>
    <!-- End the #primary -->

<?php if ($sidebar_class != 'no-sidebar'): ?>
    <div id="secondary" class="widget-area clearfix <?php echo esc_attr($sidebar_class); ?>" role="complementary">
        <?php if (is_active_sidebar('sidebar-1')) {
            dynamic_sidebar('sidebar-1');
        } ?>
    </div>
<?php endif; ?>
<?php if ($boxedornot == 'fullwidth') { ?>
    </div>
    <!-- End the container -->
<?php } ?>
<?php get_footer(); ?>