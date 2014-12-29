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
	use Parse\ParseQuery;
	use Parse\ParseUser;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg', 'N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');

	// Get REQUEST variables
	$index = $_POST["index"];

	// Get modules array from session
	session_start();
	if(isset($_SESSION["modules"]) && isset($_SESSION["currentUser"])) {
	    // Its all good!
		$modules = $_SESSION["modules"];
		$currentUser = $_SESSION["currentUser"];
	}
	else{
		echo "Error. Session expired";
		exit();
	}
	
	// Remove Module
	if($index < count($modules) && $index >= 0){
		$moduleToRemove = $modules[$index];
	}
	else{
		echo "An error occured";
		exit();
	}
	
	// Get user again because for some reason it'l throw an error otherwise
	$userQuery = ParseUser::query();
	$userQuery->equalTo($currentUser->get("username"), "xv"); 
	$users = $userQuery->find();
	$user = $users[0];
	$relation = $currentUser->getRelation("modules");	
	$relation->remove($moduleToRemove);
	echo $currentUser->get("username");
	$currentUser->save();
	
	
?>