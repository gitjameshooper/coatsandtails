<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Promotional Codes - Edit';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$promo_codes_title = '';
$promo_codes_condition = '';
$promo_codes_condition_limit = '';
$promo_codes_code = '';
$promo_codes_type = '';
$promo_codes_discount = '0';
$promo_codes_applied_to = '';
$promo_codes_applied_to_item_id = '0';
$promo_codes_applied_to_item_type = '';
$promo_codes_starting_timestamp = '';
$promo_codes_ending_condition = '';
$promo_codes_ending_timestamp = '';
$promo_codes_applied_to_item_title = '';


if(isset($_REQUEST['id'])){
	$promo_codes_id = isSetAndNotDefault('', 'REQUEST', 'id', true, 'Missing promo_code id.');
	if(!is_numeric($promo_codes_id)){
		appendError("The provided promo_code id was not valid.");
	}
	if($ERROR !== ''){
		closeConnections();
		header("Location:" . $BASE_URL . "admin/promo_codes.php");
		exit();
	}else{
		$get_promo_codes_query = $DB->query("SELECT * FROM promo_codes WHERE promo_codes_id='$promo_codes_id' LIMIT 1");
		if(!isset($get_promo_codes_query[0])){
			closeConnections();
			header("Location:" . $BASE_URL . "admin/promo_codes.php");
			exit();
		}else{
			$promo_codes_title = $get_promo_codes_query[0]['promo_codes_title'];
			$promo_codes_condition = $get_promo_codes_query[0]['promo_codes_condition'];
			$promo_codes_condition_limit = $get_promo_codes_query[0]['promo_codes_condition_limit'];
			$promo_codes_code = $get_promo_codes_query[0]['promo_codes_code'];
			$promo_codes_type = $get_promo_codes_query[0]['promo_codes_type'];
			$promo_codes_discount = $get_promo_codes_query[0]['promo_codes_discount'];
			$promo_codes_applied_to = $get_promo_codes_query[0]['promo_codes_applied_to'];
			$promo_codes_applied_to_item_id = $get_promo_codes_query[0]['promo_codes_applied_to_item_id'];
			$promo_codes_applied_to_item_type = $get_promo_codes_query[0]['promo_codes_applied_to_item_type'];
			$promo_codes_starting_timestamp = $get_promo_codes_query[0]['promo_codes_starting_timestamp'];
			$promo_codes_ending_condition = $get_promo_codes_query[0]['promo_codes_ending_condition'];
			$promo_codes_ending_timestamp = $get_promo_codes_query[0]['promo_codes_ending_timestamp'];
			if((int)$promo_codes_applied_to_item_id != 0){
				if($promo_codes_applied_to_item_type == 'frame'){
					$frames_title_query = $DB->query("SELECT * FROM frames WHERE frames_id='$promo_codes_applied_to_item_id' LIMIT 1");
					if(count($frames_title_query) > 0){
						$promo_codes_applied_to_item_title = $frames_title_query[0]['frames_title'] . ' (frame)';
					}
				}else if($promo_codes_applied_to_item_type == 'clothe'){
					$clothes_title_query = $DB->query("SELECT * FROM clothes WHERE clothes_id='$promo_codes_applied_to_item_id' LIMIT 1");
					if(count($clothes_title_query) > 0){
						$promo_codes_applied_to_item_title = $clothes_title_query[0]['clothes_title'] . ' (clothe)';
					}
				}else if($promo_codes_applied_to_item_type == 'merchandise'){
					$merchandise_title_query = $DB->query("SELECT * FROM merchandise WHERE merchandise_id='$promo_codes_applied_to_item_id' LIMIT 1");
					if(count($merchandise_title_query) > 0){
						$promo_codes_applied_to_item_title = $merchandise_title_query[0]['merchandise_title'] . ' (merchandise)';
					}
				}
			}
		}
	}
}else{
	closeConnections();
	header("Location:" . $BASE_URL . "admin/promo_codes.php");
	exit();
}

if(isset($_POST['title'])){
	$title = trim(isSetAndNotDefault('', 'POST', 'title', true, 'Provide the title of the promotional code.'));
	$condition = isSetAndNotDefault('', 'POST', 'condition', true, 'Provide the condition under which the promotional code will be applied.');
	$condition_limit = isSetAndNotDefault('', 'POST', 'condition_limit', false);
	$code = trim(isSetAndNotDefault('', 'POST', 'code', true, 'Provide the code of the promotional code.'));
	$type = isSetAndNotDefault('', 'POST', 'type', true, 'Specify what type of discount will be provided.');
	$discount_perc = isSetAndNotDefault('', 'POST', 'discount_perc', false);
	$discount_flat = isSetAndNotDefault('', 'POST', 'discount_flat', false);
	$applied_to = isSetAndNotDefault('', 'POST', 'applied_to', true, 'Specify on what the promotional code will be applied.');
	$applied_to_item = isSetAndNotDefault('', 'POST', 'applied_to_item', false);
	$applied_to_item_type = isSetAndNotDefault('', 'POST', 'applied_to_item_type', false);
	$starting = isSetAndNotDefault('', 'POST', 'starting', true, 'Specify from when the promotional code will be applicable.');
	$starting_timestamp = isSetAndNotDefault('', 'POST', 'starting_date', false);
	$ending = isSetAndNotDefault('', 'POST', 'ending', true, 'Specify from when the promotional code will be applicable.');
	$ending_timestamp = isSetAndNotDefault('', 'POST', 'ending_date', false);

	if($condition != '1'){
		$condition = '0';
	}
	if($condition_limit == ''){
		$condition_limit = '0';
	}
	if($condition == '1'){
		if(!is_numeric($condition_limit)){
			appendError("The minimum price the order should be for the code to be applicable needs to be a numeric value.");
		}else if((float)$condition_limit < 0){
			appendError("The minimum price the order should be for the code to be applicable needs to be a positive numeric value.");
		}
	}

	if(((int)$type < '0') || ((int)$type > '2')){
		$type = '0';
	}
	if($discount_perc == ''){
		$discount_perc = '0';
	}
	if($discount_flat == ''){
		$discount_flat = '0';
	}
	if($type == '1'){
		if(!is_numeric($discount_perc)){
			appendError("The percentage that is discounted needs to be a numeric value.");
		}else if((float)$discount_perc < 0){
			appendError("The percentage that is discounted needs to be a positive numeric value.");
		}else if((float)$discount_perc > 100){
			appendError("The percentage that is discounted can not be larger than 100%.");
		}else{
			$promo_codes_discount = $discount_perc;
		}
	}else if($type == '2'){
		if(!is_numeric($discount_flat)){
			appendError("The amount that is discounted needs to be a numeric value.");
		}else if((float)$discount_flat < 0){
			appendError("The amount that is discounted needs to be a positive numeric value.");
		}else{
			$promo_codes_discount = $discount_flat;
		}
	}else{
		$promo_codes_discount = '0';
	}

	if(((int)$applied_to < '0') || ((int)$applied_to > '2')){
		$applied_to = '0';
	}
	if($applied_to_item == ''){
		$applied_to_item = '0';
		$applied_to_item_type = '';
	}

	if($starting != '1'){
		$starting_timestamp = $MICROTIME;
	}else{
		$starting_timestamp = strtotime($starting_timestamp);
	}

	if(((int)$ending < '0') || ((int)$ending > '2')){
		$ending = '0';
	}
	if($ending != '1'){
		$ending_timestamp = '0';
	}else{
		$ending_timestamp = strtotime($ending_timestamp);
	}

	if((($starting == '1') && ($ending == '1')) && ($starting_timestamp > $ending_timestamp)){
		appendError("The start date can not be greater then the end date");
	}

	if($ERROR === ''){
		$promo_codes_title = $title;
		$promo_codes_condition = $condition;
		$promo_codes_condition_limit = $condition_limit;
		$promo_codes_code = $code;
		$promo_codes_type = $type;
		$promo_codes_applied_to = $applied_to;
		$promo_codes_applied_to_item_id = $applied_to_item;
		$promo_codes_applied_to_item_type = $applied_to_item_type;

		if($DB->sql("UPDATE promo_codes SET
				promo_codes_title='$title',
				promo_codes_condition='$condition',
				promo_codes_condition_limit='$condition_limit',
				promo_codes_code='$code',
				promo_codes_type='$type',
				promo_codes_discount='$promo_codes_discount',
				promo_codes_applied_to='$applied_to',
				promo_codes_applied_to_item_id='$applied_to_item',
				promo_codes_applied_to_item_type='$applied_to_item_type',
				promo_codes_starting_timestamp='$starting_timestamp',
				promo_codes_ending_condition='$ending',
				promo_codes_ending_timestamp='$ending_timestamp'
				WHERE promo_codes_id='$promo_codes_id' LIMIT 1")){
			closeConnections();
			header("Location:" . $BASE_URL . "admin/promo_codes.php");
			exit();
		}else{
			appendError("An error occurred when updating the promo code entry.");
		}
	}
}


closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin promo_codes edit">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Edit Promotional Code</h2>
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
						<label for="title" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" name="title" class="form-control" placeholder="The title of the promo_code" size="255" value="<?php echo $promo_codes_title;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="condition" class="col-sm-2 control-label">When a customer</label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="condition" value="0"<?php if($promo_codes_condition == '0'){echo ' checked';}?>> Orders anything
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
					    <div class="input-group">
					      <span class="input-group-addon">
									<label class="radio-inline">
						        <input type="radio" name="condition" value="1"<?php if($promo_codes_condition == '1'){echo ' checked';}?>> Orders at least
									</label>
					      </span>
					      <input type="number" id="condition_limit" name="condition_limit" class="form-control" placeholder="The minimum price the order should be for the code to be applicable" size="10" step="0.01" value="<?php if($promo_codes_condition == '1'){echo $promo_codes_condition_limit;}?>"<?php if($promo_codes_condition != '1'){echo ' disabled';}?>>
					    </div>
					  </div>
					</div>

					<div class="form-group">
						<label for="code" class="col-sm-2 control-label">Code</label>
						<div class="col-sm-10">
							<input type="text" name="code" class="form-control" placeholder="The code of the promo_code. 20 characters max. (ex. SUMMERSALE)" size="20" value="<?php echo $promo_codes_code;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="type" class="col-sm-2 control-label">Give them</label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="type" value="0"<?php if($promo_codes_type == '0'){echo ' checked';}?>> Free shipping
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
					    <div class="input-group">
					      <span class="input-group-addon">
									<label class="radio-inline">
						        <input type="radio" name="type" value="1"<?php if($promo_codes_type == '1'){echo ' checked';}?>> A percentage discount
									</label>
					      </span>
					      <input type="number" id="discount_perc" name="discount_perc" class="form-control" placeholder="The percentage that is discounted" size="10" step="0.01" value="<?php if($promo_codes_type == '1'){echo $promo_codes_discount;}?>"<?php if($promo_codes_type != '1'){echo ' disabled';}?>>
					      <div class="input-group-addon">%</div>
					    </div>
					  </div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
					    <div class="input-group">
					      <span class="input-group-addon">
									<label class="radio-inline">
						        <input type="radio" name="type" value="2"<?php if($promo_codes_type == '2'){echo ' checked';}?>> A flat-rate discount
									</label>
					      </span>
					      <input type="number" id="discount_flat" name="discount_flat" class="form-control" placeholder="The amount that is discounted" size="10" step="0.01" value="<?php if($promo_codes_type == '2'){echo $promo_codes_discount;}?>"<?php if($promo_codes_type != '2'){echo ' disabled';}?>>
					      <div class="input-group-addon">$</div>
					    </div>
					  </div>
					</div>

					<div class="form-group">
						<label for="applied_to" class="col-sm-2 control-label">Applied to</label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="applied_to" value="0"<?php if($promo_codes_applied_to == '0'){echo ' checked';}?>> The entire order (excl. shipping)
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="applied_to" value="1"<?php if($promo_codes_applied_to == '1'){echo ' checked';}?>> The entire order (incl. shipping)
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
					    <div class="input-group">
					      <span class="input-group-addon">
									<label class="radio-inline">
						        <input type="radio" name="applied_to" value="2"<?php if($promo_codes_applied_to == '2'){echo ' checked';}?>> A specific product
									</label>
					      </span>
					      <input type="text" id="applied_to_item_search" name="applied_to_item_search" class="form-control" placeholder="Search for a clothe, frame or merchandise by entry title" value="<?php echo stripslashes($promo_codes_applied_to_item_title);?>"<?php if($promo_codes_applied_to != '2'){echo ' disabled';}?>>
					      <input type="hidden" id="applied_to_item" name="applied_to_item" value="">
					      <input type="hidden" id="applied_to_item_type" name="applied_to_item_type" value="">
					    </div>
					  </div>
					</div>

					<div class="form-group">
						<label for="starting" class="col-sm-2 control-label">Starting</label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="starting" value="0"> Now
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
					    <div class="input-group">
					      <span class="input-group-addon">
									<label class="radio-inline">
						        <input type="radio" name="starting" value="1" checked> On
									</label>
					      </span>
					      <input type="text" id="starting_date" name="starting_date" class="form-control" placeholder="The starting date from when the promotional code will be applicable" value="<?php echo date('m/d/Y', $promo_codes_starting_timestamp);?>">
					    </div>
					  </div>
					</div>

					<div class="form-group">
						<label for="ending" class="col-sm-2 control-label">Ending</label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="ending" value="0"<?php if($promo_codes_ending_condition == '0'){echo ' checked';}?>> Never
							</label>
						</div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
					    <div class="input-group">
					      <span class="input-group-addon">
									<label class="radio-inline">
						        <input type="radio" name="ending" value="1"<?php if($promo_codes_ending_condition == '1'){echo ' checked';}?>> On
									</label>
					      </span>
					      <input type="text" id="ending_date" name="ending_date" class="form-control" placeholder="The ending date from when the promotional code will be applicable" value="<?php echo (($promo_codes_ending_condition == '1') ? date('m/d/Y', $promo_codes_ending_timestamp) : '');?>"<?php if($promo_codes_ending_condition != '1'){echo ' disabled';}?>>
					    </div>
					  </div>
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="ending" value="2"<?php if($promo_codes_ending_condition == '2'){echo ' checked';}?>> When it's been used
							</label>
						</div>
					</div>

					<input type="hidden" name="id" value="<?php echo $promo_codes_id;?>">
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