<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Frames';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$frames_count = 0;
$frames = $DB->query("SELECT * FROM frames ORDER BY frames_id DESC LIMIT 1000");
if(!isset($frames[0])){
	appendError("No frame entries were found in the database.");
}else{
	$frames_count = count($frames);
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin frames">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Frames
					<div class="pull-right">
						<a href="<?php echo $BASE_URL;?>admin/frames_add.php" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-plus"></span> Add Entry</a>
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
								<th>-</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							for($i;$i<$frames_count;$i++){
								echo '<tr data-id="' . $frames[$i]['frames_id'] . '">'
										. '<td>' . $frames[$i]['frames_id'] . '</td>'
										. '<td>' . stripslashes($frames[$i]['frames_title']) . '</td>'
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