<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Collections';

include_once(dirname(__FILE__) . '/defChecks.php');

$target_gender = "";

if(isset($_GET['g'])){
	$target_gender = isSetAndNotDefault('', 'GET', 'g', false);
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="f collections">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/portrait_banner.png" alt="Collections" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">Use this section to choose the clothes and accessories that best suit your pet's personality.</p>
		</div>
	</div>

	<div class="container center bread-container">
		<?php include_once(dirname(__FILE__) . '/bits/subheader.php');?>
	</div>
	<div class="container w-bg center">
		<h3 style="padding-bottom:15px;">First choose a collection, or theme, for your portrait.</h3>
        <div class="row">
			<div class="col-sm-2 hidden-xs">
				<div class="collections-menu">
				<?php
				if(($mens_collections_count > 0) && ($target_gender != '1')){
					?>
					<div class="gender-header">Men</div>
					<?php
					$i = 0;
					for($i;$i<$mens_collections_count;$i++){
						echo '<div>'
								. '<a href="javascript:void(0);" data-id="' . $mens_collections[$i]['clothes_id'] . '" class="collections-target">' . $mens_collections[$i]['clothes_title'] . '</a>'
							. '</div>';
					}
				}
				if(($womens_collections_count > 0) && ($target_gender != '0')){
					?>
					<div class="gender-header">Women</div>
					<?php
					$i = 0;
					for($i;$i<$womens_collections_count;$i++){
						echo '<div>'
								. '<a href="javascript:void(0);" data-id="' . $womens_collections[$i]['clothes_id'] . '" class="collections-target">' . $womens_collections[$i]['clothes_title'] . '</a>'
							. '</div>';
					}
				}
				?>
				</div>
			</div>
			<div class="col-sm-10 imgs-host">
				<?php
				if($target_gender == '0'){ // male gender targeted
					?>
					<div class="row">
						<div class="col-sm-12">
							<a href="javascript:void(0);" data-id="1" class="collections-banner-target collections-target">
								<img src="<?php echo $CDN_IMGS;?>img/baller_banner.jpg">
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<a href="javascript:void(0);" data-id="7" class="collections-banner-target collections-target">
								<img src="<?php echo $CDN_IMGS;?>img/soldier_banner.jpg">
							</a>
						</div>
						<div class="col-sm-6">
							<a href="javascript:void(0);" data-id="13" class="collections-banner-target collections-target">
								<img src="<?php echo $CDN_IMGS;?>img/noir_banner.jpg">
							</a>
						</div>
					</div>
					<?php
				}else if($target_gender == '1'){ // female gender targeted
					?>
					<div class="row">
						<div class="col-sm-12">
							<a href="javascript:void(0);" data-id="1" class="collections-banner-target collections-target">
								<img src="<?php echo $CDN_IMGS;?>img/belle_banner.jpg">
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<a href="javascript:void(0);" data-id="16" class="collections-banner-target collections-target">
								<img src="<?php echo $CDN_IMGS;?>img/edwardian_banner.jpg">
							</a>
						</div>
						<div class="col-sm-6">
							<a href="javascript:void(0);" data-id="12" class="collections-banner-target collections-target">
								<img src="<?php echo $CDN_IMGS;?>img/princess_banner.jpg">
							</a>
						</div>
					</div>
					<?php
				}else{ // no gender targeted
					?>
					<div class="row">
						<div class="col-sm-12">
							<a href="javascript:void(0);" data-id="8" class="collections-banner-target collections-target">
								<img src="<?php echo $CDN_IMGS;?>img/belle_banner.jpg">
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<a href="javascript:void(0);" data-id="7" class="collections-banner-target collections-target">
								<img src="<?php echo $CDN_IMGS;?>img/soldier_banner.jpg">
							</a>
						</div>
						<div class="col-sm-6">
							<a href="javascript:void(0);" data-id="13" class="collections-banner-target collections-target">
								<img src="<?php echo $CDN_IMGS;?>img/noir_banner.jpg">
							</a>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<div class="col-sm-2 visible-xs">
				<div class="collections-menu">
				<?php
				if(($mens_collections_count > 0) && ($target_gender != '1')){
					?>
					<div class="gender-header">Men</div>
					<?php
					$i = 0;
					for($i;$i<$mens_collections_count;$i++){
						echo '<div>'
								. '<a href="javascript:void(0);" data-id="' . $mens_collections[$i]['clothes_id'] . '" class="collections-target">' . $mens_collections[$i]['clothes_title'] . '</a>'
							. '</div>';
					}
				}
				if(($womens_collections_count > 0) && ($target_gender != '0')){
					?>
					<div class="gender-header">Women</div>
					<?php
					$i = 0;
					for($i;$i<$womens_collections_count;$i++){
						echo '<div>'
								. '<a href="javascript:void(0);" data-id="' . $womens_collections[$i]['clothes_id'] . '" class="collections-target">' . $womens_collections[$i]['clothes_title'] . '</a>'
							. '</div>';
					}
				}
				?>
				</div>
			</div>
		</div>
	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.html');?>
</body>
</html>