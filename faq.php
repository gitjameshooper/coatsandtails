<?php
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
		
	</div>
<div class="container w-bg center">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<h1>Frequently Asked Questions</h1>
<hr>


	<div class="box-faq">
	
			<h2 class="faq">Portraits</h2>
				<div class="menu-faq">
					<ul>
<li class="treenode-faq">What kind of photos should I upload?</a>
					        <ul class="leaders-faq">
    				        <li>Good question. Glad you asked. It's important, especially for the photo-edit option. First of all, the pet should be well lit. Second, the camera should be at eye-level with the pet. There should also be a lot of contrast between the subject and the background; for instance, if it's a dark pet, then there should be a light background. The pet's face should also be mostly symmetrical. For examples of good and bad photos, see <a href="/wall.php"> my Wall of Fame and Shame</a>.</li>
			</ul>                             

<li class="treenode-faq">Some of your models have arms that do not look like my dog's arms. Will you make the arms look like my dog's arms?</a>
    						    <ul class="leaders-faq">
								    <li>Yes.</li>
							    </ul>
						    <li class="treenode-faq">What outfit do you think I should choose?</a>
						        <ul class="leaders-faq">
            				        <li>The clothes can reflect your pet's personality or lifestyle. So it largely depends on what you want. To help you choose, you can take my <a href="/quiz.php"> Pet Personality test </a>, which will provide recommendations based on my current collection of clothing options.</li>
                                </ul>                    
                            <li class="treenode-faq">What types of portraits do you offer?</a>
							    <ul class="leaders-faq">
								    <li>I offer two types of portraits: readymade and custom. Readymade portraits allow you to select from pre-drawn clothes - I just draw the face, or use a photograph that you upload. Custom portraits are totally customized, so if you don't see an outfit that you want, then you can fill out a form to let me know what outfit you'd like.</li>
							    </ul>
		   				    <li class="treenode-faq">Are your portraits photographs or drawings?</a>
							    <ul class="leaders-faq">
								    <li>The clothes are drawings, but you have the option to have me draw the head onto the clothes, or have me photo-edit your photo onto them.</li>
							    </ul>
					</ul>
				</div>
			<h2 class="faq">Orders</h2>
				<div class="menu-faq">
					<ul>
						<li class="treenode-faq">How do I place an order?</a>
							<ul class="leaders-faq">
								<li>First, look through my collections to see if there's an outfit suitable for the pet. If there is, then click on that collection, and then choose your clothes and accessories. You can then move through the tabs until you reach the cart, from which you can make your purchase.</li>
							</ul>
				</div>
			<h2 class="faq">Returns</h2>
				<div class="menu-faq">
					<ul class="treenode-faq">
						<li class="treenode-faq">What items do you return?</a>
							<ul class="leaders-faq">
								<li class="subsections-faq">Frames and Merchandise<li>
								<li>I will return frames and merchandise, as long as it was in the condition it was in when it got to you.</li>
							    <li class="subsections-faq">Portraits<li>
                                <li>I will issue refunds for portraits, <i>if I haven't started drawing it yet</i>. If you change your mind once I've already started working on it, I will issue a 50% refund. After the digital image has been approved, I do not issue refunds.</li>
                            </ul>

							</div>
	

				<h2 class="faq">Shipping</h2>
				<div class="menu-faq">
					<ul>
						<li class="treenode-faq">How are prints without frames shipped?</a>
							<ul class="leaders-faq">
								<li>Prints 11"x14" and smaller are shipped flat. Larger prints are shipped rolled.</li>
							</ul>
										</div>
			<h2 class="faq">Payments</h2>
				<div class="menu-faq">
					<ul>
						<li class="treenode-faq">How secure is your website?</a>
							<ul class="leaders-faq">
								<li>This website is PCI compliant, which means it does not store any payment information, and all the channels used to process payments are completely secure.</li>
							</ul>
				</div>
			<h2 class="faq">Frames</h2>
				<div class="menu-faq">
					<ul>
						<li class="treenode-faq">Are your frames antique?</a>
							<ul class="leaders-faq">
								<li>Some of them are. Others are made to look old.</li>
							</ul>
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