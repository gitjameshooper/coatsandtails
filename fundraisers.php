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
    <div style="display:block;">
        <h3>Current Fundraiser: Austin Dog Rescue</h3>
            <p>From March 16th until May 15th, $10 of every tee shirt in my shop will go to <a href="http://www.austindog.org/" target="blank">Austin Dog Rescue</a>.</p>
            <p>Get yours <a href="http://www.coatandtails.com/merchandise.php?c=1">here</a>.
    </div>


    <h3>Do you rep a rescue group? Wanna work together?</h3>
        <p>First, I love the work rescue groups do. They have such a huge impact on so many human and animal lives. And I want Coat &amp; Tails to be a part of that.</p>
        <p>So I would like to try to help in a significant way. That’s primarily why I make and sell the shirts: to help raise money for rescue groups. I typically give $10 per shirt sold to the groups I work with. Collectively I've helped rescue groups raise thousands of dollars. And all they had to do was promote the campaign.</p>
        <p>If you’re interested in a fundraiser with Coat &amp; Tails, email bryce@coatandtails.com</p>     
  </div> 

 
</div>
 <?php echo commonFoot();?>
	

	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
</body>
</html>