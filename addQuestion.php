<?php

	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');

	// get values from request
	$questionText = $_POST["question"];
	$option1 = $_POST["opt1"];
	$option2 = $_POST["opt2"];
	$option3 = $_POST["opt3"];
	$option4 = $_POST["opt4"];
	$answer = $_POST["answer"];
	$code = $_POST["code"];
	$title = $_POST["title"];
	$gradeable = $_POST["gradeable"];
	
	// get test
	$query = new ParseQuery("Test");
	$query->equalTo("testTitle", $title);
	$query->equalTo("testModule", $code);
	$results = $query->find();
	if(count($results) < 1){
		// doesnt exist so create it
		$test = new ParseObject("Test");
		$test->set("testTitle", $title);
		$test->set("testModule", $code);
		$test->set("questionCount", 0);
		if($gradeable === "gradeable"){
			$test->set("gradeable", true);
		}
		else{
			$test->set("gradeable", false);
		}
		$test->setArray("attempters", array());
		$test->save();
	}
	else{
		// retreive test
		$test = $results[0];
	}
	
	
	// Create and save new question
	$question = new ParseObject("Question");
	$question->set("questionText", $questionText);
	$question->setArray("options", [$option1, $option2, $option3, $option4]);
	$question->set("correctAnswer", $answer);
	$question->save();
	
	// Add question to test
	$relation = $test->getRelation("questions");
	$relation->add($question);
	$test->increment("questionCount");
	$test->save();
	
	// Add test to Module
	$moduleQuery = new ParseQuery("Module");
	$moduleQuery->equalTo("moduleCode", $code);
	$results = $moduleQuery->find();
	if(count($results) < 1){
		// doesnt exist
		echo "Please check that you entered the module code correctly";
	}
	else{
		$module = $results[0];
		$testRelation = $module->getRelation("tests");
		$testRelation->add($test);
		$module->save();
	}
	

?>