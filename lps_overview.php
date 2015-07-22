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
<?php include_once(dirname(__FILE__) . '/bits/lp_header.php');?>



  <div id="contest_pet_content" class="photo_contest" style="display:block;">
    
    <div class="float-left">
      <h1>Turn your pet...</h1> 
      <img class="side-portrait" src="<?php echo $CDN_IMGS;?>img/lp/lp_photo.png" />
    </div>
    
    <div class="float-left">
      <h1>Into this:</h1>
        <img class="side-portrait" src="<?php echo $CDN_IMGS;?>img/lp/lp_photo1.png" />
    </div>
  
  <div class="float-left"><h1>Get More Info</h1>
        <form id="pet_form" name="pet_form" action="photo_contest_complete.php" method="post" onsubmit="return validateForm()"  enctype="multipart/form-data">
        <input type="hidden" name="num_pets"  value="photo-contest" />
        <input type="hidden" name="photo_contest"  value="1" />
        <input type="hidden" name="location"  value="http://www.coatandtails.com/product.php?id=14"  />
      <label class="form_titles" for="full_name">Your Name<span class="required">*</span></label>
      <input type="text" name="full_name" id="full_name" maxlength="30" placeholder="e.g. John Smith" />
      <label class="form_titles" for="email_address">Email<span class="required">*</span></label>
      <input type="text" name="email_address" id="email_address" maxlength="50" placeholder="e.g. johnsmith@gmail.com" />
      <div class="terms-conditions">By submitting your info, you are agreeing to <a href="javascript:void(0);" class="t_c">these terms and conditions</a>.</div>
      <input type="submit" name="submit" onClick="return checkfields(1);" value="Submit">
    </form>
  </div>

 
 
 
</div> 

    </body>
</html>