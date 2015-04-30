<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Clothes';

include_once(dirname(__FILE__) . '/defChecks.php');

$animal = $target_collection = 0;
$animal_options = array("dog", "cat");
if(isset($_SESSION['quiz'])){
	if(isset($_SESSION['quiz'][1])){
		if($_SESSION['quiz'][1] == "C"){
			$animal = 1;
		}
	}
}
if(isset($_GET['id'])){
	$target_collection = isSetAndNotDefault('', 'GET', 'id', false);
  $_SESSION['target_collection'] = $target_collection;
}
if(isset($_GET['a'])){
	$set_animal = isSetAndNotDefault('', 'GET', 'a', false);
  if($set_animal == '1'){
		$animal = 1;
  }else{
	  $animal = 0;
  }
}
if((int)$animal != 1){
  $animal = 0;
}

if(isset($_SESSION['target_mode'])){
	$target_mode = $_SESSION['target_mode'];
}
if(isset($_GET['m'])){
	$target_mode = isSetAndNotDefault('', 'GET', 'm', false);
  $_SESSION['target_mode'] = $target_mode;
}

// if(!isset($target_mode) || ($target_mode == '')){
//   closeConnections();
//   header("Location:" . $BASE_URL . "photo_draw.php");
//   exit();
// }

$order_pet_query = $DB->query("SELECT * FROM order_pet WHERE order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY order_pet_id ASC");
$order_pet_query_count = count($order_pet_query);

if(isset($_SESSION['target_collection'])){
	$target_collection = $_SESSION['target_collection'];
}
if($target_collection != 0){
	$clothes = $DB->query("SELECT * FROM clothes WHERE clothes_id='" . $target_collection . "' LIMIT 1");
	if(!isset($clothes[0])){
	  closeConnections();
	  header("Location:" . $BASE_URL . "collections.php");
	  exit();
	}else{
		$clothes['bg'] = $DB->query("SELECT * FROM clothes_imgs WHERE clothes_ref_id='" . $target_collection . "' AND clothes_imgs_type='dog_bg' ORDER BY clothes_imgs_id ASC");
		$clothes['label1'] = $DB->query("SELECT * FROM clothes_imgs WHERE clothes_ref_id='" . $target_collection . "' AND clothes_imgs_type='" . $animal_options[$animal] . "_label_1' ORDER BY clothes_imgs_id ASC");
		$clothes['label2'] = $DB->query("SELECT * FROM clothes_imgs WHERE clothes_ref_id='" . $target_collection . "' AND clothes_imgs_type='" . $animal_options[$animal] . "_label_2' ORDER BY clothes_imgs_id ASC");
		$clothes['label3'] = $DB->query("SELECT * FROM clothes_imgs WHERE clothes_ref_id='" . $target_collection . "' AND clothes_imgs_type='" . $animal_options[$animal] . "_label_3' ORDER BY clothes_imgs_id ASC");
		$clothes['label4'] = $DB->query("SELECT * FROM clothes_imgs WHERE clothes_ref_id='" . $target_collection . "' AND clothes_imgs_type='" . $animal_options[$animal] . "_label_4' ORDER BY clothes_imgs_id ASC");

		$clothes['bg_count'] = count($clothes['bg']);
		$clothes['label1_count'] = count($clothes['label1']);
		$clothes['label2_count'] = count($clothes['label2']);
		$clothes['label3_count'] = count($clothes['label3']);
		$clothes['label4_count'] = count($clothes['label4']);
	}
}else{
  closeConnections();
  header("Location:" . $BASE_URL . "collections.php");
  exit();
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader(); 
	  
	echo '<meta name="twitter:card" content="summary" />'
		. '<meta name="twitter:site" content="http://coatandtails.com/" />'
		. '<meta name="twitter:title" content="Custom Pet Portraits" />'
		. '<meta name="twitter:description" content="Find cool products like this and more at Coatandtails.com" />'
		. '<meta name="twitter:image" content="'.$BASE_URL.$clothes[0]['clothes_dog'].'" />'
		. '<meta name="twitter:url" content="http://www.coatandtails.com/clothes.php?id='.$target_collection.'" />'
		. '<meta property="og:title" content="Custom Pet Portraits" />'
		. '<meta property="og:site_name" content="Coat and Tails"/>'
		. '<meta property="og:url" content="http://www.coatandtails.com/clothes.php?id='.$target_collection.'" />'
		. '<meta property="og:description" content="Create your own personal pet portrait" />'
		. '<meta property="fb:app_id" content="309437425817038" />';
	?>
</head>
<body class="f clothes">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/portrait_banner.png" alt="Clothes" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">Use this section to choose the clothes and accessories that best suit your pet's personality.</p>
		</div>
	</div>

	<div class="container center small-container bread-container">
		<?php include_once(dirname(__FILE__) . '/bits/subheader.php');?>
	</div>
	<div class="container w-bg center small-container">
		<?php include_once(dirname(__FILE__) . '/bits/subheader.php');?>
		<div class="row">
			<div class="col-sm-12">
				<label for="pet_name" id="pet_name_label">Pet Name*</label>
				<input type="text" id="pet_name" placeholder="e.g. Spike" size="40" value="" required="">
			</div>
			<div class="col-sm-1">
				<?php
				if($clothes['bg_count'] > 1){
					echo '<div class="clothe-carousel-control l background"><img src="' . $CDN_IMGS . 'img/clothes_l_arrow.png"></div>';
				}
				if($clothes['label1_count'] > 1){
					echo '<div class="clothe-carousel-control l label1"><img src="' . $CDN_IMGS . 'img/clothes_l_arrow.png"></div>';
				}
				if($clothes['label2_count'] > 1){
					echo '<div class="clothe-carousel-control l label2"><img src="' . $CDN_IMGS . 'img/clothes_l_arrow.png"></div>';
				}
				if($clothes['label3_count'] > 1){
					echo '<div class="clothe-carousel-control l label3"><img src="' . $CDN_IMGS . 'img/clothes_l_arrow.png"></div>';
				}
				if($clothes['label4_count'] > 1){
					echo '<div class="clothe-carousel-control l label4"><img src="' . $CDN_IMGS . 'img/clothes_l_arrow.png"></div>';
				}
				?>
			</div>
			<div class="col-sm-10">
				<div class="clothe-collage-host">

					<div class="carousel-inner background">
						<?php
						$i = 0;
						for($i;$i<$clothes['bg_count'];$i++){
							echo '<div class="item';
							if($i == 0){
								echo ' active';
							}
							echo '" data-id="' . $i . '">'
									. '<img src="' . $CDN_IMGS . $clothes['bg'][$i]['clothes_imgs_dir'] . '">'
								. '</div>';
						}
						?>
						<input type="hidden" id="background" value="0">
					</div>

					<div class="carousel-inner animal">
						<div class="item active">
							<img src="<?php echo $CDN_IMGS . $clothes[0]['clothes_' . $animal_options[$animal]];?>">
						</div>
					</div>

					<div class="carousel-inner label1">
						<?php
						$i = 0;
						for($i;$i<$clothes['label1_count'];$i++){
							echo '<div class="item';
							if($i == 0){
								echo ' active';
							}
							echo '" data-id="' . $i . '">'
									. '<img src="' . $CDN_IMGS . $clothes['label1'][$i]['clothes_imgs_dir'] . '">'
								. '</div>';
						}
						?>
						<input type="hidden" id="label1" value="0">
					</div>

					<div class="carousel-inner label2">
						<?php
						$i = 0;
						for($i;$i<$clothes['label2_count'];$i++){
							echo '<div class="item';
							if($i == 0){
								echo ' active';
							}
							echo '" data-id="' . $i . '">'
									. '<img src="' . $CDN_IMGS . $clothes['label2'][$i]['clothes_imgs_dir'] . '">'
								. '</div>';
						}
						?>
						<input type="hidden" id="label2" value="0">
					</div>

					<div class="carousel-inner label3">
						<?php
						$i = 0;
						for($i;$i<$clothes['label3_count'];$i++){
							echo '<div class="item';
							if($i == 0){
								echo ' active';
							}
							echo '" data-id="' . $i . '">'
									. '<img src="' . $CDN_IMGS . $clothes['label3'][$i]['clothes_imgs_dir'] . '">'
								. '</div>';
						}
						?>
						<input type="hidden" id="label3" value="0">
					</div>

					<div class="carousel-inner label4">
						<?php
						$i = 0;
						for($i;$i<$clothes['label4_count'];$i++){
							echo '<div class="item';
							if($i == 0){
								echo ' active';
							}
							echo '" data-id="' . $i . '">'
									. '<img src="' . $CDN_IMGS . $clothes['label4'][$i]['clothes_imgs_dir'] . '">'
								. '</div>';
						}
						?>
						<input type="hidden" id="label4" value="0">
					</div>

				</div>
			</div>
			<div class="col-sm-1">
				<?php
				if($clothes['bg_count'] > 1){
					echo '<div class="clothe-carousel-control r background"><img src="' . $CDN_IMGS . 'img/clothes_r_arrow.png"></div>';
				}
				if($clothes['label1_count'] > 1){
					echo '<div class="clothe-carousel-control r label1"><img src="' . $CDN_IMGS . 'img/clothes_r_arrow.png"></div>';
				}
				if($clothes['label2_count'] > 1){
					echo '<div class="clothe-carousel-control r label2"><img src="' . $CDN_IMGS . 'img/clothes_r_arrow.png"></div>';
				}
				if($clothes['label3_count'] > 1){
					echo '<div class="clothe-carousel-control r label3"><img src="' . $CDN_IMGS . 'img/clothes_r_arrow.png"></div>';
				}
				if($clothes['label4_count'] > 1){
					echo '<div class="clothe-carousel-control r label4"><img src="' . $CDN_IMGS . 'img/clothes_r_arrow.png"></div>';
				}
				?>
			</div>
		</div>
		<div class="row footer-row">
			<div class="col-sm-5 col-sm-offset-1">
				<a href="<?php echo $BASE_URL;?>clothes.php?a=1" class="animal-choice pull-left">
					<img src="<?php echo $CDN_IMGS;?>img/cat_btn_img.png">
				</a>
				<a href="<?php echo $BASE_URL;?>clothes.php?a=0" class="animal-choice pull-left">
					<img src="<?php echo $CDN_IMGS;?>img/dog_btn_img.png">
				</a>
			</div>
			<div class="col-sm-5">
				<input type="hidden" id="a" value="<?php echo $animal;?>">
				<a href="javascript:void(0);" class="btn btn-lg btn-inverted btn-negative pull-right continue">Continue</a><br/>
      </div>
			<div class="col-sm-11">
				<div class="pull-right">
					<a href="javascript:void(0);" id="start_over">Start over</a>
				</div>
			</div>
			

    </div>
    	<?php  
				echo '<div class="share-btns row"><div class="col-sm-12 col-sm-offset-2"><div class="fb-share-button" data-href="http://www.coatandtails.com/clothes.php?id='.$target_collection.'" data-layout="button"></div>';
					echo '<a class="pin-btn" href="https://www.pinterest.com/pin/create/button/
        ?url=http%3A%2F%2Fwww.coatandtails.com%2Fclothes.php?id='.$target_collection.'" 
        data-pin-media="' . $CDN_IMGS . $clothes[0]['clothes_' . $animal_options[$animal]] . '" 
        data-pin-do="buttonPin"
        data-pin-description="Make Custom Pet Portraits"
        data-pin-config="none">
        <img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>';
    				echo '<a class="tweet-btn" target="_blank" href="https://twitter.com/intent/tweet?text=Look%20what%20I%20saw%20at%20&url=http%3A%2F%2Fwww.coatandtails.com%2Fclothes.php?id='.$target_collection.'">Tweet</a></div></div>';
			?>
	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	window.can_leave=<?php echo json_encode($order_pet_query_count > 1 ? false : true);?>;
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
</body>
</html>