<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Merchandise - Add';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$merchandise_title = $merchandise_desc = $merchandise_status = '';
$category_id = $variant_count = '0';
$variant_label = array();
$variant_price = array();
$variant_availability = array();

$category = $DB->query("SELECT * FROM category ORDER BY category_id ASC LIMIT 1000");
$category_count = count($category);

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
		$merchandise_status = $status;

		if($DB->sql("INSERT INTO merchandise SET
			merchandise_title='$title',
			merchandise_desc='$desc',
			merchandise_status='$status',
			merchandise_category='$category_id',
			merchandise_addition_timestamp='$MICROTIME'")){
			$merchandise = $DB->query("SELECT * FROM merchandise WHERE merchandise_addition_timestamp='$MICROTIME' LIMIT 1");

			if($variant_count > 0){
				$i = 0;
				for($i;$i<$variant_count;$i++){
					$DB->sql("INSERT INTO merchandise_variant SET
						merchandise_variant_merchandise_id='" . $merchandise[0]['merchandise_id'] . "',
						merchandise_variant_label='" . $variant_label[$i] . "',
						merchandise_variant_price='" . $variant_price[$i] . "',
						merchandise_variant_availability='" . $variant_availability[$i] . "',
						merchandise_variant_addition_timestamp='$MICROTIME'");
				}
			}

			closeConnections();
			header("Location:" . $BASE_URL . "admin/merchandise_add_imgs.php?id=" . $merchandise[0]['merchandise_id']);
			exit();
		}else{
			appendError("An error occurred when adding the merchandise entry.");
		}
	}
}


closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin merchandise add">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Add Merchandise</h2>
				<?php
				if($ERROR !== ''){
					echo '<div class="alert alert-danger">'.$ERROR.'</div>';
				}
				if($SUCCESS !== ''){
					echo '<div class="alert alert-success">'.$SUCCESS.'</div>';
				}
				?>
				<form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" role="form" name="merchandise_form">

					<div class="form-group">
						<label for="title" class="col-sm-2 control-label">Title</label>
						<div class="col-sm-10">
							<input type="text" id="title" name="title" class="form-control" placeholder="The title of the merchandise" size="255" value="" required="">
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
									echo '<option value="' . $category[$i]['category_id'] . '">' . $category[$i]['category_title'] . '</option>';
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
							<a href="javascript:void(0);" class="pull-right add_variant" data-toggle="modal" data-target="#add_variant">Add variant</a>
							<input type="hidden" id="variant_count" name="variant_count" value="0">
						</div>
					</div>

					<div class="form-group">
						<label for="desc" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<textarea id="desc" name="desc" placeholder="The description of the merchandise" class="form-control" rows="5" required=""></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="status" class="col-sm-2 control-label">Status</label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="status" value="0"> Active
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="status" value="1" checked> Hidden
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="status" value="2"> Sold Out
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="status" value="3"> Coming Soon
							</label>
						</div>
					</div>

					<a href="javascript:void(0);" class="btn btn-lg btn-primary pull-right submit">Add</a>
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