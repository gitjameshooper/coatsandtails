<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Frames - Add Images';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$frame_input = array();

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
	$k = 0;
	for($k;$k<$frame_input['url_list_count'];$k++){
		$temp = isSetAndNotDefault('', 'POST', $frame_input['url_list_arr'][$k], false);
		if(isset($temp[0])){
			array_push($frame_entries, $temp);
		}
	}
	$frame_entries_count = count($frame_entries);

	if($ERROR === ''){
		$i = 0;
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
<body class="admin frames add-imgs">

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

					<div class="form-group">
						<label for="frame_bg" class="col-sm-2 control-label">Image Directories</label>
						<div class="col-sm-10">
							<input type="text" id="frame_bg_1" name="frame_bg_1" class="form-control frame_bg" placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/frames/132845469/" size="255" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<input type="hidden" id="frame_bg_len" name="frame_bg_len" class="frame_bg_len" value="frame_bg_1">
							<a href="javascript:void(0);" data-target="frame_bg" class="pull-right append_img_dir">Add another image</a>
							<hr>
						</div>
					</div>

					<input type="hidden" name="id" value="<?php echo $frames_id;?>">
					<button class="btn btn-lg btn-primary pull-right" type="submit">Update "<?php echo $get_frames_query[0]['frames_title']?>"</button>
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