<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Clothes - Add';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$clothes_gender = '0';
$clothes_title = $clothes_desc = $clothes_dog = $clothes_cat = '';


if(isset($_POST['title']) && isset($_POST['desc']) && isset($_POST['dog']) && isset($_POST['cat']) && isset($_POST['gender'])){
	$title = trim(isSetAndNotDefault('', 'POST', 'title', true, 'Provide the title of the entry.'));
	$desc = trim(isSetAndNotDefault('', 'POST', 'desc', false));
	$dog = trim(isSetAndNotDefault('', 'POST', 'dog', true, 'Provide the image directory for the dog model.'));
	$cat = trim(isSetAndNotDefault('', 'POST', 'cat', true, 'Provide the image directory for the cat model.'));
	$gender = isSetAndNotDefault('', 'POST', 'gender', false);

	if($gender != '1'){
		$gender = '0';
	}

	if($ERROR === ''){
		$clothes_title = $title;
		$clothes_desc = $desc;
		$clothes_dog = $dog;
		$clothes_cat = $cat;

		if($DB->sql("INSERT INTO clothes SET
			clothes_title='$title',
			clothes_desc='$desc',
			clothes_gender='$gender',
			clothes_dog='$dog',
			clothes_cat='$cat',
			clothes_addition_timestamp='$MICROTIME'")){
			$clothes = $DB->query("SELECT * FROM clothes WHERE clothes_addition_timestamp='$MICROTIME' LIMIT 1");

			closeConnections();
			header("Location:" . $BASE_URL . "admin/clothes_add_imgs.php?id=" . $clothes[0]['clothes_id']);
			exit();
		}else{
			appendError("An error occurred when adding the clothe entry.");
		}
	}
}


closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin clothes add">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Add Clothe</h2>
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
							<input type="text" id="title" name="title" class="form-control" placeholder="The title of the clothe/outfit/collection" size="255" value="" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="desc" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<textarea id="desc" name="desc" placeholder="The description of the frame" class="form-control" rows="5"></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="gender" class="col-sm-2 control-label">Gender</label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="gender" id="gender1" value="0" checked> Male
							</label>
							<label class="radio-inline">
								<input type="radio" name="gender" id="gender2" value="1"> Female
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="dog" class="col-sm-2 control-label">Image Directory - Dog</label>
						<div class="col-sm-10">
							<input type="text" id="dog" name="dog" class="form-control" placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/clothes/dogs/132845469/" size="255" value="" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="cat" class="col-sm-2 control-label">Image Directory - Cat</label>
						<div class="col-sm-10">
							<input type="text" id="cat" name="cat" class="form-control" placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/clothes/cats/132845469/" size="255" value="" required="">
						</div>
					</div>

					<button class="btn btn-lg btn-primary pull-right" type="submit">Add</button>
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