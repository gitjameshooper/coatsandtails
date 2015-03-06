<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Artist Application';

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
				<img src="<?php echo $CDN_IMGS;?>img/contest_banner.png" alt="fundraiser banner" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">This section contains information for rescue groups that want to work together to raise fundz.</p>
		</div>
	</div>
<div class="container w-bg center">
  
  <div class="style_examples" style="text-align:left;">
    <h3>Do you rep a rescue group? Wanna work together?</h3>
<p>First, I love the work rescue groups do. They have such a huge impact on so many human and animal lives. And I want Coat & Tails to be a part of that.</p>
<p>So I would like to try to help in a significant way. That’s primarily why I make and sell the shirts: to help raise money for rescue groups. I typically give $10 per shirt sold to the groups I work with. Collectively I've helped rescue groups raise thousands of dollars. And all they had to do was promote the campaign.</p>
<p>If you’re interested in a fundraiser with Coat & Tails, email bryce@coatandtails.com</p>  
 
  <div style="display:none;">
 <h3>Current Fundraiser: Love-a-Bull</h3>
    <p>I designed a bunch of tee shirts featuring pit bull type dogs for <a href="http://love-a-bull.org/" target="blank">Love-a-Bull</a>, whose mission is to <i>promote responsible guardianship and improve the image and lives of pit bull type dogs through education, advocacy, and rescue</i>. The shirts I designed try to create a more positive, gentle, and happy view of pit bulls. When you buy a shirt, $10 goes to this fantastic organization.</p>
    <p>Get yours <a href="http://www.coatandtails.com/merchandise.php?c=6">here</a>.
    <p>Below are the designs</p>
    <img class="wall" src="<?php echo $CDN_IMGS;?>img/merch/tees/rescue_women.jpg">
    <p>This shirt features Whitney, who is adoptable through Love-a-Bull. Available in both men's and women's styles.</p>
    <img class="wall" src="<?php echo $CDN_IMGS;?>img/merch/tees/heads_men.jpg">
    <p>This shirt features Tank, who won a Photo Contest I had on my Facebook page. Available in both men's and women's styles.</p>
    <img class="wall" src="<?php echo $CDN_IMGS;?>img/merch/tees/furever_women.jpg">
    <p>This shirt features Jade, who is also available through Love-a-Bull. Available in both men's and women's styles.</p>
    <img class="wall" src="<?php echo $CDN_IMGS;?>img/merch/tees/adopt_men.jpg">
    <p>This shirt features Porky, who won a Photo Contest I had on my Facebook page. Available in both men's and women's styles.</p>
    </div>
    
    
    
    
    
    <div style="display:none;">
    <p>You can send me a photo of your pit bull to be considered for inclusion into these designs.</p>
    <h2>Rulez</h2>
    <ol>
        <li>Like the <a class="footer-links" href="https://www.facebook.com/pages/Coat-and-Tails-Pet-Portraits/128628673951387" title="Facebook" target="blank">Coat and Tails Facebook Page</a> and the <a class="footer-links" href="https://www.facebook.com/LoveABullAustin" title="Facebook" target="blank">Love-a-Bull Facebook page</a>.</li>
    	<li>Email the best photo of your pittie with his/her name to bryce@coatandtails.com with the subject “Tee Shirt Contest.”<br /> <i><b>Note:</b> Limit submissions to one photo.</li></i>
		<li>Anxiously await January 9th, 2015, for that's when the photos will be posted to a Facebook album on the Coat and Tails page.</li>
		<li>Once you see your photo, tag yourself, like it, and share it. If your photo gets the most likes, and we agree that it is usable, your dog will be the model for all of the shirts. Each winner will also receive a free shirt.</li>
		<li>All entries must be received by 12:00 AM CST on January 9th.</li>
		<li>Voting ends at 12:00 AM CST on January 12th.</li>
	</ol>
   </div> 
   </div> 

</div>
</div>
 <?php echo commonFoot();?>
	

	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
</body>
</html>