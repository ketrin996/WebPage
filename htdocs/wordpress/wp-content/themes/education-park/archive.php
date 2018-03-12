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

$content_class = "";
$sidebar_class = education_park_check_sidebar();
if($sidebar_class == 'pull-left'):
    $content_class = 'pull-right';
elseif($sidebar_class == 'pull-right'):
    $content_class = 'pull-left';
elseif($sidebar_class == 'no-sidebar'):
    $content_class = 'no-sidebar';
endif;

?>

	<?php education_park_breadcrumb(); ?>
	<!-- End the breadcrumb -->

	<?php if ($boxedornot == 'fullwidth') {?>
		<!-- Start the container. If full width layout is selected in the Customizer.-->
        <div class="container full-width-container">
    <?php }?>

	<?php if ($boxedornot == 'fullwidth') {?>
		<!-- Start the container -->
        <div class="container full-width-container">
    <?php }?>
	<div id="primary" class="content-area <?php echo esc_attr($content_class);?>">

		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header>
			<!-- End the .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content clearfix">
						<?php
							get_template_part( 'template-parts/content', get_post_format($post->ID) );
						?>
					</div>

					<footer class="entry-footer clearfix">
				        <?php education_park_entry_footer(); ?>
				    </footer>
				    <!-- End Entry Footer -->

				</article>

			<?php endwhile; ?>

				<!-- Navigation -->
				<nav class="navigation posts-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation','education-park' ); ?></h2>
			<div class="nav-links clearfix">
				<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous">
					<?php next_posts_link( __( 'Older posts <i class="fa fa-long-arrow-left post-arrow"></i>','education-park' ) ); ?>
				</div>
				<?php else :  ?>
					<div class="nav-previous disabled">
						<a href="#">
							<i class="fa fa-long-arrow-left post-arrow"></i><?php esc_html_e( 'No Older posts','education-park' ); ?>
						</a>
					</div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link() ) : ?>
				<div class="nav-next">
					<?php previous_posts_link( __( 'Newer posts <i class="fa fa-long-arrow-right post-arrow"></i> ','education-park' ) ); ?></div>
				<?php else :  ?>
					<div class="nav-next disabled">
					<a href="#"> <i class="fa fa-long-arrow-right post-arrow"></i><?php esc_html_e( 'No Newer post','education-park' ); ?></a></div>
				<?php endif; ?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main>
		<!-- End the #main -->
		</div>
	<!-- End the #primary -->

	<?php if($sidebar_class != 'no-sidebar'):?>


        <div id="secondary" class="widget-area clearfix <?php echo esc_attr($sidebar_class);?>" role="complementary">
            <?php if (is_active_sidebar('sidebar-1')) {
                dynamic_sidebar('sidebar-1');
            } ?>
        </div>

<?php endif; ?>

	<?php if ($boxedornot == 'fullwidth') {?>
        </div>
		<!-- End the container.-->
    <?php }?>

<?php get_footer();