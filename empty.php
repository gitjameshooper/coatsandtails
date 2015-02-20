<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Photograph or Draw Portrait';

$target_mode = '';
include_once(dirname(__FILE__) . '/defChecks.php');

if(isset($_SESSION['target_mode'])){
    $target_mode = $_SESSION['target_mode'];
}
if(isset($_GET['m'])){
	$target_mode = isSetAndNotDefault('', 'GET', 'm', false);
  $_SESSION['target_mode'] = $target_mode;
}

if($target_mode != ''){
  closeConnections();
  header("Location:" . $BASE_URL . "clothes.php");
  exit();
}

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
				<img src="<?php echo $CDN_IMGS;?>img/portrait_banner.png" alt="Personality Quiz Result" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">Use this section to choose the mode of the portrait of your pet.</div>
		</div>
	</div>

	<div class="container w-bg center">
		
	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
</body>
</html>