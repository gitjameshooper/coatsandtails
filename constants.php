<?php
$CDN_IMGS_SECURE = "https://d2q8yhb0v5x74a.cloudfront.net";
$CDN_IMGS = "http://cdn.coatandtails.com/";
if($LOCAL_PROTOCOL_IS_SECURE){
  $CDN_IMGS = "https://d2q8yhb0v5x74a.cloudfront.net/";
}

$PAYPAL_IS_IN_SANDBOX_MODE = true;
if($_SERVER['HTTP_HOST'] === '127.0.0.1'){
  $DB_LOCATION = 'localhost';
  $DB_SCHEMA = 'coat_tails';
  $DB_USER = 'root';
  $DB_PASS = '123456';
  $BASE_URL = $LOCAL_PROTOCOL . "127.0.0.1/coat_tails/";
  $SECURE_BASE_URL = "https://127.0.0.1/coat_tails/";
  $CDN_ASSETS = $LOCAL_PROTOCOL . "127.0.0.1/coat_tails/";
  $CDN_IMGS = $CDN_ASSETS;
} else if ($_SERVER['HTTP_HOST'] === 'www.studioammos.com') {
  $DB_LOCATION = 'localhost';
  $DB_SCHEMA = 'coat_tails';
  $DB_USER = 'IjY04FwQ96m64Ko';
  $DB_PASS = 'UiK8d61aPoP60X!lm36';
  $CDN_IMGS = "http://www.studioammos.com/clients/coat_tails/";
  if($LOCAL_PROTOCOL_IS_SECURE){
    $CDN_IMGS = "https://www.studioammos.com/clients/coat_tails/";
  }
  $BASE_URL = $LOCAL_PROTOCOL . "www.studioammos.com/clients/coat_tails/";
  $SECURE_BASE_URL = "https://www.studioammos.com/clients/coat_tails/";
  $CDN_ASSETS = $CDN_IMGS;

  // Paypal Credentials
  $ADMIN_EMAIL = 'ek_997@hotmail.com';
  $SUPPORT_EMAIL = 'ek_997@hotmail.com';
  $SALES_EMAIL = 'ek_997@hotmail.com';
  $PAYPAL_RECEPIENT_EMAIL = 'ek_997@hotmail.com';
}else{
  $DB_LOCATION = 'IjY04FwQ96m64Ko.db.9969548.hostedresource.com';
  $DB_SCHEMA = 'IjY04FwQ96m64Ko';
  $DB_USER = 'IjY04FwQ96m64Ko';
  $DB_PASS = 'UiK8d61aPoP60X!lm36';
  // MODIFY CDN ENDPOINTS WHEN/IF ONE IS SETUP - START
  $CDN_IMGS = "https://s3.amazonaws.com/coatandtails/";
  $CDN_ASSETS = "http://www.coatandtails.com/";
  if($LOCAL_PROTOCOL_IS_SECURE){
    $CDN_IMGS = "https://s3.amazonaws.com/coatandtails/";
    $CDN_ASSETS = "https://www.coatandtails.com/";
  }
  // MODIFY CDN ENDPOINTS WHEN/IF ONE IS SETUP - END
  $BASE_URL = $LOCAL_PROTOCOL . "www.coatandtails.com/";
  $SECURE_BASE_URL = "https://www.coatandtails.com/";
  // $CDN_ASSETS = $CDN_IMGS; // If css and js are also on s3 then uncomment

  // Paypal Credentials
  $PAYPAL_IS_IN_SANDBOX_MODE = false;

  $ADMIN_EMAIL = 'bryce.dishongh@gmail.com'; // NOTE | THIS SHOULD BE CHANGED TO 'bryce.dishongh@gmail.com';
  $SUPPORT_EMAIL = 'bryce.dishongh@gmail.com'; // NOTE | THIS SHOULD BE CHANGED TO 'support@coatandtails.com';
  $SALES_EMAIL = 'bryce.dishongh@gmail.com'; // NOTE | THIS SHOULD BE CHANGED TO 'sales@coatandtails.com';
  $PAYPAL_RECEPIENT_EMAIL = 'bryce.dishongh@gmail.com'; // NOTE | THIS SHOULD BE CHANGED TO THE CORRECT EMAIL ADDRESS
}


$SITE_NAME = 'Coat and Tails';
$ASSET_VERSION = 10;


// Paypal API Config
$PAYPAL_API_ENDPOINT = 'https://www.paypal.com/cgi-bin/webscr'; // Live endpoint
$PAYPAL_URL = 'www.paypal.com'; // Live url

// LIVE CREDENTIALS
$PAYPAL_CONFIG = array(
    'api_username'=>'bryce.dishongh_api1.gmail.com',
    'api_password'=>'MV7FFKL68UG9NMEB',
    'api_signature'=>'AFcWxV21C7fd0v3bYYYRCpSSRl31AYHc3m41HaHRV.bCFw54.FGwQH9Y',
    'use_proxy'=>false,
    'return_url'=>$BASE_URL . '?action=return',
    'cancel_url'=>$BASE_URL . '?action=cancel',
    'proxy_host'=>null,
    'proxy_port'=>null
  ); // NOTE | THE LIVE CREDENTIALS SHOULD BE CHANGED TO THOSE OF BRYCE's PAYPAL ACCOUNT

// SANDBOX CREDENTIALS
if($PAYPAL_IS_IN_SANDBOX_MODE){
  $PAYPAL_API_ENDPOINT = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; // Sandbox endpoint
  $PAYPAL_URL = 'www.sandbox.paypal.com'; // Sandbox url
  $PAYPAL_CONFIG = array(
      'api_username'=>'ek_997-facilitator_api1.hotmail.com',
      'api_password'=>'KKELHXCTBW8TUN48',
      'api_signature'=>'Acq30LdvY6-Aeti4Ij0EogJa87ZhACCeEgqq04g9jsJcLUa5cj.9Maer',
      'use_proxy'=>false,
      'return_url'=>$BASE_URL . '?action=return',
      'cancel_url'=>$BASE_URL . '?action=cancel',
      'proxy_host'=>null,
      'proxy_port'=>null
    );
}


$ERROR = $SUCCESS = '';

$DB_CONNECTION = "";

$CURL_TIMEOUT = $CURL_CONNECTION_TIMEOUT = 10;

$RAW_STR_REPLACE_SEARCH  = array('&','+','/');
$RAW_STR_REPLACE_REPLACE = array('%26','%2B','%2F');

$SIZE_OPTIONS = array('8x10', '11x14', '16x20', '20x24');

$PORTRAIT_PRICES = array(
    'photo'=>array(
      '8x10'=>40.00,
      '11x14'=>68.30,
      '16x20'=>127.92,
      '20x24'=>168.00
    ),
    'draw'=>array(
      '8x10'=>96.00,
      '11x14'=>123.00,
      '16x20'=>160.00,
      '20x24'=>193.00
    )
  );

$SHIPPING = array(
    'us'=>array(
      'no_frame'=>5.00,
      '8x10'=>10.00,
      '11x14'=>20.00,
      '16x20'=>30.00,
      '20x24'=>40.00
    ),
    'international'=>array(
      'no_frame'=>20.00,
      '8x10'=>35.00,
      '11x14'=>50.00,
      '16x20'=>65.00,
      '20x24'=>80.00
    )
  );

$TAX_PERCENT = 8.25;

?>