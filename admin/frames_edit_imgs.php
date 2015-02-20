<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Frames - Edit Images';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$frame_input = array();
$frame_img_dirs = array(
	array('frame_bg', 'Background')
	);
$frame_img_dirs_count = count($frame_img_dirs);

if(isset($_REQUEST['id'])){
	$frames_id = isSetAndNotDefault('', 'REQUEST', 'id', true, 'Missing frame id.');
	if(!is_numeric($frames_id)){
		appendError("The provided frame id was not valid.");
	}
	if($ERROR !== ''){
		closeConnections();
		header("Location:" . $BASE_URL . "admin/frames.php");
		exit();
	}else{
		$get_frames_query = $DB->query("SELECT * FROM frames WHERE frames_id='$frames_id' LIMIT 1");
		if(!isset($get_frames_query[0])){
			closeConnections();
			header("Location:" . $BASE_URL . "admin/frames.php");
			exit();
		}else{
			$frame = array();
			$i = 0;
			for($i;$i<$frame_img_dirs_count;$i++){
				$frame_count = 0;
				$frame = $DB->query("SELECT frames_imgs_dir FROM frames_imgs WHERE frames_ref_id='$frames_id' ORDER BY frames_imgs_id ASC LIMIT 1000");
				$frame_count = count($frame);
			}
		}
	}
}else{
	closeConnections();
	header("Location:" . $BASE_URL . "admin/frames.php");
	exit();
}

if(isset($_POST['frame_bg_len'])){
	$frame_entries_count = 0;
	$frame_entries = array();

	$frame_input['url_list'] = isSetAndNotDefault('', 'POST', 'frame_bg_len', true, 'Missing the amount of image directory urls.');
	$frame_input['url_list_arr'] = explode(',', $frame_input['url_list']);
	$frame_input['url_list_count'] = count($frame_input['url_list_arr']);
	$i = 0;
	for($i;$i<$frame_input['url_list_count'];$i++){
		$temp = isSetAndNotDefault('', 'POST', $frame_input['url_list_arr'][$i], false);
		if(isset($temp[0])){
			array_push($frame_entries, $temp);
		}
	}
	$frame_entries_count = count($frame_entries);

	if($ERROR === ''){
		$i = 0;
		$DB->sql("DELETE FROM frames_imgs WHERE frames_ref_id='$frames_id'");

		for($i;$i<$frame_entries_count;$i++){
			$DB->sql("INSERT INTO frames_imgs SET
				frames_ref_id='$frames_id',
				frames_imgs_dir='" . $frame_entries[$i] . "'");
		}
		closeConnections();
		header("Location:" . $BASE_URL . "admin/frames.php");
		exit();
	}
}


closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin frames edit-imgs">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Add Frame Images</h2>
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
					if($frame_count > 0){
						$temp = array();
						$i = 0;
						echo '<div class="form-group">';
						for($i;$i<$frame_count;$i++){
							if($i == 0){
								echo '<label for="frame_bg" class="col-sm-2 control-label">Image Directories</label>';
							}else{
								echo '<div class="col-sm-2" id="frame_bg_' . ($i + 1) . '_pusher"></div>';
							}
							echo '<div class="col-sm-' . ($frame_count > 1 ? '9' : '10') . '">'
										. '<input type="text" id="frame_bg_' . ($i + 1) . '" name="frame_bg_' . ($i + 1) . '" class="form-control frame_bg"'
										. ' placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/frames/132845469/" size="255" value="' . $frame[$i]['frames_imgs_dir'] . '">'
									. '</div>';
							if($frame_count > 1){
								echo '<div class="col-sm-1">'
										. '<a href="javascript:void(0);" data-target="frame_bg_' . ($i + 1) . '" class="btn btn-xs btn-default btn-icon trash">'
											. '<span class="glyphicon glyphicon-trash"></span>'
										. '</a>'
									. '</div>';
							}
							array_push($temp, 'frame_bg_' . ($i + 1));
						}
						echo '</div>'
							. '<div class="form-group">'
								. '<div class="col-sm-12">'
									. '<input type="hidden" id="frame_bg_len" name="frame_bg_len" class="frame_bg_len" value="' . implode(',', $temp) . '">'
									. '<a href="javascript:void(0);" data-target="frame_bg" class="pull-right append_img_dir">Add another image</a>'
									. '<hr>'
								. '</div>'
							. '</div>';
					}else{
						echo '<div class="form-group">'
								. '<label for="frame_bg" class="col-sm-2 control-label">Image Directories</label>'
								. '<div class="col-sm-10">'
									. '<input type="text" id="frame_bg_1" name="frame_bg_1" class="form-control frame_bg" placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/frames/132845469/" size="255" value="">'
								. '</div>'
							. '</div>'
							. '<div class="form-group">'
								. '<div class="col-sm-12">'
									. '<input type="hidden" id="frame_bg_len" name="frame_bg_len" class="frame_bg_len" value="frame_bg_1">'
									. '<a href="javascript:void(0);" data-target="frame_bg" class="pull-right append_img_dir">Add another image</a>'
									. '<hr>'
								. '</div>'
							. '</div>';
					}
					?>

					<input type="hidden" name="id" value="<?php echo $frames_id;?>">
					<button class="btn btn-lg btn-primary pull-right" type="submit">Update "<?php echo stripslashes($get_frames_query[0]['frames_title']);?>"</button>
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