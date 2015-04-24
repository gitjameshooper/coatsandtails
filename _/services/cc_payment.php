<?php
// namespace services;
// require(dirname(dirname(__FILE__)) . '/bits/vendor/autoload.php');

// use PayPal\Auth\OAuthTokenCredential;

// include_once(dirname(dirname(__FILE__)) . '/bits/vendor/paypal/Auth/OAuthTokenCredential.php');


$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

if(
    isset($_POST["total"]) &&
    isset($_POST["shipping"]) &&
    isset($_POST["discount"]) &&
    isset($_POST["d"]) &&
    isset($_POST["first_name"]) &&
    isset($_POST["last_name"]) &&
    isset($_POST["email"]) &&
    isset($_POST["phone"]) &&
    isset($_POST["address_1"]) &&
    isset($_POST["address_2"]) &&
    isset($_POST["country"]) &&
    isset($_POST["city"]) &&
    isset($_POST["zip_code"]) &&
    isset($_POST["state"]) &&
    isset($_POST["billing_same_as_shipping"]) &&
    isset($_POST["shipping_first_name"]) &&
    isset($_POST["shipping_last_name"]) &&
    isset($_POST["shipping_phone"]) &&
    isset($_POST["shipping_address_1"]) &&
    isset($_POST["shipping_address_2"]) &&
    isset($_POST["shipping_country"]) &&
    isset($_POST["shipping_city"]) &&
    isset($_POST["shipping_zip_code"]) &&
    isset($_POST["shipping_state"]) &&
    isset($_POST["company"]) &&
    isset($_POST["card_type"]) &&
    isset($_POST["name_on_card"]) &&
    isset($_POST["cc_num"]) &&
    isset($_POST["ccv_num"]) &&
    isset($_POST["expiration_m"]) &&
    isset($_POST["expiration_y"]) &&
    isset($_POST["pick_up"]) &&
    isset($_POST["comment"]) &&
    isset($_POST["coupon"])
  ){
  $total = isSetAndNotDefault('', 'POST', 'total', true, 'Missing total');
  $shipping = isSetAndNotDefault('', 'POST', 'shipping', true, 'Missing shipping');
  $discount = isSetAndNotDefault('', 'POST', 'discount', true, 'Missing discount');

  $first_name = isSetAndNotDefault('', 'POST', 'first_name', true, 'Missing first name');
  $last_name = isSetAndNotDefault('', 'POST', 'last_name', true, 'Missing last name');
  $email = isSetAndNotDefault('', 'POST', 'email', true, 'Missing email');
  $phone = isSetAndNotDefault('', 'POST', 'phone',false);
  $address_1 = isSetAndNotDefault('', 'POST', 'address_1', true, 'Missing address 1');
  $address_2 = isSetAndNotDefault('', 'POST', 'address_2', false);
  $country = isSetAndNotDefault('', 'POST', 'country', true, 'Missing country');
  $city = isSetAndNotDefault('', 'POST', 'city', true, 'Missing city');
  $zip_code = isSetAndNotDefault('', 'POST', 'zip_code', false);
  $state = isSetAndNotDefault('', 'POST', 'state', false);

  $company = isSetAndNotDefault('', 'POST', 'company', false);

  $coupon = isSetAndNotDefault('', 'POST', 'coupon', false);

  $billing_same_as_shipping = isSetAndNotDefault('', 'POST', 'billing_same_as_shipping', true, 'Unknown is the shipping address is the same as the billing address');

  if($billing_same_as_shipping == '1'){
    $shipping_first_name = $first_name;
    $shipping_last_name = $last_name;
    $shipping_phone = $phone;
    $shipping_address_1 = $address_1;
    $shipping_address_2 = $address_2;
    $shipping_country = $country;
    $shipping_city = $city;
    $shipping_zip_code = $zip_code;
    $shipping_state = $state;
  }else{
    $shipping_first_name = isSetAndNotDefault('', 'POST', 'shipping_first_name', true, 'Missing shipping first name');
    $shipping_last_name = isSetAndNotDefault('', 'POST', 'shipping_last_name', true, 'Missing shipping last name');
    $shipping_phone = isSetAndNotDefault('', 'POST', 'shipping_phone',false);
    $shipping_address_1 = isSetAndNotDefault('', 'POST', 'shipping_address_1', true, 'Missing shipping address 1');
    $shipping_address_2 = isSetAndNotDefault('', 'POST', 'shipping_address_2', false);
    $shipping_country = isSetAndNotDefault('', 'POST', 'shipping_country', true, 'Missing shipping country');
    $shipping_city = isSetAndNotDefault('', 'POST', 'shipping_city', true, 'Missing shipping city');
    $shipping_zip_code = isSetAndNotDefault('', 'POST', 'shipping_zip_code', false);
    $shipping_state = isSetAndNotDefault('', 'POST', 'shipping_state', false);
  }


  $card_type = isSetAndNotDefault('', 'POST', 'card_type', true, 'Missing the type of credti card');
  $name_on_card = isSetAndNotDefault('', 'POST', 'name_on_card', true, 'Missing the name on the credti card');
  $cc_num = isSetAndNotDefault('', 'POST', 'cc_num', true, 'Missing the credit card number');
  $ccv_num = isSetAndNotDefault('', 'POST', 'ccv_num', false);
  $expiration_m = isSetAndNotDefault('', 'POST', 'expiration_m', true, 'Missing the expiration month');
  $expiration_y = isSetAndNotDefault('', 'POST', 'expiration_y', true, 'Missing the expiration year');

  $pick_up = isSetAndNotDefault('', 'POST', 'pick_up', true, 'Missing the pick up option');

  $comment = isSetAndNotDefault('', 'POST', 'comment', false);

  $d = $_POST["d"];

  $d_cleaned = filterAndSanitize($d);
  if($d_cleaned == ''){
    appendError('Missing data');
  }
  if($ERROR === ''){
    $stored_session = $_COOKIE['PHPSESSID'];

    $d_arr = json_decode(stripslashes($d), true);
    $items = $d_arr['items'];
    $d_arr_count = count($items);

    $d = serialize($d);

    $shipping = number_format($shipping, 2);
    $discount = number_format($discount, 2);
    $total = number_format($total, 2);
    $tax = number_format(($total * ($TAX_PERCENT / 100)), 2);
    $total = number_format(($total + $tax + $shipping - $discount), 2);

    $order_id = $MICROTIME;

    $order_query = $DB->query("SELECT * FROM `$DB_SCHEMA`.`order` WHERE order_session_id='$stored_session' ORDER BY order_id DESC LIMIT 1");
    if(isset($order_query[0])){
      $DB->sql("UPDATE `$DB_SCHEMA`.`order` SET order_session_id='$stored_session', order_details='" . $d . "', order_update_timestamp='$MICROTIME', order_total='" . $total . "' WHERE order_id='" . $order_query[0]['order_id'] . "' LIMIT 1");
    }else{
      $DB->sql("INSERT INTO `$DB_SCHEMA`.`order` SET order_session_id='$stored_session', order_details='" . $d . "', order_addition_timestamp='$MICROTIME', order_update_timestamp='$MICROTIME', order_total='" . $total . "'");
    }
    if(!isset($order_query[0])){
      usleep(1000000); // delay for 1sec | give the db a chance to catch up
      $order_query = $DB->query("SELECT * FROM `$DB_SCHEMA`.`order` WHERE order_session_id='$stored_session' ORDER BY order_id DESC LIMIT 1");
    }

    if(isset($order_query[0])){
      $order_id = $order_query[0]['order_id'];
    }

    // NOTE | Disabled inventory update
    // $i = 0;
    // for($i;$i<$d_arr_count;$i++){
    //   $this_id = $items[$i]['id'];
    //   $amount = (int)$items[$i]['amount'];
    //   if($items[$i]['type'] == 'frame'){
    //     $frame = $DB->query("SELECT * FROM frames WHERE frames_id='$this_id' LIMIT 1");
    //     $size = $items[$i]['size'];
    //     if(isset($frame)){
    //       $DB->sql("UPDATE frames SET frames_" . $size . "_availability='" . ((int)$frame[0]["frames_" . $size . "_availability"] - $amount) . "' WHERE frames_id='$this_id' LIMIT 1");
    //     }
    //   }else if($items[$i]['type'] == 'merch'){
    //     $this_variant_id = $items[$i]['variant'];
    //     $merchandise = $DB->query("SELECT * FROM merchandise, merchandise_variant WHERE merchandise_variant.merchandise_variant_merchandise_id=merchandise.merchandise_id WHERE merchandise_id='$this_id' AND merchandise_variant_id='$this_variant_id' LIMIT 1");
    //     if(isset($merchandise) && isset($merchandise[0])){
    //       $DB->sql("UPDATE merchandise_variant SET merchandise_variant_availability='" . ((int)$merchandise[0]["merchandise_variant_availability"] - $amount) . "' WHERE merchandise_variant_id='$this_variant_id' LIMIT 1");
    //     }
    //   }
    // }

    $DB->sql("UPDATE `$DB_SCHEMA`.`order` SET order_payment_status='0', order_update_timestamp='$MICROTIME' WHERE order_id='" . $order_query[0]['order_id'] . "' LIMIT 1");
    $DB->sql("UPDATE cart SET cart_order_status='1' WHERE cart_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY cart_id DESC LIMIT 1");
    $DB->sql("UPDATE order_pet SET order_pet_status='1' WHERE order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY order_pet_id ASC");

    require_once(dirname(dirname(__FILE__)) . '/bits/paypal/phpPayPal.class.php');

    $p = new phpPayPal($PAYPAL_CONFIG, $PAYPAL_IS_IN_SANDBOX_MODE);

    //(required)
    $p->ip_address = $_SERVER['HTTP_HOST']=='localhost'?'127.0.0.1':$_SERVER['REMOTE_ADDR'];

    $p->use_proxy = false;
    $p->return_url = $BASE_URL . '?action=return';
    $p->cancel_url = $BASE_URL . '?action=cancel';
    //$p->notify_url = $BASE_URL . '?action=notify';

    // Order Totals (amount_total is required)
    // $p->amount_handling  = urlencode($this->amount_handling);
    // $p->amount_items    = ((float)$total + (float)$tax);
    // $p->amount_shipping = (float)$shipping;
    // $p->amount_tax    = (float)$tax;
    $p->amount_items    = number_format((float)$total, 2);
    $p->amount_total = number_format((float)$total, 2);
    $p->invoice_number = $order_id;

    // Credit Card Information (required)
    $p->credit_card_number = $cc_num;
    $p->credit_card_type = $card_type;
    $p->cvv2_code = $ccv_num;
    $p->expire_date = $expiration_m . $expiration_y;

    // Billing Details (required)
    $p->first_name = $first_name;
    $p->last_name = $last_name;
    $p->address1 = $address_1;
    $p->address2 = $address_2;
    $p->email = $email;
    $p->city = $city;
    $p->state = $state;
    $p->postal_code = $zip_code;
    $p->phone_number = $phone;
    $p->country_code = $country;

    // if($billing_same_as_shipping == '0'){
    //   // Shipping Details
    //   $p->shipping_name = $shipping_first_name . ' ' . $shipping_last_name;
    //   $p->shipping_address1 = $shipping_address_1;
    //   $p->shipping_address2 = $shipping_address_2;
    //   $p->shipping_city = $shipping_city;
    //   $p->shipping_state = $shipping_state;
    //   $p->shipping_postal_code = $shipping_zip_code;
    //   $p->shipping_phone_number = $shipping_phone;
    //   $p->shipping_country_code = $shipping_country;
    // }

    $p->add_item('Order #' . $order_id, $order_id, 1, 0, number_format((float)$total, 2));

    // Perform the payment
    $p->do_direct_payment();
    $resp = $p->Response;

    if(isset($resp['ACK'])){
      if($resp['ACK'] == 'Success'){

        $hds = "From: $SITE_NAME <$SALES_EMAIL>\nX-Mailer: PHP/".phpversion()
          . "\nReply-To: $SALES_EMAIL\nX-Priority: 3\nMIME-Version: 1.0\nContent-type: text/html; charset=utf-8\n";

        $msgH = '<html><head><title>' . $SITE_NAME . '</title></head><body><table width="100%" border="0" cellpadding=0 cellspacing=0><tr height=5><td width="8"></td><td></td></tr><tr><td width="8"></td><td><font style="font-family:Tahoma;font-size:14px">' . $SITE_NAME . ' - Payment for order '.$order_id.'</font></td></tr><tr height="40"><td colspan=2></td></tr><tr><td></td><td><font style="font-family:Tahoma;font-size:12px">Hello,<br><br>';
        $msgF = '</font></td></tr></table></body ></html>';


        $msg = "Billing Info"
          . "<br>First Name:" . $first_name
          . "<br>Last Name:" . $last_name
          . "<br>Address 1:" . $address_1
          . "<br>Address 2:" . $address_2
          . "<br>Email:" . $email
          . "<br>City:" . $city
          . "<br>State:" . $state
          . "<br>Zip Code:" . $zip_code
          . "<br>Country:" . $country
          . "<br>Phone:" . $phone
          . "<br>Shipping address is the same as the billing address: ";

        if($billing_same_as_shipping == '0'){
          $msg .= "No"
            . "<br><br>Shipping Info"
            . "<br>Shipping Name:" . $shipping_first_name . ' ' . $shipping_last_name
            . "<br>Shipping Address 1:" . $shipping_address_1
            . "<br>Shipping Address 2:" . $shipping_address_2
            . "<br>Shipping City:" . $shipping_city
            . "<br>Shipping State:" . $shipping_state
            . "<br>Shipping Zip Code:" . $shipping_zip_code
            . "<br>Shipping Country:" . $shipping_country
            . "<br>Shipping Phone:" . $shipping_phone;
        }else{
          $msg .= "Yes";
        }

        $msg .= "<br>Chose pick up option: ";

        if($pick_up == '0'){
          $msg .= "No";
        }else{
          $msg .= "Yes";
        }

        $msg .= "<br>Company:" . $company
          . "<br><br>Order Number:" . $order_id
          . "<br>Payment Method:Credit Card"
          . "<br>Payment Status:Complete"
          . "<br>Payment Amount:" . (float)$total
          . "<br><br>Comments:" . $comment;

        if(isset($resp['transaction_id'])){
          $DB->sql("UPDATE `$DB_SCHEMA`.`order` SET order_payment_status='Complete', order_transaction_id='" . $resp['transaction_id'] . "' WHERE order_id='$order_id' LIMIT 1");
          $msg .= "<br>Transaction ID:" . $resp['transaction_id'];
        }

        $msg .= "<br>Tax:" . $tax
          . "<br>Shipping:" . $shipping
          . "<br>Discount:" . $discount;
        $items_count = count($items);
        if($items_count > 0){
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
                        $msg .= "<br>Image #" . ($d + 1) . ":<a href='" . $BASE_URL . $this_pet_info['imgs'][$d] . "'>" . $BASE_URL . $this_pet_info['imgs'][$d] . "</a>";
                      }
                    }
                  }
                }
              }
            }
          }
        }
        $msg .= "<br><br>";

        $subject = "Payment for Order #" . $order_id;
        $msg=$msgH.$msg.$msgF;
        @mail($ADMIN_EMAIL, $subject, $msg, $hds);

        $arr=array('result'=>'success','data'=>$resp);
      }else{
        $arr=array('result'=>'error','error_msg'=>'The payment handler did not process this transaction.','error_msg1'=>$resp,'error_msg2'=>$resp['ACK']);
      }
    }else{
      $arr=array('result'=>'error','error_msg'=>'No response from payment handler.','error_msg2'=>$resp);
    }
  }else{
    $arr=array('result'=>'error','error_msg'=>'params_missing');
  }
}else{
  $arr=array('result'=>'error','error_msg'=>'params_missing');
}

closeConnections();

$mhour=time()-3600;
if(isset($_COOKIE['PHPSESSID'])){setcookie('PHPSESSID','',$mhour,'/');}
if(isset($_COOKIE['coatandtails'])){setcookie('coatandtails','',$mhour,'/');}
session_unset();
session_destroy();

echo json_encode($arr);