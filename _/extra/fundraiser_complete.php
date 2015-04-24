<?php

$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Merchandise';



$status_options = array('Active', 'Hidden', 'Sold Out', 'Coming Soon');

$variants = array();

$target_variant_count = 0;

$merchandise_target_variant = '';



include_once(dirname(__FILE__) . '/defChecks.php');



 



$CURRENT_PAGE_NAME = str_case(stripslashes($target_merchandise[0]['merchandise_title']), 'uw');



closeConnections();



commonHeaders();

?><html lang="en">

<head>

    <?php echo commonMetaHeader();?>

</head>

<body class="f prod">



	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>



	<div class="container sub-header">

		<div class="row">

			<div class="col-sm-12">

				<img src="<?php echo $CDN_IMGS;?>img/merch_banner.png" alt="Merchandise" class="sub-header-banner-img">

			</div>

		</div>

	</div>

    

    <?php



//  Sending Email

if(isset($_POST['submit'],$_POST['full_name'],$_POST['email_address'])) {

    

	

	$headers = 'From: '.$_POST['email_address'] . "\r\n" .

    'Reply-To: '.$_POST['email_address'] .  "\r\n" ;

	

	

	        // 1 Pet

	if($_POST['num_pets'] == 1){

		$msg = 'Name: ' . $_POST['full_name'] . "\n" 

			. 'Email: ' . $_POST['email_address'] . "\n"

			. '# of Pets: ' . $_POST['num_pets'] . "\n \n"

			

			. 'Pet Name: ' . $_POST['pet_name_1'] . "\n"

			. 'Gender: ' . $_POST['gender_1'] . "\n"

			. 'Name on Portrait: ' . $_POST['portrait_name_1'] . "\n"

			. 'Clothing: ' . $_POST['clothing_1'] . "\n"

			. 'Left: ' . $_POST['left'] . "\n"

			. 'Right: ' . $_POST['right'] ."\n";

			

			// 2 Pets

		}else if($_POST['num_pets'] == 2){

			$msg = 'Name: ' . $_POST['full_name'] . "\n" 

			. 'Email: ' . $_POST['email_address'] . "\n"

			. '# of Pets: ' . $_POST['num_pets'] . "\n"

			

			. 'Pet Name: ' . $_POST['pet_name_1'] . "\n"

			. 'Gender: ' . $_POST['gender_1'] . "\n"

			. 'Name on Portrait: ' . $_POST['portrait_name_1'] . "\n"

			. 'Clothing: ' . $_POST['clothing_1'] ."\n \n"

			

			. 'Pet Name: ' . $_POST['pet_name_2'] . "\n" 

			. 'Gender: ' . $_POST['gender_2'] . "\n"

			. 'Name on Portrait: ' . $_POST['portrait_name_2'] . "\n"

			. 'Clothing: ' . $_POST['clothing_2'] ."\n";

			

			// 3 Pets

		}else if($_POST['num_pets'] == 3){

			$msg = 'Name: ' . $_POST['full_name'] . "\n" 

			. 'Email: ' . $_POST['email_address'] . "\n"

			. '# of Pets: ' . $_POST['num_pets'] . "\n"

			

			. 'Pet Name: ' . $_POST['pet_name_1'] . "\n"

			. 'Gender: ' . $_POST['gender_1'] . "\n"

			. 'Name on Portrait: ' . $_POST['portrait_name_1'] . "\n"

			. 'Clothing: ' . $_POST['clothing_1'] ."\n \n"

			

			. 'Pet Name: ' . $_POST['pet_name_2'] . "\n" 

			. 'Gender: ' . $_POST['gender_2'] . "\n"

			. 'Name on Portrait: ' . $_POST['portrait_name_2'] . "\n"

			. 'Clothing: ' . $_POST['clothing_2'] ."\n"

			

			

			. 'Pet Name: ' . $_POST['pet_name_3'] . "\n" 

			. 'Gender: ' . $_POST['gender_3'] . "\n"

			. 'Name on Portrait: ' . $_POST['portrait_name_3'] . "\n"

			. 'Clothing: ' . $_POST['clothing_3'] ."\n";

			

			

			

		}

		 

		  $sent = @mail('bryce.dishongh@gmail.com', 'COAT&TAILS: '.$_POST['full_name'].' Order', $msg, $headers);

		 

		echo "<h2>Thank You! Your Email has been Sent!<br /> I will review it and contact you shortly.</h2>

		     

		";

 			

			// Make Directory 

		  

			$full_name = str_replace(' ','',$_POST['full_name']);

			$pet_name = str_replace(' ','',$_POST['pet_name_1']);

			

			$target_path = $_SERVER['DOCUMENT_ROOT'].'/fundraiser_upload/'.$full_name.'-'.$pet_name;

			 mkdir($target_path);

                 

     

 

		

		

		function testFile($file){ 

		

		if($file["size"] < 200000000){

				$file_type =  explode("/", $file["type"]);

			  

				if ((($file_type[1] == "gif")

				|| ($file_type[1] == "jpeg")

				|| ($file_type[1] == "jpg")

				|| ($file_type[1] == "pjpeg")

				|| ($file_type[1] == "x-png")

				|| ($file_type[1] == "png"))){

		

					return true;

				}else {

					

					return false;

				}

		  

		  }else {

			  return false;

		  }

		}

		

		

		function uploadFile ($file){

			

			// Remove Spaces

			$full_name = str_replace(' ','',$_POST['full_name']);

			 $pet_name = str_replace(' ','',$_POST['pet_name_1']);

			

		 

			

			$target_path = $_SERVER['DOCUMENT_ROOT'].'/fundraiser_upload/'.$full_name.'-'.$pet_name.'/';

			

			$target_path = $target_path.$pet_name.'-'.basename( $file['name']); 

		    

		if(move_uploaded_file($file['tmp_name'], $target_path)) {

			 

		} else{

			

			echo '<p class="upload-error">There was an error uploading the picture '.basename( $file['name']).'. I will contact you for this picture at a later date.</p>';

		}

	 	

		 

		 

	}

		// remove errors

			error_reporting(0);

	// Loop Thru All Files Uploaded

		  

	foreach($_FILES as $file){

			  

			if(testFile($file) == true){

				   

				uploadFile($file);

				 

			} 

				

	}

}

 

 

 

		echo commonFoot();

?>

	<script>

	window.init.base_url="<?php echo $BASE_URL;?>";

	window.variants=<?php echo json_encode($variants);?>;

	window.target_variant=<?php echo json_encode($merchandise_target_variant);?>;

	</script>

	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>

</body>

</html>

	

 