<?php
	/*
	 *
	 * DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED
	 * DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED
	 * DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED DEPRECATED
	 *
	 */
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg', 'N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');

	use Parse\ParseQuery;
	$query = new ParseQuery("Module");
	$query->equalTo("moduleCode", $_POST['moduleCode']);
	$results = $query->find();
	echo "Successfully retrieved " . count($results) . " scores.";

	use Parse\ParseUser;
	$userQuery = ParseUser::query();
	$userQuery->equalTo("username", "xv"); 
	$users = $userQuery->find();
	$user = $users[0];
	
	use Parse\ParseRelation;
	$moduleRelation = $user->getRelation("modules");	
	$activityRelation = $user->getRelation("activities");	
	if(count($results) > 0 && $_POST['checked'] == true){
		// add module
		$moduleRelation->add($results[0]);
		
		// create activty and add it
		$activityMessage = "added a new module:  " . $results[0]->get("moduleCode") . " - " . $results[0]->get("moduleName") . ".";
		$newActivity = new ParseObject("Activity");
		$newActivity->set("activityMessage", $activityMessage);
		$newActivity->save();
		$activityRelation->add($newActivity);
		
		// save
		$user->save();
		session_start();
		$_SESSION["currentUser"] = $user;
	}
	else if(count($results) > 0 && $_POST['checked'] == false){
		// remove module
		$moduleRelation->remove($results[0]);
		
		// create activty and add it
		$activityMessage = "removed the module:  " . $results[0]->get("moduleCode") . " - " . $results[0]->get("moduleName") . ".";
		$newActivity = new ParseObject("Activity");
		$newActivity->set("activityMessage", $activityMessage);
		$newActivity->save();
		
		$activityRelation->add($newActivity);
		
		// save
		$user->save();
		session_start();
		$_SESSION["currentUser"] = $user;
	}
	
	
?>