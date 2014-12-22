<?php

	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	session_start();
	
	if(isset($_SESSION["modules"])) {
	    // Its all good!
		$modules = $_SESSION["modules"];
	}
	else{
		// get modules from Parse
		
		$currentUser = $_SESSION["currentUser"];
		if (isset($_SESSION["currentUser"])) {
		    // Its all good!
		}
		else {
		    // show the signup or login page
			header("Location: error.php?msg=Wrong%20credentials%20maybe");
		}
		
		$moduleRelation = $currentUser->getRelation("modules");
		$query = $moduleRelation->getQuery();
		$query->className = "Module";
		$modules = $query->find(); // gets an array of Module PFObjects
		$_SESSION["modules"] = $modules;
	}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>UEA RevPort - Tests</title>
		<?php include 'includes.php';?>
		
		<style>
			.moduleCode{
					padding: 3px;
					margin: 0 0 8em;
					margin-left: 8px;
				    font-size: 22px;
				    //line-height: 1.3;
					font-weight: 600;
					color:#4183c4;
			}
			
			.moduleName{
					padding: 3px;
					margin-left: 8px;
				    font-style: normal;
				    font-weight: bold;
				    border-radius: 3px;
					color: #666;
			}
			
			.moduleOrganizer{
					padding: 3px;
					margin-left: 8px;
					display: block;
				    margin-top: 1px;
				    margin-bottom: 0;
				    font-size: 13px;
				    color: #888;
			}
			
			.moduleMeta{
				margin-top: 6px;
				margin-right:20px;
				float: right;
				font-size: 12px;
				font-weight: bold;
				color: #888;
				clear: right;
			}
		</style>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<hr />
		<?php
			for ($i = 0; $i < count($modules); $i++) { 
		  	  $object = $modules[$i];

			  // get the tests for this module
			  $testRelation = $object->getRelation("tests");
			  $query = $testRelation->getQuery();
			  $query->className = "Test";
			  $tests = $query->find();
			  
			  echo "<span class=\"moduleMeta\">
				  <span class=\"glyphicon glyphicon-list-alt\" aria-hidden=\"true\" style=\"margin-right:6px;\"></span>" . count($tests) .
			       "</span>
			  <br />";
		  	  echo "<a href=\"testList.php?index=" .$i. "\"><span class=\"moduleCode\">" . $object->get("moduleCode") . "</span></a><br />";
			  echo "<span class=\"moduleName\">" . $object->get("moduleName") . "</span><br />";
			  echo "<span class=\"moduleOrganizer\">" . $object->get("moduleOrganizer") . "</span><br />";
			  echo "<hr />";
			}
		?>
	</body>
</html>