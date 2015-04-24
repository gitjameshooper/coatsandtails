<?php

function handleImg($b_dir, $up_path, $var){
	$arr=array();

	$allowed_image_types = array('image/pjpeg'=>"jpg",'image/jpeg'=>"jpg",'image/jpg'=>"jpg",'image/png'=>"png",'image/x-png'=>"png",'image/gif'=>"gif");

	if(isset($_FILES[$var]['tmp_name']) && @is_uploaded_file($_FILES[$var]['tmp_name'])) {
		$userfile_name = $_FILES[$var]['name'];
		$userfile_tmp = $_FILES[$var]['tmp_name'];
		$userfile_type = $_FILES[$var]['type'];
		$filename = basename($userfile_name);
		$file_ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
		$error_msg = "";
		$arr=array();

		foreach($allowed_image_types as $mime_type => $ext) {
			if($file_ext==$ext && $userfile_type==$mime_type){
				$error_msg = "";
				$arr=array();
				break;
			}else{
				$arr=array('result'=>'error','error_msg'=>'not_allowed_image');
			}
		}

	}else{
		$arr=array('result'=>'error','error_msg'=>'no_image');
	}

	if((count($arr) == 0)){

		if(isset($userfile_name)){
			$large_image_location = $up_path . strtolower(substr($filename, 0 , strrpos($filename, '.'))) . "." . $file_ext;

			move_uploaded_file($userfile_tmp, $b_dir . $large_image_location);

			$arr=array('result'=>'success','img'=>$large_image_location);
		}
	}
	return $arr;
}

$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Upload';

include_once(dirname(__FILE__) . '/defChecks.php');

if(!isset($target_mode) || ($target_mode == '')){
  closeConnections();
  header("Location:" . $BASE_URL . "photo_draw.php");
  exit();
}

$target_mode_options = array('photo', 'draw');

$order_pet_query = $DB->query("SELECT * FROM order_pet WHERE order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY order_pet_id ASC");
$order_pet_query_count = count($order_pet_query);

$pet_photos = array();

if(isset($_POST["upload"]) && ($_POST["upload"] == "Upload")){
	$base_dir = dirname(__FILE__) . '/';
	$upload_dir = "img/user_uploads/" . md5($_COOKIE['PHPSESSID']);
	$upload_path = $upload_dir . "/";

	if(!file_exists($base_dir . $upload_path)){
		mkdir($base_dir . $upload_path);
	}

	$i = 0;
	for($i;$i<$order_pet_query_count;$i++){
		array_push($pet_photos, array());

		$photo1 = handleImg($base_dir, $upload_path, ($i + 1) . '_1');
		$photo2 = handleImg($base_dir, $upload_path, ($i + 1) . '_2');
		$photo3 = handleImg($base_dir, $upload_path, ($i + 1) . '_3');

		if(($photo1['result'] == 'error') && ($photo2['result'] == 'error') && ($photo3['result'] == 'error')){
			$error_txt = 'You need to upload at least one image of ';
			if(isset($order_pet_query[$i]['order_pet_name'][0])){
				$error_txt .= $order_pet_query[$i]['order_pet_name'];
			}else{
				$error_txt .= 'Pet ' . ($i + 1);
			}
			appendError($error_txt);
		}else if(($photo1['result'] == 'success') || ($photo2['result'] == 'success') || ($photo3['result'] == 'success')){

			$this_pet_info = objectToArray(json_decode($order_pet_query[$i]['order_pet_clothe_optional']));

			if($photo1['result'] == 'success'){
				array_push($pet_photos[$i], $photo1['img']);
			}
			if($photo2['result'] == 'success'){
				array_push($pet_photos[$i], $photo2['img']);
			}
			if($photo3['result'] == 'success'){
				array_push($pet_photos[$i], $photo3['img']);
			}

			$this_pet_info['imgs'] = $pet_photos[$i];
			$DB->sql("UPDATE order_pet SET order_pet_clothe_optional='" . json_encode($this_pet_info) . "' WHERE order_pet_id='" . $order_pet_query[$i]['order_pet_id'] . "' LIMIT 1");
		}
	}

	if($ERROR === ''){
    closeConnections();
    header("Location:" . $BASE_URL . "cart.php");
    exit();
	}
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="f upload">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="title-caption">
				<img src="<?php echo $CDN_IMGS;?>img/portrait_banner.png" alt="Upload Photos" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">Use this section to upload photos of your pets.</p>
		</div>
		<?php
		if($ERROR !== ''){
			echo '<div class="alert alert-danger">'.$ERROR.'</div>';
		}
		?>
	</div>

	<div class="container center bread-container">
		<?php include_once(dirname(__FILE__) . '/bits/subheader.php');?>
	</div>
	<div class="container w-bg center">
		<form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" role="form">
			<div class="row">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-4 upload-info visible-xs">
							<h2>Photo Requirements</h2>
							<div class="header-desc">
								The photo needs to be taken at eye-level and straight on, so it's mostly symmetrical.<br/><br/>
								I will only draw what I can see in the photo you upload. If I don't see whiskers, for instance, no whiskers will be drawn. So please choose your photos carefully.
							</div>
						</div>
						<div class="col-sm-8">
							<?php
							if($order_pet_query_count > 1){
								echo '<img class="res-img" style="width:70%" src="' . $CDN_IMGS . 'img/cute_dog.jpg">';
							}else{
								echo '<img class="res-img" style="width:70%" src="' . $CDN_IMGS . 'img/cute_dog.jpg">';
							}
							?>
						</div>
						<div class="col-sm-4 upload-info">
							<h2 class="hidden-xs">Photo Requirements</h2>
							<div class="header-desc hidden-xs">
								The photo needs to be taken at eye-level and straight on, so it's mostly symmetrical.<br/><br/>
								I will only draw what I can see in the photo you upload. If I don't see whiskers, for instance, no whiskers will be included. So please choose your photos carefully.
							</div>
							<?php
							$i = 0;
							for($i;$i<$order_pet_query_count;$i++){
								echo '<h2>Upload a Photo of ';
								if(isset($order_pet_query[$i]['order_pet_name'][0])){
									echo $order_pet_query[$i]['order_pet_name'];
								}else{
									echo 'Pet ' . ($i + 1);
								}
								echo '</h2>'
									. '<div class="upload-desc">(.gif, .jpeg, .jpg, .png)</div>';
								$d = 1;
								for($d;$d<4;$d++){
									echo '<input type="file" name="' . ($i + 1) . '_' . $d . '" id="' . ($i + 1) . '_' . $d . '"';
									if($d == 1){
										echo ' required';
									}
									echo '>';
								}
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="row footer-row">
				<div class="col-sm-12">
					<input type="hidden" name="upload" value="Upload">
					<button type="submit" class="btn btn-lg btn-inverted btn-negative continue pull-right">Continue</button>
					<div class="pull-right t_c_host">By uploading a photo, you are agreeing to <a href="javascript:void(0);" class="t_c">these terms and conditions</a>.</div><br/>
				</div>

				<div class="col-sm-12">
					<div class="pull-right">
						<a href="javascript:void(0);" id="start_over">Start over</a>
					</div>
				</div>
			</div>
		</form>
	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	window.can_leave=<?php echo json_encode($order_pet_query_count > 1 ? false : true);?>;
	</script>
</body>
</html>