<?php
$IS_ADMIN_PAGE = true;
$IS_SERVICE = true;
include_once(dirname(dirname(dirname(__FILE__))) . '/defChecks.php');
commonHeaders();

if($LOGGED){
	if(isset($_POST["id"])){
		$frames_id = isSetAndNotDefault('', 'POST', 'id', false);

		if($ERROR === ''){
			$get_frames_query = $DB->query("SELECT * FROM frames WHERE frames_id='$frames_id' LIMIT 1");
			if(isset($get_frames_query[0])){

				$DB->sql("DELETE FROM frames WHERE frames_id='$frames_id' LIMIT 1");
				$DB->sql("DELETE FROM frames_imgs WHERE frames_ref_id='$frames_id'");
				$DB->sql("DELETE FROM promo_codes WHERE promo_codes_applied_to_item_type='frame' AND promo_codes_applied_to_item_id='$frames_id'");
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