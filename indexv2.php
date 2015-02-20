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
					<div class="carousel-inner" role="listbox">
						<div class="item active">
						 <a href="http://www.coatandtails.com/collections.php">
    							<div class="carousel-item-img" style="background-image:url('<?php echo $CDN_IMGS;?>img/slide1.jpg');"></div>
							</a>
							</a>
						</div>
						<div class="item">
						    <a href="http://www.coatandtails.com/clothes.php?id=8">
    							<div class="carousel-item-img" style="background-image:url('<?php echo $CDN_IMGS;?>img/slide2.jpg');"></div>
							</a>
						</div>                        
						<div class="item">
							<a href="http://www.coatandtails.com/clothes.php?id=3">
    							<div class="carousel-item-img" style="background-image:url('<?php echo $CDN_IMGS;?>img/slide5.jpg');"></div>
							</a>
						</div>
					</div>

					<a class="l carousel-control home-carousel-control" href="javascript:void(0);">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="r carousel-control home-carousel-control" href="javascript:void(0);">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="homepage_tiles">
        <img class="tile" src="<?php echo $CDN_IMGS;?>img/tile1.jpg">
        <img class="tile" src="<?php echo $CDN_IMGS;?>img/tile1.jpg">
        <img class="tile" src="<?php echo $CDN_IMGS;?>img/tile1.jpg">
    </div>
    
    <div class="mobile_tiles">
        <img class="mobile" src="<?php echo $CDN_IMGS;?>img/tile1.jpg">
        <img class="mobile" src="<?php echo $CDN_IMGS;?>img/tile1.jpg">
        <img class="mobile" src="<?php echo $CDN_IMGS;?>img/tile1.jpg">
    </div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.html');?>
</body>
</html>