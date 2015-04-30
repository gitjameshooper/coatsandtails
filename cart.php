<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Cart';

include_once(dirname(__FILE__) . '/defChecks.php');

if(isset($target_mode) && ($target_mode == 1)){
	$target_mode_size_options = 4;
}else{
	$target_mode_size_options = 2;
}

$cart_info = array();
$cart_total = 0;
$cart_arr = array('total'=>0,'tax_perc'=>$TAX_PERCENT,'shipping_total'=>0,'discount_total'=>0,'discount'=>'','pick_up'=>0,'items'=>array());

$target_mode_options = array('photo', 'draw');

$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

$portrait_price = 0;
$pet_names_arr = array();
$pet_names = '';

$order_pet_query = $DB->query("SELECT * FROM order_pet WHERE order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "' AND order_pet_status='0' ORDER BY order_pet_id ASC");
$order_pet_query_count = count($order_pet_query);

if(($order_pet_query_count > 0) && (!isset($target_mode) || ($target_mode == ''))){
  closeConnections();
  header("Location:" . $BASE_URL . "photo_draw.php");
  exit();
}

$largest_frame_size = '8x10';
$frame_size_found = false;

$cart_query = $DB->query("SELECT * FROM cart WHERE cart_session_id='" . $_COOKIE['PHPSESSID'] . "' AND cart_order_status='0' ORDER BY cart_id DESC LIMIT 1");
$cart_query_count = count($cart_query);

if($cart_query_count == 1){
	$cart_info = objectToArray(json_decode($cart_query[0]['cart_payload']));
	$cart_query = $cart_info['items'];
	$cart_arr['items'] = $cart_query;
	$cart_query_count = count($cart_query);
	if($cart_query_count > 0){
		$i = 0;
		for($i;$i<$cart_query_count;$i++){
			if($cart_query[$i]['type'] == "merch"){
				$cart_query[$i]['info'] = $DB->query("SELECT * FROM merchandise_variant, merchandise LEFT JOIN merchandise_imgs ON merchandise_imgs.merchandise_ref_id=merchandise.merchandise_id WHERE merchandise_id='" . $cart_query[$i]['id'] . "' AND merchandise_variant_id='" . $cart_query[$i]['variant'] . "' AND merchandise_status='0' AND merchandise_variant_merchandise_id=merchandise_id GROUP BY merchandise_id LIMIT 1000");
				if(!isset($cart_query[$i]['info'][0])){
					$mhour=time()-3600;
					if(isset($_COOKIE['PHPSESSID'])){setcookie('PHPSESSID','',$mhour,'/');}
					if(isset($_COOKIE['coatandtails'])){setcookie('coatandtails','',$mhour,'/');}
					session_unset();
					session_destroy();
					closeConnections();
					header("Location:" . $BASE_URL);
					exit();
				}
				$cart_arr['items'][$i]['available'] = (int)$cart_query[$i]['info'][0]['merchandise_variant_availability'];
			}else if($cart_query[$i]['type'] == "frame"){
				$frame_size_found = true;
				$cart_query[$i]['info'] = $DB->query("SELECT * FROM frames LEFT JOIN frames_imgs ON frames_imgs.frames_ref_id=frames.frames_id WHERE frames_id='" . $cart_query[$i]['id'] . "' ORDER BY frames_imgs_id ASC");
				if(!isset($cart_query[$i]['info'][0])){
					$mhour=time()-3600;
					if(isset($_COOKIE['PHPSESSID'])){setcookie('PHPSESSID','',$mhour,'/');}
					if(isset($_COOKIE['coatandtails'])){setcookie('coatandtails','',$mhour,'/');}
					session_unset();
					session_destroy();
					closeConnections();
					header("Location:" . $BASE_URL);
					exit();
				}
				$d = 0;
				for($d;$d<$target_mode_size_options;$d++){
					$cart_arr['items'][$i]['available_' . $SIZE_OPTIONS[$d]] = (int)$cart_query[$i]['info'][0]['frames_' . $SIZE_OPTIONS[$d] . '_availability'];
				}

				if(array_search($cart_query[$i]['size'], $SIZE_OPTIONS) > array_search($largest_frame_size, $SIZE_OPTIONS)){
					$largest_frame_size = $cart_query[$i]['size'];
				}
			}
		}
	}
}

if($order_pet_query_count > 0){
	$portrait_price = (float)number_format((float)$PORTRAIT_PRICES[$target_mode_options[$target_mode]][$largest_frame_size] + (((float)$PORTRAIT_PRICES[$target_mode_options[$target_mode]][$largest_frame_size] * 0.75) * ($order_pet_query_count - 1)), 2);
	$i = 0;
	for($i;$i<$order_pet_query_count;$i++){
		if(isset($order_pet_query[$i]['order_pet_name'][0])){
			array_push($pet_names_arr, $order_pet_query[$i]['order_pet_name']);
		}else{
			array_push($pet_names_arr, 'Pet ' . ($i + 1));
		}
	}
	$pet_names = implode(', ', $pet_names_arr);
	array_push($cart_arr['items'], array(
		'id'=>"0",
		'amount'=>1,
		'available'=>1000,
		'price'=>$portrait_price,
		'first_pet'=>(float)number_format((float)$PORTRAIT_PRICES[$target_mode_options[$target_mode]][$largest_frame_size], 2),
		'pet_count'=>(int)$order_pet_query_count,
		'size'=>$largest_frame_size,
		'type'=>"portrait",
		'clothe'=>$order_pet_query[0]['order_pet_clothe_ref_id']
		));
}

$cart_arr['size_found'] = $frame_size_found;

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="f cart">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/merch_banner.png" alt="Cart" class="sub-header-banner-img">
			</div>
		</div>
	</div>

	<div class="container w-bg center cart-section">
		<div class="row">
			<div class="col-sm-12 cart-table-host">
				<?php
				include_once(dirname(__FILE__) . '/bits/country_codes.php');
				if(($order_pet_query_count == 0) && ($cart_query_count == 0)){
					echo '<div class="alert alert-danger">You do not have any items pending in the cart.</div>';
				}else{
					?>
					<div class="row">
						<div class="col-sm-12">
							<table class="table table-striped">
								<?php
								if($order_pet_query_count > 0){
									$cart_total += $portrait_price;
									echo '<tr data-item="portrait" data-item-id="0" id="portrait_0">'
											. '<td>'
												. '<div class="thumb" style="background-image:url(https://s3.amazonaws.com/coatandtails/img/cart_portrait.png);"></div>'
											. '</td>'
											. '<td>'
												. '<div>Portrait for ' . $pet_names . '</div>'
												. '<div class="price">$' . $portrait_price . '</div>'
												. '<div id="portrait_size_host"><select class="form-control" id="portrait_size" name="portrait_size">';
													$i = 0;
													for($i;$i<$target_mode_size_options;$i++){
														echo '<option value="' . $SIZE_OPTIONS[$i] . '"';
														if($frame_size_found && ($largest_frame_size == $SIZE_OPTIONS[$i])){
															echo ' selected';
														}
														echo '>' . $SIZE_OPTIONS[$i] . '</option>';
													}
													echo '</select>'
												. '</div>'
											. '</td>'
											. '<td>'
												. '<input type="number" class="form-control amount" size="10" step="1" min="0" value="1" required="">'
											. '</td>'
											. '<td>'
												. '<a href="javascript:void(0);" class="btn btn-xs btn-default btn-icon trash" data-item="portrait" data-item-id="0">'
													. '<span class="glyphicon glyphicon-trash"></span>'
												. '</a>'
											. '</td>'
										. '</tr>';
								}
								if($cart_query_count > 0){
									$i = 0;
									for($i;$i<$cart_query_count;$i++){
										if(($cart_query[$i]['type'] == "merch") && isset($cart_query[$i]['info'][0])){
											$cart_total += number_format(((float)$cart_query[$i]['info'][0]['merchandise_variant_price'] * $cart_query[$i]['amount']), 2);
											echo '<tr data-item="merch" data-item-id="' . $cart_query[$i]['id'] . '" id="merch_' . $cart_query[$i]['id'] . '">'
													. '<td>'
														. '<div class="thumb" style="background-image:url(';
											if(!isset($cart_query[$i]['info'][0]['merchandise_imgs_dir'])){
												echo $CDN_IMGS . 'img/missing.png';
											}else{
												echo $CDN_IMGS . $cart_query[$i]['info'][0]['merchandise_imgs_dir'];
											}
											$cart_arr['items'][$i]['itemName'] = stripslashes($cart_query[$i]['info'][0]['merchandise_title']);
											$cart_arr['items'][$i]['description'] = $cart_query[$i]['info'][0]['merchandise_variant_label'];
											echo ');"></div>'
													. '</td>'
													. '<td>'
														. '<div>' . stripslashes($cart_query[$i]['info'][0]['merchandise_title']) . ' <small>(' . $cart_query[$i]['info'][0]['merchandise_variant_label'] . ')</small></div>'
														. '<div class="price">$' . number_format((float)$cart_query[$i]['info'][0]['merchandise_variant_price'], 2) . '</div>'
													. '</td>'
													. '<td>'
														. '<input type="number" class="form-control amount" size="10" step="1" min="0" value="' . $cart_query[$i]['amount'] . '" required="">'
													. '</td>'
													. '<td>'
														. '<a href="javascript:void(0);" class="btn btn-xs btn-default btn-icon trash" data-item="merch" data-item-id="' . $cart_query[$i]['id'] . '">'
															. '<span class="glyphicon glyphicon-trash"></span>'
														. '</a>'
													. '</td>'
												. '</tr>';
										}else if(($cart_query[$i]['type'] == "frame") && isset($cart_query[$i]['info'][0])){
											$cart_total += number_format(((float)$cart_query[$i]['info'][0]['frames_' . $cart_query[$i]['size'] . '_price'] * $cart_query[$i]['amount']), 2);
											echo '<tr data-item="frame" data-item-id="' . $cart_query[$i]['id'] . '" id="frame_' . $cart_query[$i]['id'] . '">'
													. '<td>'
														. '<div class="thumb" style="background-image:url(';
											if(!isset($cart_query[$i]['info'][0]['frames_imgs_dir'])){
												echo $CDN_IMGS . 'img/missing.png';
											}else{
												echo $CDN_IMGS . $cart_query[$i]['info'][0]['frames_imgs_dir'];
											}
											echo ');"></div>'
													. '</td>'
													. '<td>'
														. '<div>' . $cart_query[$i]['info'][0]['frames_title'] . '</div>'
														. '<div class="price">$' . number_format((float)$cart_query[$i]['info'][0]['frames_' . $cart_query[$i]['size'] . '_price'], 2) . '</div>'
														. '<div>' . $cart_query[$i]['size'] . '</div>'
													. '</td>'
													. '<td>'
														. '<input type="number" class="form-control amount" size="10" step="1" min="0" value="' . $cart_query[$i]['amount'] . '" required="">'
													. '</td>'
													. '<td>'
														. '<a href="javascript:void(0);" class="btn btn-xs btn-default btn-icon trash" data-item="frame" data-item-id="' . $cart_query[$i]['id'] . '">'
															. '<span class="glyphicon glyphicon-trash"></span>'
														. '</a>'
													. '</td>'
												. '</tr>';
										}
									}
								}
								echo '<tr class="subtotal-host">'
										. '<td colspan="2"></td>'
										. '<td>Subtotal</td>'
										. '<td class="subtotal">$' . $cart_total . '</td>'
									. '</tr>';
								$cart_arr['total'] = $cart_total;
								?>
							</table>
						</div>
					</div>
					<div class="row footer-row checkout-host">
						<div class="col-sm-3 pull-right">
							<a href="javascript:void(0);" class="btn btn-lg btn-block checkout">checkout</a>
						</div>
					</div>
					<?php
				}
				?>
			</div>

			<div class="col-sm-12 checkout-table-host">
				<form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" role="form">
					<div class="row">
						<div class="col-sm-4">
							<h2>Billing Information</h2>
							<div class="row">

								<div class="col-sm-6">
									<div class="form-group">
										<label for="first_name" class="col-sm-12 control-label">First Name*</label>
										<div class="col-sm-12">
											<input type="text" id="first_name" name="first_name" class="form-control" size="60" value="" required="">
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="last_name" class="col-sm-12 control-label">Last Name*</label>
										<div class="col-sm-12">
											<input type="text" id="last_name" name="last_name" class="form-control" size="60" value="" required="">
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="email" class="col-sm-12 control-label">Email*</label>
										<div class="col-sm-12">
											<input type="text" id="email" name="email" class="form-control" size="255" value="" required="">
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="phone" class="col-sm-12 control-label">Telephone</label>
										<div class="col-sm-12">
											<input type="text" id="phone" name="phone" class="form-control" size="20" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="form-group">
										<label for="address_1" class="col-sm-12 control-label">Address*</label>
										<div class="col-sm-12">
											<input type="text" id="address_1" name="address_1" class="form-control" size="255" value="" required="">
										</div>
										<div class="col-sm-12">
											<input type="text" id="address_2" name="address_2" class="form-control" size="255" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="form-group">
										<label for="country" class="col-sm-12 control-label">Country*</label>
										<div class="col-sm-12">
											<select class="form-control" id="country" name="country"><?php echo countryListOptionsList('us');?></select>
										</div>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="form-group">
										<label for="city" class="col-sm-12 control-label">City*</label>
										<div class="col-sm-12">
											<input type="text" id="city" name="city" class="form-control" size="120" value="" required="">
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="zip_code" class="col-sm-12 control-label">Zip Code</label>
										<div class="col-sm-12">
											<input type="text" id="zip_code" name="zip_code" class="form-control" size="10" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="state" class="col-sm-12 control-label">State</label>
										<div class="col-sm-12">
											<select class="form-control" id="state" name="state">
												<option value=""></option>
												<?php echo stateListOptionsList('');?>
											</select>
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="shipping_company" class="col-sm-12 control-label">Company</label>
										<div class="col-sm-12">
											<input type="text" id="shipping_company" name="shipping_company" class="form-control" size="120" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-12" id="billing_same_as_shipping_host">
									<div class="form-group">
										<div class="col-sm-12">
											<input type="checkbox" id="billing_same_as_shipping" value="1" checked> <label for="billing_same_as_shipping">Shipping address is the same as the billing address.</label>
										</div>
									</div>
								</div>
							</div>


							<h2 class="shipping-control">Shipping Information</h2>
							<div class="row shipping-control">

								<div class="col-sm-6">
									<div class="form-group">
										<label for="shipping_first_name" class="col-sm-12 control-label">First Name*</label>
										<div class="col-sm-12">
											<input type="text" id="shipping_first_name" name="shipping_first_name" class="form-control" size="60" value="" required="">
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="shipping_last_name" class="col-sm-12 control-label">Last Name*</label>
										<div class="col-sm-12">
											<input type="text" id="shipping_last_name" name="shipping_last_name" class="form-control" size="60" value="" required="">
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="shipping_phone" class="col-sm-12 control-label">Telephone</label>
										<div class="col-sm-12">
											<input type="text" id="shipping_phone" name="shipping_phone" class="form-control" size="20" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="form-group">
										<label for="shipping_address_1" class="col-sm-12 control-label">Address*</label>
										<div class="col-sm-12">
											<input type="text" id="shipping_address_1" name="shipping_address_1" class="form-control" size="255" value="">
										</div>
										<div class="col-sm-12">
											<input type="text" id="shipping_address_2" name="shipping_address_2" class="form-control" size="255" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="form-group">
										<label for="shipping_country" class="col-sm-12 control-label">Country*</label>
										<div class="col-sm-12">
											<select class="form-control" id="shipping_country" name="shipping_country"><?php echo countryListOptionsList('us');?></select>
										</div>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="form-group">
										<label for="shipping_city" class="col-sm-12 control-label">City*</label>
										<div class="col-sm-12">
											<input type="text" id="shipping_city" name="shipping_city" class="form-control" size="120" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="shipping_zip_code" class="col-sm-12 control-label">Zip Code</label>
										<div class="col-sm-12">
											<input type="text" id="shipping_zip_code" name="shipping_zip_code" class="form-control" size="10" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="shipping_state" class="col-sm-12 control-label">State</label>
										<div class="col-sm-12">
											<select class="form-control" id="shipping_state" name="shipping_state">
												<option value=""></option>
												<?php echo stateListOptionsList('');?>
											</select>
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class="col-sm-4">

							<h2>Payment Method</h2>
							<div class="row">

								<div class="col-sm-12">
									<div class="form-group">
										<div class="col-sm-12">
											<label class="radio-inline">
												<input type="radio" name="payment_method" value="0" checked> Paypal
											</label>
										</div>
										<div class="col-sm-12">
											<label class="radio-inline">
												<input type="radio" name="payment_method" value="1"> Credit Card
											</label>
										</div>
									</div>
								</div>


								<div class="col-sm-12 cc-info">
									<div class="form-group">
										<label for="card_type" class="col-sm-12 control-label">Card Type*</label>
										<div class="col-sm-12">
											<select class="form-control" id="card_type" name="card_type">
												<option value="Visa" selected="selected">Visa</option>
												<option value="MasterCard">MasterCard</option>
												<option value="Discover">Discover</option>
												<option value="Amex">Amex</option>
												<option value="Switch">Switch</option>
												<option value="Solo">Solo</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-sm-12 cc-info">
									<div class="form-group">
										<label for="name_on_card" class="col-sm-12 control-label">Name of Card Holder*</label>
										<div class="col-sm-12">
											<input type="text" id="name_on_card" name="name_on_card" class="form-control" size="120" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-12 cc-info">
									<div class="form-group">
										<label for="cc_num" class="col-sm-12 control-label">Credit Card Number*</label>
										<div class="col-sm-12">
											<input type="text" id="cc_num" name="cc_num" class="form-control" size="20" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-12 cc-info">
									<div class="form-group">
										<label for="ccv_num" class="col-sm-12 control-label">Credit Card Verification Number</label>
										<div class="col-sm-12">
											<input type="text" id="ccv_num" name="ccv_num" class="form-control" size="6" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-6 cc-info">
									<div class="form-group">
										<label for="expiration_m" class="col-sm-12 control-label">Expiration Month*</label>
										<div class="col-sm-12">
											<select class="form-control" id="expiration_m" name="expiration_m">
												<?php
												$i = 0;
												for($i;$i<12;$i++){
													echo '<option value="' . ($i + 1) . '"';
													if(date('n') == ($i + 1)){
														echo ' selected="selected"';
													}
													echo '>' . $months[$i] . '</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>

								<div class="col-sm-6 cc-info">
									<div class="form-group">
										<label for="expiration_y" class="col-sm-12 control-label">Expiration Year*</label>
										<div class="col-sm-12">
											<select class="form-control" id="expiration_y" name="expiration_y">
												<?php
												echo '<option value="' . date('Y') . '" selected="selected">' . date('Y') . '</option>';
												$i = 1;
												for($i;$i<10;$i++){
													echo '<option value="' . ((int)date('Y') + $i) . '">' . ((int)date('Y') + $i) . '</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>

							</div>

							<h2>Shipping</h2>
							<div class="row">

								<div class="col-sm-12">
									<div class="form-group">
										<div class="col-sm-12">
											<input type="checkbox" id="pick_up" value="1"> <label for="pick_up">I want to pick it up in person.</label>
										</div>
									</div>
								</div>

							</div>

						</div>
						<div class="col-sm-4">

							<h2>Review Your Order</h2>
							<div class="row">

								<div class="col-sm-6">
									<div class="form-group">
										<label for="coupon" class="col-sm-12 control-label">Coupon Code</label>
										<div class="col-sm-12">
											<input type="text" id="coupon" name="coupon" class="form-control" size="20" value="">
										</div>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label for="apply-coupon" class="col-sm-12 control-label apply-coupon-label">&nbsp;</label>
										<div class="col-sm-12">
											<a href="javascript:void(0);" id="apply-coupon" class="form-control btn btn-default btn-block apply-coupon">Apply Coupon</a>
										</div>
									</div>
								</div>

								<div class="col-sm-12">
									<div class="form-group">
										<label for="comment" class="col-sm-12 control-label">Deadline/Comments</label>
										<div class="col-sm-12">
											<textarea id="comment" name="comment" class="form-control" rows="5"></textarea>
										</div>
									</div>
								</div>

								<div class="col-sm-12">
									<table class="table table-condensed">
										<tr class="subtotal-host">
											<td>Subtotal</td>
											<td class="subtotal">$<?php echo $cart_total;?></td>
										</tr>
										<tr class="shipping-host">
											<td>Shipping</td>
											<td class="shipping">$<?php echo $cart_total;?></td>
										</tr>
										<tr class="tax-host">
											<td>Tax</td>
											<td class="tax">$<?php echo number_format(($cart_total * ($TAX_PERCENT / 100)), 2);?></td>
										</tr>
										<tr class="total-host">
											<td>Grand total</td>
											<td class="total">$<?php echo number_format(($cart_total + (float)(number_format(($cart_total * ($TAX_PERCENT / 100)), 2)) + $cart_arr['shipping_total']), 2);?></td>
										</tr>
									</table>
								</div>

							</div>

						</div>
					</div>
					<div class="row footer-row checkout-host">
						<div class="col-sm-3 pull-right">
							<div class="t_c_host"><input type="checkbox" id="agree_t_c" value="1"> I have read and agree to the <a href="javascript:void(0);" class="t_c">Terms and Conditions</a>.</div>
							<a href="javascript:void(0);" class="btn btn-lg btn-block place-order">Place Order Now</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row sharing-box">
		<h3 class="share-btns-header">Share Coat &amp; Tails with Your Friends</h3>
		<div class="share-btns">
		<div class="fb-share-button" data-href="http://www.coatandtails.com/" data-layout="button"></div>
					 <a class="pin-btn" href="https://www.pinterest.com/pin/create/button/?url=http%3A%2F%2Fwww.coatandtails.com&media=http://s3.amazonaws.com/coatandtails/img/logo.png" data-pin-do="buttonPin" data-pin-description="Shop at Coat and Tails" data-pin-config="none">
        				<img src="//assets.pinterest.com/images/pidgets/pin_it_button.png" /></a>
    				 <a class="tweet-btn" target="_blank" href="https://twitter.com/intent/tweet?text=Shop%20at&url=http%3A%2F%2Fwww.coatandtails.com">Tweet</a></div>
								</div></div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	window.cart=<?php echo json_encode($cart_arr);?>;
	window.shipping_prices=<?php echo json_encode($SHIPPING);?>;
	<?php
	if($order_pet_query_count > 0){
		echo 'window.portrait_prices=' . json_encode($PORTRAIT_PRICES[$target_mode_options[$target_mode]]) . ';';
	}
	?>
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
</body>
</html>