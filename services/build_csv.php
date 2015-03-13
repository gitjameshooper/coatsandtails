<?php
$IS_SERVICE = true;
include_once(dirname(dirname(__FILE__)) . '/defChecks.php');
commonHeaders();
 



 // Write to The File
function writeToCsv($allMerch){
	$filename = '../csv/teeshirts.csv';
	
	if (!file_exists($filename)) {
		$fp = fopen($filename, 'a');
	    file_put_contents ( $filename , "Date, Name, Product Id, Description, Size, Amount, Ship, Street Address 1, Street Address 2, City, State, Zip, Country, Email \n");
	}else{
		$fp = fopen($filename, 'a');
	}
	
	foreach ($allMerch as $fields) {
	    fputcsv($fp, $fields);
	}

	fclose($fp);

	closeConnections();
}
                   
$list = $_POST["items"];
$billing_same_as_shipping = $_POST["customer"]["billing_same_as_shipping"];
$shipFirstName =   $billing_same_as_shipping ? $_POST["customer"]["first_name"] : $_POST["customer"]["shipping_first_name"];
$shipLastName = $billing_same_as_shipping ? $_POST["customer"]["last_name"] : $_POST["customer"]["shipping_last_name"];
$shipName = $shipFirstName . " " . $shipLastName;
$email = $_POST["customer"]["email"];
$pickUp = $_POST["customer"]["pick_up"] ? "PICKUP" : "SHIP";
$shipAdd1 = $billing_same_as_shipping ? $_POST["customer"]["address_1"] : $_POST["customer"]["shipping_address_1"];
$shipAdd2 = $billing_same_as_shipping ? $_POST["customer"]["address_2"] : $_POST["customer"]["shipping_address_2"];
$shipCountry = $billing_same_as_shipping ? $_POST["customer"]["country"] : $_POST["customer"]["shipping_country"];
$shipCity = $billing_same_as_shipping ? $_POST["customer"]["city"] : $_POST["customer"]["shipping_city"];
$shipState = $billing_same_as_shipping ? $_POST["customer"]["state"] : $_POST["customer"]["shipping_state"];
$shipZip = $billing_same_as_shipping ? $_POST["customer"]["zip_code"] : $_POST["customer"]["shipping_zip_code"];

date_default_timezone_set("America/Chicago");
$date = date("F j Y g:i a"); 
$allMerch = array();
foreach($list as $listItem){
	 
	if($listItem['type'] === 'merch'){
		
		$id = $listItem['id'];
		$result = $DB->query("SELECT * FROM `merchandise` WHERE merchandise_id=".$id);
		
		if($result[0]['merchandise_category'] == 1){
	  
			$item = array($date, $shipName, $id, $listItem['itemName'], $listItem['description'], $listItem['amount'], $pickUp, $shipAdd1, $shipAdd2, $shipCity, $shipState, $shipZip, $shipCountry, $email);
	         
			$allMerch [] = $item;
			$item = null;	 
			
		}

	}
	       
}
 
if (!empty($allMerch))
{
   writeToCsv($allMerch);
}
 
 
?>