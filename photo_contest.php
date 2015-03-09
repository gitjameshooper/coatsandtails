<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Photo Contest';

$target_mode = '';
include_once(dirname(__FILE__) . '/defChecks.php');
 
  
 closeConnections();

commonHeaders();
?>

<html lang="en">
<head>
    <?php echo commonMetaHeader();?>
     
    <script type="application/javascript" language="javascript" src="<?php echo $BASE_URL;?>js/extraform-contest.js"></script>
</head>
<body class="f photo_draw">
<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/photo_contest_banner.png" alt="wall of fame" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">I need one doggie model for a shirt design that I’ll sell to help raise money for Austin Dog Rescue. You can submit your photo for a chance to have your dog drawn on one of the shirt designs!</p>		</div>
	</div>
    
 
    
<div id="contest_pet_content" class="photo_contest">
 
	<div class="float-left">
	    <h1>Rulez</h1>
	    <ul>
	        <li>Like the <a  href="https://www.facebook.com/pages/Coat-and-Tails-Pet-Portraits/128628673951387" title="Facebook" target="blank">Coat and Tails Facebook Page</a> and the <a href="https://www.facebook.com/austin.dog.rescue" title="Facebook" target="blank">Austin Dog Rescue Facebook page</a>. <b> Note:</b> This contest is not affiliated with Facebook, Inc.</li>    	
			<li>Photo Submission Deadline is 8:00 P.M. CST on March 11th.</i>
			<li>The photos will be posted to a Facebook album on the Coat &amp; Tails Facebook page on March 12th, 2015 to be voted upon by the community. Votes = Likes.</li>
			<li>If your photo gets the most likes, and we agree that it is usable, your dog will be the model for one of the shirt designs. The winner will also receive a free shirt.</li>
			<li>Voting ends at 10:00 P.M. CST on March 15th.</li>
		</ul>
	</div>
  	<div class="float-left">
		<h1>Photo Recommendations</h1>
		 
		<p class="photo-rec-tagline">Below are recommendations. For more examples of dos and don'ts, see my <a href="http://www.coatandtails.com/wall.php" />Wall of Fame and &amp; Shame</a></p>
		<img class="side-portrait" src="<?php echo $CDN_IMGS;?>img/cute_dog.jpg" />
  
	</div>
	<div class="float-left"><h1>Submission Form</h1>
	    <p>Please complete the fields below to enter the Photo Contest for my <a href="/fundraisers.php">Current Fundraiser</a>.</p>
		  	<form id="pet_form" name="pet_form" action="photo_contest_complete.php" method="post" onsubmit="return validateForm()"  enctype="multipart/form-data">
		    <input type="hidden" name="num_pets"  value="photo-contest" />
		    <input type="hidden" name="photo_contest"  value="1" />
		    <input type="hidden" name="location"  value="http://www.coatandtails.com/product.php?id=14"  />
			<label class="form_titles" for="full_name">Your Name<span class="required">*</span></label>
			<input type="text" name="full_name" id="full_name" maxlength="30" placeholder="e.g. John Smith" />
			<label class="form_titles" for="email_address">Email<span class="required">*</span></label>
			<input type="text" name="email_address" id="email_address" maxlength="50" placeholder="e.g. johnsmith@gmail.com" />
			
			<label class="form_titles" for="upload">Upload Your Picture (.gif, .jpeg, .jpg, .png )</label> 
			  <input style=" display: inline; width: 180px;" type="file" id="upload" name="pet1img1"><span class="required">*</span>
			  
			<label class="form_titles" for="pet_name_1">Pet Name<span class="required">*</span></label>
			<input type="text" name="pet_name_1" id="pet_name_1" maxlength="30" placeholder="e.g. spike" />
			
			<div class="terms-conditions">By uploading a photo, you are agreeing to <a href="javascript:void(0);" class="t_c">these terms and conditions</a>.</div>
			<input type="submit" name="submit" onClick="return checkfields(1);" value="Submit">
		</form>
	</div>

 
 
 
 
</div>


<?php echo commonFoot();?>
    

    <script>
    window.init.base_url="<?php echo $BASE_URL;?>";
    </script>
    <?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
    </body>
</html>