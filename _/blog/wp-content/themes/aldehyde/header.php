<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Aldehyde
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="http://fonts.googleapis.com/css?family=IM+Fell+English" rel="stylesheet" type="text/css">
<link rel="icon" href="https://s3.amazonaws.com/coatandtails/img/favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="https://s3.amazonaws.com/coatandtails/img/favicon.ico" type="image/x-icon">
<meta http-equiv="X-Frame-Options" content="DENY"><link href="http://www.coatandtails.com/index.php" rel="canonical">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="parallax-bg"></div>
<div id="page" class="hfeed site">
	<?php do_action( 'aldehyde_before' ); ?>
	
	  
	<header class="site-header row" role="banner">
		<div class="site-branding">
		<?php if((of_get_option('logo', true) != "") && (of_get_option('logo', true) != 1) ) { ?>
			<h1 class="logo-container"><a href="http://www.coatandtails.com" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<?php
			echo "<img class='main_logo' src='https://s3.amazonaws.com/coatandtails/img/logo.png' title='".esc_attr(get_bloginfo( 'name','display' ) )."'></a></h1>";	
			}
		else { ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1> 
		<?php	
		}
		?>
		
		</div>
		<div class="toggle-button"></div>
		
	  <div class="default-nav-wrapper"> 	
	   <nav id="site-navigation" class="main-navigation" role="navigation">
         <div id="nav-container">
			
			<div class="screen-reader-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'aldehyde' ); ?>"><?php _e( 'Skip to content', 'aldehyde' ); ?></a></div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
          </div>
		</nav><!-- #site-navigation -->
	  
		  
	    </div>
	    <div class="mobile-nav">
	    	<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	    </div>
	    <div id="social-icons">
		  	    <a href="http://www.coatandtails.com/cart.php" id="cart-link"><img src="https://s3.amazonaws.com/coatandtails/img/cart-icon.png"></a>
			    <span class="divider"></span>
			    <?php if ( of_get_option('facebook', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('facebook', true)); ?>" title="Facebook" ><img src="https://s3.amazonaws.com/coatandtails/img/facebook.png"></a>
	             <?php } ?>
	             <?php if ( of_get_option('tumblr', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('tumblr', true)); ?>" title="Tumblr" ><img src="https://s3.amazonaws.com/coatandtails/img/tumblr.png"></a>
	             <?php } ?>
	             <?php if ( of_get_option('instagram', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('instagram', true)); ?>" title="Instagram" ><img src="https://s3.amazonaws.com/coatandtails/img/ig.png"></a>
	             <?php } ?>
	            <?php if ( of_get_option('twitter', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url("http://twitter.com/".of_get_option('twitter', true)); ?>" title="Twitter" ><img src="https://s3.amazonaws.com/coatandtails/img/twitter.png"></a>
	             <?php } ?>
	             <?php if ( of_get_option('google', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('google', true)); ?>" title="Google Plus" ><i class="social-icon icon-google-plus-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('feedburner', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('feedburner', true)); ?>" title="RSS Feeds" ><i class="social-icon icon-rss-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('pinterest', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('pinterest', true)); ?>" title="Pinterest" ><i class="social-icon icon-pinterest-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('linkedin', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('linkedin', true)); ?>" title="LinkedIn" ><i class="social-icon icon-linkedin-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('youtube', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('youtube', true)); ?>" title="YouTube" ><i class="social-icon icon-youtube-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('flickr', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('flickr', true)); ?>" title="Flickr" ><i class="social-icon icon-flickr"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('dribble', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('dribble', true)); ?>" title="Dribbble" ><i class="social-icon icon-dribbble"></i></a>
	             <?php } ?> 
		    </div>
	</header><!-- #masthead -->

	
	<?php
	if ( (function_exists( 'of_get_option' )) && (of_get_option('slidetitle5',true) !=1) ) {
	if ( ( of_get_option('slider_enabled') != 0 ) && (is_home())  )  
		{ ?>
	<div class="slider-wrapper theme-default container"> 
    	<div class="ribbon"></div>    
    		<div id="slider" class="nivoSlider">
    			<?php
		  		$slider_flag = false;
		  		for ($i=1;$i<6;$i++) {
		  			$caption = ((of_get_option('slidetitle'.$i, true)=="")?"":"#caption_".$i);
					if ( of_get_option('slide'.$i, true) != "" ) {
						echo "<a href='".of_get_option('slideurl'.$i, true)."'><img src='".of_get_option('slide'.$i, true)."' title='".$caption."'></a>"; 
						$slider_flag = true;
					}
				}
				?>  
    		</div><!--#slider-->
    		<?php for ($i=1;$i<6;$i++) {
    				$caption = ((of_get_option('slidetitle'.$i, true)=="")?"":"#caption_".$i);
    				if ($caption != "")
    				{
	    				echo "<div id='caption_".$i."' class='nivo-html-caption'>";
	    				echo "<a href='".of_get_option('slideurl'.$i, true)."'><div class='slide-title'>".of_get_option('slidetitle'.$i, true)."</div></a>";
	    				echo "<div class='slide-description'>".of_get_option('slidedesc'.$i, true)."</div>";
	    				echo "</div>";
    				}
    			}	
    	    
			?>
    </div>	
	<?php 
			}
		}
		?>
		<div id="content" class="site-content row">
			<div class="gray-area"></div>
		<div class="container col-md-12"> 
