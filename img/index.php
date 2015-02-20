<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Home';

include_once(dirname(__FILE__) . '/defChecks.php');

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="f main">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 carousel-host">
				<div id="home-carousel" class="carousel slide">
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<a href="http://www.coatandtails.com/v2/clothes.php?id=1">
								<div class="carousel-item-img" style="background-image:url('img/slide1.jpg');"></div>
							</a>
						</div>
						<div class="item">
							<div class="carousel-item-img" style="background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI5MDAiIGhlaWdodD0iNTAwIj48cmVjdCB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgZmlsbD0iIzY2NiIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjQ1MCIgeT0iMjUwIiBzdHlsZT0iZmlsbDojNDQ0O2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjU2cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+U2Vjb25kIHNsaWRlPC90ZXh0Pjwvc3ZnPg==')"></div>
						</div>
						<div class="item">
							<div class="carousel-item-img" style="background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI5MDAiIGhlaWdodD0iNTAwIj48cmVjdCB3aWR0aD0iOTAwIiBoZWlnaHQ9IjUwMCIgZmlsbD0iIzU1NSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9IjQ1MCIgeT0iMjUwIiBzdHlsZT0iZmlsbDojMzMzO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjU2cHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+VGhpcmQgc2xpZGU8L3RleHQ+PC9zdmc+')"></div>
						</div>
					</div>

					<a class="l carousel-control home-carousel-control" href="javascript:void(0);">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="r carousel-control home-carousel-control" href="javascript:void(0);">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<a href="#" class="home-subcarousel-targets">
					<div class="img-thumbnail embed-responsive embed-responsive-4by3" style="background-image:url('img/tile1.jpg');"></div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="#" class="home-subcarousel-targets">
					<div class="img-thumbnail embed-responsive embed-responsive-4by3" style="background-image:url('img/tile2.jpg');">></div>
				</a>
			</div>
			<div class="col-md-4">
				<a href="#" class="home-subcarousel-targets">
					<div class="img-thumbnail embed-responsive embed-responsive-4by3" style="background-image:url('img/tile3.jpg');">></div>
				</a>
			</div>
		</div>
	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
</body>
</html>