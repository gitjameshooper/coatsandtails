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

    <script type="text/javascript" src="<?php echo $BASE_URL;?>js/jquery-min.js"></script>
    <script type="text/javascript" src="<?php echo $BASE_URL;?>js/lightbox.js"></script>
 
    <script type="text/javascript">
    function MM_preloadImages() { //v3.0
      var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
        var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
        if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
    }
    function MM_swapImgRestore() { //v3.0
      var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
    }

    function MM_findObj(n, d) { //v4.01
      var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
        d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
      if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
      for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
      if(!x && d.getElementById) x=d.getElementById(n); return x;
    }

    function MM_swapImage() { //v3.0
      var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
       if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
    }
    </script>

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
            <p class="title-caption">In addition to a partially customized portrait, you can also get a wholly customized portrait. The difference is that I work closely with you to create some new theme or concept that I don't have in the Men and Women sections, which contain pre-drawn clothes and accessories. This section shows examples of totally customized portraits.</p>     </div>
    </div>
  <div class="samples">
    <a href="<?php echo $BASE_URL;?>img/samples/25.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/25.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/26.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/26.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/24.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/24.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/23.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/23.jpg" width="200" height="200" border="0" /> </a>
    
    <a href="<?php echo $BASE_URL;?>img/samples/22.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/22.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/21.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/21.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/20.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/20.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/19.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/19.jpg" width="200" height="200" border="0" /> </a>
    
    <a href="<?php echo $BASE_URL;?>img/samples/18.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/18.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/17.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/17.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/16.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/16.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/15.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/15.jpg" width="200" height="200" border="0" /></a>
    
    <a href="<?php echo $BASE_URL;?>img/samples/14.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/14.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/13.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/13.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/12.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/12.jpg" alt="" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/11.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/11.jpg" width="200" height="200" border="0" /></a>
    
    <a href="<?php echo $BASE_URL;?>img/samples/10.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/10.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/9.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/9.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/8.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/8.jpg" alt="" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/7.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/7.jpg" width="200" height="200" border="0" /></a>
    
    <a href="<?php echo $BASE_URL;?>img/samples/6.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/6.jpg" width="200" height="200" border="0" /> </a>
    <a href="<?php echo $BASE_URL;?>img/samples/5.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/5.jpg" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/4.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/4.jpg" alt="" width="200" height="200" border="0" /></a>
    <a href="<?php echo $BASE_URL;?>img/samples/3.jpg" data-lightbox="lightbox[digital]"><img src="<?php echo $BASE_URL;?>img/samples/small/3.jpg" width="200" height="200" border="0" /></a>
  </div> 
   
   

 
<?php echo commonFoot();?>
    

    <script>
    window.init.base_url="<?php echo $BASE_URL;?>";
    </script>
    <?php include_once(dirname(__FILE__) . '/bits/footer.php');?>
    </body>
</html>