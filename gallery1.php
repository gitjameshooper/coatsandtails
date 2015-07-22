<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Custom Portraits';

$target_mode = '';
include_once(dirname(__FILE__) . '/defChecks.php');
 
  
 closeConnections();

commonHeaders();
?><html lang="en">
<head>
    <?php echo commonMetaHeader();?>
        
    <link href="<?php echo $BASE_URL;?>css/mycss/lightbox.css" rel="stylesheet" />

</head>
<body class="f photo_draw">
<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
<div class="container sub-header">
        <div class="row">
            <div class="col-sm-12">
                <img src="<?php echo $CDN_IMGS;?>img/photoedits.png" alt="photoedits" class="sub-header-banner-img" />
            </div>
        </div>
        <div class="row">
            <p class="title-caption">This section shows photo edits for readymade clothes. These start at $40. You get a damn fancy print: a giclee print on acid-free, cold-press paper.</p>    
        </div>
    </div>
  <div class="samples">
    <a href="<?php echo $BASE_URL;?>clothes.php?id=12"><img src="<?php echo $BASE_URL;?>img/samples/photoedits/small/paperdoll.jpg" width="300" height="300" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>clothes.php?id=12"><img src="<?php echo $BASE_URL;?>img/samples/photoedits/small/paperdoll.jpg" width="300" height="300" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>clothes.php?id=12"><img src="<?php echo $BASE_URL;?>img/samples/photoedits/small/paperdoll.jpg" width="300" height="300" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>clothes.php?id=12"><img src="<?php echo $BASE_URL;?>img/samples/photoedits/small/paperdoll.jpg" width="300" height="300" border="0" /> </a>
    


  
  </div> 
   <div class="container sub-header">
        <div class="row">
            <div class="col-sm-12">
                <img src="<?php echo $CDN_IMGS;?>img/readymade.png" alt="readymade" class="sub-header-banner-img" />
            </div>
        </div>
        <div class="row">
            <p class="title-caption">This section shows drawings for readymade clothes. These start at $96. You get a classy ass print: a giclee print on acid-free, cold-press paper.</p>    
        </div>
    </div>
   
 <div class="samples">
    <a href="<?php echo $BASE_URL;?>img/samples/readymade/bailey.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/readymade/small/bailey.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/readymade/cane.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/readymade/small/cane.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/readymade/henri.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/readymade/small/henri.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/readymade/lobiondo.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/readymade/small/lobiondo.jpg" width="200" height="200" border="0" /> </a>

    <a href="<?php echo $BASE_URL;?>img/samples/readymade/mia.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/readymade/small/mia.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/readymade/powell.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/readymade/small/powell.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/readymade/winston.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/readymade/small/winston.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/readymade/bianchi.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/readymade/small/bianchi.jpg" width="200" height="200" border="0" /> </a>

  </div> 


 </div> 
   <div class="container sub-header">
        <div class="row">
            <div class="col-sm-12">
                <img src="<?php echo $CDN_IMGS;?>img/custom.png" alt="custom" class="sub-header-banner-img" />
            </div>
        </div>
        <div class="row">
            <p class="title-caption">This section shows totally customized portraits. These start at $184. You get a classy as ballz print: a giclee print on acid-free, cold-press paper.</p>    
        </div>
    </div>

  <div class="samples">  
    <a href="<?php echo $BASE_URL;?>img/samples/20.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/20.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/19.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/19.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/18.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/18.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/17.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/17.jpg" width="200" height="200" border="0" /> </a>

    
    <a href="<?php echo $BASE_URL;?>img/samples/15.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/15.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/14.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/14.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/13.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/13.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/12.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/12.jpg" width="200" height="200" border="0" /></a>
    
    <a href="<?php echo $BASE_URL;?>img/samples/11.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/11.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/10.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/10.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/9.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/9.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/8.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/8.jpg" width="200" height="200" border="0" /></a>
    
    <a href="<?php echo $BASE_URL;?>img/samples/7.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/7.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/6.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/6.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/4.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/4.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/3.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/3.jpg" width="200" height="200" border="0" /></a>
 </div>
<?php echo commonFoot();?>
    

    <script>
    window.init.base_url="<?php echo $BASE_URL;?>";
    </script>
    <?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
    </body>
</html>