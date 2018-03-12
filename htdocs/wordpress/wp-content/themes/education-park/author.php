<?php
/**
 * The template for displaying author pages.
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

	<?php  education_park_breadcrumb(); ?>
	<!-- End the breadcrumb -->

	<?php if ($boxedornot == 'fullwidth') {?>
		<!-- Start the container. If full width layout is selected in the Customizer.-->
        <div class="container full-width-container">
    <?php }?>

	<?php if ($boxedornot == 'fullwidth') {?>
		<!-- Start the container -->
        <div class="container full-width-container">
    <?php }?>
	<div id="primary" class="content-area <?php echo  esc_attr($content_class);?>">
		<main id="main" class="site-main author-page" role="main">

		<?php if ( have_posts() ) : ?>

			<div class="post-author">

				<div class="author-img text-center">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 60 );?>
				</div>

				<div class="author-desc">

					<h5><?php esc_html_e('Article By','education-park'); ?> <a href="<?php echo esc_url( get_author_posts_url(get_the_author_meta( 'ID' )) ); ?>"><?php the_author_meta('display_name'); ?></a></h5>
					<p><?php the_author_meta('description'); ?></p>

					<div class="author-links">
								<?php
									$author_id = get_the_author_meta('ID');
                                    $user_info = get_userdata($author_id);
                                    $author_url = $user_info->user_url;

								$author_url = preg_replace('#^https?://#', '', rtrim($author_url,'/'));

								if (!empty($author_url)) : ?>

									<a class="upper author-link-website" title="<?php esc_html_e('Author website','education-park'); ?>" href="<?php echo esc_url($author_url); ?>"><i class="fa fa-globe"></i> <?php esc_html_e('Author website','education-park'); ?></a>

								<?php endif;

								$author_mail = get_the_author_meta('email');

								$show_mail = get_the_author_meta('showemail');

								if ( !empty($author_mail) && ($show_mail == "yes") ) : ?>

									<a class="upper author-link-mail" title="<?php echo esc_attr($author_mail); ?>" href="mailto:<?php echo esc_attr(antispambot($author_mail)); ?>"><?php echo esc_html($author_mail); ?></a>

								<?php endif; ?>
					</div>
					<!-- Author-links -->

				</div>
				<!-- Author Desc -->
			</div>
			<!-- Post Author -->
			<!-- End the Post Author -->

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry-content">
						<?php
							get_template_part( 'template-parts/content', get_post_format() );
						?>
					</div>
				    <!-- End Entry-content -->

				    <footer class="entry-footer clearfix">
				        <?php education_park_entry_footer(); ?>
				    </footer>
				    <!-- End Entry Footer -->

				</article>
				<!-- End Article Post -->

			<?php endwhile; ?>

				<!-- Navigation -->
						
			<nav class="navigation posts-navigation" role="navigation">
			<div class="nav-links clearfix">
				<?php if ( get_next_posts_link() ) : ?>
				<div class="nav-previous">
					<?php next_posts_link( __( '<i class="fa fa-long-arrow-left post-arrow"></i>Older posts','education-park' ) ); ?>
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