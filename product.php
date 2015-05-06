<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Merchandise';
$META_PAGE = 'Product';

$status_options = array('Active', 'Hidden', 'Sold Out', 'Coming Soon');
$variants = array();
$target_variant_count = 0;
$merchandise_target_variant = '';

include_once(dirname(__FILE__) . '/defChecks.php');

$target_id = 0;
if(isset($_GET['id'])){
	$target_id = isSetAndNotDefault('', 'GET', 'id', false);
	if(!is_numeric($target_id)){
		$target_id = 0;
	}else if((int)$target_id < 0){
		$target_id = 0;
	}
	if($target_id != 0){
		$target_merchandise = $DB->query("SELECT * FROM merchandise LEFT JOIN merchandise_imgs ON merchandise_imgs.merchandise_ref_id=merchandise.merchandise_id LEFT JOIN merchandise_variant ON merchandise_variant.merchandise_variant_merchandise_id=merchandise.merchandise_id WHERE merchandise.merchandise_id='$target_id' AND merchandise_status!='1' ORDER BY merchandise_imgs_id DESC LIMIT 1");
		$target_merchandise_count = count($target_merchandise);
		if(count($target_merchandise) == 0){
			closeConnections();
			header("Location:" . $BASE_URL . "merchandise.php");
			exit();
		}else if($target_merchandise[0]['merchandise_status'] == '1'){
			closeConnections();
			header("Location:" . $BASE_URL . "merchandise.php");
			exit();
		}else if($target_merchandise_count > 0){
			$target_merchandise[0]['variants'] = $DB->query("SELECT * FROM merchandise_variant WHERE merchandise_variant_merchandise_id='" . $target_merchandise[0]['merchandise_id'] . "' ORDER BY merchandise_variant_id DESC LIMIT 1000");
			$target_variant_count = count($target_merchandise[0]['variants']);
			if($target_variant_count > 0){
				$i = 0;
				for($i;$i<$target_variant_count;$i++){
					if(((int)$target_merchandise[0]['variants'][$i]['merchandise_variant_availability'] > 0) && ($merchandise_target_variant === '')){
						$merchandise_target_variant = $i;
					}
					array_push($variants, array(
						'merchandise_id'=>$target_merchandise[0]['variants'][$i]['merchandise_variant_merchandise_id'],
						'variant_id'=>$target_merchandise[0]['variants'][$i]['merchandise_variant_id'],
						'label'=>$target_merchandise[0]['variants'][$i]['merchandise_variant_label'],
						'price'=>$target_merchandise[0]['variants'][$i]['merchandise_variant_price'],
						'availability'=>$target_merchandise[0]['variants'][$i]['merchandise_variant_availability']
						)
					);
				}

			}else{
				$target_merchandise[0]['merchandise_status'] = '2';
			}
		}
	}
}

$CURRENT_PAGE_NAME = str_case(stripslashes($target_merchandise[0]['merchandise_title']), 'uw');

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();
	echo '<meta name="twitter:card" content="summary_large_image">'
		. '<meta name="twitter:site" content="http://coatandtails.com/" />'
		. '<meta name="twitter:title" content="'.$target_merchandise[0]['merchandise_title'].'" />'
		. '<meta name="twitter:description" content="Find cool products like this and more at Coatandtails.com" />'
		. '<meta name="twitter:image" content="'.$CDN_IMGS . $target_merchandise[0]['merchandise_imgs_dir'].'" />'
		. '<meta name="twitter:url" content="http://www.coatandtails.com/product.php?id='.$target_id.'" />'
		. '<meta property="og:title" content="'.$CURRENT_PAGE_NAME.'" />'
		. '<meta property="og:site_name" content="Coat & Tails"/>'
		. '<meta property="og:image" content="'.$CDN_IMGS . $target_merchandise[0]['merchandise_imgs_dir'].'" />'
		. '<meta property="og:url" content="http://www.coatandtails.com/product.php?id='.$target_id.'" />'
		. '<meta property="og:description" content="Visit Us at Coat & Tails" />';
	?>
</head>
<body class="f prod">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/merch_banner.png" alt="Merchandise" class="sub-header-banner-img">
			</div>
		</div>
	</div>

	<div class="container w-bg center">
		<div class="row">
			<div class="col-sm-4">
				<h2><?php echo stripslashes($target_merchandise[0]['merchandise_title']);?></h2>
				<span class="dash"></span>
				<h3 class="price">
					<?php
					if($merchandise_target_variant !== ''){
						echo '<span class="currency_sign">$</span>' . $target_merchandise[0]['variants'][$merchandise_target_variant]['merchandise_variant_price'];
					}
					?>
				</h3>
				<div class="desc"><?php echo stripslashes(nl2br(htmlspecialchars_decode($target_merchandise[0]['merchandise_desc'])));?></div>
				<?php
				if($target_variant_count > 0){
					echo '<div class="variants_host">'
						. '<select class="form-control" id="variants" name="variants">';
					$i = 0;
					for($i;$i<$target_variant_count;$i++){
						echo '<option value="' . $target_merchandise[0]['variants'][$i]['merchandise_variant_id'] . '" data-i="' . $i . '"';
						if($i == $merchandise_target_variant){
							echo ' selected="selected"';
						}
						echo '>' . $target_merchandise[0]['variants'][$i]['merchandise_variant_label'] . ' ($' . $target_merchandise[0]['variants'][$i]['merchandise_variant_price'] . ')' . '</option>';
					}
					echo '</select>'
						. '</div>';
				}
				if($target_merchandise[0]['merchandise_status'] == '0'){
					echo '<a href="javascript:void(0);" class="btn btn-lg add-to-cart" data-id="' . $target_merchandise[0]['merchandise_id'] . '">Add to Cart</a>';
					echo '<div class="share-btns"><div class="btn-wrap"><div class="fb-share-button" data-href="http://www.coatandtails.com/product.php?id='.$target_id.'" data-layout="button"></div></div>';
					echo '<div class="btn-wrap"><a class="pin-btn" href="https://www.pinterest.com/pin/create/button/
        ?url=http%3A%2F%2Fwww.coatandtails.com%2Fproduct.php?id='.$target_id.'
        &media=' . $CDN_IMGS . $target_merchandise[0]['merchandise_imgs_dir'] . '
        data-pin-do="buttonPin"
        data-pin-description="'.$target_merchandise[0]['merchandise_title'].'"
        data-pin-config="none">
        <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a></div>';
    				echo '<div class="btn-wrap"><a class="tweet-btn" target="_blank" href="https://twitter.com/intent/tweet?text='.$CURRENT_PAGE_NAME.'&url=http%3A%2F%2Fwww.coatandtails.com%2Fproduct.php?id='.$target_id.'">Tweet</a></div></div>';
				}else if($target_merchandise[0]['merchandise_status'] == '2'){
					echo '<div class="alert alert-danger">Sold Out</div>';
				}else if($target_merchandise[0]['merchandise_status'] == '3'){
					echo '<div class="alert alert-success">Coming Soon</div>';
				}
				?>
			</div>
			<div class="col-sm-8">
				<div class="product_thumb">
					<?php
					if(isset($target_merchandise[0]['merchandise_imgs_dir'])){
						echo '<img class="merch-img" src="' . $CDN_IMGS . $target_merchandise[0]['merchandise_imgs_dir'] . '" alt="Image of ' . stripslashes($target_merchandise[0]['merchandise_title']) . '">';
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	window.variants=<?php echo json_encode($variants);?>;
	window.target_variant=<?php echo json_encode($merchandise_target_variant);?>;
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
</body>
</html>