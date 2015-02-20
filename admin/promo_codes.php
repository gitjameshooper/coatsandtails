<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Promotional Codes';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$type = array('Free shipping', 'A percentage discount', 'A flat-rate discount');
$ending = array('Never', '', 'When it\'s been used');

$promo_codes_count = 0;
$promo_codes = $DB->query("SELECT * FROM promo_codes ORDER BY promo_codes_id DESC LIMIT 1000");
if(!isset($promo_codes[0])){
	appendError("No promotional code entries were found in the database.");
}else{
	$promo_codes_count = count($promo_codes);
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin promo_codes">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Promotional Codes
					<div class="pull-right">
						<a href="<?php echo $BASE_URL;?>admin/promo_codes_add.php" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span> Add Entry</a>
					</div>
				</h2>
				<?php
				if($ERROR !== ''){
					echo '<div class="alert alert-danger">'.$ERROR.'</div>';
				}else{
				?>
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Code</th>
								<th>Giving them</th>
								<th>Starting</th>
								<th>Ending</th>
								<th>-</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							for($i;$i<$promo_codes_count;$i++){
								echo '<tr data-id="' . $promo_codes[$i]['promo_codes_id'] . '">'
										. '<td>' . $promo_codes[$i]['promo_codes_id'] . '</td>'
										. '<td>' . $promo_codes[$i]['promo_codes_title'] . '</td>'
										. '<td>' . $promo_codes[$i]['promo_codes_code'] . '</td>'
										. '<td>' . $type[(int)$promo_codes[$i]['promo_codes_type']];
								if((int)$promo_codes[$i]['promo_codes_type'] != 0){
									echo ' of ';
									if((int)$promo_codes[$i]['promo_codes_type'] == 1){
										echo '%';
									}else{
										echo '$';
									}
									echo rtrim(rtrim(number_format((float)$promo_codes[$i]['promo_codes_discount'], 2, '.', ','), '0'), '.');
								}
								echo '</td>'
										. '<td>' . date('m/d/Y', $promo_codes[$i]['promo_codes_starting_timestamp']) . '</td>'
										. '<td>' . ($promo_codes[$i]['promo_codes_ending_condition'] != '1' ? $ending[(int)$promo_codes[$i]['promo_codes_ending_condition']] : date('m/d/Y', $promo_codes[$i]['promo_codes_ending_timestamp'])) . '</td>'
										. '<td>'
											. '<a href="javascript:void(0);" class="btn btn-xs btn-default btn-icon edit">'
												. '<span class="glyphicon glyphicon-pencil"></span>'
											. '</a>'
											. '<a href="javascript:void(0);" class="btn btn-xs btn-default btn-icon trash">'
												. '<span class="glyphicon glyphicon-trash"></span>'
											. '</a>'
										. '</td>'
									. '</tr>';
							}
							?>
						</tbody>
					</table>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
</body>
</html>