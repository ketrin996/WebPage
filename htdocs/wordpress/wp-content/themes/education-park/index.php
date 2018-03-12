<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Education Park
 */

get_header();
// Boxed or Fullwidth
$boxedornot = education_park_boxedornot();

$sidebar_layout = get_theme_mod('layout_picker');

$sidebar_class = education_park_check_sidebar();
if ($sidebar_class == 'pull-left'):
    $content_class = 'pull-right';
elseif ($sidebar_class == 'pull-right'):
    $content_class = 'pull-left';
elseif ($sidebar_class == 'no-sidebar'):
    $content_class = 'no-sidebar';
endif;
?>

<?php if ($boxedornot == 'fullwidth') { ?>
    <!-- Start the container. If full width layout is selected in the Customizer.-->
    <div class="container full-width-container">
<?php } ?>


<?php if (!empty($sidebar_layout)){ ?>
    <div id="primary" class="content-area <?php echo esc_attr($content_class); ?>">
    <?php } else { ?>
    <div id="primary" class="content-area">
<?php } ?>
    <main id="main" class="site-main hello" role="main">

        <?php if (have_posts()) : ?>

            <?php if (is_home() && is_front_page()) { ?>
                <header class="page-header">
                    <?php echo sprintf(esc_html__('%1$s Latest Posts %2$s', 'education-park'), '<h1 class="page-title">', '</h1>'); ?>
                </header>
            <?php } ?>
            <!-- .page-header -->

            <?php /* Start the Loop */
            while (have_posts()) : the_post();

                /* Include the Post-Format-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                get_template_part('template-parts/content', get_post_format());
            endwhile; ?>

            <!-- Navigation -->

            <nav class="navigation posts-navigation" role="navigation">
                <div class="nav-links clearfix">
                    <?php if (get_next_posts_link()) : ?>
                        <div class="nav-previous">
                            <?php next_posts_link(__('<i class="fa fa-long-arrow-left post-arrow"></i>Older posts', 'education-park')); ?>
                        </div>
                    <?php else : ?>
                        <div class="nav-previous disabled">
                            <a href="#">
                                <i class="fa fa-long-arrow-left post-arrow"></i><?php esc_html_e('No Older posts', 'education-park'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <?php if (get_previous_posts_link()) : ?>
                        <div class="nav-next">
                            <?php previous_posts_link(__('Newer posts <i class="fa fa-long-arrow-right post-arrow"></i> ', 'education-park')); ?></div>
                    <?php else : ?>
                        <div class="nav-next disabled">
                            <a href="#"> <i
                                        class="fa fa-long-arrow-right post-arrow"></i><?php esc_html_e('No Newer post', 'education-park'); ?>
                            </a></div>
                    <?php endif; ?>
                </div><!-- .nav-links -->
            </nav><!-- .navigation -->


            <?php
        else :
            get_template_part('template-parts/content', 'none');

        endif;
        ?>

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
    <!-- End the Sidebar -->

<?php if ($boxedornot == 'fullwidth') { ?>
    </div>
    <!-- End the container -->
<?php } ?>

<?php get_footer(); ?>