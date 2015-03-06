<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Custom Portraits';

$target_mode = '';
include_once(dirname(__FILE__) . '/defChecks.php');
 
  
 closeConnections();

commonHeaders();
?>

<html lang="en">
<head>
    <?php echo commonMetaHeader();?>
  
    <script type="application/javascript" language="javascript" src="js/extraform.js"></script>
</head>
<body class="f photo_draw">
<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/custom.png" alt="Custom" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">Fill out the form to order a fully-customized portrait.</p>		</div>
	</div>
    
 
    
<div id="order_pet_content">
<?php 
 
if(!isset($_GET['pet_num'])){
	$pet_num = 1;
}else{
 	$pet_num = $_GET['pet_num'];
 }
	 
           
 if($pet_num == 1 || $pet_num == NULL ){     
  echo '<h1>Custom Portrait: 1 Pet</h1>
   <p id="num_pets_tag">Want <strong>two</strong> pets in one portrait? Click <a href="request_order.php?pet_num=2">Here.</a></p>
  <img class="side-portrait" src="https://s3.amazonaws.com/coatandtails/img/quiz/MDS_A_L_.jpg" />
 
 
 <form id="pet_form" name="pet_form" action="/complete.php" method="post" onsubmit="return validateForm()"  enctype="multipart/form-data">
    <input type="hidden" name="num_pets"  value="1" />
    <input type="hidden" name="location"  value="http://www.coatandtails.com/product.php?id=14"  />
	<label class="form_titles" for="full_name">Your Name<span class="required">*</span></label>
	<input type="text" name="full_name" id="full_name" maxlength="30" placeholder="e.g. John Smith" />
	<label class="form_titles" for="email_address">Email<span class="required">*</span></label>
	<input type="text" name="email_address" id="email_address" maxlength="50" placeholder="e.g. johnsmith@gmail.com" />
	
	<label class="form_titles" for="upload">Upload Your Picture (.gif, .jpeg, .jpg, .png )</label> 
	  <input style=" display: inline; width: 180px;" type="file" id="upload" name="pet1img1"><span class="required">*</span>
	  <input type="file" name="pet1img2">
	  <input type="file" name="pet1img3">
	
	<label class="form_titles" for="pet_name_1">Pet Name<span class="required">*</span></label>
	<input type="text" name="pet_name_1" id="pet_name_1" maxlength="30" placeholder="e.g. spike" />
	
	<p class="form_titles">Gender <span class="required">*</span></p>
	<input type="radio" name="gender_1" id="male" value="male" /><label for="male"> Male</label> <br />
    <input type="radio" name="gender_1" id="female" value="female" /><label for="male"> Female</label>  
	
	
	<p class="form_titles">Name written on portrait?<span class="required">*</span></p>
	  <input type="radio" name="portrait_name_1" id="yes_name" value="yes" /><label for="yes_name"> Yes</label> <br /> 
      <input type="radio" name="portrait_name_1" id="no_name"  value="no" /> <label for="no_name"> No</label>  
	
	<p class="form_titles">Clothing/Accessories</p>
	<textarea name="clothing_1" cols="95" rows="15"   placeholder="Enter any ideas you have about clothing accessories you\'d like to include on your portrait. If you\'d rather leave it up to me, leave this field blank."></textarea>
	<input type="submit" name="submit" onClick="return checkfields(1);" value="Submit">
	<div class="terms-conditions">By uploading a photo, you are agreeing to <a href="javascript:void(0);" class="t_c">these terms and conditions</a>.</div>

</form>
 ';
 
}else if($pet_num == 2){
	 echo '<h1>Custom Portrait: 2 Pets</h1>
	 <p id="num_pets_tag">Want <strong>three</strong> pets in one portrait? Click <a href="request_order.php?pet_num=3">Here.</a></p>
  <img class="side-portrait" src="https://s3.amazonaws.com/coatandtails/img/quiz/MDS_A_L_.jpg" />
 
 
 <form id="pet_form" name="pet_form" action="/complete.php" method="post" onsubmit="return validateForm()"  enctype="multipart/form-data">
    <input type="hidden" name="num_pets"  value="2" />
    <input type="hidden" name="location"  value="http://www.coatandtails.com/product.php?id=15"  />
	
	<label class="form_titles" for="full_name">Your Name<span class="required">*</span></label>
	<input type="text" name="full_name" id="full_name" maxlength="30" placeholder="e.g. John Smith" />
	<label class="form_titles" for="email_address">Email<span class="required">*</span></label>
	<input type="text" name="email_address" id="email_address" maxlength="50" placeholder="e.g. johnsmith@gmail.com" />
	
	<h2>YOUR FIRST PET</h2>
	<label class="form_titles" for="upload">Upload Your Picture (.gif, .jpeg, .jpg, .png )</label> 
	  <input style=" display: inline; width: 180px;" type="file" id="upload" name="pet1img1"><span class="required">*</span>
	  <input type="file" name="pet1img2">
	  <input type="file" name="pet1img3">
	
	<label class="form_titles" for="pet_name_1">Pet Name<span class="required">*</span></label>
	<input type="text" name="pet_name_1" id="pet_name_1" maxlength="30" placeholder="e.g. spike" />
	
	<p class="form_titles">Gender <span class="required">*</span></p>
	<input type="radio" name="gender_1" id="male" value="male" /><label for="male"> Male</label> <br />
    <input type="radio" name="gender_1" id="female" value="female" /><label for="female"> Female</label>  
	
	
	<p class="form_titles">Name written on portrait?<span class="required">*</span></p>
	  <input type="radio" name="portrait_name_1" id="yes_name" value="yes" /><label for="yes_name"> Yes</label> <br /> 
      <input type="radio" name="portrait_name_1" id="no_name"  value="no" /> <label for="no_name"> No</label>  
	
	<p class="form_titles">Clothing/Accessories</p>
	<textarea name="clothing_1" cols="95" rows="15"   placeholder="Enter any ideas you have about clothing accessories you\'d like to include on your portrait. If you\'d rather leave it up to me, leave this field blank."></textarea>
	
	
	
	<h2>YOUR SECOND PET</h2>
	<label class="form_titles" for="upload">Upload Your Picture (.gif, .jpeg, .jpg, .png )</label> 
	  <input style=" display: inline; width: 180px;" type="file" id="upload" name="pet2img1"><span class="required">*</span>
	  <input type="file" name="pet2img2">
	  <input type="file" name="pet2img3">
	
	<label class="form_titles" for="pet_name_2">Pet Name<span class="required">*</span></label>
	<input type="text" name="pet_name_2" id="pet_name_2" maxlength="30" placeholder="e.g. spike" />
	
	<p class="form_titles">Gender <span class="required">*</span></p>
	<input type="radio" name="gender_2" id="male_2" value="male" /><label for="male_2"> Male</label> <br />
    <input type="radio" name="gender_2" id="female_2" value="female" /><label for="female_2"> Female</label>  
	
	
	<p class="form_titles">Name written on portrait?<span class="required">*</span></p>
	  <input type="radio" name="portrait_name_2" id="yes_name_2" value="yes" /><label for="yes_name_2"> Yes</label> <br /> 
      <input type="radio" name="portrait_name_2" id="no_name_2"  value="no" /> <label for="no_name_2"> No</label>  
	
	<p class="form_titles">Clothing/Accessories</p>
	<textarea name="clothing_2" cols="95" rows="15"   placeholder="Enter any ideas you have about clothing accessories you\'d like to include on your portrait. If you\'d rather leave it up to me, leave this field blank."></textarea>
	<input type="submit" name="submit" onClick=" return checkfields(2);" value="Submit">
	<div class="terms-conditions">By uploading a photo, you are agreeing to <a href="javascript:void(0);" class="t_c">these terms and conditions</a>.</div>

</form>
 ';
 
}else if($pet_num == 3){
	 echo '<h1>Custom Portrait: 3 Pets</h1>
	 <p id="num_pets_tag">Want <strong>one</strong> pet in one portrait? Click <a href="request_order.php?pet_num=1">Here.</a></p>
  <img class="side-portrait" src="https://s3.amazonaws.com/coatandtails/img/quiz/MDS_A_L_.jpg" />
  
 
 
 <form id="pet_form" name="pet_form" action="/complete.php" method="post" onsubmit="return validateForm()"  enctype="multipart/form-data">
    <input type="hidden" name="num_pets"  value="3" />
    <input type="hidden" name="location"  value="http://www.coatandtails.com/product.php?id=16"  />
	
	<label class="form_titles" for="full_name">Your Name<span class="required">*</span></label>
	<input type="text" name="full_name" id="full_name" maxlength="30" placeholder="e.g. John Smith" />
	<label class="form_titles" for="email_address">Email<span class="required">*</span></label>
	<input type="text" name="email_address" id="email_address" maxlength="50" placeholder="e.g. johnsmith@gmail.com" />
	
	<h2>YOUR FIRST PET</h2>
	<label class="form_titles" for="upload">Upload Your Picture (.gif, .jpeg, .jpg, .png )</label> 
	  <input style=" display: inline; width: 180px;" type="file" id="upload" name="pet1img1"><span class="required">*</span>
	  <input type="file" name="pet1img2">
	  <input type="file" name="pet1img3">
	
	<label class="form_titles" for="pet_name_1">Pet Name<span class="required">*</span></label>
	<input type="text" name="pet_name_1" id="pet_name_1" maxlength="30" placeholder="e.g. spike" />
	
	<p class="form_titles">Gender <span class="required">*</span></p>
	<input type="radio" name="gender_1" id="male" value="male" /><label for="male"> Male</label> <br />
    <input type="radio" name="gender_1" id="female" value="female" /><label for="female"> Female</label>  
	
	
	<p class="form_titles">Name written on portrait?<span class="required">*</span></p>
	  <input type="radio" name="portrait_name_1" id="yes_name" value="yes" /><label for="yes_name"> Yes</label> <br /> 
      <input type="radio" name="portrait_name_1" id="no_name"  value="no" /> <label for="no_name"> No</label>  
	
	<p class="form_titles">Clothing/Accessories</p>
	<textarea name="clothing_1" cols="95" rows="15"   placeholder="Enter any ideas you have about clothing accessories you\'d like to include on your portrait. If you\'d rather leave it up to me, leave this field blank."></textarea>
	
	
	
	<h2>YOUR SECOND PET</h2>
	<label class="form_titles" for="upload">Upload Your Picture (.gif, .jpeg, .jpg, .png )</label> 
	  <input style=" display: inline; width: 180px;" type="file" id="upload" name="pet2img1"><span class="required">*</span>
	  <input type="file" name="pet2img2">
	  <input type="file" name="pet2img3">
	
	<label class="form_titles" for="pet_name_2">Pet Name<span class="required">*</span></label>
	<input type="text" name="pet_name_2" id="pet_name_2" maxlength="30" placeholder="e.g. spike" />
	
	<p class="form_titles">Gender <span class="required">*</span></p>
	<input type="radio" name="gender_2" id="male_2" value="male" /><label for="male_2"> Male</label> <br />
    <input type="radio" name="gender_2" id="female_2" value="female" /><label for="female_2"> Female</label>  
	
	
	<p class="form_titles">Name written on portrait?<span class="required">*</span></p>
	  <input type="radio" name="portrait_name_2" id="yes_name_2" value="yes" /><label for="yes_name_2"> Yes</label> <br /> 
      <input type="radio" name="portrait_name_2" id="no_name_2"  value="no" /> <label for="no_name_2"> No</label>  
	
	<p class="form_titles">Clothing/Accessories</p>
	<textarea name="clothing_2" cols="95" rows="15"   placeholder="Enter any ideas you have about clothing accessories you\'d like to include on your portrait. If you\'d rather leave it up to me, leave this field blank."></textarea>
	
	<h2>YOUR THIRD PET</h2>
	<label class="form_titles" for="upload">Upload Your Picture (.gif, .jpeg, .jpg, .png )</label> 
	  <input style=" display: inline; width: 180px;" type="file" id="upload" name="pet3img1"><span class="required">*</span>
	  <input type="file" name="pet3img2">
	  <input type="file" name="pet3img3">
	
	<label class="form_titles" for="pet_name_3">Pet Name<span class="required">*</span></label>
	<input type="text" name="pet_name_3" id="pet_name_3" maxlength="30" placeholder="e.g. spike" />
	
	<p class="form_titles">Gender<span class="required">*</span> </p>
	<input type="radio" name="gender_3" id="male_3" value="male" /><label for="male_3"> Male</label> <br />
    <input type="radio" name="gender_3" id="female_3" value="female" /><label for="female_3"> Female</label>  
	
	
	<p class="form_titles">Name written on portrait?<span class="required">*</span></p>
	  <input type="radio" name="portrait_name_3" id="yes_name_3" value="yes" /><label for="yes_name_3"> Yes</label> <br /> 
      <input type="radio" name="portrait_name_3" id="no_name_3"  value="no" /> <label for="no_name_3"> No</label>  
	
	<p class="form_titles">Clothing/Accessories</p>
	<textarea name="clothing_3" cols="95" rows="15"   placeholder="Enter any ideas you have about clothing accessories you\'d like to include on your portrait. If you\'d rather leave it up to me, leave this field blank."></textarea>
	<input type="submit" name="submit" onClick=" return checkfields(3);" value="Submit">
	<div class="terms-conditions">By uploading a photo, you are agreeing to <a href="javascript:void(0);" class="t_c">these terms and conditions</a>.</div>

</form>
 ';
	
	
	
} else {
	
		echo '<h3>There seems to be an error. Please Try Again Later</h3>';	
}
 
      
?>
 
</div>


<?php echo commonFoot();?>
    

    <script>
    window.init.base_url="<?php echo $BASE_URL;?>";
    </script>
    <?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
    </body>
</html>