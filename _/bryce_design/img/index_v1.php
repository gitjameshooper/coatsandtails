<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Custom Portraits';

$target_mode = '';
include_once(dirname(__FILE__) . '/defChecks.php');
 
  
 closeConnections();

commonHeaders();
?><html lang="en">
<head>
    <?php echo commonMetaHeader();?>
</head>
<body class="f photo_draw">


  <div class="style_examples">
    <a class="startingat" href="/pricing.php"><img src="/graphics/162.png" alt="" border="0" /></a>  
    
    
    <a href="samples/25.jpg" rel="lightbox[digital]"><img src="/samples/small/25.jpg" width="200" height="200" border="0" /> </a>
    <a href="samples/26.jpg" rel="lightbox[digital]"><img src="/samples/small/26.jpg" width="200" height="200" border="0" /> </a>
    <a href="samples/24.jpg" rel="lightbox[digital]"><img src="/samples/small/24.jpg" width="200" height="200" border="0" /></a>
    <a href="samples/23.jpg" rel="lightbox[digital]"><img src="/samples/small/23.jpg" width="200" height="200" border="0" /> </a>
    
    <a href="samples/22.jpg" rel="lightbox[digital]"><img src="/samples/small/22.jpg" width="200" height="200" border="0" /> </a>
    <a href="samples/21.jpg" rel="lightbox[digital]"><img src="/samples/small/21.jpg" width="200" height="200" border="0" /> </a>
    <a href="samples/20.jpg" rel="lightbox[digital]"><img src="/samples/small/20.jpg" width="200" height="200" border="0" /></a>
    <a href="samples/19.jpg" rel="lightbox[digital]"><img src="/samples/small/19.jpg" width="200" height="200" border="0" /> </a>
    
    <a href="samples/18.jpg" rel="lightbox[digital]"><img src="/samples/small/18.jpg" width="200" height="200" border="0" /></a>
    <a href="samples/17.jpg" rel="lightbox[digital]"><img src="/samples/small/17.jpg" width="200" height="200" border="0" /> </a>
    <a href="samples/16.jpg" rel="lightbox[digital]"><img src="/samples/small/16.jpg" width="200" height="200" border="0" /></a>
    <a href="samples/15.jpg" rel="lightbox[digital]"><img src="/samples/small/15.jpg" width="200" height="200" border="0" /></a>
    
    <a href="samples/14.jpg" rel="lightbox[digital]"><img src="/samples/small/14.jpg" width="200" height="200" border="0" /> </a>
    <a href="samples/13.jpg" rel="lightbox[digital]"><img src="/samples/small/13.jpg" width="200" height="200" border="0" /></a>
    <a href="samples/12.jpg" rel="lightbox[digital]"><img src="/samples/small/12.jpg" alt="" width="200" height="200" border="0" /></a>
    <a href="samples/11.jpg" rel="lightbox[digital]"><img src="/samples/small/11.jpg" width="200" height="200" border="0" /></a>
    
    <a href="samples/10.jpg" rel="lightbox[digital]"><img src="/samples/small/10.jpg" width="200" height="200" border="0" /> </a>
    <a href="samples/9.jpg" rel="lightbox[digital]"><img src="/samples/small/9.jpg" width="200" height="200" border="0" /></a>
    <a href="samples/8.jpg" rel="lightbox[digital]"><img src="/samples/small/8.jpg" alt="" width="200" height="200" border="0" /></a>
    <a href="samples/7.jpg" rel="lightbox[digital]"><img src="/samples/small/7.jpg" width="200" height="200" border="0" /></a>
    
    <a href="samples/6.jpg" rel="lightbox[digital]"><img src="/samples/small/6.jpg" width="200" height="200" border="0" /> </a>
    <a href="samples/5.jpg" rel="lightbox[digital]"><img src="/samples/small/5.jpg" width="200" height="200" border="0" /></a>
    <a href="samples/4.jpg" rel="lightbox[digital]"><img src="/samples/small/4.jpg" alt="" width="200" height="200" border="0" /></a>
    <a href="samples/3.jpg" rel="lightbox[digital]"><img src="/samples/small/3.jpg" width="200" height="200" border="0" /></a>
  </div> 
   
   <div class="style_examples">
  <a class="start_here" href="/order/black_ticked/index.php?pet_num=1"><img src="/graphics/sendphoto.png" alt="" border="0" /></a>
</div>

 
<?php echo commonFoot();?>
    

    <script>
    window.init.base_url="<?php echo $BASE_URL;?>";
    </script>
    <?php include_once(dirname(__FILE__) . '/bits/footer.html');?>
    </body>
</html>