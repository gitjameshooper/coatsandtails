<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

if(isset($_POST["total"]) && isset($_POST["shipping"]) && isset($_POST["discount"]) && isset($_POST["d"])){
  $total = isSetAndNotDefault('', 'POST', 'total', true, 'Missing total');
  $shipping = isSetAndNotDefault('', 'POST', 'shipping', true, 'Missing shipping');
  $discount = isSetAndNotDefault('', 'POST', 'discount', true, 'Missing discount');
  $d = $_POST["d"];

  $d_cleaned = filterAndSanitize($d);
  if($d_cleaned == ''){
    appendError('Missing data');
  }
  if($ERROR === ''){

    $d_arr = json_decode(stripslashes($d), true);
    $items = $d_arr['items'];
    $d_arr_count = count($items);

    $d = base64_encode($d);

    $subtotal = number_format($total, 2);
    $shipping = number_format($shipping, 2);
    $discount = number_format($discount, 2);
    $total = number_format($total, 2);
    $tax = number_format(($total * ($TAX_PERCENT / 100)), 2);
    $total = number_format(($total + $tax + $shipping - $discount), 2);


    $order_query = $DB->query("SELECT * FROM `$DB_SCHEMA`.`order` WHERE order_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY order_id DESC LIMIT 1");
    if(isset($order_query[0])){
      $DB->sql("UPDATE `$DB_SCHEMA`.`order` SET order_session_id='" . $_COOKIE['PHPSESSID'] . "', order_details='" . $d . "', order_update_timestamp='$MICROTIME', order_total='" . $total . "' WHERE order_id='" . $order_query[0]['order_id'] . "' LIMIT 1");
    }else{
      $DB->sql("INSERT INTO `$DB_SCHEMA`.`order` SET order_session_id='" . $_COOKIE['PHPSESSID'] . "', order_details='" . $d . "', order_addition_timestamp='$MICROTIME', order_update_timestamp='$MICROTIME', order_total='" . $total . "'");
    }
    if(!isset($order_query[0])){
      usleep(1000000); // delay for 1sec | give the db a chance to catch up
      $order_query = $DB->query("SELECT * FROM `$DB_SCHEMA`.`order` WHERE order_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY order_id DESC LIMIT 1");
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

    include_once(dirname(dirname(__FILE__)) . '/bits/paypal.inc.php');

    $paypal = new paypal();

    //set the price
    $paypal->price = $total;
    $paypal->ipn = $BASE_URL . 'services/ipn.php'; //full web address to IPN script

    // //enable recurring payment(subscription) for every number of years
    // $paypal->recurring_year('0');
    // //OR every number of months
    // $paypal->recurring_month('0');
    // //OR every number of days
    // $paypal->recurring_day('0');
    //OR one-time payment
    $paypal->enable_payment();

    //change currency code
    $paypal->add('currency_code','USD');
    // $paypal->add('tax', $tax);
    // $paypal->add('shipping', $shipping);

    //your paypal email address
    $paypal->add('business', $PAYPAL_RECEPIENT_EMAIL);

    $paypal->add('item_name', 'Order #' . $order_query[0]['order_id']);
    $paypal->add('item_number', $order_query[0]['order_id']); //Unique order id
    $paypal->add('quantity', 1);

    $paypal->add('return', $BASE_URL);
    $paypal->add('cancel_return', $BASE_URL);

    $arr=array('result'=>'success','data'=>$paypal->output_form());

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