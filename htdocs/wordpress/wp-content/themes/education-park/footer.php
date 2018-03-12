<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Education Park
 */
?>


<?php
$boxedornot = education_park_boxedornot();

?>


	</div><!-- #content -->
		<footer id="colophon" class="site-footer" role="contentinfo">

			<div class="footer-widget">
				<div class="container">
					<div class="row">

						<div class="col-md-4 col-sm-12 pad0 foot-bor">
							<?php
								if ( is_active_sidebar( 'footer-1' ) ) {
									dynamic_sidebar( 'footer-1' );
								}
								else{
									if(is_user_logged_in() && current_user_can('edit_theme_options') ){
										echo '<h6 class="text-center"><a href="'.esc_url(admin_url("customize.php")).'"><i class="fa fa-plus-circle"></i>'.esc_html__('Assign a Widget', 'education-park').'</a></h6>';
									}
								}
							?>
						</div>

						<div class="col-md-4 col-sm-12 pad0 foot-bor">
							<?php
								if ( is_active_sidebar( 'footer-2' ) ) {
									dynamic_sidebar( 'footer-2' );
								}
								else{
									if(is_user_logged_in()&& current_user_can('edit_theme_options') ){
										echo '<h6 class="text-center"><a href="'.esc_url(admin_url("customize.php")).'"><i class="fa fa-plus-circle"></i>'.esc_html__('Assign a Widget', 'education-park').'</a></h6>';
									}
								}
							?>
						</div>

						<div class="col-md-4 col-sm-12 pad0 foot-bor br0">
							<?php
								if ( is_active_sidebar( 'footer-3' ) ) {
									dynamic_sidebar( 'footer-3' );
								}
								else{
									if(is_user_logged_in()&& current_user_can('edit_theme_options')  ){
										echo '<h6 class="text-center"><a href="'.esc_url(admin_url("customize.php")).'"><i class="fa fa-plus-circle"></i>'.esc_html__('Assign a Widget', 'education-park').'</a></h6>';
									}
								}
							?>
						</div>
						<!-- End Footer Widget Columns -->

					</div>
				</div>

	        </div>
	        <!-- Footer Widgets -->

	        <div class="copyright clearfix">

	        	<?php if ($boxedornot == 'fullwidth') {?>
			    	<div class="container">
			    <?php }?>

			    <div class="container pad0">

				  	<div class="copyright-content">
				        <p class="text-right">
				        	<?php $copyright_link = esc_url('https://yudleethemes.com/'); ?>
				        		<?php esc_html_e('Theme by ', 'education-park');?>
		        				<a href="<?php echo esc_url($copyright_link); ?>" target="_blank">
		        					 <?php echo esc_html__( 'Yudlee Themes','education-park' ); ?>
		        				</a>
						</p>
				  	</div>

			  	</div>

			  	<?php if ($boxedornot == 'fullwidth') {?>
			    	</div>
			    <?php }?>

			</div>
			<!-- End the Copyright -->

		</footer>
	<!-- End the Footer -->
</div>
<!-- End the Page -->

<a href="#0" class="cp-top"><?php esc_html_e('Top', 'education-park');?></a>
<!-- End the scroll to top -->

<?php wp_footer(); ?>
</body>
</html>