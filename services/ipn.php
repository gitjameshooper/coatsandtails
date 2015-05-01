<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.

$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
	$keyval = explode ('=', $keyval);
	if (count($keyval) == 2)
		$myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
	$get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
	if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
		$value = urlencode(stripslashes($value));
	} else {
		$value = urlencode($value);
	}
	$req .= "&$key=$value";
}

// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data
// $paypal_url = "https://www.paypal.com/cgi-bin/webscr"; // live: https://www.paypal.com/cgi-bin/webscr | sandbox: https://www.sandbox.paypal.com/cgi-bin/webscr

$ch = curl_init($PAYPAL_API_ENDPOINT);
if ($ch == FALSE) {
	return FALSE;
}

curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

// CONFIG: Optional proxy configuration
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

// Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.

//$cert = __DIR__ . "./cacert.pem";
//curl_setopt($ch, CURLOPT_CAINFO, $cert);


$hds = "From: $SITE_NAME <$SALES_EMAIL>\nX-Mailer: PHP/".phpversion()
	. "\nReply-To: $SALES_EMAIL\nX-Priority: 3\nMIME-Version: 1.0\nContent-type: text/html; charset=utf-8\n";

$msg = "";

$res = curl_exec($ch);
if (curl_errno($ch) != 0){ // cURL error
	$msg .= "HTTP request error.<br>";
	$subject = "HTTP request error when attempting to validate a payment.";
	curl_close($ch);
	exit;
} else {
	$msgF = "<br><br>HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req<br>HTTP response of validation request: $res<br>";
	curl_close($ch);

	// assign posted variables to local variables
	$item_name=@$_POST['item_name'];
	$item_number=@$_POST['item_number'];
	$payment_status=@$_POST['payment_status'];
	$payment_amount=@$_POST['mc_gross'];
	$payment_currency=@$_POST['mc_currency'];
	$txn_id=@$_POST['txn_id'];
	$receiver_email=@$_POST['receiver_email'];
	$payer_email=@$_POST['payer_email'];

	// Inspect IPN validation result and act accordingly

	$msgH = '<html><head><title>' . $SITE_NAME . '</title></head><body><table width="100%" border="0" cellpadding=0 cellspacing=0><tr height=5><td width="8"></td><td></td></tr><tr><td width="8"></td><td><font style="font-family:Tahoma;font-size:14px">' . $SITE_NAME . ' - Payment for order '.$item_number.'</font></td></tr><tr height="40"><td colspan=2></td></tr><tr><td></td><td><font style="font-family:Tahoma;font-size:12px">Hello,<br><br>';
	$msgF .= '</font></td></tr></table></body ></html>';

	$msg .= "Order Number:" . $item_number
    . "<br>Payment Method:Paypal"
		. "<br>Payment Status:" . $payment_status
		. "<br>Payment Amount:" . $payment_amount
		. "<br>Transaction ID:" . $txn_id
		. "<br>Receivers Email:" . $receiver_email
		. "<br>Payers Email:" . $payer_email;

  $order_query = $DB->query("SELECT * FROM `$DB_SCHEMA`.`order` WHERE order_id='$item_number' LIMIT 1");
	if(isset($order_query[0])){

		// TODO | Extract all the remaining info of the order (e.g billing/shipping info, comments, pick up option)

    $details = objectToArray(json_decode(stripslashes(base64_decode($order_query[0]['order_details']))));

		$msg .= "<br>Tax:" . number_format(((float)$details['total'] * ((float)$details['tax_perc'] / 100)), 2)
	    . "<br>Comments:" . $details['order_details']['comment']
	    . "<br>Promo Code:" . $details['order_details']['coupon'];

		$msg .= "<br><br>Billing Info"
			. "<br>First Name:" . $details['order_details']['first_name']
	    . "<br>Last Name:" . $details['order_details']['last_name']
	    . "<br>Email:" . $details['order_details']['email']
	    . "<br>Phone:" . $details['order_details']['phone']
	    . "<br>Address 1:" . $details['order_details']['address_1']
	    . "<br>Address 2:" . $details['order_details']['address_2']
	    . "<br>Country:" . $details['order_details']['country']
	    . "<br>City:" . $details['order_details']['city']
	    . "<br>Zip Code:" . $details['order_details']['zip_code']
	    . "<br>State:" . $details['order_details']['state']
	    . "<br>Company:" . $details['order_details']['company']
	    . "<br><br>Pickup:";
	  if($details['pick_up'] == '1'){
	  	$msg .= "Yes";
	  }else{
	  	$msg .= "No";
			$msg .= "<br><br>Shipping Info"
		    . "<br>Shipping address is the same as the billing address:";
		  if($details['order_details']['billing_same_as_shipping'] == '1'){
		  	$msg .= "Yes";
		  }else{
		  	$msg .= "No";
		  }
			$msg .= "<br>First Name:" . $details['order_details']['shipping_first_name']
		    . "<br>Last Name:" . $details['order_details']['shipping_last_name']
		    . "<br>Email:" . $details['order_details']['shipping_email']
		    . "<br>Phone:" . $details['order_details']['shipping_phone']
		    . "<br>Address 1:" . $details['order_details']['shipping_address_1']
		    . "<br>Address 2:" . $details['order_details']['shipping_address_2']
		    . "<br>Country:" . $details['order_details']['shipping_country']
		    . "<br>City:" . $details['order_details']['shipping_city']
		    . "<br>Zip Code:" . $details['order_details']['shipping_zip_code']
		    . "<br>State:" . $details['order_details']['shipping_state'];
	  }

	  $items_count = count($details['items']);
	  if($items_count > 0){
		  $stored_session = $order_query[0]['order_session_id'];
	  	$items = $details['items'];
      $msg .= "<br><br>Items:";
			$i = 0;
			for($i;$i<$items_count;$i++){
				$msg .= "<br><br>Item #" . ($i + 1)
			    . "<br>ID #:" . $items[$i]['id']
			    . "<br>Type:" . $items[$i]['type']
			    . "<br>Price Each:" . $items[$i]['price']
			    . "<br>Amount:" . $items[$i]['amount']
			    . "<br>Price Total:" . $items[$i]['total'];
        if($items[$i]['type'] == 'merch'){
			    $msg .= '<br>Item Link: <a href="">' . $BASE_URL . 'product.php?id=' . $items[$i]['id'] . "</a>";
				  $variant_query = $DB->query("SELECT * FROM merchandise_variant WHERE merchandise_variant_id='" . $items[$i]['variant'] . "' LIMIT 1");
					if(isset($variant_query[0])){
						$msg .= "<br>Variant Label:" . $variant_query[0]['merchandise_variant_label'];
					}
			  }else if($items[$i]['type'] == 'frame'){
			    $msg .= '<br>Item Link: <a href="">' . $BASE_URL . 'admin/frames_edit.php?id=' . $items[$i]['id'] . "</a>";
			  }
			  if(isset($items[$i]['size'])){
					$msg .= "<br>Size:" . $items[$i]['size'];
			  }
			  if(isset($items[$i]['clothe'])){
				  $pets_query = $DB->query("SELECT * FROM order_pet LEFT JOIN clothes ON clothes.clothes_id=order_pet.order_pet_clothe_ref_id WHERE order_pet_session_id='$stored_session'");
					if(isset($pets_query[0])){
					  $pets_count = count($pets_query);
					  if($pets_count > 0){
				      $msg .= "<br><br>Pets:";
							$k = 0;
							for($k;$k<$pets_count;$k++){
								$msg .= "<br>Pet #" . ($k + 1)
							    . "<br>Name:" . $pets_query[$k]['order_pet_name']
							    . "<br>Collection Name:" . $pets_query[$k]['clothes_title'];
							  if($pets_query[$k]['order_pet_animal'] == '0'){
									$msg .= "<br>Animal:Dog";
							  }else{
									$msg .= "<br>Animal:Cat";
							  }
							  if($pets_query[$k]['clothes_gender'] == '0'){
									$msg .= "<br>Gender:Male";
							  }else{
									$msg .= "<br>Gender:Female";
							  }
								$this_pet_info = objectToArray(json_decode($pets_query[$k]['order_pet_clothe_optional']));
								if(isset($this_pet_info['imgs'])){
									$msg .= "<br>BG:" . $this_pet_info['bg']
										. "<br>Label 1:" . $this_pet_info['label1']
										. "<br>Label 2:" . $this_pet_info['label2']
										. "<br>Label 3:" . $this_pet_info['label3']
										. "<br>Label 4:" . $this_pet_info['label4'];
									$this_pet_info_count = count($this_pet_info['imgs']);
									$d = 0;
									for($d;$d<$this_pet_info_count;$d++){
										$msg .= "<br>Uploaded Image #" . ($d + 1) . ":<a href='" . $BASE_URL . $this_pet_info['imgs'][$d] . "'>" . $BASE_URL . $this_pet_info['imgs'][$d] . "</a>";
									}
								}
							}
					  }
					}
			  }
			}
	  }


	}
	$msg .= "<br><br>";


	if($payment_status=='Refunded'){
		$subject = "Refund for Order #" . $item_number;
	}else{
		$subject = "Payment for Order #" . $item_number;
		$pay_type = 'paypal';
		// email receipt
	    include("email_receipt.php"); 
	}

	// if (strcmp ($res, "VERIFIED") == 0) {

		if(isset($order_query[0])){
			if(($order_query[0]['order_transaction_id'] == '') && ($txn_id != '')){
				$DB->sql("UPDATE `$DB_SCHEMA`.`order` SET order_transaction_id='$txn_id' WHERE order_id='$item_number' LIMIT 1");
			}
			if($order_query[0]['order_payment_status'] == '2'){
				$msg .= "The customer attempted to pay again for the order #" . $item_number . " which is already flagged as paid.<br><br>";
			}else{
				$DB->sql("UPDATE `$DB_SCHEMA`.`order` SET order_payment_status='$payment_status', order_update_timestamp='$MICROTIME' WHERE order_id='$item_number' LIMIT 1");
				if($payment_status=='Completed'){
					$msg .= "The transaction for the order #" . $item_number . " is now Complete and the system was successfully updated.<br>";
				}else if($payment_status=='Pending'){
					$msg .= "The transaction for the order #" . $item_number . " is now Pending and the system was successfully updated.<br>";
				}else if($payment_status=='Refunded'){
					$msg .= "The system was successfully updated for the refund of the transaction of the order #" . $item_number . ".<br>";
				}
			}
		}else{
			$msg .= "The customer with email account " . $payer_email . " attempted to pay for the order #" . $item_number . ", which order was not found in the system. Please investigate what went wrong for this transaction.<br>";
		}
		$msg .= "The transaction for the order #" . $item_number . " was verified.<br>";

	// } else if (strcmp ($res, "INVALID") == 0) {
	// 	// log for manual investigation
	// 	// Add business logic here which deals with invalid IPN messages
	// 	$msg .= "The transaction for the order #" . $item_number . " was flagged as INVALID and needs further investigation.<br>";
	// }

	$msg=$msgH.$msg.$msgF;
}

@mail($ADMIN_EMAIL, $subject, $msg,$hds);


exit();
?>