<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'About Coat and Tails';

$target_mode = '';
include_once(dirname(__FILE__) . '/defChecks.php');


closeConnections();

commonHeaders();
?><html lang="en">
<head>
    <?php echo commonMetaHeader();?>
</head>

<body class="f photo_draw">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/about_banner.png" alt="about coat and tails" class="sub-header-banner-img">
			</div>
		</div>
		
	</div>
<div class="container w-bg center">
  
  <div class="bodytext">
    <div class="aspect-ratio"><iframe id="about-video" width="100%" height="315" src="https://www.youtube.com/embed/XBKsYZceIz8?rel=0&modestbranding=1" frameborder="0" allowfullscreen></iframe></div>
	<h2>WTF is Coat and Tails?</h2>
	<p class="about-c_t">
		Coat and Tails is me, Bryce Dishongh. I live in Austin, Texas with my dog Bess. This is my website, and everything on it was created by me. 
		Coat and Tails exists because I wanted a way for people 
		to express contextual information about their pets figuratively: 
		the clothes and accessories are symbols showing particular behaviors, backgrounds, and dispositions, not only of the pet, but also of the owner. 
		For instance, if you have a particularly Southern dog, 
		then you can get a portrait of your dog wearing a Southern Belle costume. But portraits can also be ironic: if you have an unruly cat, 
		then you could get a portrait of the cat wearing a tuxedo. Ultimately, I want each portrait to show the pet's <i>story</i>, both for you and for other viewers.
	</p>
	<p class="about-c_t">
		Another reason I draw pets wearing clothes that most of our pets are caught in this weird limbo between human and non-human worlds. As a result, we don’t often know how to view them, especially when 
		non-pet people enter our lives and wonder why we sometimes prioritize pets over them. Drawing dogs and other domesticated animals in clothes reflects this weird 
		position and in so doing embraces it. Getting a portrait of a pet wearing formal clothing is also a big and over-the-top sign of how a lot of us feel about our pets: 
		they’re family members that play important roles.
	</p>	
	
  </div> 
   
 <?php echo commonFoot();?>
	

	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
</body>
</html>