<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Fundraiser Information';

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
  
<div class="style_examples">  
  <div style="text-align:left;display:none;">
  	<h3>There is no fundraiser right now</h3>
  	<p>The next one will be with Austin Bully Butt Rescue on May 1st 2015. Details to come!</p>
  </div>
    <div style="display:block;text-align:left;padding: 10px;">
        <h3>Current Fundraiser: Don't Bully Me Rescue</h3>
            <p>Throughout the month of June, $10 of <a href="/merchandise.php?c=8">these shirts</a> will go to Don't Bully Me Rescue.</p>
                
                <img style="text-align:center;" src="<?php echo $CDN_IMGS;?>img/merch/tees/pitbull_adoptshop_women.jpg">
                <p></p>
            <p>Participate by getting yours <a href="/merchandise.php?c=8">here</a>.</p>
    </div>

<div style="display:block;text-align:left;">
    <h3>Do you rep a rescue group? Wanna work together?</h3>
        <p>First, I love the work rescue groups do. They have such a huge impact on so many human and animal lives. And I want Coat &amp; Tails to be a part of that.</p>
        <p>So I would like to try to help in a significant way. That’s primarily why I make and sell the shirts: to help raise money for rescue groups. I typically give $10 per shirt sold to the groups I work with. Collectively I've helped rescue groups raise thousands of dollars. And all they had to do was promote the campaign.</p>
        <p>If you’re interested in a fundraiser with Coat &amp; Tails, email bryce@coatandtails.com</p>    
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
</div>
 <?php echo commonFoot();?>
	

	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
</body>
</html>