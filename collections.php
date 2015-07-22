<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Collections';

include_once(dirname(__FILE__) . '/defChecks.php');

$target_gender = "";

if(isset($_GET['g'])){
	$target_gender = isSetAndNotDefault('', 'GET', 'g', false);
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="f collections">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/portrait_banner.png" alt="Collections" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">Choose a theme that best reflects the pet's personality.</p>
		</div>
	</div>

	<div class="container center bread-container">
		<?php include_once(dirname(__FILE__) . '/bits/subheader.php');?>
	</div>
	<div class="container w-bg center">
        <div class="row">
			<div class="col-sm-2 hidden-xs">
				<div class="collections-menu">
				<?php
				if(($mens_collections_count > 0) && ($target_gender != '1')){
					?>
					<div class="gender-header">Men</div>
					<?php
					$i = 0;
					for($i;$i<$mens_collections_count;$i++){
						echo '<div>'
								. '<a href="javascript:void(0);" data-id="' . $mens_collections[$i]['clothes_id'] . '" class="collections-target">' . $mens_collections[$i]['clothes_title'] . '</a>'
							. '</div>';
					}
				}
				if(($womens_collections_count > 0) && ($target_gender != '0')){
					?>
					<div class="gender-header">Women</div>
					<?php
					$i = 0;
					for($i;$i<$womens_collections_count;$i++){
						echo '<div>'
								. '<a href="javascript:void(0);" data-id="' . $womens_collections[$i]['clothes_id'] . '" class="collections-target">' . $womens_collections[$i]['clothes_title'] . '</a>'
							. '</div>';
					}
				}
				?>
				</div>
			</div>
			<div class="col-sm-10 imgs-host">
				<?php
				if($target_gender == '0'){ // male gender targeted
					?>
					<div class="collections">
						<h3>Themes for Male Pets</h3>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=1"><img src="img/clothes/1/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=2"><img src="img/clothes/2/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
					<a href="<?php echo $BASE_URL;?>clothes.php?id=20"><img src="img/clothes/20/cover.png" style="padding:5px;" width="295" height="350" border="0" /></a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=22"><img src="img/clothes/22/cover.png" style="padding:5px;" width="295" height="350" border="0" /></a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=21"><img src="img/clothes/21/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=13"><img src="img/clothes/13/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=11"><img src="img/clothes/11/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=9"><img src="img/clothes/9/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=4"><img src="img/clothes/4/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=7"><img src="img/clothes/7/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=3"><img src="img/clothes/3/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>

  
  </div> 
					<?php
				}else if($target_gender == '1'){ // female gender targeted
					?>
					<div class="collections">
						<h3>Themes for Female Pets</h3>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=19"><img src="img/clothes/19/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=18"><img src="img/clothes/18/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
					<a href="<?php echo $BASE_URL;?>clothes.php?id=16"><img src="img/clothes/16/cover.png" style="padding:5px;" width="295" height="350" border="0" /></a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=15"><img src="img/clothes/15/cover.png" style="padding:5px;" width="295" height="350" border="0" /></a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=14"><img src="img/clothes/14/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=12"><img src="img/clothes/12/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=8"><img src="img/clothes/8/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    

  
  </div> 
					<?php
				}else{ // no gender targeted
					?>
					<div class="collections">
						<h3>Themes for Male Pets</h3>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=1"><img src="img/clothes/1/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=2"><img src="img/clothes/2/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
					<a href="<?php echo $BASE_URL;?>clothes.php?id=20"><img src="img/clothes/20/cover.png" style="padding:5px;" width="295" height="350" border="0" /></a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=22"><img src="img/clothes/22/cover.png" style="padding:5px;" width="295" height="350" border="0" /></a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=21"><img src="img/clothes/21/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=13"><img src="img/clothes/13/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=11"><img src="img/clothes/11/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=9"><img src="img/clothes/9/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=4"><img src="img/clothes/4/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=7"><img src="img/clothes/7/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=3"><img src="img/clothes/3/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>

  
  </div> 
		
		<div class="collections">
						<h3>Themes for Female Pets</h3>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=19"><img src="img/clothes/19/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=18"><img src="img/clothes/18/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
					<a href="<?php echo $BASE_URL;?>clothes.php?id=16"><img src="img/clothes/16/cover.png" style="padding:5px;" width="295" height="350" border="0" /></a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=15"><img src="img/clothes/15/cover.png" style="padding:5px;" width="295" height="350" border="0" /></a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=14"><img src="img/clothes/14/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
    				<a href="<?php echo $BASE_URL;?>clothes.php?id=12"><img src="img/clothes/12/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    <a href="<?php echo $BASE_URL;?>clothes.php?id=8"><img src="img/clothes/8/cover.png" style="padding:5px;" width="295" height="350" border="0" /> </a>
  				    

  
  </div> 
					<?php
				}
				?>
			</div>
			<div class="col-sm-2 visible-xs">
				<div class="collections-menu">
				<?php
				if(($mens_collections_count > 0) && ($target_gender != '1')){
					?>
					<div class="gender-header">Men</div>
					<?php
					$i = 0;
					for($i;$i<$mens_collections_count;$i++){
						echo '<div>'
								. '<a href="javascript:void(0);" data-id="' . $mens_collections[$i]['clothes_id'] . '" class="collections-target">' . $mens_collections[$i]['clothes_title'] . '</a>'
							. '</div>';
					}
				}
				if(($womens_collections_count > 0) && ($target_gender != '0')){
					?>
					<div class="gender-header">Women</div>
					<?php
					$i = 0;
					for($i;$i<$womens_collections_count;$i++){
						echo '<div>'
								. '<a href="javascript:void(0);" data-id="' . $womens_collections[$i]['clothes_id'] . '" class="collections-target">' . $womens_collections[$i]['clothes_title'] . '</a>'
							. '</div>';
					}
				}
				?>
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
					