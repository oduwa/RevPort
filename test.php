<?php
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	
	// Get REQUEST variables
	$testIndex = $_GET["testIndex"];
	
	// Get list of tests (for the relevant module)
	session_start();
	if (isset($_SESSION["tests"])) {
	    // Its all good!
		$tests = $_SESSION["tests"];
	}
	else {
	    // Refetch the tests
		if(isset($_SESSION["modules"])){
			$modules = $_SESSION["modules"];
			$module = $modules[$index];
			
			// Get test relation from module
			$testRelation = $module->getRelation("tests");
			$query = $testRelation->getQuery();
			$query->className = "Test";
			$tests = $query->find();

			// Cache retrieved tests in session
			$_SESSION["tests"] = $tests;
		}
		else{
			// error
			header("Location: error.php?msg=Your%20Session%20Has%20Expired");
		}
	}
	
	// get questions
	$test = $tests[$testIndex];
  	$questionRelation = $test->getRelation("questions");
  	$query = $questionRelation->getQuery();
  	$query->className = "Question";
  	$questions = $query->find();
	$_SESSION["questions"] = $questions;
	$_SESSION["theTest"] = $test;

	// Helper functions
	include "HelperFunctions.php";
?>

<html>
	<head>
		<title><?php echo $test->get("testModule") . " - " . $test->get("testTitle") ?></title>
		<?php include 'includes.php';?>
		
		<style>
			#pageContainer{
				margin:1% 20%;
			}
			
			.question{
				margin: 0 0 8em;
			    font-size: 18px;
				font-weight: 600;
				color:#E95393;
			}
			
			.option{
				margin: 0 0 2em;
				color:#666;
			}
		</style>
		
		<script>
			var yourAnswers = [];
			
			$(document).ready(function () {
				// show gradeable warning modal
				<?php
					if($test->get("gradeable")){
				?>
				$('#invisiButton').trigger('click');
				<?php
					}
				?>
				
				// initialize answers array
				for(var i = 0; i < <?php echo count($questions);?>; i++){
					yourAnswers[i] = "";
				}
				
				// Set up onclick listeners for each radio button.
				var radios = $("input[type='radio']");
				$.each(radios, function(index, value){
					var id = "#" + value.attributes[2].nodeValue;
					var idx = value.attributes[4].nodeValue;
					var ans = value.attributes[3].nodeValue;
					$("#" + value.attributes[2].nodeValue).click(function(){
						yourAnswers[idx] = ans;
					});
				});
			});
			
			function submitAnswers(){
				var str = "";
				for(var i = 0; i < yourAnswers.length; i++){
					str = str + " " + yourAnswers[i];
				}
				markAnswers();
			}
			
			function markAnswers() {
			      $.ajax({
			           type: "POST",
			           url: 'storeAnswersFunction.php',
					   async: false,
			           data:{answers:yourAnswers},
			           success:function(html) {
						 if(html == "You have not attempted all questions. Please complete the test before submitting."){
						   // do nothing
							 alert("You have not attempted all questions. Please complete the test before submitting.");
						 }
						 else{
						 	window.location.href = "testDone.php";
						 }    
			             //alert(html);
			           }

			      });
			 }
		</script>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<div id="pageContainer">
			<?php
				for ($i = 0; $i < count($questions); $i++){
					$question = $questions[$i];
					$questionNumber = $i + 1;
					echo "<span class=\"question\">Question " . $questionNumber . ": " . $question->get("questionText") . "</span><br />";
					
					// Get options for each question
					$optionsList = $question->get("options");
					
					
					for ($j = 0; $j < count($optionsList); $j++){
						$option = $optionsList[$j];
						echo "<input type=\"radio\" name=\"ans_" . $i . "\" id=\"ans_" . $i . "_" . $j . "\" value=\"" . $option . "\" index=\"" . $i . "\">";
						echo "<span class=\"option\">" . changeNumberToLetter($j) . ": " . $option . "</span><br />";
					}
					
					echo "<br />";
				}
			?>
			<button onclick="submitAnswers()" style="float:right;">Submit</button>
		</div>
	
	
	
		<!-- Modal -->
		<button style="display:none;" id="invisiButton" data-toggle="modal" data-target="#myModal">Invisible Button To Trigger Warning Modal :D</button>
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog"> 
			      <div class="modal-content">
				  <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color:#e11;"></span> WARNING: THIS TEST IS MARKED AS GRADEABLE.<br /></h4>
				  </div>
			      <div class="modal-body">
					  This means that once initially completed, your score is final. Retaking the test will not change your score so make sure you're ready before taking it.
			      </div>
  			    <div class="modal-footer">
  			      <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
  			    </div>
			    </div>
			  </div>
			</div>

	</body>
</html>






