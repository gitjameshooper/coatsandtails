<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();

$t_and_c_query = $DB->query("SELECT * FROM global_variables WHERE global_variables_id='1' LIMIT 1");
if(isset($t_and_c_query[0])){
	$arr=array('result'=>'success','data'=>htmlspecialchars_decode($t_and_c_query[0]['terms_and_conditions']));
}else{
	$arr=array('result'=>'error','error_msg'=>'not_found');
}

closeConnections();

echo json_encode($arr);
?>