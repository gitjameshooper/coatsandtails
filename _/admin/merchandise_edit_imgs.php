<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Merchandise - Edit Images';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$merchandise_input = array();
$merchandise_img_dirs = array(
	array('merchandise_bg', 'Background')
	);
$merchandise_img_dirs_count = count($merchandise_img_dirs);

if(isset($_REQUEST['id'])){
	$merchandise_id = isSetAndNotDefault('', 'REQUEST', 'id', true, 'Missing merchandise id.');
	if(!is_numeric($merchandise_id)){
		appendError("The provided merchandise id was not valid.");
	}
	if($ERROR !== ''){
		closeConnections();
		header("Location:" . $BASE_URL . "admin/merchandise.php");
		exit();
	}else{
		$get_merchandise_query = $DB->query("SELECT * FROM merchandise WHERE merchandise_id='$merchandise_id' LIMIT 1");
		if(!isset($get_merchandise_query[0])){
			closeConnections();
			header("Location:" . $BASE_URL . "admin/merchandise.php");
			exit();
		}else{
			$merchandise = array();
			$i = 0;
			for($i;$i<$merchandise_img_dirs_count;$i++){
				$merchandise_count = 0;
				$merchandise = $DB->query("SELECT merchandise_imgs_dir FROM merchandise_imgs WHERE merchandise_ref_id='$merchandise_id' ORDER BY merchandise_imgs_id ASC LIMIT 1000");
				$merchandise_count = count($merchandise);
			}
		}
	}
}else{
	closeConnections();
	header("Location:" . $BASE_URL . "admin/merchandise.php");
	exit();
}

if(isset($_POST['merchandise_bg_len'])){
	$merchandise_entries_count = 0;
	$merchandise_entries = array();

	$merchandise_input['url_list'] = isSetAndNotDefault('', 'POST', 'merchandise_bg_len', true, 'Missing the amount of image directory urls.');
	$merchandise_input['url_list_arr'] = explode(',', $merchandise_input['url_list']);
	$merchandise_input['url_list_count'] = count($merchandise_input['url_list_arr']);
	$i = 0;
	for($i;$i<$merchandise_input['url_list_count'];$i++){
		$temp = isSetAndNotDefault('', 'POST', $merchandise_input['url_list_arr'][$i], false);
		if(isset($temp[0])){
			array_push($merchandise_entries, $temp);
		}
	}
	$merchandise_entries_count = count($merchandise_entries);

	if($ERROR === ''){
		$i = 0;
		$DB->sql("DELETE FROM merchandise_imgs WHERE merchandise_ref_id='$merchandise_id'");

		for($i;$i<$merchandise_entries_count;$i++){
			$DB->sql("INSERT INTO merchandise_imgs SET
				merchandise_ref_id='$merchandise_id',
				merchandise_imgs_dir='" . $merchandise_entries[$i] . "'");
		}
		closeConnections();
		header("Location:" . $BASE_URL . "admin/merchandise.php");
		exit();
	}
}


closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin merchandise edit-imgs">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Add Merchandise Images</h2>
				<?php
				if($ERROR !== ''){
					echo '<div class="alert alert-danger">'.$ERROR.'</div>';
				}
				if($SUCCESS !== ''){
					echo '<div class="alert alert-success">'.$SUCCESS.'</div>';
				}
				?>
				<form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" role="form">

					<?php
					if($merchandise_count > 0){
						$temp = array();
						$i = 0;
						echo '<div class="form-group">';
						for($i;$i<$merchandise_count;$i++){
							if($i == 0){
								echo '<label for="merchandise_bg" class="col-sm-2 control-label">Image Directories</label>';
							}else{
								echo '<div class="col-sm-2" id="merchandise_bg_' . ($i + 1) . '_pusher"></div>';
							}
							echo '<div class="col-sm-' . ($merchandise_count > 1 ? '9' : '10') . '">'
										. '<input type="text" id="merchandise_bg_' . ($i + 1) . '" name="merchandise_bg_' . ($i + 1) . '" class="form-control merchandise_bg"'
										. ' placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/merchandise/132845469/" size="255" value="' . $merchandise[$i]['merchandise_imgs_dir'] . '">'
									. '</div>';
							if($merchandise_count > 1){
								echo '<div class="col-sm-1">'
										. '<a href="javascript:void(0);" data-target="merchandise_bg_' . ($i + 1) . '" class="btn btn-xs btn-default btn-icon trash">'
											. '<span class="glyphicon glyphicon-trash"></span>'
										. '</a>'
									. '</div>';
							}
							array_push($temp, 'merchandise_bg_' . ($i + 1));
						}
						echo '</div>'
							. '<div class="form-group">'
								. '<div class="col-sm-12">'
									. '<input type="hidden" id="merchandise_bg_len" name="merchandise_bg_len" class="merchandise_bg_len" value="' . implode(',', $temp) . '">'
									. '<a href="javascript:void(0);" data-target="merchandise_bg" class="pull-right append_img_dir">Add another image</a>'
									. '<hr>'
								. '</div>'
							. '</div>';
					}else{
						echo '<div class="form-group">'
								. '<label for="merchandise_bg" class="col-sm-2 control-label">Image Directories</label>'
								. '<div class="col-sm-10">'
									. '<input type="text" id="merchandise_bg_1" name="merchandise_bg_1" class="form-control merchandise_bg" placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/merchandise/132845469/" size="255" value="">'
								. '</div>'
							. '</div>'
							. '<div class="form-group">'
								. '<div class="col-sm-12">'
									. '<input type="hidden" id="merchandise_bg_len" name="merchandise_bg_len" class="merchandise_bg_len" value="merchandise_bg_1">'
									. '<a href="javascript:void(0);" data-target="merchandise_bg" class="pull-right append_img_dir">Add another image</a>'
									. '<hr>'
								. '</div>'
							. '</div>';
					}
					?>

					<input type="hidden" name="id" value="<?php echo $merchandise_id;?>">
					<button class="btn btn-lg btn-primary pull-right" type="submit">Update "<?php echo stripslashes($get_merchandise_query[0]['merchandise_title']);?>"</button>
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