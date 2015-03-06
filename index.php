<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Home';

include_once(dirname(__FILE__) . '/defChecks.php');

closeConnections();

commonHeaders();
?><html lang="en">
<head>
    <?php echo commonMetaHeader();?>
</head>
<body class="f main">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 carousel-host">
				<div id="home-carousel" class="carousel slide">
					<div class="carousel-bg-layer" style="background-image:url('<?php echo $CDN_IMGS;?>img/homepage/background.png');"></div>
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<a href="http://www.coatandtails.com/collections.php">
								<div class="carousel-item-img img-thumbnail embed-responsive embed-responsive-4by2" style="background-image:url('<?php echo $CDN_IMGS;?>img/homepage/slide1.png');"></div>
							</a>
						</div>
						<div class="item">
							<a href="http://www.coatandtails.com/collections.php">
								<div class="carousel-item-img img-thumbnail embed-responsive embed-responsive-4by2" style="background-image:url('<?php echo $CDN_IMGS;?>img/homepage/slide2.png');"></div>
							</a>
						</div>
					</div>

					<a class="l carousel-control home-carousel-control" href="javascript:void(0);">
						<span class="glyphicon glyphicon-chevron-left">
							<img src="<?php echo $CDN_IMGS;?>img/clothes_l_arrow.png">
						</span>
					</a>
					<a class="r carousel-control home-carousel-control" href="javascript:void(0);">
						<span class="glyphicon glyphicon-chevron-right">
							<img src="<?php echo $CDN_IMGS;?>img/clothes_r_arrow.png">
						</span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<a href="http://www.coatandtails.com/merchandise.php" class="home-subcarousel-targets">
					<div class="img-thumbnail embed-responsive embed-responsive-4by3"><img src="<?php echo $CDN_IMGS;?>img/tile1.jpg" style="width:100%;"></div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="http://www.coatandtails.com/merchandise.php?c=2" class="home-subcarousel-targets">
					    <div class="img-thumbnail embed-responsive embed-responsive-4by3"><img src="<?php echo $CDN_IMGS;?>img/tile2.jpg" style="width:100%;"></div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="http://www.coatandtails.com/quiz.php" class="home-subcarousel-targets">
					    <div class="img-thumbnail embed-responsive embed-responsive-4by3"><img src="<?php echo $CDN_IMGS;?>img/tile3.jpg" style="width:100%;"></div>
				</a>
			</div>
		</div>
	</div>

	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
</body>
</html>