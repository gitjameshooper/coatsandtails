<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script type="text/javascript">
(function(d){
    var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
    p.type = 'text/javascript';
    p.async = true;
    p.src = '//assets.pinterest.com/js/pinit.js';
    f.parentNode.insertBefore(p, f);
}(document));
</script>
<div class="navbar main-navbar" role="navigation">
    <div class="container-fluid">
    	<div class="navbar-header">
			<button type="button" class="navbar-toggle">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo $BASE_URL;?>">
				<img src="<?php echo $CDN_IMGS;?>img/logo.png" alt="<?php echo $SITE_NAME;?>">
			</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav main">
				<?php
				if($mens_collections_count > 0){
					?>
					<li>
						<a href="<?php echo $BASE_URL;?>collections.php?g=0" class="dropdown-toggle">Men</a>
						<ul class="dropdown-menu grouped" role="menu">
							<li role="presentation" class="dropdown-header">Choose a Collection.</li>
							<li role="presentation" style="font-size:20px;"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>collections.php?g=0">View All Collections</a></li>
							<li role="presentation" style="font-size:20px;"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>gallery.php">View Gallery</a></li>
							<?php
							$i = 0;
							for($i;$i<$mens_collections_count;$i++){
								echo '<li role="presentation">'
										. '<a role="menuitem" tabindex="-1" href="' . $BASE_URL . 'clothes.php?id=' . $mens_collections[$i]['clothes_id'] . '" data-img="' . $BASE_URL . 'img/clothes/' . $mens_collections[$i]['clothes_id'] . '/cover.png">'
											. $mens_collections[$i]['clothes_title']
										. '</a>'
									. '</li>';
							}
							?>
							 
								<div class="cover-banner">
									<img src="">
								</div>
							 
						</ul>
						 
					</li>
					<?php
				}
				if($womens_collections_count > 0){
					?>
					<li>
						<a href="<?php echo $BASE_URL;?>collections.php?g=1" class="dropdown-toggle">Women</a>
						<ul class="dropdown-menu grouped" role="menu">
							<li role="presentation" class="dropdown-header">Choose a Collection.</li>
							<li role="presentation" style="font-size:20px;"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>collections.php?g=1">View All Collections</a></li>
							<li role="presentation" style="font-size:20px;"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>gallery.php">View Gallery</a></li>
							<?php
							$i = 0;
							for($i;$i<$womens_collections_count;$i++){
								echo '<li role="presentation">'
										. '<a role="menuitem" tabindex="-1" href="' . $BASE_URL . 'clothes.php?id=' . $womens_collections[$i]['clothes_id'] . '" data-img="' . $BASE_URL . 'img/clothes/' . $womens_collections[$i]['clothes_id'] . '/cover.png">'
											. $womens_collections[$i]['clothes_title']
										. '</a>'
									. '</li>';
							}
							?>
							 
								<div class="cover-banner">
									<img src="">
								</div>
							 
						</ul>
						 
					</li>
					<?php
				}
				?>
				<li>
					<a href="<?php echo $BASE_URL;?>merchandise.php" class="dropdown-toggle">Merchandise</a>
					<ul class="dropdown-menu" role="menu">
						<li role="presentation" class="dropdown-header">Oh and I also make shirts and stuff</li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>merchandise.php">View all Merchandise</a></li>
						<?php
						$i = 0;
						for($i;$i<$merchandise_count;$i++){
							echo '<li role="presentation">'
									. '<a role="menuitem" tabindex="-1" href="' . $BASE_URL . 'merchandise.php?c=' . $merchandise[$i]['category_id'] . '">' . $merchandise[$i]['category_title'] . '</a>'
								. '</li>';
						}
						?>
					</ul>
					 
				</li>
				<li>
					<a href="<?php echo $BASE_URL;?>about.php" class="dropdown-toggle">Info</a>
					<ul class="dropdown-menu" role="menu">
	                 <li role="presentation" class="dropdown-header">What's up?</li>
    					<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);" id="contact_link">Contact</a></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>about.php">About Coat &amp; Tails</a></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>faq.php">FAQ</a></li>
						<li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>pricing.php">Pricing</a></li>
					</ul>
					 
				</li>
				<li>
					<a href="<?php echo $BASE_URL;?>#" class="dropdown-toggle">Fun</a>
					
                    <ul class="dropdown-menu" role="menu">
                    <li role="presentation" class="dropdown-header">Let's get weird.</li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>quiz.php">Personality Test</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>fundraisers.php">Philanthropomorphize</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $BASE_URL;?>wall.php">Wall of Fame & Shame</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="http://blog.coatandtails.com/">Blog</a></li>
					</ul>
					 
				</li>
			</ul>
			<div id="social-icons" class="navbar-right">
				 
					<a id="cart-link" href="<?php echo $BASE_URL;?>cart.php" id="cart_link">
						<img src="<?php echo $CDN_IMGS;?>img/cart-icon.png">
					</a>
				 
				<span class="divider"></span>
				 
					<a href="http://www.facebook.com/pages/Coat-and-Tails-Pet-Portraits/128628673951387" class="social_icon" target="_blank"><img src="<?php echo $CDN_IMGS;?>img/facebook.png"></a>
					<a href="http://blog.coatandtails.com" class="social_icon" target="_self"><img src="<?php echo $CDN_IMGS;?>img/tumblr.png"></a>
					<a href="http://instagram.com/coatandtails/" class="social_icon" target="_blank"><img src="<?php echo $CDN_IMGS;?>img/ig.png"></a>
					<a href="https://twitter.com/coatandtails" class="social_icon" target="_blank"><img src="<?php echo $CDN_IMGS;?>img/twitter.png"></a>
				 
			</div>
		</div>
	</div>
</div>
<div class="gray-area"></div>