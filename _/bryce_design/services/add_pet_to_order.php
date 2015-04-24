<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

$arr=array();

if(isset($_SESSION['target_collection'])){
	$target_collection = $_SESSION['target_collection'];
	$clothes = $DB->query("SELECT * FROM clothes WHERE clothes_id='" . $target_collection . "' LIMIT 1");

	$order_pet_query = $DB->query("SELECT * FROM order_pet WHERE order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "'");
	if(isset($clothes[0])){

		if(isset($_POST["a"]) && isset($_POST["bg"]) && isset($_POST["pet_name"]) && isset($_POST["label1"]) && isset($_POST["label2"]) && isset($_POST["label3"]) && isset($_POST["label4"])){
			$animal = isSetAndNotDefault('', 'POST', 'a', true, 'Missing animal');
			$bg = isSetAndNotDefault('', 'POST', 'bg', true, 'Missing bg');
			$pet_name = isSetAndNotDefault('', 'POST', 'pet_name', true, 'Missing pet name');
			$label1 = isSetAndNotDefault('', 'POST', 'label1', true, 'Missing label 1');
			$label2 = isSetAndNotDefault('', 'POST', 'label2', true, 'Missing label 2');
			$label3 = isSetAndNotDefault('', 'POST', 'label3', true, 'Missing label 3');
			$label4 = isSetAndNotDefault('', 'POST', 'label4', true, 'Missing label 4');
			if($ERROR === ''){
				$existing_pet = $DB->query("SELECT * FROM order_pet WHERE order_pet_name='$pet_name' AND order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "'");
				if(!isset($existing_pet[0])){
					$order_pet_info = array(
						'bg'=>$bg,
						'label1'=>$label1,
						'label2'=>$label2,
						'label3'=>$label3,
						'label4'=>$label4
						);
					if($DB->sql("INSERT INTO order_pet SET order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "', order_pet_animal='$animal', order_pet_clothe_ref_id='$target_collection', order_pet_name='$pet_name', order_pet_clothe_optional='" . json_encode($order_pet_info) . "'")){
						$arr=array('result'=>'success','pet_count'=>(count($order_pet_query) + 1));
					}else{
						$arr=array('result'=>'error','error_msg'=>'pet_found');
					}
				}else{
					$arr=array('result'=>'error','error_msg'=>'not_added');
				}

			}else{
				$arr=array('result'=>'error','error_msg'=>'params_missing');
			}
		}else{
			$arr=array('result'=>'error','error_msg'=>'params_missing');
		}
	}else{
		$arr=array('result'=>'error','error_msg'=>'collection_not_found');
	}
}else{
	$arr=array('result'=>'error','error_msg'=>'params_missing');
}

closeConnections();

echo json_encode($arr);
?>