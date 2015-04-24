<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

$arr=array();

if(isset($_POST["coupon"])){
	$coupon = isSetAndNotDefault('', 'POST', 'coupon', true, 'Missing coupon');
	if($ERROR === ''){

		$coupon_query = $DB->query("SELECT * FROM promo_codes WHERE promo_codes_code='$coupon' AND promo_codes_active='1' AND (promo_codes_ending_timestamp>'$MICROTIME' OR promo_codes_ending_timestamp='0') AND promo_codes_starting_timestamp<'$MICROTIME' LIMIT 1");
		if(isset($coupon_query[0])){
			$data = array(
				'applied_to'=>$coupon_query[0]['promo_codes_applied_to'],
				'applied_to_item_id'=>$coupon_query[0]['promo_codes_applied_to_item_id'],
				'applied_to_item_type'=>$coupon_query[0]['promo_codes_applied_to_item_type'],
				'condition'=>$coupon_query[0]['promo_codes_condition'],
				'condition_limit'=>(float)$coupon_query[0]['promo_codes_condition_limit'],
				'discount'=>(float)number_format((float)$coupon_query[0]['promo_codes_discount'], 2),
				'type'=>$coupon_query[0]['promo_codes_type']
				);
			$arr=array('result'=>'success','data'=>$data);

		}else{
			$arr=array('result'=>'error','error_msg'=>'not_found');
		}

	}else{
		$arr=array('result'=>'error','error_msg'=>'params_missing');
	}
}else{
	$arr=array('result'=>'error','error_msg'=>'params_missing');
}

closeConnections();

echo json_encode($arr);
?>