<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Fundraiser Information';

$target_mode = '';
include_once(dirname(__FILE__) . '/defChecks.php');


closeConnections();

commonHeaders();
?><html lang="en">
<head>
    <?php echo commonMetaHeader();?>
</head>

<body class="f photo_draw">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/events_banner.png" alt="events yay!" class="sub-header-banner-img">
			</div>
		</div>
    <div class="row">
            <p class="title-caption">Below is a list of upcoming parties I plan to crash. </p>    
        </div>
	</div>
<div class="container w-bg center">
  
<div class="style_examples">  
    <div style="display:block;text-align:left">
        <h3>Paws 'n' Pints</p>
          <h4>June 9th, 4 - 9 PM, Scoot Inn, 1308 E 4th St.</h4>
            <p>I've partnered with Scoot Inn to bring all y'all all the dogs. This event is bi-monthly: it's the second and last Tuesday of the month. The event is both an
              outreach effort and a funraising effort. Rescues can set up a booth and educate the community about fostering or the adoption process. 
              We are also able to raise money: 10% of the bar tab goes to participating rescues, and funds are also collected from the pet fashion show/contest and my pet portraits,
              which I do live on the stage at Scoot Inn. </p>
            <p>The next event is June 9th and will help raise money for Austin Dog Rescue and Austin Boxer Rescue.</p>
                <img style="text-align:center;width:100%;" src="<?php echo $CDN_IMGS;?>img/events/draft1_500.jpg">
                <p></p>
  
    </div>

    <div style="display:block;text-align:left;">
        <h3>Calling All Rescues and Pet-Industry Vendors</h3>
        <p>If you're an Austin-area rescue group or you want to help spread the word about your pet-industry business, email bryce@coatandtails.com and we'll get you set up.</p>
    </div> 
   </div> 
</div>
</div>
</div>
 <?php echo commonFoot();?>
	

	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
</body>
</html>