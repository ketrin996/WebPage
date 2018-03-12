<?php
/**
 * The template for displaying search results pages.
 *
 * @package Education Park
 */

get_header();
// Boxed or Fullwidth
$boxedornot = education_park_boxedornot();

$sidebar_layout = get_theme_mod('layout_picker');

$sidebar_class = education_park_check_sidebar();
?>

	<?php education_park_breadcrumb(); ?>
	<!-- End the breadcrumb -->

	<?php if ($boxedornot == 'fullwidth') {?>
		<!-- Start the container. If full width layout is selected in the Customizer.-->
        <div class="container full-width-container">
    <?php }?>

	    <?php if(!empty($sidebar_layout)){ ?>
	    <div id="primary" class="content-area <?php echo esc_attr($sidebar_class); ?>">
	    	<?php } else {?>
	    	<div id="primary" class="content-area">
	    		<?php } ?>

			<main id="main" class="site-main search-main" role="main">

				<?php if ( have_posts() ) : ?>

					<header class="page-header">
						<h3 class="page-title">
							<?php printf( esc_html__( 'Search Results for: %s','education-park' ), '<span> ' . get_search_query() . ' </span>' ); ?>
						</h3>
					</header>
					<!-- End the .page-header -->

					<section class="searchpage-form">
						<div class="page-content">
							<?php get_search_form(); ?>
						</div>
						<!-- End the .page-content -->
					</section>
					<!-- End .no-results -->

					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>

						<?php
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );
						?>

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

	<?php
		if(!empty($sidebar_layout)){
			 if( ($sidebar_layout == 2) || ($sidebar_layout == 3)) {  ?>
				<?php if( $sidebar_layout == 2) { $sidebar = "left-sidebar";}  if( $sidebar_layout == 3) { $sidebar = "right-sidebar";} ?>
		   		 <div id="secondary" class="widget-area clearfix <?php echo esc_attr($sidebar); ?>" role="complementary">
					<?php get_sidebar();?>
				</div>
	<?php }  }  else{ ?>
		<div id="secondary" class="widget-area clearfix right-sidebar" role="complementary">
			<?php get_sidebar();?>
		</div>
	<?php } ?>
	<!-- End the Sidebar -->

	<?php if ($boxedornot == 'fullwidth') {?>
        </div>
		<!-- End the container -->
    <?php }?>

<?php get_footer(); ?>