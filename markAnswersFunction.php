<?php
	
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	
	// Get REQUEST variables
	if(isset($_POST["answers"])){
		$usersAnswers = $_POST["answers"];
	}
	else{
		echo "You have not answered any question. Attempt the test before submitting.";
		exit();
	}
	
	// Get questions to be marked
	session_start();
	if (isset($_SESSION["questions"])) {
	    // Its all good!
		$questions = $_SESSION["questions"];
	}
	else{
		echo "An error occured. Your session may have expired.";
	}
	
	// Mark users answers by iterating through the questions and checking the correct answer
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
	
	$mark = ($numberCorrect/$totalNumber)*100.0;
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
	
	echo $message;
	
	
?>