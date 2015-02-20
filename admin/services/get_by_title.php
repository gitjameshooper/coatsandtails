<?php
$IS_ADMIN_PAGE = true;
$IS_SERVICE = true;
include_once(dirname(dirname(dirname(__FILE__))) . '/defChecks.php');
commonHeaders();

$arr=array();
if(isset($_POST["s"])){
	$search_term = isSetAndNotDefault('', 'POST', 's', false);
	if($ERROR === ''){
		$clothes_title_query = $DB->query("SELECT * FROM clothes WHERE clothes_title LIKE '%$search_term%' ORDER BY clothes_id DESC LIMIT 10");
		$clothes_title_query_count = count($clothes_title_query);
		if($clothes_title_query_count > 0){
			$i = ($clothes_title_query_count-1);
			do{
				$arr1=array(
					'id'=>$clothes_title_query[$i]['clothes_id'],
					'title'=>$clothes_title_query[$i]['clothes_title'],
					'type'=>'clothe'
					);

				array_push($arr,$arr1);
				--$i;
			}while($i >= 0);
		}

		$frames_title_query = $DB->query("SELECT * FROM frames WHERE frames_title LIKE '%$search_term%' ORDER BY frames_id DESC LIMIT 10");
		$frames_title_query_count = count($frames_title_query);
		if($frames_title_query_count > 0){
			$i = ($frames_title_query_count-1);
			do{
				$arr1=array(
					'id'=>$frames_title_query[$i]['frames_id'],
					'title'=>$frames_title_query[$i]['frames_title'],
					'type'=>'frame'
					);

				array_push($arr,$arr1);
				--$i;
			}while($i >= 0);
		}

		$merchandise_title_query = $DB->query("SELECT * FROM merchandise WHERE merchandise_title LIKE '%$search_term%' ORDER BY merchandise_id DESC LIMIT 10");
		$merchandise_title_query_count = count($merchandise_title_query);
		if($merchandise_title_query_count > 0){
			$i = ($merchandise_title_query_count-1);
			do{
				$arr1=array(
					'id'=>$merchandise_title_query[$i]['merchandise_id'],
					'title'=>$merchandise_title_query[$i]['merchandise_title'],
					'type'=>'merchandise'
					);

				array_push($arr,$arr1);
				--$i;
			}while($i >= 0);
		}
	}
}

closeConnections();

echo json_encode($arr);
?>