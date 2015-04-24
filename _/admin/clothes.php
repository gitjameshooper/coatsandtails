<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Clothes';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$clothes_count = 0;
$clothes = $DB->query("SELECT *, COUNT(clothes_imgs_id) AS clothes_imgs_count FROM clothes LEFT JOIN clothes_imgs ON clothes_imgs.clothes_ref_id=clothes.clothes_id GROUP BY clothes_id ORDER BY clothes_id DESC LIMIT 1000");
if(!isset($clothes[0])){
	appendError("No clothe entries were found in the database.");
}else{
	$clothes_count = count($clothes);
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin clothes">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Clothes
					<div class="pull-right">
						<a href="<?php echo $BASE_URL;?>admin/clothes_add.php" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span> Add Entry</a>
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
								<th>Gender</th>
								<th>Images</th>
								<th>-</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							for($i;$i<$clothes_count;$i++){
								echo '<tr data-id="' . $clothes[$i]['clothes_id'] . '">'
										. '<td>' . $clothes[$i]['clothes_id'] . '</td>'
										. '<td>' . $clothes[$i]['clothes_title'] . '</td>'
										. '<td>' . ($clothes[$i]['clothes_gender'] == '0' ? 'Male' : 'Female') . '</td>'
										. '<td>' . $clothes[$i]['clothes_imgs_count'] . '</td>'
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