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
	$modules = $moduleRelation->getQuery()->find(); // gets an array of Module PFObjects

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
				border-radius: 25px;
			}
		
		 	.moduleList{
		 		float:right;
				clear: right;
				display:block;
				background: #00ffff;
				width: 20%;
				border: 2px solid #a1a1a1;
				padding: 10px 20px;
				border-radius: 25px;
		 	}
		</style>
	</head>
	
	<body>
		
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
		
		<?php echo "Welcome " . $currentUser->get("username") . "!" ?>
			
		Hello, <div id="usernamePlaceholder"> </div>
	</body>
</html>