<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Education Park
 */

get_header();
// Boxed or Fullwidth
$boxedornot = education_park_boxedornot();
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
    <!-- End the Breadcrumb -->

<?php if ($boxedornot == 'fullwidth') { ?>
    <!-- Start the container. If full width layout is selected in the Customizer.-->
    <div class="container full-width-container">
<?php } ?>

    <div id="primary" class="content-area <?php echo esc_attr($content_class); ?>">

        <main id="main" class="site-main" role="main">

            <section class="error-404 not-found">

                <div class="no-image-fall image-404">
                    <span><?php esc_html_e('404 Error. This page can&rsquo;t be found.', 'education-park'); ?></span>
                </div>

                <div class="page-content">

                    <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try to search it below?', 'education-park'); ?></p>

                    <section class="searchpage-form">
                        <div class="page-content">
                            <?php get_search_form(); ?>
                        </div>
                        <!-- End the .page-content -->
                    </section>
                    <!-- End .no-results -->
                </div>
                <!-- End the .page-content -->

            </section>
            <!-- End the .error-404 -->

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