<?php
/*
  Template Name: Full Width - No Container
 * This is the template that displays the contents in full Width
 *
 * @package Education Park
 */

get_header();
// Boxed or Fullwidth
$boxedornot = education_park_boxedornot();

education_park_breadcrumb(); ?>
		<!-- Start the container -->
        <div class="container full-width-container">
			<div class="content-area full-width-posts">
				<main id="main" class="site-main" role="main">

					 <?php
		                while ( have_posts() ) : the_post();

		                    the_content();

		                endwhile; // End of the loop.
		                ?>

				</main>
				<!-- End the #main -->
			</div>
			<!-- End the #primary -->
        </div>

<?php get_footer(); ?>