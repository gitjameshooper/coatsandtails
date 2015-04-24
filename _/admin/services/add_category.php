<?php
$IS_ADMIN_PAGE = true;
$IS_SERVICE = true;
include_once(dirname(dirname(dirname(__FILE__))) . '/defChecks.php');
commonHeaders();

if($LOGGED){
	if(isset($_POST["title"])){
		$title = isSetAndNotDefault('', 'POST', 'title', false);

		if($ERROR === ''){
			$get_category_query = $DB->query("SELECT * FROM category WHERE category_title='$title' LIMIT 1");
			if(!isset($get_category_query[0])){

				if($DB->sql("INSERT INTO category SET category_title='$title', category_addition_timestamp='$MICROTIME'")){
					$get_category_query = $DB->query("SELECT * FROM category WHERE category_addition_timestamp='$MICROTIME' LIMIT 1");

					$arr=array('result'=>'success','id'=>$get_category_query[0]['category_id']);
				}else{
					$arr=array('result'=>'error','error_msg'=>'not_added');
				}
			}else{
				$arr=array('result'=>'error','error_msg'=>'found');
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