<?php
session_start();
$mhour=time()-3600;
if(isset($_COOKIE['PHPSESSID'])){setcookie('PHPSESSID','',$mhour,'/');}
if(isset($_COOKIE['coatandtails'])){setcookie('coatandtails','',$mhour,'/');}
session_unset();
session_destroy();

if(!isset($_SERVER['SERVER_PORT'])){
  $_SERVER['SERVER_PORT'] = '80';
}

$LOCAL_PROTOCOL_IS_SECURE = $_SERVER['SERVER_PORT'] == '80'? false : true;
$LOCAL_PROTOCOL = 'http://';
if($LOCAL_PROTOCOL_IS_SECURE){
  $LOCAL_PROTOCOL = 'https://';
}

if(!isset($_SERVER['HTTP_HOST'])){
  $_SERVER['HTTP_HOST'] = '';
}

if($_SERVER['HTTP_HOST'] === '127.0.0.1'){
  $BASE_URL = $LOCAL_PROTOCOL . "127.0.0.1/coat_tails/";
}else{
  $BASE_URL = $LOCAL_PROTOCOL . "www.coatandtails.com/";
}

if(isset($_GET['p'])){
	header("Location:".$_GET['p']);
	exit();
}else{
	header("Location:" . $BASE_URL);
	exit();
}
?>