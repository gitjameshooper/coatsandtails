<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Merchandise';

$status_options = array('Active', 'Hidden', 'Sold Out', 'Coming Soon');

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$merchandise_count = 0;
$merchandise = $DB->query("SELECT * FROM merchandise LEFT JOIN category ON category.category_id=merchandise.merchandise_category GROUP BY merchandise_id ORDER BY merchandise_id DESC LIMIT 1000");
if(!isset($merchandise[0])){
	appendError("No merchandise entries were found in the database.");
}else{
	$merchandise_count = count($merchandise);
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin merchandise">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Merchandise
					<div class="pull-right">
						<a href="<?php echo $BASE_URL;?>admin/merchandise_add.php" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span> Add Entry</a>
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
								<th>Title</th>
								<th>Category</th>
								<th>Status</th>
								<th>-</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							for($i;$i<$merchandise_count;$i++){
								echo '<tr data-id="' . $merchandise[$i]['merchandise_id'] . '">'
										. '<td>' . $merchandise[$i]['merchandise_id'] . '</td>'
										. '<td>' . stripslashes($merchandise[$i]['merchandise_title']) . '</td>'
										. '<td>' . ($merchandise[$i]['merchandise_category'] == '0' ? 'N/A' : $merchandise[$i]['category_title']) . '</td>'
										. '<td>' . $status_options[$merchandise[$i]['merchandise_status']] . '</td>'
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