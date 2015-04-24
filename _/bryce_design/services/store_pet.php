<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

$arr=array();

if(isset($_POST["id"])){
	$target_collection = isSetAndNotDefault('', 'POST', 'id', true, 'Missing id');
	if($ERROR === ''){

		$_SESSION['target_collection'] = $target_collection;
		$_SESSION['quiz'] = '';

		if(!isset($_SESSION['target_mode'])){
			$arr=array('result'=>'success','mode_known'=>false);
		}else{
			$arr=array('result'=>'success','mode_known'=>true);
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