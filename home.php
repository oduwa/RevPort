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
	$_SESSION["modules"] = $modules;
	
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
				width: 22%;
				//border: 1px solid #a1a1a1;
				padding: 10px 10px;
				//border-radius: 15px;
			}
		
		 	.moduleList{
		 		float:right;
				clear: right;
				display:block;
				width: 22%;
				//border: 2px solid #a1a1a1;
				padding: 10px 10px;
				//border-radius: 15px;
		 	}
			
			.mainBody{
				float:left;
				clear:left;
				display:block;
				width: 78%;
				padding-left:10px;
				padding-right:10px;
			}
			
			.tableHeader{
			    font-size: 16px;
				font-weight: 900;
				color:#000;
				line-height: 17px;
			}
			
			a:hover{
				color:#E95393;
			}
			
			a.glyphLink, a.tableHeader {
				color:#000;
			}

			a.glyphLink:hover {
				color:#0ff;
			}
		</style>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<div class="mainBody">

			<hr>
			
			<?php
				for ($i = 0; $i < count($activities); $i++) { 
			  	  $object = $activities[$i];
			  	  echo "  " . $object->get("activityMessage") . "<hr />";
				}
			?>
		</div>
		
		<div class="contactList">
			<div class="panel panel-default" style="border-radius:5px;">
				<table class="table table-bordered">
					<tr class="active">
						<th>
							<a href="#" class="tableHeader">Contacts</a>
							<a class="glyphLink" href="about.html" style="float:right;">
								<span class="glyphicon glyphicon-plus" style="color:#000;" aria-hidden="true"></span>
							</a>
						</th>
					</tr>
					<?php
						for ($i = 0; $i < count($modules); $i++) { 
					  	  $object = $modules[$i];
					  	  echo "<tr><td><a href=\"#\">" . $object->get("moduleOrganizer") . "</a></td></tr>";
						}
					?>
				</table>
			</div>
		</div>
		
		<div class="moduleList">
			<div class="panel panel-default" style="border-radius:5px;">
				<table class="table table-bordered">
					<tr class="active">
						<th>
							<a href="moduleList.php" class="tableHeader">Modules</a>
							<a class="glyphLink" href="editModules.php" style="float:right;">
								<span class="glyphicon glyphicon-plus" style="color:#000;" aria-hidden="true"></span>
							</a>
						</th>
					</tr>
					<?php
						for ($i = 0; $i < count($modules); $i++) { 
					  	  $object = $modules[$i];
					  	  echo "<tr><td><a href=\"testList.php?index=" . $i . "\">" . $object->get("moduleName") . "</a></td></tr>";
						}
					?>
				</table>
			</div>
		</div>
		
		
		
		
	</body>
</html>