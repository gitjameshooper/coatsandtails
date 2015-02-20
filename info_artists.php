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
			<p class="title-caption">This section contains information about how artists can sell their own work on my site.</p>
		</div>
	</div>
<div class="container w-bg center">
  
  <div class="style_examples" style="text-align:left;">
    <h3>Information for Artists</h3>
    <p>If you’re an artist, and want to get paid to draw pets wearing clothes, you’ve stumbled across the right rabbit hole. I’m looking for artists who can digitally paint high-quality clothes and accessories to post for sale on this site. Here’s how it would work:</p>
<h4>Option 1:</h4>
<p>You paint clothes and accessories, and I upload them onto the site. When someone orders what you created, you get paid. </p>
<h4>Option 2:</h4>
<p>You paint clothes and accessories, and I buy them and the exclusive rights to them from you.</p>
<p>Pretty simple, right? So if interested, email bryce@coatandtails.com with a link to your work.</p>    
</div>
</div>
 <?php echo commonFoot();?>
	

	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.html');?>
</body>
</html>