<?php
$IS_ADMIN_PAGE = true;
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Home';

include_once(dirname(dirname(__FILE__)) . '/defChecks.php');

$shipping_price_usa = $shipping_price_international = '0';
$terms_and_conditions = '';

$global_variables = $DB->query("SELECT * FROM global_variables WHERE global_variables_id='1' LIMIT 1");
if(!isset($global_variables[0])){
	appendError("No global variables entry was found in the database.");
}else{
	$shipping_price_usa = $global_variables[0]['shipping_price_usa'];
	$shipping_price_international = $global_variables[0]['shipping_price_international'];
	$terms_and_conditions = htmlspecialchars(str_replace("<br/>", "\r\n", htmlspecialchars_decode($global_variables[0]['terms_and_conditions'])));
}



if(isset($_POST['shipping_usa']) && isset($_POST['shipping_international']) && isset($_POST['t_and_c'])){
	$shipping_usa = trim(isSetAndNotDefault('', 'POST', 'shipping_usa', true, 'Provide the price for shipping in the U.S.A..'));
	$shipping_international = trim(isSetAndNotDefault('', 'POST', 'shipping_international', true, 'Provide the price for shipping in the U.S.A..'));
	$t_and_c = trim(isSetAndNotDefault('', 'POST', 't_and_c', true, 'Provide the content for the Terms & Conditions.'));

	if($ERROR === ''){
		$shipping_usa = str_replace(',', '', $shipping_usa);
		if(!is_numeric($shipping_usa)){
			appendError("The Shipping Price (U.S.A.) needs to be a numeric value.");
		}
		$shipping_international = str_replace(',', '', $shipping_international);
		if(!is_numeric($shipping_international)){
			appendError("The Shipping Price (International) needs to be a numeric value.");
		}
	}
	if($ERROR === ''){
		$shipping_price_usa = $shipping_usa;
		$shipping_price_international = $shipping_international;
		$terms_and_conditions = htmlspecialchars(str_replace(array("\\r\\n", "\\n", "\\r"), "<br/>", $t_and_c));

		$DB->sql("UPDATE global_variables
			SET
				shipping_price_usa='$shipping_price_usa',
				shipping_price_international='$shipping_price_international',
				terms_and_conditions='$terms_and_conditions'
			WHERE global_variables_id='1' LIMIT 1");
		appendSuccess('Global variables updated.');
		$terms_and_conditions = htmlspecialchars(str_replace("<br/>", "\r\n", htmlspecialchars_decode($terms_and_conditions)));
	}
}


closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="admin main">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h2 class="sub-header">Global Variables</h2>
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
				    <label for="shipping_usa" class="col-sm-2 control-label">Shipping Price (U.S.A.)</label>
				    <div class="col-sm-10">
					    <input type="number" id="shipping_usa" name="shipping_usa" class="form-control" placeholder="Shipping Price (U.S.A.). E.g.: 10.25" size="10" step="0.01" value="<?php echo number_format($shipping_price_usa, 2);?>" required="">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="shipping_international" class="col-sm-2 control-label">Shipping Price (International)</label>
				    <div class="col-sm-10">
					    <input type="number" id="shipping_international" name="shipping_international" class="form-control" placeholder="Shipping Price (International). E.g.: 20.58" size="10" step="0.01" value="<?php echo number_format($shipping_price_international, 2);?>" required="">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="t_and_c" class="col-sm-2 control-label">Terms & Conditions</label>
				    <div class="col-sm-10">
				    	<textarea id="t_and_c" name="t_and_c" placeholder="Shipping Price (International)" class="form-control" rows="5" required=""><?php echo str_replace("\\", "", textareaLineBreak($terms_and_conditions));?></textarea>
					  </div>
				  </div>

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