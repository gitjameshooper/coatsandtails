<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

$arr=array();

if(isset($_POST["id"]) && isset($_POST["variant"])){
	$target_id = isSetAndNotDefault('', 'POST', 'id', false);
	$variant_id = isSetAndNotDefault('', 'POST', 'variant', false);

	if(!is_numeric($target_id)){
		$target_id = 0;
	}else if((int)$target_id < 0){
		$target_id = 0;
	}

	if(!is_numeric($variant_id)){
		$variant_id = 0;
	}else if((int)$variant_id < 0){
		$variant_id = 0;
	}

	if(($target_id != 0) && ($variant_id != 0)){
		if($ERROR === ''){
			$target_merchandise = $DB->query("SELECT * FROM merchandise, merchandise_variant WHERE merchandise_variant.merchandise_variant_merchandise_id=merchandise.merchandise_id AND merchandise_id='$target_id' AND merchandise_variant_id='$variant_id' AND merchandise_status='0' GROUP BY merchandise.merchandise_id LIMIT 1");
			if(isset($target_merchandise[0])){
				$target_merchandise[0]['imgs'] = $DB->query("SELECT merchandise_imgs_dir FROM merchandise_imgs WHERE merchandise_ref_id='$target_id' ORDER BY merchandise_imgs_id ASC LIMIT 1000");
				if((int)$target_merchandise[0]['merchandise_variant_availability'] > 0){

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
							if(($cart_info['items'][$i]['type'] == 'merch') && ($cart_info['items'][$i]['id'] == $target_id) && ($cart_info['items'][$i]['variant'] == $variant_id)){
								$found_in_cart = true;
								if((int)$cart_info['items'][$i]['amount'] >= (int)$target_merchandise[0]['merchandise_variant_availability']){
									$arr=array('result'=>'error','error_msg'=>'not_enough_available');
								}else{
									$cart_info['items'][$i]['amount']++;
									$cart_total += (float)$target_merchandise[0]['merchandise_variant_price'];
									$cart_info['total'] = $cart_total;
								}
								$amount_of_item_in_cart = $cart_info['items'][$i]['amount'];
								break;
							}
						}
					}
					if(!$found_in_cart){
						$amount_of_item_in_cart = 1;
						$cart_info['total'] = ($cart_total + (float)$target_merchandise[0]['merchandise_variant_price']);
						array_push(
							$cart_info['items'],
							array(
								'type'=>'merch',
								'id'=>$target_id,
								'variant'=>$variant_id,
								// 'title'=>$target_merchandise[0]['merchandise_title'],
								'amount'=>1,
								'price'=>(float)$target_merchandise[0]['merchandise_variant_price']
								)
							);
					}

					if(empty($arr)){
						$arr=array(
							'result'=>'success',
							'title'=>stripslashes($target_merchandise[0]['merchandise_title']),
							'img'=>'default_dir/',
							'amount'=>$amount_of_item_in_cart,
							'cart_total'=>number_format($cart_info['total'], 2)
							);
						if(isset($target_merchandise[0]['imgs'][0])){
							$arr['img'] = $target_merchandise[0]['imgs'][0]['merchandise_imgs_dir'];
						}
						if(!$DB->sql("UPDATE cart SET cart_payload='" . json_encode($cart_info) . "' WHERE cart_session_id='" . $_COOKIE['PHPSESSID'] . "' ORDER BY cart_id DESC LIMIT 1")){
							$arr=array('result'=>'error','error_msg'=>'not_added','raw'=>$cart_info);
						}
					}

				}else{
					$arr=array('result'=>'error','error_msg'=>'out_of_stock');
				}
			}else{
				$arr=array('result'=>'error','error_msg'=>'not_found');
			}
		}else{
			$arr=array('result'=>'error','error_msg'=>'params_missing');
		}
	}
}else{
	$arr=array('result'=>'error','error_msg'=>'params_missing');
}

closeConnections();

echo json_encode($arr);
?>