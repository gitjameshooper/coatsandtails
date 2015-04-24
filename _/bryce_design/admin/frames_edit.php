<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Frames - Edit';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$frames_title = $frames_price_desc = $frames_desc = '';
$offset_top = $offset_bottom = $offset_left = $offset_right = '';
$frames_price_8x10 = $frames_availability_8x10 = '';
$frames_price_11x14 = $frames_availability_11x14 = '';
$frames_price_16x20 = $frames_availability_16x20 = '';
$frames_price_20x24 = $frames_availability_20x24 = '';

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
			$frames_title = $get_frames_query[0]['frames_title'];
			$frames_price_desc = htmlspecialchars(str_replace("<br/>", "\r\n", htmlspecialchars_decode($get_frames_query[0]['frames_price_desc'])));
			$frames_desc = htmlspecialchars(str_replace("<br/>", "\r\n", htmlspecialchars_decode($get_frames_query[0]['frames_desc'])));

			$offset_top = $get_frames_query[0]['frames_offset_top'];
			$offset_bottom = $get_frames_query[0]['frames_offset_bottom'];
			$offset_left = $get_frames_query[0]['frames_offset_left'];
			$offset_right = $get_frames_query[0]['frames_offset_right'];

			$frames_price_8x10 = $get_frames_query[0]['frames_8x10_price'];
			$frames_availability_8x10 = $get_frames_query[0]['frames_8x10_availability'];

			$frames_price_11x14 = $get_frames_query[0]['frames_11x14_price'];
			$frames_availability_11x14 = $get_frames_query[0]['frames_11x14_availability'];

			$frames_price_16x20 = $get_frames_query[0]['frames_16x20_price'];
			$frames_availability_16x20 = $get_frames_query[0]['frames_16x20_availability'];

			$frames_price_20x24 = $get_frames_query[0]['frames_20x24_price'];
			$frames_availability_20x24 = $get_frames_query[0]['frames_20x24_availability'];
		}
	}
}else{
	closeConnections();
	header("Location:" . $BASE_URL . "admin/frames.php");
	exit();
}

if(isset($_POST['title'])){
	$title = trim(isSetAndNotDefault('', 'POST', 'title', true, 'Provide the title of the frame.'));
	$price_desc = trim(isSetAndNotDefault('', 'POST', 'price_desc', true, 'Provide the price description of the frame.'));
	$desc = trim(isSetAndNotDefault('', 'POST', 'desc', true, 'Provide the description of the frame.'));

	$offset_top = trim(isSetAndNotDefault('', 'POST', 'offset_top', false));
	$offset_bottom = trim(isSetAndNotDefault('', 'POST', 'offset_bottom', false));
	$offset_left = trim(isSetAndNotDefault('', 'POST', 'offset_left', false));
	$offset_right = trim(isSetAndNotDefault('', 'POST', 'offset_right', false));

	$price_8x10 = trim(isSetAndNotDefault('', 'POST', 'price_8x10', false));
	$availability_8x10 = trim(isSetAndNotDefault('', 'POST', 'availability_8x10', false));

	$price_11x14 = trim(isSetAndNotDefault('', 'POST', 'price_11x14', false));
	$availability_11x14 = trim(isSetAndNotDefault('', 'POST', 'availability_11x14', false));

	$price_16x20 = trim(isSetAndNotDefault('', 'POST', 'price_16x20', false));
	$availability_16x20 = trim(isSetAndNotDefault('', 'POST', 'availability_16x20', false));

	$price_20x24 = trim(isSetAndNotDefault('', 'POST', 'price_20x24', false));
	$availability_20x24 = trim(isSetAndNotDefault('', 'POST', 'availability_20x24', false));

	if($offset_top == ''){
		$offset_top = '0';
	}
	if(!is_numeric($offset_top)){
		appendError("The percentage of the top offset needs to be a numeric value.");
	}else if((float)$offset_top < 0){
		appendError("The percentage of the top offset needs to be a positive numeric value.");
	}else if((float)$offset_top > 100){
		appendError("The percentage of the top offset can not be larger than 100%.");
	}

	if($offset_bottom == ''){
		$offset_bottom = '0';
	}
	if(!is_numeric($offset_bottom)){
		appendError("The percentage of the bottom offset needs to be a numeric value.");
	}else if((float)$offset_bottom < 0){
		appendError("The percentage of the bottom offset needs to be a positive numeric value.");
	}else if((float)$offset_bottom > 100){
		appendError("The percentage of the bottom offset can not be larger than 100%.");
	}

	if($offset_left == ''){
		$offset_left = '0';
	}
	if(!is_numeric($offset_left)){
		appendError("The percentage of the left offset needs to be a numeric value.");
	}else if((float)$offset_left < 0){
		appendError("The percentage of the left offset needs to be a positive numeric value.");
	}else if((float)$offset_left > 100){
		appendError("The percentage of the left offset can not be larger than 100%.");
	}

	if($offset_right == ''){
		$offset_right = '0';
	}
	if(!is_numeric($offset_right)){
		appendError("The percentage of the right offset needs to be a numeric value.");
	}else if((float)$offset_right < 0){
		appendError("The percentage of the right offset needs to be a positive numeric value.");
	}else if((float)$offset_right > 100){
		appendError("The percentage of the right offset can not be larger than 100%.");
	}

	if($ERROR === ''){
		if(($price_8x10 != '') && ($price_8x10 != '0')){
			$price_8x10 = str_replace(',', '', $price_8x10);
			if(!is_numeric($price_8x10)){
				appendError("The price of the 8x10 frame needs to be a numeric value.");
			}else if((float)$price_8x10 < 0.01){
				appendError("The price of the 8x10 frame needs to be a numeric value larger than zero.");
			}
		}
		if(($availability_8x10 != '') && ($availability_8x10 != '0')){
			$availability_8x10 = str_replace(',', '', $availability_8x10);
			if(!is_numeric($availability_8x10)){
				$availability_8x10 = 0;
			}else if((float)$availability_8x10 < 1){
				$availability_8x10 = 0;
			}
		}

		if(($price_11x14 != '') && ($price_11x14 != '0')){
			$price_11x14 = str_replace(',', '', $price_11x14);
			if(!is_numeric($price_11x14)){
				appendError("The price of the 11x14 frame needs to be a numeric value.");
			}else if((float)$price_11x14 < 0.01){
				appendError("The price of the 11x14 frame needs to be a numeric value larger than zero.");
			}
		}
		if(($availability_11x14 != '') && ($availability_11x14 != '0')){
			$availability_11x14 = str_replace(',', '', $availability_11x14);
			if(!is_numeric($availability_11x14)){
				$availability_11x14 = 0;
			}else if((float)$availability_11x14 < 1){
				$availability_11x14 = 0;
			}
		}

		if(($price_16x20 != '') && ($price_16x20 != '0')){
			$price_16x20 = str_replace(',', '', $price_16x20);
			if(!is_numeric($price_16x20)){
				appendError("The price of the 16x20 frame needs to be a numeric value.");
			}else if((float)$price_16x20 < 0.01){
				appendError("The price of the 16x20 frame needs to be a numeric value larger than zero.");
			}
		}
		if(($availability_16x20 != '') && ($availability_16x20 != '0')){
			$availability_16x20 = str_replace(',', '', $availability_16x20);
			if(!is_numeric($availability_16x20)){
				$availability_16x20 = 0;
			}else if((float)$availability_16x20 < 1){
				$availability_16x20 = 0;
			}
		}

		if(($price_20x24 != '') && ($price_20x24 != '0')){
			$price_20x24 = str_replace(',', '', $price_20x24);
			if(!is_numeric($price_20x24)){
				appendError("The price of the 20x24 frame needs to be a numeric value.");
			}else if((float)$price_20x24 < 0.01){
				appendError("The price of the 20x24 frame needs to be a numeric value larger than zero.");
			}
		}
		if(($availability_20x24 != '') && ($availability_20x24 != '0')){
			$availability_20x24 = str_replace(',', '', $availability_20x24);
			if(!is_numeric($availability_20x24)){
				$availability_20x24 = 0;
			}else if((float)$availability_20x24 < 1){
				$availability_20x24 = 0;
			}
		}
	}
	if($ERROR === ''){
		$frames_title = $title;
		$frames_price_desc = htmlspecialchars(str_replace(array("\\r\\n", "\\n", "\\r"), "<br/>", $price_desc));
		$frames_desc = htmlspecialchars(str_replace(array("\\r\\n", "\\n", "\\r"), "<br/>", $desc));

		$frames_price_8x10 = $price_8x10;
		$frames_availability_8x10 = $availability_8x10;

		$frames_price_11x14 = $price_11x14;
		$frames_availability_11x14 = $availability_11x14;

		$frames_price_16x20 = $price_16x20;
		$frames_availability_16x20 = $availability_16x20;

		$frames_price_20x24 = $price_20x24;
		$frames_availability_20x24 = $availability_20x24;

		if($DB->sql("UPDATE frames SET
			frames_title='$frames_title',
			frames_price_desc='$frames_price_desc',
			frames_desc='$frames_desc',
			frames_offset_top='$offset_top',
			frames_offset_bottom='$offset_bottom',
			frames_offset_left='$offset_left',
			frames_offset_right='$offset_right',
			frames_8x10_price='$price_8x10',
			frames_8x10_availability='$availability_8x10',
			frames_11x14_price='$price_11x14',
			frames_11x14_availability='$availability_11x14',
			frames_16x20_price='$price_16x20',
			frames_16x20_availability='$availability_16x20',
			frames_20x24_price='$price_20x24',
			frames_20x24_availability='$availability_20x24'
			WHERE frames_id='$frames_id' LIMIT 1")){

			closeConnections();
			header("Location:" . $BASE_URL . "admin/frames_edit_imgs.php?id=" . $frames_id);
			exit();
		}else{
			appendError("An error occurred when updating the frame entry.");
		}
	}
}


closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin frames edit">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Edit Frame</h2>
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
						<label for="title" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-10">
							<input type="text" id="title" name="title" class="form-control" placeholder="The title of the frame" size="255" value="<?php echo stripslashes($frames_title);?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="price_desc" class="col-sm-2 control-label">Price Description</label>
						<div class="col-sm-10">
							<textarea id="price_desc" name="price_desc" placeholder="The price description of the frame" class="form-control" rows="5" required=""><?php echo str_replace("\\", "", textareaLineBreak($frames_price_desc));?></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="desc" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<textarea id="desc" name="desc" placeholder="The description of the frame" class="form-control" rows="5" required=""><?php echo str_replace("\\", "", textareaLineBreak($frames_desc));?></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="offset_top" class="col-sm-2 control-label">Top Offset</label>
						<div class="col-sm-10">
							<input type="number" id="offset_top" name="offset_top" class="form-control" placeholder="The percent of the top offset of the frame image" size="3" step="1" value="<?php echo $offset_top;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="offset_bottom" class="col-sm-2 control-label">Bottom Offset</label>
						<div class="col-sm-10">
							<input type="number" id="offset_bottom" name="offset_bottom" class="form-control" placeholder="The percent of the bottom offset of the frame image" size="3" step="1" value="<?php echo $offset_bottom;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="offset_left" class="col-sm-2 control-label">Left Offset</label>
						<div class="col-sm-10">
							<input type="number" id="offset_left" name="offset_left" class="form-control" placeholder="The percent of the left offset of the frame image" size="3" step="1" value="<?php echo $offset_left;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="offset_right" class="col-sm-2 control-label">Right Offset</label>
						<div class="col-sm-10">
							<input type="number" id="offset_right" name="offset_right" class="form-control" placeholder="The percent of the right offset of the frame image" size="3" step="1" value="<?php echo $offset_right;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="price_8x10" class="col-sm-2 control-label">8x10 Price</label>
						<div class="col-sm-10">
							<input type="number" id="price_8x10" name="price_8x10" class="form-control" placeholder="The price of the 8x10 frame" size="10" step="0.01" value="<?php echo number_format($frames_price_8x10, 2);?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="availability_8x10" class="col-sm-2 control-label">8x10 Availability</label>
						<div class="col-sm-10">
							<input type="number" id="availability_8x10" name="availability_8x10" class="form-control" placeholder="The availability of the 8x10 frame" size="10" step="1" value="<?php echo $frames_availability_8x10;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="price_11x14" class="col-sm-2 control-label">11x14 Price</label>
						<div class="col-sm-10">
							<input type="number" id="price_11x14" name="price_11x14" class="form-control" placeholder="The price of the 11x14 frame" size="10" step="0.01" value="<?php echo number_format($frames_price_11x14, 2);?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="availability_11x14" class="col-sm-2 control-label">11x14 Availability</label>
						<div class="col-sm-10">
							<input type="number" id="availability_11x14" name="availability_11x14" class="form-control" placeholder="The availability of the 11x14 frame" size="10" step="1" value="<?php echo $frames_availability_11x14;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="price_16x20" class="col-sm-2 control-label">16x20 Price</label>
						<div class="col-sm-10">
							<input type="number" id="price_16x20" name="price_16x20" class="form-control" placeholder="The price of the 16x20 frame" size="10" step="0.01" value="<?php echo number_format($frames_price_16x20, 2);?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="availability_16x20" class="col-sm-2 control-label">16x20 Availability</label>
						<div class="col-sm-10">
							<input type="number" id="availability_16x20" name="availability_16x20" class="form-control" placeholder="The availability of the 16x20 frame" size="10" step="1" value="<?php echo $frames_availability_16x20;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="price_20x24" class="col-sm-2 control-label">20x24 Price</label>
						<div class="col-sm-10">
							<input type="number" id="price_20x24" name="price_20x24" class="form-control" placeholder="The price of the 20x24 frame" size="10" step="0.01" value="<?php echo number_format($frames_price_20x24, 2);?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="availability_20x24" class="col-sm-2 control-label">20x24 Availability</label>
						<div class="col-sm-10">
							<input type="number" id="availability_20x24" name="availability_20x24" class="form-control" placeholder="The availability of the 20x24 frame" size="10" step="1" value="<?php echo $frames_availability_20x24;?>" required="">
						</div>
					</div>

					<input type="hidden" name="id" value="<?php echo $frames_id;?>">
					<button class="btn btn-lg btn-primary pull-right" type="submit">Update</button>
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