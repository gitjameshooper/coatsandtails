<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Aldehyde
 */
?>
	</div>
	</div><!-- #content -->

	<footer id="colophon" class="site-footer row" role="contentinfo">
	<div id="footer-container" class="container">
		<hr class="footer" />
	 <?php wp_nav_menu( array( 'menu' =>  'footerMenu' ) ); ?>
	 <hr class="footer" />
	 <p class="copyright" style="text-align:center;color: #666666;font-size:14px;">Copyright © 2015 Bryce Dishongh. All rights reserved.</p>
	</div>   
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<?php		
	if ( (function_exists( 'of_get_option' ) && (of_get_option('footercode1', true) != 1) ) ) {
			 	echo of_get_option('footercode1', true); } ?>
<?php wp_footer(); ?>
</body>
</html>