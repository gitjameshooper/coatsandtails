<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Merchandise';

include_once(dirname(__FILE__) . '/defChecks.php');

$target_cat = 0;
if(isset($_GET['c'])){
	$target_cat = isSetAndNotDefault('', 'GET', 'c', false);
	if(!is_numeric($target_cat)){
		$target_cat = 0;
	}else if((int)$target_cat < 0){
		$target_cat = 0;
	}
	if($target_cat != 0){
		if(count($DB->query("SELECT * FROM category WHERE category_id='$target_cat' LIMIT 1")) == 0){
			$target_cat = 0;
		}
	}
}

if($target_cat == 0){
	$target_merchandise = $DB->query("SELECT * FROM merchandise LEFT JOIN merchandise_imgs ON merchandise_imgs.merchandise_ref_id=merchandise.merchandise_id WHERE merchandise_status!='1' GROUP BY merchandise_id ORDER BY merchandise_id DESC, merchandise_imgs_id DESC LIMIT 1000");
}else{
	$target_merchandise = $DB->query("SELECT * FROM merchandise LEFT JOIN merchandise_imgs ON merchandise_imgs.merchandise_ref_id=merchandise.merchandise_id WHERE merchandise.merchandise_category='$target_cat' AND merchandise_status!='1' GROUP BY merchandise_id ORDER BY merchandise_id DESC, merchandise_imgs_id DESC LIMIT 1000");
}
$target_merchandise_count = count($target_merchandise);
if($target_merchandise_count > 0){
	$i = 0;
	for($i;$i<$target_merchandise_count;$i++){
		$target_merchandise[$i]['target_variant'] = '';
		$target_merchandise[$i]['variants'] = $DB->query("SELECT * FROM merchandise_variant WHERE merchandise_variant_merchandise_id='" . $target_merchandise[$i]['merchandise_id'] . "' ORDER BY merchandise_variant_id DESC LIMIT 1000");

		$target_variant_count = count($target_merchandise[$i]['variants']);
		if($target_variant_count > 0){
			$d = 0;
			for($d;$d<$target_variant_count;$d++){
				if(($target_merchandise[$i]['variants'][$d]['merchandise_variant_availability'] > 0) && ($target_merchandise[$i]['target_variant'] === '')){
					$target_merchandise[$i]['target_variant'] = $d;
				}
			}

		}else{
			$target_merchandise[$i]['merchandise_status'] = '2';
		}
	}
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="f merch">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/merch_banner.png" alt="Merchandise" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 center">
			<?php
			echo '<a href="' . $BASE_URL . 'merchandise.php" class="def-col">View all Merchandise</a>';
			$i = 0;
			for($i;$i<$merchandise_count;$i++){
				echo '<a href="' . $BASE_URL . 'merchandise.php?c=' . $merchandise[$i]['category_id'] . '" class="def-col">' . $merchandise[$i]['category_title'] . '</a>';
			}
			?>
			</div>
		</div>
	</div>

	<div class="container w-bg center">
			<div class="row">
			<?php
			$i = 0;
			for($i;$i<$target_merchandise_count;$i++){
				?>
				<div class="col-sm-4 product" id="prod_<?php echo $target_merchandise[$i]['merchandise_id'];?>">
					<a href="<?php echo $BASE_URL;?>product.php?id=<?php echo $target_merchandise[$i]['merchandise_id'];?>" title="<?php echo stripslashes($target_merchandise[$i]['merchandise_title']);?>">
						<div class="product_header">
							<h2><?php echo stripslashes($target_merchandise[$i]['merchandise_title']);?></h2>
							<span class="dash"></span>
							<h3>
							<?php
								if($target_merchandise[$i]['merchandise_status'] == '0'){
									if($target_merchandise[$i]['target_variant'] !== ''){
										echo '<span class="currency_sign">$</span>' . number_format((float)$target_merchandise[$i]['variants'][$target_merchandise[$i]['target_variant']]['merchandise_variant_price'], 2);
									}
								}else if($target_merchandise[$i]['merchandise_status'] == '2'){
									echo '<div>Sold Out</div>';
								}else if($target_merchandise[$i]['merchandise_status'] == '3'){
									echo '<div>Coming Soon</div>';
								}
							?>
							</h3>
						</div>
						<div class="product_thumb">
							<div class="merch-img" style="background-image:url('<?php
							if(!isset($target_merchandise[$i]['merchandise_imgs_dir'])){
								echo $CDN_IMGS . 'img/missing.png';
							}else{
								echo $CDN_IMGS . $target_merchandise[$i]['merchandise_imgs_dir'];
							}
							?>');" class="fade_in" alt="Image of <?php echo stripslashes($target_merchandise[$i]['merchandise_title']);?>"></div>
						</div>
					</a>
				</div>
			<?php
		}
		?>
		</div>
	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.html');?>
</body>
</html>