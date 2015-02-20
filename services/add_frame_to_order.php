<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

$arr=array();

if(isset($_POST["id"]) && isset($_POST["size"])){
	$frame_id = isSetAndNotDefault('', 'POST', 'id', true, 'Missing frame id');
	$size = isSetAndNotDefault('', 'POST', 'size', true, 'Missing frame size');
	if($ERROR === ''){
		$frames = $DB->query("SELECT * FROM frames WHERE frames_id='" . $frame_id . "' LIMIT 1");
		if(isset($frames[0])){

			if((int)$frames[0]['frames_' . $size . '_availability'] > 0){
				$cart_info = array();
				$cart_total = 0;

				$cart_query = $DB->query("SELECT * FROM cart WHERE cart_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY cart_id DESC LIMIT 1");
				if(isset($cart_query[0])) {
					$cart_info = objectToArray(json_decode($cart_query[0]['cart_payload']));
					$cart_total = (float)$cart_info['total'];
				}else{
					$cart_info['total'] = $cart_total;
					$cart_info['items'] = array();
					$DB->sql("INSERT INTO cart SET cart_session_id='" . $_COOKIE['PHPSESSID'] . "', cart_payload='" . json_encode($cart_info) . "', cart_addition_timestamp='$MICROTIME'");
				}
				$cart_info_count = count($cart_info['items']);
				$found_in_cart = false;

				if($cart_info_count > 0){
					$i = 0;
					for($i;$i<$cart_info_count;$i++){
						if(($cart_info['items'][$i]['type'] == 'frame') && ($cart_info['items'][$i]['id'] == $frame_id)){
							$found_in_cart = true;
							if((int)$cart_info['items'][$i]['amount'] >= (int)$frames[0]['frames_' . $size . '_availability']){
								$arr=array('result'=>'error','error_msg'=>'frame_not_available');
							}else{
								$cart_info['items'][$i]['amount']++;
								$cart_total += (float)$frames[0]['frames_' . $size . '_price'];
								$cart_info['total'] = $cart_total;
							}
							$amount_of_item_in_cart = $cart_info['items'][$i]['amount'];
							break;
						}
					}
				}
				if(!$found_in_cart){
					$amount_of_item_in_cart = 1;
					$cart_info['total'] = ($cart_total + (float)$frames[0]['frames_' . $size . '_price']);
					array_push(
						$cart_info['items'],
						array(
							'type'=>'frame',
							'id'=>$frame_id,
							// 'title'=>$frames[0]['frames_title'],
							'amount'=>1,
							'size'=>$size,
							'price'=>(float)$frames[0]['frames_' . $size . '_price']
							)
						);
				}

				if(count($arr) == 0){
					$arr=array('result'=>'success');
				}

				$DB->sql("UPDATE cart SET cart_payload='" . json_encode($cart_info) . "' WHERE cart_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY cart_id DESC LIMIT 1");
			}else{
				$arr=array('result'=>'error','error_msg'=>'frame_not_available');
			}
		}else{
			$arr=array('result'=>'error','error_msg'=>'frame_not_found');
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