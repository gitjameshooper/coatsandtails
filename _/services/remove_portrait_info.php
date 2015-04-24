<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

if($DB->sql("DELETE FROM order_pet WHERE order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY order_pet_id DESC LIMIT 4")){
	$arr=array('result'=>'success');
}else{
	$arr=array('result'=>'error','error_msg'=>'removal_failed');
}

unset($_SESSION['quiz']);
unset($_SESSION['quiz_collection']);
unset($_SESSION['target_collection']);
unset($_SESSION['target_mode']);

closeConnections();

echo json_encode($arr);
?>