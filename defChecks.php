<?php
date_default_timezone_set('America/New_York');

$MICROTIME = microtime(true);
$TIME = time();
$TWO_DAYS_AGO = ($TIME - 172800);
$SESSION_ID = session_id();
session_start();
setcookie('coatandtails', $SESSION_ID, ($TIME+3600), "/");

$LOCAL_PROTOCOL_IS_SECURE = https();
$LOCAL_PROTOCOL = 'http://';
if($LOCAL_PROTOCOL_IS_SECURE){
	$LOCAL_PROTOCOL = 'https://';
}

if(!isset($_SERVER['HTTP_HOST'])){
	$_SERVER['HTTP_HOST'] = '';
}

// constants
include_once(dirname(__FILE__) . '/static_files.php');
include_once(dirname(__FILE__) . '/constants.php');

if(!isset($IS_SERVICE)){
	$IS_SERVICE = false;
}
if(!isset($IS_ADMIN_PAGE)){
	$IS_ADMIN_PAGE = false;
}

$DB_CONNECTION = mysql_pconnect($DB_LOCATION,$DB_USER,$DB_PASS);
mysql_select_db($DB_SCHEMA);

if(!isset($LOGGED)){
	$LOGGED = false;
}

if(!isset($CURRENT_PAGE_TYPE)){
	$CURRENT_PAGE_TYPE = "";
}

$DB = new Database;

if(!$IS_ADMIN_PAGE && !$IS_SERVICE){
	$mens_collections = $DB->query("SELECT * FROM clothes WHERE clothes_gender='0' ORDER BY clothes_id DESC LIMIT 1000");
	$mens_collections_count = count($mens_collections);

	$womens_collections = $DB->query("SELECT * FROM clothes WHERE clothes_gender='1' ORDER BY clothes_id DESC LIMIT 1000");
	$womens_collections_count = count($womens_collections);

	$merchandise = $DB->query("SELECT category_title, category_id FROM merchandise, category WHERE merchandise.merchandise_category=category.category_id AND merchandise_status!='1' GROUP BY merchandise_category ORDER BY category_id DESC LIMIT 1000");
	$merchandise_count = count($merchandise);
}

if(isset($_SESSION['p'])){
	$USER_PASSWORD = $_SESSION['p'];
	$curr_user_query = $DB->query("SELECT * FROM admin_user WHERE admin_id='1' LIMIT 1");
	if(isset($curr_user_query[0])){
		if($USER_PASSWORD === $curr_user_query[0]["admin_pass"]){

			$_SESSION['p'] = $USER_PASSWORD;
			$LOGGED = true;
		}
	}
}

if(isset($_SESSION['quiz'])){
	$quiz_res = $_SESSION['quiz'];
	$_SESSION['quiz'] = $quiz_res;
}

if(isset($_SESSION['quiz_collection'])){
	$quiz_res = $_SESSION['quiz_collection'];
	$_SESSION['quiz_collection'] = $quiz_res;
}

if(isset($_SESSION['target_collection'])){
	$target_collection = $_SESSION['target_collection'];
	$_SESSION['target_collection'] = $target_collection;
}

if(isset($_SESSION['target_mode'])){
	$target_mode = $_SESSION['target_mode'];
	$_SESSION['target_mode'] = $target_mode;
}


if($IS_ADMIN_PAGE && (($CURRENT_PAGE_TYPE != 'Login') && !$LOGGED)){
	closeConnections();
	header("Location:" . $BASE_URL . "admin/login.php");
	exit();
}

if(!isset($CURRENT_PAGE_NAME)){
	$CURRENT_PAGE_NAME = "";
}

function sanitize_output($buffer){
	$search = array(
			'/\>[^\S ]+/s', //strip whitespaces after tags, except space
			'/[^\S ]+\</s', //strip whitespaces before tags, except space
			'/(\s)+/s',	// shorten multiple whitespace sequences
			'/\>(\s)+\</s'	// strip whitespaces between tags
			);
	$replace = array('>','<','\\1','><');

	// $buffer = preg_replace($search, $replace, $buffer);

	// $buffer = str_replace(array("\n", "\r", "	"), "", $buffer); // NOTE | Was messing up content in textareas that had linebreaks
	$buffer = str_replace(array("\r\n", "\n", "\r", "\t", "	", "\2n", "\2r", "\2r\2n"), array("", "", "", "", "", "\n", "\r", "\r\n"), $buffer);
	// $buffer = str_replace(array("	", "", $buffer);
	return $buffer;
}

// filter and sanitize any user insert-able/injectable payload prior to committing to the database
function filterAndSanitize($payload){
	global $DB_CONNECTION, $IS_ADMIN_PAGE;

	if(!$IS_ADMIN_PAGE){
		$payload = filter_var($payload, FILTER_SANITIZE_STRING);
	}
	if($_SERVER['HTTP_HOST'] !== '127.0.0.1'){
		if($DB_CONNECTION === ""){
			$payload = mysql_escape_string($payload);
		}else{
			$payload = mysql_real_escape_string($payload);
		}
	}else{
		$payload = mysql_real_escape_string($payload);
	}
	return $payload;
}

class Database{
	protected $rows;
	protected $result;
	public function query($sql){
		global $DB_CONNECTION, $DB_LOCATION, $DB_USER, $DB_PASS, $DB_SCHEMA;
		$result = array();
		if($DB_CONNECTION === ""){
			$DB_CONNECTION = mysql_pconnect($DB_LOCATION,$DB_USER,$DB_PASS);
			mysql_select_db($DB_SCHEMA);
		}
		$t = mysql_query($sql);
		$rows = array();
		if($t != false){
			while($r = mysql_fetch_assoc($t)){
				$rows[] = $r;
			}
			$result = $rows;
			mysql_free_result($t);
		}
		return $result;
	}
	public function sql($sql){
		global $DB_CONNECTION, $DB_LOCATION, $DB_USER, $DB_PASS, $DB_SCHEMA;
		if($DB_CONNECTION === ""){
			$DB_CONNECTION = mysql_pconnect($DB_LOCATION,$DB_USER,$DB_PASS);
			mysql_select_db($DB_SCHEMA);
		}
		return mysql_query($sql);
	}
}

function closeConnections(){
	global $DB_CONNECTION;
	if($DB_CONNECTION !== ""){
		mysql_close($DB_CONNECTION);
		$DB_CONNECTION = "";
	}
}

function https(){
	if(!isset($_SERVER['SERVER_PORT'])){
		$_SERVER['SERVER_PORT'] = '80';
	}
	return $_SERVER['SERVER_PORT'] == '80'? false : true;
}

function isSetAndNotDefault($default, $method, $param, $required, $error_msg=''){
	global $ERROR;
	$temp_var = $default;
	if($method === 'POST'){
		if(isset($_POST[$param])){
			$temp_var = $_POST[$param];
			$temp_var = filterAndSanitize($temp_var);
			if(($temp_var == $default) && $required){
				appendError($error_msg);
			}
		}else if($required){
			appendError($error_msg);
		}
	}else if($method === 'GET'){
		if(isset($_GET[$param])){
			$temp_var = $_GET[$param];
			$temp_var = filterAndSanitize($temp_var);
			if(($temp_var == $default) && $required){
				appendError($error_msg);
			}
		}else if($required){
			appendError($error_msg);
		}
	}else if($method === 'REQUEST'){
		if(isset($_REQUEST[$param])){
			$temp_var = $_REQUEST[$param];
			$temp_var = filterAndSanitize($temp_var);
			if(($temp_var == $default) && $required){
				appendError($error_msg);
			}
		}else if($required){
			appendError($error_msg);
		}
	}
	return $temp_var;
}

function appendError($error_msg=''){
	global $ERROR;
	if($ERROR !== ''){$ERROR .= "<br/>";}
	$ERROR .= $error_msg;
}

function appendSuccess($success_msg=''){
	global $SUCCESS;
	if($SUCCESS !== ''){$SUCCESS .= "<br/>";}
	$SUCCESS .= $success_msg;
}

function str_case($str='', $case=''){
	if(isset($str)){
		if($case == 's'){ // lower case
			return mb_strtolower($str, 'UTF-8');
		}else if($case == 'u'){ // upper case
			return mb_strtoupper($str, 'UTF-8');
		}else if($case == 'uw'){ // camel case | upper case first character of each word
			return mb_convert_case($str, MB_CASE_TITLE, 'UTF-8');
		}else if($case == 'uf'){ // upper case first character of the entire string
			return ucfirst_utf8($str);
		}else{ // return as it was found
			return $str;
		}
	}else{
		return '';
	}
}

function ucfirst_utf8($str){
	if(!empty($str)){
		if($str{0}>="\xc3"){
			return (($str{1}>="\xa0")?
			($str{0}.chr(ord($str{1})-32)):
			($str{0}.$str{1})).substr($str,2);
		}else{
			return ucfirst($str);
		}
	}else{
		return $str;
	}
}

function objectToArray($d){
	if(is_object($d)){
		$d = get_object_vars($d);
	}
	if(is_array($d)){
		return array_map(__FUNCTION__, $d);
	}else{
		return $d;
	}
}

function commonFoot(){
 global $CDN_ASSETS, $CDN_IMGS, $STATIC_FILES, $IS_ADMIN_PAGE, $GZ, $CURRENT_PAGE_TYPE, $ASSET_VERSION;
 $payload = '<script src="' . $CDN_ASSETS . 'js/' . $STATIC_FILES['libs'] . $GZ . '.js?v=' . $ASSET_VERSION . '"></script>';
 if($IS_ADMIN_PAGE){
 $payload .= '<script src="' . $CDN_ASSETS . 'js/' . $STATIC_FILES['admin_js'] . $GZ . '.js?v=' . $ASSET_VERSION . '"></script>';
 }else if($CURRENT_PAGE_TYPE == 'Home'){
 $payload .= '<script src="' . $CDN_ASSETS . 'js/carousel' . $GZ . '.js?v=' . $ASSET_VERSION . '"></script>'
 . '<script src="' . $CDN_ASSETS . 'js/transition' . $GZ . '.js?v=' . $ASSET_VERSION . '"></script>';
 }
 $payload .= '<script src="' . $CDN_ASSETS . 'js/' . $STATIC_FILES['main_js'] . $GZ . '.js?v=' . $ASSET_VERSION . '"></script>'
            . '<script>(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');ga(\'create\',\'UA-35809490-1\',\'auto\');ga(\'send\',\'pageview\');</script>';
 return $payload;

}

function commonHeaders(){
	global $IS_SERVICE, $TWO_DAYS_AGO, $GZ;
	if($IS_SERVICE){
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: pre-check=0, post-check=0, max-age=0");
		header("Pragma: no-cache");
		header("Expires: ".gmdate("D, d M Y H:i:s", $TWO_DAYS_AGO) . " GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header('Content-Type: application/json; charset=utf-8');
		if(!ob_start("ob_gzhandler")) ob_start();
	}else{
		$GZ	= '';
		// UNCOMMENT WHEN/IF A CDN IS SETUP - START
		// if($_SERVER['HTTP_HOST'] !== '127.0.0.1'){
		// 	if(isset($_SERVER['HTTP_ACCEPT_ENCODING'])){
		// 		$GZ	= strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false ? '.gz' : '';
		// 	}
		// }
		// UNCOMMENT WHEN/IF A CDN IS SETUP - END
		header("Cache-Control: no-cache, must-revalidate");
		header("Pragma: no-cache");
		header("Expires: ".gmdate("D, d M Y H:i:s", $TWO_DAYS_AGO) . " GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header('Content-Type: text/html; charset=utf-8');
		ob_start("sanitize_output");
	}
}

function commonMetaHeader(){
	global $CURRENT_PAGE_TITLE, $META_PAGE, $SITE_NAME, $PAGE_DESCRIPTION, $CURRENT_PAGE_NAME, $IS_ADMIN_PAGE, $LOGGED, $CDN_IMGS, $CDN_ASSETS, $GZ, $BASE_URL, $STATIC_FILES, $ASSET_VERSION;
	$CURRENT_PAGE_TITLE = $SITE_NAME;
	$current_page_description = $PAGE_DESCRIPTION . ' at ' . $SITE_NAME;
	if($CURRENT_PAGE_NAME !== 'Home'){
		$CURRENT_PAGE_TITLE .= ' - ' . $CURRENT_PAGE_NAME;
	}
	$payload = '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'
		. '<link href="' . $CDN_IMGS . '" rel="dns-prefetch">'
		. '<meta property="robots" name="robots" content="index,follow">'
		. '<meta http-equiv="X-UA-Compatible" content="IE=edge">'
		. '<meta name="title" content="' . $CURRENT_PAGE_TITLE . '" />'
		. '<meta name="viewport" content="width=device-width, initial-scale=1.0">'
		. '<link rel="icon" href="' . $CDN_IMGS . 'img/favicon.ico" type="image/x-icon">'
		. '<link rel="shortcut icon" href="' . $CDN_IMGS . 'img/favicon.ico" type="image/x-icon">'
		. '<meta http-equiv="X-Frame-Options" content="DENY">'
		. '<link href="' . substr($BASE_URL, 0, -1) . $_SERVER['PHP_SELF'] . '">'
		. '<link href="http://fonts.googleapis.com/css?family=IM+Fell+English" rel="stylesheet" type="text/css">'
		. '<link href="' . $CDN_ASSETS . 'css/' . $STATIC_FILES['main_css'] . $GZ . '.css?v=' . $ASSET_VERSION . '" rel="stylesheet">'
		. '<link href="' . $CDN_ASSETS . 'css/mycss/about.css?v=' . $ASSET_VERSION . '" rel="stylesheet" />'
		. '<link href="' . $CDN_ASSETS . 'css/mycss/faq.css?v=' . $ASSET_VERSION . '" rel="stylesheet" />'
		. '<link href="' . $CDN_ASSETS . 'css/mycss/footer.css?v=' . $ASSET_VERSION . '" rel="stylesheet" />'
		. '<link href="' . $CDN_ASSETS . 'css/mycss/main.css?v=' . $ASSET_VERSION . '" rel="stylesheet" />'
		. '<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->'
		. '<script src="' . $CDN_ASSETS. 'js/ie10-viewport-bug-workaround.js"></script>'
		. '<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->'
		. '<!--[if lt IE 9]>'
		. '<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>'
		. '<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>'
		. '<script type="text/javascript" async src="//platform.twitter.com/widgets.js"></script>'
		. '<![endif]-->';
	 
	 
	if(($CURRENT_PAGE_NAME == 'Quiz') && isset($_GET['q'])){
	  $target_quiz = isSetAndNotDefault('', 'GET', 'q', false);


		$result_gender = substr($target_quiz, 0, 1);
		$result_animal = substr($target_quiz, 1, 1);
		$possessive_genders = array("F"=>"her", "M"=>"his");
		$animals = array("D"=>"dog", "C"=>"cat");

		$payload .= '<meta name="description" content="If my ' . $animals[$result_animal] . ' wore clothes, this would be ' . $possessive_genders[$result_gender] . ' outfit. What would yours wear?">'
			. '<meta property="og:image" content="' . $CDN_IMGS . 'img/quiz/' . $target_quiz . '.jpg" />'
			. '<meta name="twitter:image" content="' . $CDN_IMGS . 'img/quiz/' . $target_quiz . '.jpg">';
	}else if($META_PAGE != 'Clothes' && $META_PAGE != 'Product'){
	 
		$payload .= '<meta name="twitter:card" content="summary_large_image">'
		. '<meta name="twitter:site" content="http://coatandtails.com/" />'
		. '<meta name="twitter:title" content="Custom Pet Portraits" />'
		. '<meta name="twitter:description" content="Create your own personal pet portrait" />'
		. '<meta name="twitter:image" content="'.$CDN_IMGS.'img/baller_banner.jpg" />'
		. '<meta property="og:title" content="Custom Pet Portraits" />'
		. '<meta property="og:site_name" content="Coat and Tails"/>'
		. '<meta property="og:image" content="'.$CDN_IMGS.'img/baller_banner.jpg" />'
		. '<meta property="og:description" content="Create your own personal pet portrait" />';
	}
	if(!$IS_ADMIN_PAGE){
		$payload .= '<base href="' . $BASE_URL . '" />';
	}else{
		$payload .= '<base href="' . $BASE_URL . 'admin/" />';
	}
	$payload .= '<title>' . $CURRENT_PAGE_TITLE . '</title>'
		. '<script>init=' . json_encode(array('base_url'=> $BASE_URL,'imgs_url'=> $CDN_IMGS)) . ';</script>';
	return $payload;
}

function commonNavHeader(){
	global $DEFAULT_COLORS, $LOGGED, $CDN_ASSETS, $CDN_IMGS, $curr_user_query, $USER_USERNAME, $BASE_URL, $DICTIONARY, $DEFAULT_CATEGORIES, $RAW_STR_REPLACE_SEARCH, $RAW_STR_REPLACE_REPLACE;
	$colour_count = count($DEFAULT_COLORS);
	$cat_count = count($DEFAULT_CATEGORIES);
	$payload = '<div class="navbar navbar-fixed-top">'
		. '<div class="navbar-inner">'
			. '<div class="container">'
				. '<a href="' . $BASE_URL . '" class="brand"></a>'
				. '<ul class="nav pull-left">'
					. '<li class="dropdown">'
						. '<a href="javascript:void(0);" class="browse_by dropdown-toggle" role="button" data-toggle="dropdown">browse by <b class="caret"></b></a>'
						. '<ul class="dropdown-menu" role="menu">'
							. '<li class="dropdown-submenu">'
								. '<a tabindex="-1" href="javascript:void(0);">color</a>'
								. '<ul class="dropdown-menu">';
									$i = 0;
									do{
										$payload .= '<li><a tabindex="-1" href="' . $BASE_URL . 'color/' . rawurlencode($DEFAULT_COLORS[$i]) . '" class="bg_' . str_replace(' ', '_', $DEFAULT_COLORS[$i]) . '"></a>' . $DEFAULT_COLORS[$i] . '</li>';
										++$i;
									}while($i < $colour_count);
								$payload .= '</ul>'
							. '</li>'
						. '</ul>'
					. '</li>'
					. '<li><a href="brands">brands</a></li>'
						. '<li class="divider-vertical"></li>'
						. '<li class="dropdown">'
							. '<a href="javascript:void(0);" class="by_categories dropdown-toggle" role="button" data-toggle="dropdown">categories <b class="caret"></b></a>'
							. '<ul class="dropdown-menu" role="menu">';
							$i = 0;
							do{
								$payload .= '<li><a tabindex="-1" href="' . $BASE_URL . 'category/' . rawurlencode(str_replace($RAW_STR_REPLACE_SEARCH, $RAW_STR_REPLACE_REPLACE, $DEFAULT_CATEGORIES[$i]['cat'])) . '">'
									. str_case($DEFAULT_CATEGORIES[$i]['cat'], 'uw')
								. '</a></li>';
								++$i;
							}while($i < $cat_count);
							$payload .= '</ul>'
						. '</li>';
					if($LOGGED){
						$payload .= '<li class="divider-vertical"></li><li><a href="' . $BASE_URL . 'add" rel="nofollow">add</a></li>';
					}else{
						$payload .= '<li class="divider-vertical"></li><li><a href="' . $BASE_URL . 'login?next=add" rel="nofollow">add</a></li>';
					}
					$payload .= '</ul>'
						. '<ul class="nav pull-right green" id="navbar-right">'
							. '<li class="navbar-right-s"></li>';
				$payload .= '<li id="menu_collapse_host">'
						. '<a href="javascript:void(0);" id="menu_collapse" class="btn">'
							. '<i class="ic-list"></i>'
						. '</a>'
					. '</li>'
				. '</ul>'
			. '</div>'
			. '<div class="nav-collapse collapse" id="collapse_menu">'
				. '<ul class="nav">'
					. '<li id="collapse_menu_search_host" class="navbar-right-s"></li>'
					. '<li class="dropdown">'
						. '<a href="javascript:void(0);" class="browse_by dropdown-toggle" role="button" data-toggle="dropdown">browse by <b class="caret"></b></a>'
						. '<ul class="dropdown-menu" role="menu">'
							. '<li class="dropdown-submenu">'
								. '<a tabindex="-1" href="javascript:void(0);">color</a>'
								. '<ul class="dropdown-menu">';
									$i = 0;
									do{
										$payload .= '<li><a tabindex="-1" href="' . $BASE_URL . 'color/' . rawurlencode($DEFAULT_COLORS[$i]) . '" class="bg_' . str_replace(' ', '_', $DEFAULT_COLORS[$i]) . '"></a>' . $DEFAULT_COLORS[$i] . '</li>';
										++$i;
									}while($i < $colour_count);
								$payload .= '</ul>'
							. '</li>'
						. '</ul>'
					. '</li>'
					. '<li><a href="brands">brands</a></li>'
					. '<li class="dropdown">'
						. '<a href="javascript:void(0);" class="by_categories dropdown-toggle" role="button" data-toggle="dropdown">categories <b class="caret"></b></a>'
						. '<ul class="dropdown-menu" role="menu">';
						$i = 0;
						do{
							$payload .= '<li><a tabindex="-1" href="' . $BASE_URL . 'category/' . rawurlencode(str_replace($RAW_STR_REPLACE_SEARCH, $RAW_STR_REPLACE_REPLACE, $DEFAULT_CATEGORIES[$i]['cat'])) . '">'
								. str_case($DEFAULT_CATEGORIES[$i]['cat'], 'uw')
							. '</a></li>';
							++$i;
						}while($i < $cat_count);
						$payload .= '</ul>'
					. '</li>';
					if($LOGGED){
						$payload .= '<li><a href="' . $BASE_URL . 'add" rel="nofollow">add</a></li>';
					}else{
						$payload .= '<li><a href="' . $BASE_URL . 'login?next=add" rel="nofollow">add</a></li>';
					}
				$payload .= '</ul>'
			. '</div>'
		. '</div>'
	. '</div>';
	return $payload;
}

function textareaLineBreak($str){
	return str_replace(array("<br/>", "\r\n", "\n", "\r"), array("\2r\2n", "\2r\2n", "\2n", "\2r"), $str);
}

?>