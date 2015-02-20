<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Quiz Result';

$status_options = array('Active', 'Hidden', 'Sold Out', 'Coming Soon');

include_once(dirname(__FILE__) . '/defChecks.php');

if(isset($_SESSION['quiz']) && isset($_SESSION['quiz_collection'])){
	$_SESSION['target_collection'] = $_SESSION['quiz_collection'];
	$clothes_query = $DB->query("SELECT * FROM clothes WHERE clothes_id='" . $_SESSION['quiz_collection'] . "' LIMIT 1");
	if(!isset($clothes_query[0])){
		closeConnections();
		header("Location:" . $BASE_URL . "collections.php");
		exit();
	}else{
		$clothes_title = $clothes_query[0]['clothes_title'];
		$clothes_desc = $clothes_query[0]['clothes_desc'];
		$clothes_img = $_SESSION['quiz'] . '.jpg';
	}
}else{
  closeConnections();
  header("Location:" . $BASE_URL . "quiz.php");
  exit();
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="f quiz_res">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
    			<img src="<?php echo $CDN_IMGS;?>img/quiz_banner.png" alt="Personality Quiz" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">This section presents a highly scientifical analysis of this pet's personality.</p>
		</div>
	</div>

	<div class="container w-bg center">
		<div class="row">
			<div class="col-sm-9 col-sm-offset-2">
				<h2>This pet is <?php echo $clothes_title;?>!</h2>
				<div class="title-sub-header">...so this is the outfit I'd recommend.</div>
			</div>
			<div class="col-sm-9 col-sm-offset-2">
				<div class="row">
					<div class="col-sm-8">
						<img class="res-img" src="<?php echo $CDN_IMGS;?>img/quiz/<?php echo $_SESSION['quiz'];?>.jpg">
					</div>
					<div class="col-sm-4">
						<a href="<?php echo $BASE_URL;?>photo_draw.php" class="btn btn-lg btn-inverted btn-shadow btn-block">Order this Portrait</a>
						<div class="link-desc">Click here to have me draw your pet wearing this outfit.</div>

						<div style="text-align:left;" class="visible-xs clothe-desc"><?php echo stripslashes($clothes_query[0]['clothes_desc']);?></div>
						<hr>
						<h2>
							<img src="<?php echo $CDN_IMGS;?>img/share_quiz_results.png" alt="Share your results">
						</h2>
						<a href="javascript:void(0);" id="share_facebook" class="btn btn-block sharing-option" style="font-size: 16px;"><img src="<?php echo $BASE_URL;?>img/facebook.png">Facebook</a>
						<a href="javascript:void(0);" id="share_twitter" class="btn btn-block sharing-option" style="font-size: 16px;"><img src="<?php echo $BASE_URL;?>img/twitter.png">Twitter</a>
					</div>
				</div>

</div>
            
			<div class="col-sm-9 col-sm-offset-2 hidden-xs">
            
				<div class="clothe-desc"><?php echo stripslashes($clothes_query[0]['clothes_desc']);?>
                <h2>What other celebrities should I include here? (Include the type, plz, since this box is applicable to all results.)</h2>
                <div class="fb-comments" data-href="http://www.coatandtails.com/v2/quiz_result.php" data-width="800" data-numposts="50" data-colorscheme="light"></div></div>
                
			</div>
            
		</div>

</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	window.target_quiz=<?php echo json_encode($_SESSION['quiz']);?>;
	</script>
    
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=249573578387236&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>