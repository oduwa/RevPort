<?php
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');

	// Get REQUEST variables
	$isGradeable = false;
	if(isset($_GET["isGradeable"])){
		$isGradeable = $_GET["isGradeable"];
	}

	// Get questions as well as users answers
	session_start();
	$questions = $_SESSION["questions"];
	$usersAnswers = $_SESSION["answers"];
	
	// Calculate users mark
	$numberCorrect = 0;
	$totalNumber = count($usersAnswers);
	for ($i = 0; $i < count($questions); $i++){
		$question = $questions[$i];

		// Get correct answer for each question
		$correctAnswer = $question->get("correctAnswer");
		
		// mark question
		if($usersAnswers[$i] === $correctAnswer){
			$numberCorrect++;
		}
	}
	
	$mark = ($numberCorrect/$totalNumber) * 100.0;
	$mark = round($mark, 2);
	
	$message = "You Scored " . $mark . "%";
	
	if($mark >= 80){
		$message = "Excellent! You Scored " . $mark . "%";
	}
	else if($mark >= 70 && $mark < 80){
		$message = "Good Work! You Scored " . $mark . "%";
	}
	else if($mark >= 60 && $mark < 70){
		$message = "Nice! You Scored  " . $mark . "%";
	}
	else if($mark < 60){
		$message = "You Scored " . $mark . "%. You can do better!";
	}
	
	// Save users score if not already saved
	$currentUser = $_SESSION["currentUser"];
	$test = $_SESSION["theTest"];
	$test->fetch();
	$attempters = $test->get("attempters");
	if(isset($_SESSION["theTest"]) && isset($_SESSION["currentUser"])){
		// Check if user already took test
		$alreadyAttempted = false;
		for($i = 0; $i < count($attempters); $i++){
			if($attempters[$i] === $currentUser->get("username")){
				$alreadyAttempted = true;
				break;
			}
		}
		
		if(!$alreadyAttempted){
			// Add as attempted
			array_push($attempters, $currentUser->get("username"));
			$test->setArray("attempters", $attempters);
			$test->save();
			
			// save score
			$score = new ParseObject("Score");
			$score->set("username", $currentUser->get("username"));
			$score->set("mark", $mark);
			$score->set("scoreModule", $test->get("testModule"));
			$score->set("scoreTitle", $test->get("testTitle"));
			$score->save();
			
			$relation = $test->getRelation("scores");
			$relation->add($score);
			$test->save();
		}
	}
	else{
		header("Location: error.php?msg=Your%20Score%20Could%20Not%20Be%20Saved");
	}
	
	
	// Helper functions
	include "HelperFunctions.php";
?>

<html>
	<head>
		<title></title>
		<?php include 'includes.php';?>
		
		<style>
			#pageContainer{
				margin:1% 20%;
			}
		
			.heading{
				margin: 0 0 8em;
			    font-size: 22px;
				font-weight: 900;
				color:#E95393;
			}
			
			.question{
				margin: 0 0 8em;
			    font-size: 18px;
				font-weight: 600;
				color:#777;
			}
		
			.option{
				margin: 0 0 2em;
				color:#666;
			}
		</style>
		
		<script>
			function finishTest(){
				// save score if test is gradeable
				<?php
					if($isGradeable){
						// save
					}
				?>
				window.location.href = "moduleList.php";
			}
		</script>
		
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<div id="pageContainer">
			
			<span class="heading"><?php echo $message; ?></span><br /><br />
			
			<?php
				for ($i = 0; $i < count($questions); $i++){
					$question = $questions[$i];
					$questionNumber = $i + 1;
					echo "<span class=\"question\">Question " . $questionNumber . ": " . $question->get("questionText") . "</span><br />";
					
					// Get correct answer
					$correctAnswer = $question->get("correctAnswer");
					
					// Get options for each question
					$optionsList = $question->get("options");
					
					for ($j = 0; $j < count($optionsList); $j++){
						$option = $optionsList[$j];
						if($option === $correctAnswer){
							echo "<span class=\"option\" style=\"color:green; font-weight:900;\">" . changeNumberToLetter($j) . ": " . $option . "</span><br />";
						}
						else if($option === $usersAnswers[$i]){
							echo "<span class=\"option\" style=\"color:red; font-weight:900;\">" . changeNumberToLetter($j) . ": " . $option . "</span><br />";
						}
						else{
							echo "<span class=\"option\">" . changeNumberToLetter($j) . ": " . $option . "</span><br />";
						}
						
					}
					
					echo "<br />";
				}
			?>
			<button onclick="finishTest()" style="float:right;">Done</button>
		</div>
	</body>
</html>





