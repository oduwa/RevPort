<?php
	
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
	$relation = $user->getRelation("modules");	
	if(count($results) > 0 && $_POST['checked'] == true){
		$relation->add($results[0]);
		$user->save();
	}
	else if(count($results) > 0 && $_POST['checked'] == false){
		$relation->remove($results[0]);
		$user->save();
	}
	
	
?>