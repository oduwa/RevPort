<?php
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	
	session_start();
	$modules = $_SESSION["modules"];
	$currentUser = $_SESSION["currentUser"];
	
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>RevPort Leaderboards</title>
		<?php include 'includes.php';?>
		<!-- Spinner -->
		<script src="web/bootstrap/js/spin.js"></script>
		<script type="text/javascript" src="Spinner/assets/fd-slider/fd-slider.js"></script>
		<script src="Spinner/spin.min.js"></script>
		<!-- Fancy Select -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
		
		
		<style>
			.screenCentered {  
			  position:fixed;
			  z-index: 100;  
			  top:50%;  
			  left:50%;  
			  margin:-100px 0 0 -100px;  
			  width:200px;  
			  height:200px;  
			}  
			
			.rankingContainer{
				width: 100%;
				display:block;
			}
			
			.rankingPosition{
				margin-top:30px;
				margin-left:25px;
				float: left;
				clear: left;
			}
			
			.profilePic{
				margin-left: 8px;
				float:left;
				//clear: left;
			}
			
			.name{
				display: block;
				margin-top:30px;
				margin-left:15px;
			}
			
			.score{
				margin-top: 30px;
				margin-right:30px;
				float: right;
				font-size: 18px;
				font-weight: bold;
				background-color: #fff;
				color: #888;
				clear: right;
			}
			
			.markPercent{
				//background:cyan;
				//display:inline-block;
				display:block;
				width:65px;
			}
			
			progress{
				margin-right:10px;
			}

		</style>
		
		<script>
		
			Parse.initialize("ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso", "nwbeFPq6tz314WF0FaG2LrvkZ6PvJSJGgOwusG1e");
			var spinner;
			var target;
			
			$(document).ready(function(){
				var opts = {
				  lines: 13, // The number of lines to draw
					length: 4,//20, // The length of each line
					width: 3,//10, // The line thickness
					radius: 6,//30, // The radius of the inner circle
				  corners: 1, // Corner roundness (0..1)
				  rotate: 0, // The rotation offset
				  direction: 1, // 1: clockwise, -1: counterclockwise
				  color: '#000', // #rgb or #rrggbb or array of colors
				  speed: 1, // Rounds per second
				  trail: 60, // Afterglow percentage
				  shadow: false, // Whether to render a shadow
				  hwaccel: false, // Whether to use hardware acceleration
				  className: 'spinner', // The CSS class to assign to the spinner
				  zIndex: 2e9, // The z-index (defaults to 2000000000)
				  top: '50%', // Top position relative to parent
				  left: '50%' // Left position relative to parent
				};
				target = document.getElementById('spinnerContainer');
				spinner = new Spinner(opts);
				spinner.spin();
				clearRankings(-1);
			});

			function showRankings(modCode){
				if(modCode != ""){
					// start activity indicator
					spinner.spin(target);
					
					// get rankings for given module
					var rankingQuery = new Parse.Query("Ranking");
					rankingQuery.equalTo("moduleCode", modCode);
					rankingQuery.notEqualTo("username", "Non Attempter");
					rankingQuery.descending("averageMark");
					rankingQuery.find({
					  success: function(results) {
						  spinner.spin();
						  clearRankings(-1);
						  for(var i = 0; i < results.length; i++){
							  var ranking = results[i];
							  var markHtml = " <span class=\"markPercent\">" + ranking.get("averageMark") + "%</span>";
							  $("#rankingPosition" + i).text(i+1 + ".");
							  $("#name" + i).text(ranking.get("username"));
							  $("#score" + i).html("<progress value=\"" + ranking.get("averageMark") + "\" max=\"100\"></progress>" + markHtml);$("#score" + i).show();
							  $("#profilePic" + i).show();
						  }
					  },
					  error: function(error) {
						  spinner.spin();
					    alert("Error: " + error.code + " " + error.message);
					  }
					});
				}
			}
			
			function clearRankings(indexToClearFrom){
				for(var x = indexToClearFrom+1; x < 10; x++){
				  $("#name" + x).text("");
				  $("#rankingPosition" + x).text("");
				  //$("#score" + x).text("");
				  $("#score" + x).html("<progress value=\"0\" max=\"100\"></progress> 0%");$("#score" + x).hide();
				  //$("#profilePic" + x).attr('src', '');
				  $("#profilePic" + x).hide();
				}
			}
		</script>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<div id="spinnerContainer" class="screenCentered"></div>

		<div id="selectContainer" class="horizontalCenter" style="margin-top:20px; margin-bottom:20px;">
			<select name="module" class="selectpicker" data-live-search="true" data-width="auto" id="moduleSelect" onchange="showRankings(this.value)">
				<option value=""> --- </option>
				<?php
					for ($i = 0; $i < count($modules); $i++){
						$module = $modules[$i];
						echo "<option value=\"" . $module->get("moduleCode") . "\">" . $module->get("moduleCode") . " - " . $module->get("moduleName") . "</option>";
					}
				?>
			</select>
		</div>
		
		<br />
		
		<!-- <div id="rankingContent" class="horizontalCentemr">

		</div> -->
		<?php
			for ($j = 0; $j < 10; $j++){
		?>
		<div class="ranking" style="background:#4ff margin-top:100px; margin-bottom:100px;">
			<span class="rankingPosition" id="<?php echo "rankingPosition" . $j ?>">1</span>
			<img class="profilePic" id="<?php echo "profilePic" . $j ?>" src="web/images/default_profile_pic.png" style="float:left;" />
			<span class="name" id="<?php echo "name" . $j ?>" style="float:left;" value="xxx">@username</span>
			<span class="score" id="<?php echo "score" . $j ?>"><progress value="0" max="100"></progress> <span class="markPercent"><?php $out = 75; if($j%2 == 0){$out = 66.67;} echo $out . "%"; ?></span></span>
		</div>
		<?php
			}
		?>

		
		
		
	</body>
</html>