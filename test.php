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
			           url: 'markAnswersFunction.php',
					   async: false,
			           data:{answers:yourAnswers},
			           success:function(html) {
						 if(html == "You have not answered any question. Attempt the test before submitting."){
						   // do nothing
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
		
	</body>
</html>






