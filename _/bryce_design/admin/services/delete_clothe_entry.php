<?php
$IS_ADMIN_PAGE = true;
$IS_SERVICE = true;
include_once(dirname(dirname(dirname(__FILE__))) . '/defChecks.php');
commonHeaders();

if($LOGGED){
	if(isset($_POST["id"])){
		$clothes_id = isSetAndNotDefault('', 'POST', 'id', false);

		if($ERROR === ''){
			$get_clothes_query = $DB->query("SELECT * FROM clothes WHERE clothes_id='$clothes_id' LIMIT 1");
			if(isset($get_clothes_query[0])){

				$DB->sql("DELETE FROM clothes WHERE clothes_id='$clothes_id' LIMIT 1");
				$DB->sql("DELETE FROM clothes_imgs WHERE clothes_ref_id='$clothes_id'");
				$DB->sql("DELETE FROM promo_codes WHERE promo_codes_applied_to_item_type='clothe' AND promo_codes_applied_to_item_id='$clothes_id'");
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