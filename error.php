<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Page Not Found';
include_once(dirname(__FILE__) . '/defChecks.php');


closeConnections();

commonHeaders();
?><html lang="en">
<head>
    <?php echo commonMetaHeader();?>
</head>

<body class="f photo_draw">

    <?php include_once(dirname(__FILE__) . '/bits/header.php');?>


<div class="container w-bg center">

  <div class="style_examples">
  	
	<p class="wall">Page not Found.</p>

    
  
   </div> 
    </div> 
 <?php echo commonFoot();?>
	

	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
</body>
</html>