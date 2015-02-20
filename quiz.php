<?php
$PAGE_DESCRIPTION = $CURRENT_PAGE_NAME = $CURRENT_PAGE_TYPE = 'Quiz';

$categories = array("Spoiled vs Humble", "Analytical vs Random", "Lazy vs Energetic");
$categories_sum = array(0, 0, 0);
$categories_count = count($categories);

$questions = array(
    array("I only eat the best and most expensive pet food.", 0),
    array("I thrive when I have a task, such as fetch or herding.", 1),
	array("I choose to sleep a lot.", 2),
	array("My bed is luxurious.", 0),
	array("I'm persistent.", 1),
	array("Food is my only motivator.", 2),
	array("My birthday is a big deal, and rightfully so.", 0),
	array("I'm a leader.", 1),
	array("My favorite thing to do is nothing.", 2),
	array("I can be condescending.", 0),
	array("I'm difficult to train.", -1),
	array("I enjoy chasing squirrels and/or laser pointers.", -2)
	);
$questions_count = count($questions);

$cat_flags = array("N", "_", "Y");

$target_result = array(
  "M"=>array(
    "D"=>array(
      "SNANLN"=>9,
      "S_ANLN"=>9,
      "SYANLN"=>1,

      "SNA_LN"=>9,
      "S_A_LN"=>7,
      "SYA_LN"=>4,

      "SNAYLN"=>2,
      "S_AYLN"=>2,
      "SYAYLN"=>4,


      "SNANL_"=>9,
      "S_ANL_"=>1,
      "SYANL_"=>1,

      "SNA_L_"=>9,
      "S_A_L_"=>1,
      "SYA_L_"=>1,

      "SNAYL_"=>7,
      "S_AYL_"=>13,
      "SYAYL_"=>4,


      "SNANLY"=>3,
      "S_ANLY"=>3,
      "SYANLY"=>3,

      "SNA_LY"=>11,
      "S_A_LY"=>3,
      "SYA_LY"=>4,

      "SNAYLY"=>11,
      "S_AYLY"=>11,
      "SYAYLY"=>4
    ),
    "C"=>array(
     "SNANLN"=>9,
      "S_ANLN"=>2,
      "SYANLN"=>1,

      "SNA_LN"=>2,
      "S_A_LN"=>7,
      "SYA_LN"=>4,

      "SNAYLN"=>7,
      "S_AYLN"=>2,
      "SYAYLN"=>4,


      "SNANL_"=>9,
      "S_ANL_"=>1,
      "SYANL_"=>1,

      "SNA_L_"=>9,
      "S_A_L_"=>1,
      "SYA_L_"=>1,

      "SNAYL_"=>7,
      "S_AYL_"=>13,
      "SYAYL_"=>4,


      "SNANLY"=>3,
      "S_ANLY"=>3,
      "SYANLY"=>3,

      "SNA_LY"=>11,
      "S_A_LY"=>3,
      "SYA_LY"=>4,

      "SNAYLY"=>11,
      "S_AYLY"=>11,
      "SYAYLY"=>4
      )
    ),
  "F"=>array(
    "D"=>array(
      "SNANLN"=>8,
      "S_ANLN"=>8,
      "SYANLN"=>8,

      "SNA_LN"=>19,
      "S_A_LN"=>19,
      "SYA_LN"=>12,

      "SNAYLN"=>19,
      "S_AYLN"=>19,
      "SYAYLN"=>18,


      "SNANL_"=>14,
      "S_ANL_"=>15,
      "SYANL_"=>12,

      "SNA_L_"=>14,
      "S_A_L_"=>15,
      "SYA_L_"=>12,

      "SNAYL_"=>19,
      "S_AYL_"=>14,
      "SYAYL_"=>18,


      "SNANLY"=>15,
      "S_ANLY"=>15,
      "SYANLY"=>12,

      "SNA_LY"=>14,
      "S_A_LY"=>15,
      "SYA_LY"=>16,

      "SNAYLY"=>15,
      "S_AYLY"=>15,
      "SYAYLY"=>16
    ),
    "C"=>array(
     "SNANLN"=>8,
      "S_ANLN"=>8,
      "SYANLN"=>8,

      "SNA_LN"=>19,
      "S_A_LN"=>19,
      "SYA_LN"=>12,

      "SNAYLN"=>19,
      "S_AYLN"=>19,
      "SYAYLN"=>18,


      "SNANL_"=>14,
      "S_ANL_"=>15,
      "SYANL_"=>12,

      "SNA_L_"=>14,
      "S_A_L_"=>15,
      "SYA_L_"=>12,

      "SNAYL_"=>19,
      "S_AYL_"=>14,
      "SYAYL_"=>18,


      "SNANLY"=>15,
      "S_ANLY"=>15,
      "SYANLY"=>12,

      "SNA_LY"=>14,
      "S_A_LY"=>15,
      "SYA_LY"=>16,

      "SNAYLY"=>15,
      "S_AYLY"=>15,
      "SYAYLY"=>16
      )
    )
);

include_once(dirname(__FILE__) . '/defChecks.php');


if(isset($_POST['q0'])){

  $gender = isSetAndNotDefault('', 'POST', 'gender', false);
  if($gender != '1'){
    $gender = '0';
  }

  $animal = isSetAndNotDefault('', 'POST', 'animal', false);
  if($animal != '1'){
    $animal = '0';
  }

	$q = array();
	$i = 0;
	for($i;$i<$questions_count;$i++){
		$q[$i] = trim(isSetAndNotDefault('', 'POST', 'q' . $i, true, 'We did not receive your answer for question #' . ($i + 1)));
		if(!is_numeric($q[$i])){
			appendError("Your answer for question #" . ($i + 1) . " needs to be a numeric value.");
		}else if(((float)$q[$i] < -2) || ((float)$q[$i] > 2)){
			appendError("Your answer for question #" . ($i + 1) . " needs to be a numeric value between -2 and 2.");
		}else{
			$categories_sum[$questions[$i][1]] += (int)$q[$i];
		}
	}
	$i = 0;
	for($i;$i<$categories_count;$i++){
		$categories_sum[$i] = (int)(round($categories_sum[$i] / 8) + 1);
	}
	if($ERROR === ''){
    $_SESSION['quiz'] = ($gender == '0' ? 'M' : 'F') . ($animal == '0' ? 'D' : 'C') . "S" . $cat_flags[$categories_sum[0]] . "A" . $cat_flags[$categories_sum[1]] . "L" . $cat_flags[$categories_sum[2]];

    $_SESSION['quiz_collection'] = $target_result[($gender == '0' ? 'M' : 'F')][($animal == '0' ? 'D' : 'C')]["S" . $cat_flags[$categories_sum[0]] . "A" . $cat_flags[$categories_sum[1]] . "L" . $cat_flags[$categories_sum[2]]];

    closeConnections();
    header("Location:" . $BASE_URL . "quiz_result.php");
    exit();
	}
}

closeConnections();

commonHeaders();
?><html lang="en">
<head>
	<?php echo commonMetaHeader();?>
</head>
<body class="f quiz">

	<?php include_once(dirname(__FILE__) . '/bits/header.php');?>

	<div class="container sub-header">
		<div class="row">
			<div class="col-sm-12">
				<img src="<?php echo $CDN_IMGS;?>img/quiz_banner.png" alt="Personality Quiz" class="sub-header-banner-img">
			</div>
		</div>
		<div class="row">
			<p class="title-caption">Use this highly scientifical personality test
                            to help determine the clothing line that would
                            best suit your pet's personality.</p>
		</div>
		<?php
		if($ERROR !== ''){
			echo '<div class="alert alert-danger">'.$ERROR.'</div>';
		}
		?>
	</div>

	<div class="container w-bg center small-container">
		<div class="row">
			<div class="col-sm-12">
				<p class="gray left">
					<span>Directions</span><br/>
					Answer from the pet’s perspective.<br/>
					Avoid leaving neutral selected.<br/>
                    Take it very seriously.
				</p>
			</div>
		</div>
		<form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" role="form" name="quiz_form">
      <div class="row pet">
        <div class="col-sm-12">
          <div class="form-group">
            <label for="gender" class="col-sm-2 control-label">Gender</label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <input type="radio" name="gender" id="gender1" value="0"> Male
              </label>
              <label class="radio-inline">
                <input type="radio" name="gender" id="gender2" value="1"> Female
              </label>
            </div>
          </div>
          <hr>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <label for="animal" class="col-sm-2 control-label">Pet</label>
            <div class="col-sm-10">
              <label class="radio-inline">
                <input type="radio" name="animal" id="animal1" value="0"> Dog
              </label>
              <label class="radio-inline">
                <input type="radio" name="animal" id="animal2" value="1"> Cat
              </label>
            </div>
          </div>
          <hr>
        </div>
      </div>
			<?php
			$i = 0;
			for($i;$i<$questions_count;$i++){
				?>
				<div class="row">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-12">
								<label for="q<?php echo $i;?>"><?php echo $questions[$i][0];?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-2">
								<label>Disagree</label>
							</div>
							<div class="col-sm-8">
								<input type="text" class="form-control sliders" value="0" name="q<?php echo $i;?>" id="q<?php echo $i;?>">
							</div>
							<div class="col-sm-2">
								<label>Agree</label>
							</div>
						</div>
						<hr>
					</div>
				</div>
				<?php
			}
			?>
			<a href="javascript:void(0);" class="btn btn-lg btn-inverted btn-negative pull-right continue" type="submit">Continue</a>
		</form>
	</div>

	<?php echo commonFoot();?>
	<script>
	window.init.base_url="<?php echo $BASE_URL;?>";
	</script>
<?php include_once(dirname(__FILE__) . '/bits/footer.html');?>
</body>
</html>