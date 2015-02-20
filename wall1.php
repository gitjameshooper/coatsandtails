<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Wall of Fame and Shame';
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
				<img src="<?php echo $CDN_IMGS;?>img/wall_banner.png" alt="wall of fame" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">Below are photos that people have emailed or uploaded on this site. They're arranged in order from best to worst.</p>
		</div>
	</div>
<div class="container w-bg center">
  <div class="wall-container" style="width:1000;">
  <div class="style_examples" style="width:500px;float:left;">
  	
  	<h1>Good</h1>
  	<img class="wall" src="/samples/good/1.jpg"  border="0" />
	<p class="wall">Two of the essential qualities of a good photo is that (1) it is mostly symmetrical and (2) that it is taken at eye level. This is an excellent example.</p>

<h1>Good</h1>
    <img class="wall" src="/samples/good/14.jpg"  border="0" />
	<p class="wall">Another quality of excellent photos is the lighting. Here, the photo is not only well lit, the light is not coming from a single source, so there aren't any hard shadows. And of course that look is totes adorbz.</p>

<h1>Good</h1>
    <img class="wall"  src="/samples/good/13.jpg"   border="0" />
	<p class="wall">Again, the photo is taken at eye level and mostly symmetrical. The lighting is also decent: there are no hard shadows, so the light could be coming from anywhere. Points are docked, however, because the snout is downward - the photo was taken slightly above the subject. Look back at the first photo to see the difference.</p>    

<h1>Good</h1>
    <img class="wall"  src="/samples/good/4.jpg"   border="0" />
    <p class="wall">This is an excellent photo if you're wanting two pets in one portrait. It's best to get both pets in the same reference photo so that it won't look like the heads are at two different angles with different light sources.</p>
    
    <h1>Good</h1>
    <img class="wall" src="/samples/good/2.jpg"   border="0" />
	<p class="wall">Another thing you want to think about when taking photos for my pet portraits is the contrast between the background and subject. Here, it'd be difficult to identify where the lighter hairs stop and start, but it mostly works around the dark areas. The photo above this one has good contrast for the white dog.</p>
    <h1>Good</h1>
    <img class="wall"  src="/samples/bad/2.jpg"   border="0" /> 
	<p class="wall">The lighting is pretty dark here. Unless you want me to draw your dog peering out of a jail cell, try to send brighter photos. Also, the dog's mouth flap things and neck are obscured by the blanket, so I wouldn't be able to draw or photo-edit this one very well.</p>
    <h1>Good</h1>
    <img class="wall"  src="/samples/bad/3.jpg"   border="0" />
	<p class="wall">As much as I love seeing the shit y'all are planning to sell on Craigslist, I would prefer to stay out of your business. Unless you actually want me to draw your furniture wearing clothes.Cuz I totally want to draw your furniture wearing clothes.</p>
    <h1>Good</h1>
    <img class="wall"  src="/samples/bad/5.jpg"   border="0" /> 
    <p class="wall">I'm pretty flattered that someone uploaded this photo, but unfortunately I'm not so good at photo-editing that I can make this usable. Even drawing it would amount to an obscene amount of guesswork. Despite the low quality of this photo, it gets points for the inclusion of the hairy thigh.</p>
 <h1>Good</h1>
    <img class="wall"  src="/samples/bad/1.jpg"   border="0" />
    <p class="wall">In case it's not obvious, I can't see this cat for shit.</p>
   </div> 
   <div class="style_examples" style="width:500px;float:left;">
  	<h1>Bad</h1>
  	<img class="wall" src="/samples/good/1.jpg"  border="0" />
	<p class="wall">Two of the essential qualities of a good photo is that (1) it is mostly symmetrical and (2) that it is taken at eye level. This is an excellent example.</p>
  	<h1>Bad</h1>

    <img class="wall" src="/samples/good/14.jpg"  border="0" />
	<p class="wall">Another quality of excellent photos is the lighting. Here, the photo is not only well lit, the light is not coming from a single source, so there aren't any hard shadows. And of course that look is totes adorbz.</p>
  	<h1>Bad</h1>

    <img class="wall"  src="/samples/good/13.jpg"   border="0" />
	<p class="wall">Again, the photo is taken at eye level and mostly symmetrical. The lighting is also decent: there are no hard shadows, so the light could be coming from anywhere. Points are docked, however, because the snout is downward - the photo was taken slightly above the subject. Look back at the first photo to see the difference.</p>    
  	<h1>Bad</h1>

    <img class="wall"  src="/samples/good/4.jpg"   border="0" />
    <p class="wall">This is an excellent photo if you're wanting two pets in one portrait. It's best to get both pets in the same reference photo so that it won't look like the heads are at two different angles with different light sources.</p>
      	<h1>Bad</h1>

    <img class="wall" src="/samples/good/2.jpg"   border="0" />
	<p class="wall">Another thing you want to think about when taking photos for my pet portraits is the contrast between the background and subject. Here, it'd be difficult to identify where the lighter hairs stop and start, but it mostly works around the dark areas. The photo above this one has good contrast for the white dog.</p>
      	<h1>Bad</h1>

    <img class="wall"  src="/samples/bad/2.jpg"   border="0" /> 
	<p class="wall">The lighting is pretty dark here. Unless you want me to draw your dog peering out of a jail cell, try to send brighter photos. Also, the dog's mouth flap things and neck are obscured by the blanket, so I wouldn't be able to draw or photo-edit this one very well.</p>
      	<h1>Bad</h1>

    <img class="wall"  src="/samples/bad/3.jpg"   border="0" />
	<p class="wall">As much as I love seeing the shit y'all are planning to sell on Craigslist, I would prefer to stay out of your business. Unless you actually want me to draw your furniture wearing clothes.Cuz I totally want to draw your furniture wearing clothes.</p>
      	<h1>Bad</h1>

    <img class="wall"  src="/samples/bad/5.jpg"   border="0" /> 
    <p class="wall">I'm pretty flattered that someone uploaded this photo, but unfortunately I'm not so good at photo-editing that I can make this usable. Even drawing it would amount to an obscene amount of guesswork. Despite the low quality of this photo, it gets points for the inclusion of the hairy thigh.</p>
   	<h1>Bad</h1>

    <img class="wall"  src="/samples/bad/1.jpg"   border="0" />
    <p class="wall">In case it's not obvious, I can't see this cat for shit.</p>
   </div> 
   </div> 
    </div> 
 <?php echo commonFoot();?>
	

	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
	<?php include_once(dirname(__FILE__) . '/bits/footer.html');?>
</body>
</html>