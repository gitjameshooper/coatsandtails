<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Contest Rules';

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
				<img src="<?php echo $CDN_IMGS;?>img/contest_banner.png" alt="wall of fame" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">Below are contest rules.</p>
		</div>
	</div>
<div class="container w-bg center">
  
  <div class="style_examples">
    <h1>Want your pittie's face to be printed on hundreds of shirts?</h1>
    <p>Then enter this contest...</p>
    <p>I'm designing tee shirts for an upcoming fundraiser with Love-a-Bull, and I need you to help me figure out what pit bull type dogs I should incorporate into the designs. I have two designs so far. Here's the first design:</p>
    <img class="wall" src="<?php echo $CDN_IMGS;?>img/contest1.jpg" style=border="0" />
    <p style="padding-top:15px;">...and here's the second design:</p>
    <img class="wall" src="<?php echo $CDN_IMGS;?>img/contest2.jpg"  border="0" />
    <p>So I'm having a contest to determine what pit bull's face should be drawn in the middle. </p>
    <h2>Contest Rules</h2>
    <ul>
    	<li>Like the <a class="footer-links" href="https://www.facebook.com/pages/Coat-and-Tails-Pet-Portraits/128628673951387" title="Facebook" target="blank">Coat and Tails Facebook Page</a> and the <a class="footer-links" href="https://www.facebook.com/LoveABullAustin" title="Facebook" target="blank">Love-a-Bull Facebook page</a>.</li>
    	<li>Email the best photo of your pittie with his/her name to bryce@coatandtails.com with the subject “Tee Shirt Contest.” Note: Limit submissions to one photo.</li>
		<li>The photos will be posted to a Facebook album on the Coat and Tails page on January 9th, 2015.</li>
		<li>Once you see your photo, tag yourself, like it, and share it. If your photo gets the most likes, and we agree that it is usable, your dog will be the model for all of the shirts. Each winner will also receive a free shirt.</li>
		<li>All entries must be received by 12:00 AM CST on January 9th.</li>
		<li>Voting ends at 12:00 AM CST on January 12th.</li>
	</ul>
    
   </div> 
   </div> 
 <?php echo commonFoot();?>
	

	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.html');?>
</body>
</html>