<?php
$IS_ADMIN_PAGE = true;
$IS_SERVICE = true;
include_once(dirname(dirname(dirname(__FILE__))) . '/defChecks.php');
commonHeaders();

if($LOGGED){
	if(isset($_POST["id"])){
		$merchandise_id = isSetAndNotDefault('', 'POST', 'id', false);

		if($ERROR === ''){
			$get_merchandise_query = $DB->query("SELECT * FROM merchandise WHERE merchandise_id='$merchandise_id' LIMIT 1");
			if(isset($get_merchandise_query[0])){

				$DB->sql("DELETE FROM merchandise WHERE merchandise_id='$merchandise_id' LIMIT 1");
				$DB->sql("DELETE FROM promo_codes WHERE promo_codes_applied_to_item_type='merchandise' AND promo_codes_applied_to_item_id='$merchandise_id'");
				$arr=array('result'=>'success');
			}else{
				$arr=array('result'=>'error','error_msg'=>'not_found');
			}
		}else{
			$arr=array('result'=>'error','error_msg'=>'params_missing');
		}
	}else{
		$arr=array('result'=>'error','error_msg'=>'params_missing');
	}
}else{
	$arr=array('result'=>'error','error_msg'=>'not_logged');
}

closeConnections();

$arr['time'] = round(((microtime(true)-$MICROTIME)*1000), 4) . 'ms';

echo json_encode($arr);
?>