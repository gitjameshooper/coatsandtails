<?php
$IS_ADMIN_PAGE = true;
$CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Login';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

if($LOGGED){
	closeConnections();
	header("Location:" . $BASE_URL . "admin/index.php");
	exit();
}else{
	if(isset($_POST['pass'])){
		$pass = isSetAndNotDefault('', 'POST', 'pass', false);

		if($pass === ''){
			appendError("Please provide a valid password.");
		}else{
			$get_user = $DB->query("SELECT * FROM admin_user WHERE admin_id='1' LIMIT 1");
			if(!isset($get_user[0])){
				appendError("No administrator was found in the system.");
			}else{
				$thisProvPass = md5($pass);
				$USER_PASSWORD = $get_user[0]['admin_pass'];
				if($thisProvPass === $USER_PASSWORD){

					$_SESSION['p'] = $USER_PASSWORD;
					$LOGGED = true;

					closeConnections();
					header("Location:" . $BASE_URL . "admin/index.php");
					exit();
				}else{
					appendError("Incorrect password, please try again.");
				}
			}
		}
	}
}

if(isset($_GET['error']) && isset($_GET['error_msg'])){
	appendError(isSetAndNotDefault('', 'GET', 'error_msg', false));
}

closeConnections();

commonHeaders();
?><!DOCTYPE html>
<html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="login">

	<div class="container">

		<?php
		if($ERROR !== ''){
			echo '<div class="alert alert-danger">'.$ERROR.'</div>';
		}
		?>
		<form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" role="form">
      <h2 class="form-signin-heading">Please sign in</h2>
			<div class="input-group">
	      <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
	      <input class="form-control" name="pass" size="10" type="password" value="" placeholder="Password" required="" autofocus="">
	    </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		</form>

	</div>

	<?php echo commonFoot();?>
</body>
</html>