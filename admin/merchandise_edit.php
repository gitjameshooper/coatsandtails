<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Merchandise - Edit';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$merchandise_title = $merchandise_desc = $merchandise_status = '';
$merchandise_category = $variant_count = '0';
$variant_id = array();
$variant_label = array();
$variant_price = array();
$variant_availability = array();

$category = $DB->query("SELECT * FROM category ORDER BY category_id ASC LIMIT 1000");
$category_count = count($category);

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
			$merchandise_variants = $DB->query("SELECT * FROM merchandise_variant WHERE merchandise_variant_merchandise_id='$merchandise_id' ORDER BY merchandise_variant_id DESC LIMIT 1000");

			$merchandise_title = $get_merchandise_query[0]['merchandise_title'];
			$merchandise_desc = htmlspecialchars(str_replace("<br/>", "\r\n", htmlspecialchars_decode($get_merchandise_query[0]['merchandise_desc'])));
			$merchandise_category = $get_merchandise_query[0]['merchandise_category'];
			$merchandise_status = $get_merchandise_query[0]['merchandise_status'];
		}
	}
}else{
	closeConnections();
	header("Location:" . $BASE_URL . "admin/merchandise.php");
	exit();
}

if(isset($_POST['title'])){
	$title = trim(isSetAndNotDefault('', 'POST', 'title', true, 'Provide the title of the merchandise.'));
	$desc = trim(isSetAndNotDefault('', 'POST', 'desc', true, 'Provide the description of the merchandise.'));
	$category_id = trim(isSetAndNotDefault('', 'POST', 'category', false));
	$status = trim(isSetAndNotDefault('', 'POST', 'status', false));

	$variant_count = trim(isSetAndNotDefault('', 'POST', 'variant_count', false));

	if($ERROR === ''){

		if(!is_numeric($variant_count)){
			$variant_count = 0;
		}else if((int)$variant_count != $variant_count){
			$variant_count = 0;
		}else if((int)$variant_count < 0){
			$variant_count = 0;
		}else{
			$variant_count = (int)$variant_count;
		}
		if($variant_count > 0){
			$i = 0;
			for($i;$i<$variant_count;$i++){
				$variant_id[$i] = trim(isSetAndNotDefault('', 'POST', 'variable_id_' . $i, false));
				$variant_label[$i] = trim(isSetAndNotDefault('', 'POST', 'variable_label_' . $i, true, 'Provide the label of the variant ' . ($i + 1)));
				$variant_price[$i] = trim(isSetAndNotDefault('', 'POST', 'variable_price_' . $i, true, 'Provide the price of the variant ' . ($i + 1)));
				$variant_availability[$i] = trim(isSetAndNotDefault('', 'POST', 'variable_availability_' . $i, true, 'Provide the availability of the variant ' . ($i + 1)));
			}
		}

		if(!is_numeric($status)){
			$status = 1;
		}else if((int)$status < 0){
			$status = 1;
		}
	}
	if($ERROR === ''){
		$merchandise_title = $title;
		$merchandise_desc = htmlspecialchars(str_replace(array("\\r\\n", "\\n", "\\r"), "<br/>", $desc));
		$merchandise_category = $category_id;
		$merchandise_status = $status;

		if($DB->sql("UPDATE merchandise SET
			merchandise_title='$merchandise_title',
			merchandise_desc='$merchandise_desc',
			merchandise_status='$merchandise_status',
			merchandise_category='$merchandise_category'
			WHERE merchandise_id='$merchandise_id' LIMIT 1")){

			if($variant_count > 0){
				$i = 0;
				for($i;$i<$variant_count;$i++){

					$variant_query = $DB->query("SELECT * FROM merchandise_variant WHERE merchandise_variant_id='" . $variant_id[$i] . "' LIMIT 1");

					if(count($variant_query) == 0){
						$DB->sql("INSERT INTO merchandise_variant SET
							merchandise_variant_merchandise_id='$merchandise_id',
							merchandise_variant_label='" . $variant_label[$i] . "',
							merchandise_variant_price='" . $variant_price[$i] . "',
							merchandise_variant_availability='" . $variant_availability[$i] . "',
							merchandise_variant_addition_timestamp='$MICROTIME'");
					}else{
						$DB->sql("UPDATE merchandise_variant SET
							merchandise_variant_label='" . $variant_label[$i] . "',
							merchandise_variant_price='" . $variant_price[$i] . "',
							merchandise_variant_availability='" . $variant_availability[$i] . "'
							WHERE merchandise_variant_id='" . $variant_id[$i] . "' LIMIT 1");
					}
				}
			}else{
				$DB->sql("DELETE FROM merchandise_variant WHERE merchandise_variant_merchandise_id='$merchandise_id'");
			}

			closeConnections();
			header("Location:" . $BASE_URL . "admin/merchandise_edit_imgs.php?id=" . $merchandise_id);
			exit();
		}else{
			appendError("An error occurred when updating the merchandise entry.");
		}
	}
}


closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin merchandise edit">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Edit Merchandise</h2>
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
							<input type="text" id="title" name="title" class="form-control" placeholder="The title of the merchandise" size="255" value="<?php echo stripslashes($merchandise_title);?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="category" class="col-sm-2 control-label">Category</label>
						<div class="col-sm-10">
							<select class="form-control" id="category" name="category">
								<option value="0">No Category</option>
								<?php
								$i = 0;
								for($i;$i<$category_count;$i++){
									echo '<option value="' . $category[$i]['category_id'] . '"';
									if($merchandise_category == $category[$i]['category_id']){
										echo ' selected';
									}
									echo '>' . $category[$i]['category_title'] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<a href="javascript:void(0);" class="pull-right add_category" data-toggle="modal" data-target="#add_category">Add category</a>
						</div>
					</div>

					<div class="form-group">
						<label for="variant" class="col-sm-2 control-label">Variant</label>
						<div class="col-sm-10 variant-host">
							<?php
							$merchandise_variant_count = count($merchandise_variants);
							if($merchandise_variant_count > 0){
								$i = 0;
								for($i;$i<$merchandise_variant_count;$i++){
									echo '<div id="variant_' . $i . '" class="row variant_entry">'
										. '<div class="col-sm-5">'
											. '<input type="text" id="variable_label_' . $i . '" name="variable_label_' . $i . '" class="form-control variable_label" placeholder="The label of the variant" size="100" value="' . $merchandise_variants[$i]['merchandise_variant_label'] . '">'
										. '</div>'
										. '<div class="col-sm-3">'
											. '<input type="number" id="variable_price_' . $i . '" name="variable_price_' . $i . '" class="form-control variable_price" placeholder="The price of the variant" size="10" step="0.01" min="0" value="' . $merchandise_variants[$i]['merchandise_variant_price'] . '">'
										. '</div>'
										. '<div class="col-sm-3">'
											. '<input type="number" id="variable_availability_' . $i . '" name="variable_availability_' . $i . '" class="form-control variable_availability" placeholder="The availability of the variant" size="6" step="1" min="0" value="' . $merchandise_variants[$i]['merchandise_variant_availability'] . '">'
										. '</div>'
										. '<div class="col-sm-1">'
											. '<input type="hidden" name="variable_id_' . $i . '" class="variable_id" value="' . $merchandise_variants[$i]['merchandise_variant_id'] . '">'
											. '<a href="javascript:void(0);" data-target="variant_' . $i . '" class="btn btn-xs btn-default btn-icon trash">'
												. '<span class="glyphicon glyphicon-trash"></span>'
											. '</a>'
										. '</div>'
									. '</div>';
								}
							}
							?>
							<a href="javascript:void(0);" class="pull-right add_variant" data-toggle="modal" data-target="#add_variant">Add variant</a>
							<input type="hidden" id="variant_count" name="variant_count" value="<?php echo $merchandise_variant_count;?>">
						</div>
					</div>

					<div class="form-group">
						<label for="desc" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<textarea id="desc" name="desc" placeholder="The description of the merchandise" class="form-control" rows="5" required=""><?php echo str_replace("\\", "", textareaLineBreak($merchandise_desc));?></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="status" value="0"<?php if($merchandise_status == '0'){echo ' checked';}?>> Active
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="status" value="1"<?php if($merchandise_status == '1'){echo ' checked';}?>> Hidden
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="status" value="2"<?php if($merchandise_status == '2'){echo ' checked';}?>> Sold Out
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="status" value="3"<?php if($merchandise_status == '3'){echo ' checked';}?>> Coming Soon
							</label>
						</div>
					</div>

					<input type="hidden" name="id" value="<?php echo $merchandise_id;?>">
					<button class="btn btn-lg btn-primary pull-right" type="submit">Update</button>
				</form>
			</div>
		</div>

	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>

<div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="add_categoryLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="add_categoryLabel">Add Category</h4>
      </div>
      <div class="modal-body">
				<input type="text" id="category_title" class="form-control" placeholder="The name of the new category" size="100" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_new_category">Save</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>