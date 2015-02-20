<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Frame';
$target_collection = 0;
$animal_options = array("dog", "cat");
$target_mode_options = array('photo', 'draw');

include_once(dirname(__FILE__) . '/defChecks.php');

if(!isset($target_mode) || ($target_mode == '')){
  closeConnections();
  header("Location:" . $BASE_URL . "photo_draw.php");
  exit();
}

$order_pet_query = $DB->query("SELECT * FROM order_pet WHERE order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY order_pet_id ASC");
$order_pet_query_count = count($order_pet_query);

$target_mode_size_options = 4;

if($target_mode == 1){
	$frames_query = $DB->query("SELECT * FROM frames LEFT JOIN frames_imgs ON frames_imgs.frames_ref_id=frames.frames_id WHERE frames_8x10_availability>0 OR frames_11x14_availability>0 OR frames_16x20_availability>0 OR frames_20x24_availability>0 GROUP BY frames_id ORDER BY frames_id DESC LIMIT 1000");
}else{
	$target_mode_size_options = 2;
	$frames_query = $DB->query("SELECT * FROM frames LEFT JOIN frames_imgs ON frames_imgs.frames_ref_id=frames.frames_id WHERE frames_8x10_availability>0 OR frames_11x14_availability>0 GROUP BY frames_id ORDER BY frames_id DESC LIMIT 1000");
}
$frames_query_count = count($frames_query);

$price = 0;
$target_size = 0;
$target_size_output = '';
$available_sizes = 0;

$frame_availability = array('mode'=>$target_mode,'items'=>array());

if($frames_query_count > 0){
	$frames_query[0]['imgs_count'] = 0;
	if(isset($frames_query[0]['frames_imgs_id'][0])){
		$frames_query[0]['imgs'] = $DB->query("SELECT * FROM frames_imgs WHERE frames_ref_id='" . $frames_query[0]['frames_id'] . "' ORDER BY frames_imgs_id ASC LIMIT 6");
		$frames_query[0]['imgs_count'] = count($frames_query[0]['imgs']);
	}
	$i = 0;
	for($i;$i<$target_mode_size_options;$i++){
		if((int)$frames_query[0]['frames_' . $SIZE_OPTIONS[$i] . '_availability'] > 0){
			$available_sizes++;
			if($price == 0){
				$target_size = $i;
				$target_size_output = $SIZE_OPTIONS[$i];
				$price = (float)$frames_query[0]['frames_' . $SIZE_OPTIONS[$i] . '_price'];
			}
		}
	}
	$i = 0;
	for($i;$i<$frames_query_count;$i++){
		$arr1 = array();
		$d = 0;
		for($d;$d<$target_mode_size_options;$d++){
			$arr1[$SIZE_OPTIONS[$d]] = array(
				'price'=>number_format((float)$frames_query[$i]['frames_' . $SIZE_OPTIONS[$d] . '_price'], 2),
				'availability'=>(int)$frames_query[$i]['frames_' . $SIZE_OPTIONS[$d] . '_availability']
			);
		}
		$arr2 = array();
		if(isset($frames_query[$i]['frames_imgs_id'][0])){
			$frames_imgs = $DB->query("SELECT * FROM frames_imgs WHERE frames_ref_id='" . $frames_query[$i]['frames_id'] . "' ORDER BY frames_imgs_id ASC LIMIT 6");
			$frames_imgs_count = count($frames_imgs);
			$d = 0;
			for($d;$d<$frames_imgs_count;$d++){
				array_push(
					$arr2,
					array(
						'dir'=>$frames_imgs[$d]['frames_imgs_dir']
					)
				);
			}
		}
		array_push(
			$frame_availability['items'],
			array(
				'id'=>$frames_query[$i]['frames_id'],
				'title'=>$frames_query[$i]['frames_title'],
				'price_desc'=>stripslashes(nl2br(htmlspecialchars_decode($frames_query[$i]['frames_price_desc']))),
				'desc'=>stripslashes(nl2br(htmlspecialchars_decode($frames_query[$i]['frames_desc']))),
				'sizes'=>$arr1,
				'images'=>$arr2,
				'top_offset'=>(int)$frames_query[$i]['frames_offset_top'],
				'bottom_offset'=>(int)$frames_query[$i]['frames_offset_bottom'],
				'left_offset'=>(int)$frames_query[$i]['frames_offset_left'],
				'right_offset'=>(int)$frames_query[$i]['frames_offset_right']
			)
		);
	}
}else{
  closeConnections();
  header("Location:" . $BASE_URL . "upload.php");
  exit();
}

$clothes = $DB->query("SELECT * FROM order_pet LEFT JOIN clothes ON clothes.clothes_id=order_pet.order_pet_clothe_ref_id WHERE order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "'");
$clothes_count = count($clothes);
if(($clothes_count == 1) && isset($clothes[0]['clothes_id'][0])){
	$this_pet_info = objectToArray(json_decode($clothes[0]['order_pet_clothe_optional']));
	$target_collection = $clothes[0]['clothes_id'];
	$animal = $clothes[0]['order_pet_animal'];
	if($target_collection != 0){
		if(isset($this_pet_info['bg'])){
			$clothes['bg'] = $DB->query("SELECT * FROM clothes_imgs WHERE clothes_ref_id='$target_collection' AND clothes_imgs_type='dog_bg' ORDER BY clothes_imgs_id ASC");
			$clothes['bg'] = $clothes['bg'][$this_pet_info['bg']]['clothes_imgs_dir'];
		}

		if(isset($this_pet_info['label1'])){
			$clothes['label1'] = $DB->query("SELECT * FROM clothes_imgs WHERE clothes_ref_id='$target_collection' AND clothes_imgs_type='" . $animal_options[$animal] . "_label_1' ORDER BY clothes_imgs_id ASC");
			$clothes['label1'] = $clothes['label1'][$this_pet_info['label1']]['clothes_imgs_dir'];
		}

		if(isset($this_pet_info['label2'])){
			$clothes['label2'] = $DB->query("SELECT * FROM clothes_imgs WHERE clothes_ref_id='$target_collection' AND clothes_imgs_type='" . $animal_options[$animal] . "_label_2' ORDER BY clothes_imgs_id ASC");
			$clothes['label2'] = $clothes['label2'][$this_pet_info['label2']]['clothes_imgs_dir'];
		}

		if(isset($this_pet_info['label3'])){
			$clothes['label3'] = $DB->query("SELECT * FROM clothes_imgs WHERE clothes_ref_id='$target_collection' AND clothes_imgs_type='" . $animal_options[$animal] . "_label_3' ORDER BY clothes_imgs_id ASC");
			$clothes['label3'] = $clothes['label3'][$this_pet_info['label3']]['clothes_imgs_dir'];
		}

		if(isset($this_pet_info['label4'])){
			$clothes['label4'] = $DB->query("SELECT * FROM clothes_imgs WHERE clothes_ref_id='$target_collection' AND clothes_imgs_type='" . $animal_options[$animal] . "_label_4' ORDER BY clothes_imgs_id ASC");
			$clothes['label4'] = $clothes['label4'][$this_pet_info['label4']]['clothes_imgs_dir'];
		}
	}
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="f frame">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/portrait_banner.png" alt="Frame" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">Use this section to choose the frame that best fits your portrait.</p>
		</div>
	</div>

	<div class="container center small-container bread-container">
		<?php include_once(dirname(__FILE__) . '/bits/subheader.php');?>
	</div>
	<div class="container frame-container">
		<div class="row">
			<div class="col-sm-1">
				<div class="frame-carousel-control l background"><img src="<?php echo $CDN_IMGS;?>img/clothes_l_arrow.png"></div>
			</div>
			<div class="col-sm-10 w-bg center frame-collage-host">
				<div class="row">
					<div class="col-sm-2 hidden-xs">
						<div class="frame-info">
							<div class="frame-price">Price: $<span><?php echo number_format($price, 2);?></span></div>
							<div class="frame-price-desc"><?php echo nl2br(htmlspecialchars_decode($frames_query[0]['frames_price_desc'], ENT_QUOTES));?></div>
							<div class="frame-desc-header">Description</div>
							<div class="frame-desc"><?php echo nl2br(htmlspecialchars_decode($frames_query[0]['frames_desc'], ENT_QUOTES));?></div>
							<select class="form-control available_sizes" name="available_sizes">
							</select>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="def-frame-bg"><?php
						if(isset($clothes['bg'])){
							echo '<img src="' . $CDN_IMGS . $clothes['bg'] . '" class="layer_bg">'
								. '<img src="' . $CDN_IMGS . $clothes[0]['clothes_' . $animal_options[$animal]] . '" class="layer_animal">';
							if(isset($clothes['label1'])){
								echo '<img src="' . $CDN_IMGS . $clothes['label1'] . '" class="layer_1">';
							}
							if(isset($clothes['label2'])){
								echo '<img src="' . $CDN_IMGS . $clothes['label2'] . '" class="layer_2">';
							}
							if(isset($clothes['label3'])){
								echo '<img src="' . $CDN_IMGS . $clothes['label3'] . '" class="layer_3">';
							}
							if(isset($clothes['label4'])){
								echo '<img src="' . $CDN_IMGS . $clothes['label4'] . '" class="layer_4">';
							}
						}else{
							echo '<img class="res-img" src="' . $CDN_IMGS . 'img/' . $target_mode_options[$target_mode] . '_mode.jpg">';
						}
						?></div>
						<img src="<?php
						if($frames_query[0]['imgs_count'] > 0){
							echo $CDN_IMGS . $frames_query[0]['imgs'][0]['frames_imgs_dir'];
							}
						?>" class="def-frame-img">
					</div>
					<div class="col-sm-2 visible-xs">
						<div class="frame-info">
							<div class="frame-price">Price: $<span><?php echo number_format($price, 2);?></span></div>
							<div class="frame-price-desc"><?php echo nl2br(htmlspecialchars_decode($frames_query[0]['frames_price_desc']));?></div>
							<div class="frame-desc-header">Description</div>
							<div class="frame-desc"><?php echo nl2br(htmlspecialchars_decode($frames_query[0]['frames_desc']));?></div>
							<select class="form-control available_sizes" name="available_sizes">
							</select>
						</div>
					</div>
					<div class="col-sm-2 frame-thumbs">
						<div class="frame-thumbs-host">
							<div class="frame-thumbs-title">Detailed Photos</div>
							<div class="row"></div>
						</div>
					</div>
				</div>
				<div class="row footer-row">
					<div class="col-sm-12">
						<div class="pull-right">
							<a href="javascript:void(0);" class="btn btn-lg btn-inverted btn-negative continue">Continue</a><br/>
							<a href="<?php echo $BASE_URL;?>upload.php">I don't want a frame</a><br/>
							<a href="javascript:void(0);" id="start_over">Start over</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-1">
				<div class="frame-carousel-control r background"><img src="<?php echo $CDN_IMGS;?>img/clothes_r_arrow.png"></div>
			</div>
		</div>
	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	window.frame_availability=<?php echo json_encode($frame_availability);?>;
	window.curr_frame=0;
	window.curr_size="<?php echo $target_size_output;?>";
	window.can_leave=<?php echo json_encode($order_pet_query_count > 1 ? false : true);?>;
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.html');?>
</body>
</html>