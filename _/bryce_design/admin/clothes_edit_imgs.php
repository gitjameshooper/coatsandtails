<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Clothes - Edit Images';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$dog_input = array();
$cat_input = array();
$dog_img_dirs = array(
	array('dog_bg', 'Background'),
	array('dog_label_1', 'Label 1'),
	array('dog_label_2', 'Label 2'),
	array('dog_label_3', 'Label 3'),
	array('dog_label_4', 'Label 4')
	);
$cat_img_dirs = array(
	array('cat_bg', 'Background'),
	array('cat_label_1', 'Label 1'),
	array('cat_label_2', 'Label 2'),
	array('cat_label_3', 'Label 3'),
	array('cat_label_4', 'Label 4')
	);
$dog_img_dirs_count = count($dog_img_dirs);
$cat_img_dirs_count = count($cat_img_dirs);

if(isset($_REQUEST['id'])){
	$clothes_id = isSetAndNotDefault('', 'REQUEST', 'id', true, 'Missing clothe id.');
	if(!is_numeric($clothes_id)){
		appendError("The provided clothe id was not valid.");
	}
	if($ERROR !== ''){
		closeConnections();
		header("Location:" . $BASE_URL . "admin/clothes.php");
		exit();
	}else{
		$get_clothes_query = $DB->query("SELECT * FROM clothes WHERE clothes_id='$clothes_id' LIMIT 1");
		if(!isset($get_clothes_query[0])){
			closeConnections();
			header("Location:" . $BASE_URL . "admin/clothes.php");
			exit();
		}else{
			$dog = array();
			$i = 0;
			for($i;$i<$dog_img_dirs_count;$i++){
				$dog[$dog_img_dirs[$i][0] . '_count'] = 0;
				$temp = $DB->query("SELECT clothes_imgs_dir FROM clothes_imgs WHERE clothes_ref_id='$clothes_id' AND clothes_imgs_type='" . $dog_img_dirs[$i][0] . "' ORDER BY clothes_imgs_id ASC LIMIT 1000");
				if(isset($temp[0])){
					$dog[$dog_img_dirs[$i][0]] = $temp;
					$dog[$dog_img_dirs[$i][0] . '_count'] = count($dog[$dog_img_dirs[$i][0]]);
				}
			}
			$cat = array();
			$i = 0;
			for($i;$i<$cat_img_dirs_count;$i++){
				$cat[$cat_img_dirs[$i][0] . '_count'] = 0;
				$temp = $DB->query("SELECT clothes_imgs_dir FROM clothes_imgs WHERE clothes_ref_id='$clothes_id' AND clothes_imgs_type='" . $cat_img_dirs[$i][0] . "' ORDER BY clothes_imgs_id ASC LIMIT 1000");
				if(isset($temp[0])){
					$cat[$cat_img_dirs[$i][0]] = $temp;
					$cat[$cat_img_dirs[$i][0] . '_count'] = count($cat[$cat_img_dirs[$i][0]]);
				}
			}
		}
	}
}else{
	closeConnections();
	header("Location:" . $BASE_URL . "admin/clothes.php");
	exit();
}

if(isset($_POST['dog_bg_len'])){
	$dog_entries_count = 0;
	$dog_entries = array();
	$i = 0;
	for($i;$i<$dog_img_dirs_count;$i++){
		$dog_input[$i] = array();
		$dog_input[$i]['url_list'] = isSetAndNotDefault('', 'POST', $dog_img_dirs[$i][0] . '_len', true, 'Missing the amount of urls for ' . $dog_img_dirs[$i][1]);
		$dog_input[$i]['url_list_arr'] = explode(',', $dog_input[$i]['url_list']);
		$dog_input[$i]['url_list_count'] = count($dog_input[$i]['url_list_arr']);
		$k = 0;
		for($k;$k<$dog_input[$i]['url_list_count'];$k++){
			$temp = isSetAndNotDefault('', 'POST', $dog_input[$i]['url_list_arr'][$k], false);
			if(isset($temp[0])){
				array_push($dog_entries, array($temp, $dog_img_dirs[$i][0]));
			}
		}
	}
	$dog_entries_count = count($dog_entries);

	$cat_entries_count = 0;
	$cat_entries = array();
	$i = 0;
	for($i;$i<$cat_img_dirs_count;$i++){
		$cat_input[$i] = array();
		$cat_input[$i]['url_list'] = isSetAndNotDefault('', 'POST', $cat_img_dirs[$i][0] . '_len', true, 'Missing the amount of urls for ' . $cat_img_dirs[$i][1]);
		$cat_input[$i]['url_list_arr'] = explode(',', $cat_input[$i]['url_list']);
		$cat_input[$i]['url_list_count'] = count($cat_input[$i]['url_list_arr']);
		$k = 0;
		for($k;$k<$cat_input[$i]['url_list_count'];$k++){
			$temp = isSetAndNotDefault('', 'POST', $cat_input[$i]['url_list_arr'][$k], false);
			if(isset($temp[0])){
				array_push($cat_entries, array($temp, $cat_img_dirs[$i][0]));
			}
		}
	}
	$cat_entries_count = count($cat_entries);

	if($ERROR === ''){
		$i = 0;
		$DB->sql("DELETE FROM clothes_imgs WHERE clothes_ref_id='$clothes_id'");

		for($i;$i<$dog_entries_count;$i++){
			$DB->sql("INSERT INTO clothes_imgs SET
				clothes_ref_id='$clothes_id',
				clothes_imgs_type='" . $dog_entries[$i][1] . "',
				clothes_imgs_dir='" . $dog_entries[$i][0] . "',
				clothes_imgs_animal='0'");
		}
		$i = 0;
		for($i;$i<$cat_entries_count;$i++){
			$DB->sql("INSERT INTO clothes_imgs SET
				clothes_ref_id='$clothes_id',
				clothes_imgs_type='" . $cat_entries[$i][1] . "',
				clothes_imgs_dir='" . $cat_entries[$i][0] . "',
				clothes_imgs_animal='1'");
		}
		closeConnections();
		header("Location:" . $BASE_URL . "admin/clothes.php");
		exit();
	}
}


closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin clothes edit-imgs">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Add Clothe Images</h2>
				<?php
				if($ERROR !== ''){
					echo '<div class="alert alert-danger">'.$ERROR.'</div>';
				}
				if($SUCCESS !== ''){
					echo '<div class="alert alert-success">'.$SUCCESS.'</div>';
				}
				?>
				<form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" role="form">

					<div class="form-group">
						<h2 class="col-sm-2 control-label">Dog</h2>
					</div>

					<?php
					$i = 0;
					for($i;$i<$dog_img_dirs_count;$i++){
						if($dog[$dog_img_dirs[$i][0] . '_count'] > 0){
							$temp = array();
							$k = 0;
							echo '<div class="form-group">';
							for($k;$k<$dog[$dog_img_dirs[$i][0] . '_count'];$k++){
								if($k == 0){
									echo '<label for="' . $dog_img_dirs[$i][0] . '" class="col-sm-2 control-label">' . $dog_img_dirs[$i][1] . '</label>';
								}else{
									echo '<div class="col-sm-2" id="' . $dog_img_dirs[$i][0] . '_' . ($k + 1) . '_pusher"></div>';
								}
								echo '<div class="col-sm-' . ($dog[$dog_img_dirs[$i][0] . '_count'] > 1 ? '9' : '10') . '">'
											. '<input type="text" id="' . $dog_img_dirs[$i][0] . '_' . ($k + 1) . '" name="' . $dog_img_dirs[$i][0] . '_' . ($k + 1) . '" class="form-control ' . $dog_img_dirs[$i][0] . '"'
											. ' placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/clothes/dogs/132845469/" size="255" value="' . $dog[$dog_img_dirs[$i][0]][$k]['clothes_imgs_dir'] . '">'
										. '</div>';
								if($dog[$dog_img_dirs[$i][0] . '_count'] > 1){
									echo '<div class="col-sm-1">'
											. '<a href="javascript:void(0);" data-target="' . $dog_img_dirs[$i][0] . '_' . ($k + 1) . '" class="btn btn-xs btn-default btn-icon trash">'
												. '<span class="glyphicon glyphicon-trash"></span>'
											. '</a>'
										. '</div>';
								}
								array_push($temp, $dog_img_dirs[$i][0] . '_' . ($k + 1));
							}
							echo '</div>'
								. '<div class="form-group">'
									. '<div class="col-sm-12">'
										. '<input type="hidden" id="' . $dog_img_dirs[$i][0] . '_len" name="' . $dog_img_dirs[$i][0] . '_len" class="' . $dog_img_dirs[$i][0] . '_len" value="' . implode(',', $temp) . '">'
										. '<a href="javascript:void(0);" data-target="' . $dog_img_dirs[$i][0] . '" class="pull-right append_img_dir">Add another image</a>'
										. '<hr>'
									. '</div>'
								. '</div>';
						}else{
							echo '<div class="form-group">'
									. '<label for="' . $dog_img_dirs[$i][0] . '" class="col-sm-2 control-label">' . $dog_img_dirs[$i][1] . '</label>'
									. '<div class="col-sm-10">'
										. '<input type="text" id="' . $dog_img_dirs[$i][0] . '_1" name="' . $dog_img_dirs[$i][0] . '_1" class="form-control ' . $dog_img_dirs[$i][0] . '" placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/clothes/dogs/132845469/" size="255" value="">'
									. '</div>'
								. '</div>'
								. '<div class="form-group">'
									. '<div class="col-sm-12">'
										. '<input type="hidden" id="' . $dog_img_dirs[$i][0] . '_len" name="' . $dog_img_dirs[$i][0] . '_len" class="' . $dog_img_dirs[$i][0] . '_len" value="' . $dog_img_dirs[$i][0] . '_1">'
										. '<a href="javascript:void(0);" data-target="' . $dog_img_dirs[$i][0] . '" class="pull-right append_img_dir">Add another image</a>'
										. '<hr>'
									. '</div>'
								. '</div>';
						}
					}
					?>

					<div class="form-group">
						<h2 class="col-sm-2 control-label">Cat</h2>
					</div>

					<?php
					$i = 0;
					for($i;$i<$cat_img_dirs_count;$i++){
						if($cat[$cat_img_dirs[$i][0] . '_count'] > 0){
							$temp = array();
							$k = 0;
							echo '<div class="form-group">';
							for($k;$k<$cat[$cat_img_dirs[$i][0] . '_count'];$k++){
								if($k == 0){
									echo '<label for="' . $cat_img_dirs[$i][0] . '" class="col-sm-2 control-label">' . $cat_img_dirs[$i][1] . '</label>';
								}else{
									echo '<div class="col-sm-2" id="' . $cat_img_dirs[$i][0] . '_' . ($k + 1) . '_pusher"></div>';
								}
								echo '<div class="col-sm-' . ($cat[$cat_img_dirs[$i][0] . '_count'] > 1 ? '9' : '10') . '">'
											. '<input type="text" id="' . $cat_img_dirs[$i][0] . '_' . ($k + 1) . '" name="' . $cat_img_dirs[$i][0] . '_' . ($k + 1) . '" class="form-control ' . $cat_img_dirs[$i][0] . '"'
											. ' placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/clothes/cats/132845469/" size="255" value="' . $cat[$cat_img_dirs[$i][0]][$k]['clothes_imgs_dir'] . '">'
										. '</div>';
								if($cat[$cat_img_dirs[$i][0] . '_count'] > 1){
									echo '<div class="col-sm-1">'
											. '<a href="javascript:void(0);" data-target="' . $cat_img_dirs[$i][0] . '_' . ($k + 1) . '" class="btn btn-xs btn-default btn-icon trash">'
												. '<span class="glyphicon glyphicon-trash"></span>'
											. '</a>'
										. '</div>';
								}
								array_push($temp, $cat_img_dirs[$i][0] . '_' . ($k + 1));
							}
							echo '</div>'
								. '<div class="form-group">'
									. '<div class="col-sm-12">'
										. '<input type="hidden" id="' . $cat_img_dirs[$i][0] . '_len" name="' . $cat_img_dirs[$i][0] . '_len" class="' . $cat_img_dirs[$i][0] . '_len" value="' . implode(',', $temp) . '">'
										. '<a href="javascript:void(0);" data-target="' . $cat_img_dirs[$i][0] . '" class="pull-right append_img_dir">Add another image</a>'
										. '<hr>'
									. '</div>'
								. '</div>';
						}else{
							echo '<div class="form-group">'
									. '<label for="' . $cat_img_dirs[$i][0] . '" class="col-sm-2 control-label">' . $cat_img_dirs[$i][1] . '</label>'
									. '<div class="col-sm-10">'
										. '<input type="text" id="' . $cat_img_dirs[$i][0] . '_1" name="' . $cat_img_dirs[$i][0] . '_1" class="form-control ' . $cat_img_dirs[$i][0] . '" placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/clothes/cats/132845469/" size="255" value="">'
									. '</div>'
								. '</div>'
								. '<div class="form-group">'
									. '<div class="col-sm-12">'
										. '<input type="hidden" id="' . $cat_img_dirs[$i][0] . '_len" name="' . $cat_img_dirs[$i][0] . '_len" class="' . $cat_img_dirs[$i][0] . '_len" value="' . $cat_img_dirs[$i][0] . '_1">'
										. '<a href="javascript:void(0);" data-target="' . $cat_img_dirs[$i][0] . '" class="pull-right append_img_dir">Add another image</a>'
										. '<hr>'
									. '</div>'
								. '</div>';
						}
					}
					?>

					<input type="hidden" name="id" value="<?php echo $clothes_id;?>">
					<button class="btn btn-lg btn-primary pull-right" type="submit">Update "<?php echo $get_clothes_query[0]['clothes_title']?>"</button>
				</form>
			</div>
		</div>

	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
</body>
</html>