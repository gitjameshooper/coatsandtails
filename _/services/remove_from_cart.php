<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

$arr=array();

if(isset($_POST["id"]) && isset($_POST["item"])){
	$id = isSetAndNotDefault('', 'POST', 'id', true, 'Missing the item id');
	$item = isSetAndNotDefault('', 'POST', 'item', true, 'Missing the item type');
	if(($item != "merch") && ($item != "frame") && ($item != "portrait")){
		appendError("Unknown item type.");
	}
	if(!is_numeric($id)){
		appendError("The id was not a number.");
	}else if((float)$id < 0){
		appendError("The id was not a positive number.");
	}
	if($ERROR === ''){

		if($item == "portrait"){
			if($DB->sql("DELETE FROM order_pet WHERE order_pet_session_id='" . $_COOKIE['PHPSESSID'] . "'")){
				$arr=array('result'=>'success');
			}else{
				$arr=array('result'=>'error','error_msg'=>'not_removed');
			}
		}else{

			$cart_query = $DB->query("SELECT * FROM cart WHERE cart_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY cart_id DESC LIMIT 1");
			if(!isset($cart_query[0])) {
				$arr=array('result'=>'error','error_msg'=>'not_found');
			}else{
				$cart_info = objectToArray(json_decode($cart_query[0]['cart_payload']));
				$cart_total = (float)$cart_info['total'];

				$cart_info_count = count($cart_info['items']);
				$found_in_cart = false;

				$i = 0;
				for($i;$i<$cart_info_count;$i++){
					if(($cart_info['items'][$i]['type'] == $item) && ($cart_info['items'][$i]['id'] == $id)){
						$found_in_cart = true;

						$cart_total -= ((float)$cart_info['items'][$i]['price'] * (int)$cart_info['items'][$i]['amount']);
						$cart_info['total'] = $cart_total;

						unset($cart_info['items'][$i]);
						$cart_info['items'] = array_values($cart_info['items']);

						break;
					}
				}

				if(!$found_in_cart){
					$arr=array('result'=>'error','error_msg'=>'not_found');
				}else{
					$arr=array('result'=>'success');
					$DB->sql("UPDATE cart SET cart_payload='" . json_encode($cart_info) . "' WHERE cart_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY cart_id DESC LIMIT 1");
				}

			}
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