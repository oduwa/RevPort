<?php

	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');

	session_start();
	$currentUser = $_SESSION["currentUser"];
	if (isset($_SESSION["currentUser"])) {
	    // Its all good!
	}
	else {
	    // show the signup or login page
		header("Location: error.php?msg=Wrong%20credentials%20maybe");
	}

	//Get users modules
	use Parse\ParseRelation;
	$moduleRelation = $currentUser->getRelation("modules");
	$query = $moduleRelation->getQuery();
	$query->className = "Module";
	$modules = $query->find(); // gets an array of Module PFObjects
	
	// Get users activities
	$activityRelation = $currentUser->getRelation("activities");
	$query = $activityRelation->getQuery();
	$query->className = "Activity";
	$activities = $query->find(); // gets an array of Activity PFObjects

?>
		
<!DOCTYPE HTML>
<html>
	<head>
		<title>UEA RevPort</title>
		<?php include 'includes.php';?>
		
		<style>
			.contactList{
				float:right;
				clear: right;
				display:block;
				background: #ff0000;
				width: 20%;
				border: 2px solid #a1a1a1;
				padding: 10px 20px;
				border-radius: 15px;
			}
		
		 	.moduleList{
		 		float:right;
				clear: right;
				display:block;
				background: #00ffff;
				width: 20%;
				border: 2px solid #a1a1a1;
				padding: 10px 20px;
				border-radius: 15px;
		 	}
			
			.mainBody{
				float:left;
				clear:left;
				display:block;
				width: 80%;
			}
		</style>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<div class="mainBody">
			<?php echo "Welcome " . $currentUser->get("username") . "! <br />" ?>
			<hr>
			
			<?php
				for ($i = 0; $i < count($activities); $i++) { 
			  	  $object = $activities[$i];
			  	  echo "  " . $object->get("activityMessage") . "<hr />";
				}
				for ($i = 0; $i < count($activities); $i++) { 
			  	  $object = $activities[$i];
			  	  echo "  " . $object->get("activityMessage") . "<hr />";
				}
				for ($i = 0; $i < count($activities); $i++) { 
			  	  $object = $activities[$i];
			  	  echo "  " . $object->get("activityMessage") . "<hr />";
				}
				for ($i = 0; $i < count($activities); $i++) { 
			  	  $object = $activities[$i];
			  	  echo "  " . $object->get("activityMessage") . "<hr />";
				}
			?>
		</div>
		
		<div class="contactList">
			<?php
				for ($i = 0; $i < count($modules); $i++) { 
			  	  $object = $modules[$i];
			  	  echo $object->get("moduleOrganizer") . "<br />";
				}
			?>
		</div>
		
		<div class="moduleList">
			<?php
				for ($i = 0; $i < count($modules); $i++) { 
			  	  $object = $modules[$i];
			  	  echo $object->get("moduleName") . "<br />";
				}
			?>
		</div>
		
	</body>
</html>