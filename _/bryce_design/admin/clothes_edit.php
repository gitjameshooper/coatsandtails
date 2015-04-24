<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Clothes - Edit';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$clothes_gender = '0';
$clothes_title = $clothes_desc = $clothes_dog = $clothes_cat = '';

if(isset($_REQUEST['id'])){
	$clothes_id = isSetAndNotDefault('', 'REQUEST', 'id', true, 'Missing clothe id.');
	if(!is_numeric($clothes_id)){
		appendError("The provided clothe id was not valid.");
	}
	if($ERROR !== ''){
		closeConnections();
		header("Location:" . $BASE_URL . "admin/clothes.php");
		exit();
	}else{
		$get_clothes_query = $DB->query("SELECT * FROM clothes WHERE clothes_id='$clothes_id' LIMIT 1");
		if(!isset($get_clothes_query[0])){
			closeConnections();
			header("Location:" . $BASE_URL . "admin/clothes.php");
			exit();
		}else{
			$clothes_title = $get_clothes_query[0]['clothes_title'];
			$clothes_desc = $get_clothes_query[0]['clothes_desc'];
			$clothes_gender = $get_clothes_query[0]['clothes_gender'];
			$clothes_dog = $get_clothes_query[0]['clothes_dog'];
			$clothes_cat = $get_clothes_query[0]['clothes_cat'];
		}
	}
}else{
	closeConnections();
	header("Location:" . $BASE_URL . "admin/clothes.php");
	exit();
}

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

		if($DB->sql("UPDATE clothes
			SET
				clothes_title='$title',
				clothes_desc='$desc',
				clothes_gender='$gender',
				clothes_dog='$dog',
				clothes_cat='$cat'
			WHERE clothes_id='$clothes_id' LIMIT 1")){
			closeConnections();
			header("Location:" . $BASE_URL . "admin/clothes_edit_imgs.php?id=" . $clothes_id);
			exit();
		}else{
			appendError("An error occurred when updating the clothe entry.");
		}
	}
}


closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin clothes update">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2 class="sub-header">Edit Clothe</h2>
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
							<input type="text" id="title" name="title" class="form-control" placeholder="The title of the clothe/outfit/collection" size="255" value="<?php echo $clothes_title;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="desc" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<textarea id="desc" name="desc" placeholder="The description of the clothe/outfit/collection" class="form-control" rows="5"><?php echo str_replace("\\", "", textareaLineBreak($clothes_desc));?></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="gender" class="col-sm-2 control-label">Gender</label>
						<div class="col-sm-10">
							<label class="radio-inline">
								<input type="radio" name="gender" id="gender1" value="0"<?php if($clothes_gender == '0'){echo ' checked';}?>> Male
							</label>
							<label class="radio-inline">
								<input type="radio" name="gender" id="gender2" value="1"<?php if($clothes_gender == '1'){echo ' checked';}?>> Female
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="dog" class="col-sm-2 control-label">Image Directory - Dog</label>
						<div class="col-sm-10">
							<input type="text" id="dog" name="dog" class="form-control" placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/clothes/dogs/132845469/" size="255" value="<?php echo $clothes_dog;?>" required="">
						</div>
					</div>

					<div class="form-group">
						<label for="cat" class="col-sm-2 control-label">Image Directory - Cat</label>
						<div class="col-sm-10">
							<input type="text" id="cat" name="cat" class="form-control" placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/clothes/cats/132845469/" size="255" value="<?php echo $clothes_cat;?>" required="">
						</div>
					</div>

					<input type="hidden" name="id" value="<?php echo $clothes_id;?>">
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