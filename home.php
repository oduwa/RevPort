<?php

	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');

	session_start();
	$currentUser = $_SESSION["currentUser"];
	if (isset($_SESSION["currentUser"])) {
	    // Its all good!
		if(empty($currentUser->get("username"))){
			header("Location: index.php?error=loginError");
		}
	}
	else {
	    // show the signup or login page
		header("Location: index.php?error=loginError");
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
	$query->descending("createdAt");
	$query->limit(10);
	$activities = $query->find(); // gets an array of Activity PFObjects

	// Helper functions
	include "HelperFunctions.php";
?>
		
<!DOCTYPE HTML>
<html>
	<head>
		<title>UEA RevPort</title>
		<!-- <link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'> -->
		<!-- <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,700' rel='stylesheet' type='text/css'> -->
		<link href='http://fonts.googleapis.com/css?family=Josefin+Sans:400,700,400italic' rel='stylesheet' type='text/css'>
		
		<?php $pageTitle = "home"; ?>
		<?php include 'includes.php';?>
		
		<style>
			.contactList{
				float:left;
				clear: left;
				display:block;
				width: 22%;
				//border: 1px solid #a1a1a1;
				padding: 10px 10px;
				//border-radius: 15px;
			}
		
		 	.moduleList{
		 		float:left;
				clear: left;
				display:block;
				width: 22%;
				//border: 2px solid #a1a1a1;
				padding: 10px 10px;
				//border-radius: 15px;
		 	}
			
			.mainBody{
				float:right;
				clear:right;
				display:block;
				width: 78%;
				padding-left:10px;
				padding-right:10px;
				margin-top:20px;
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
			
			.SidebarText {
				font-family: 'Josefin Sans', sans-serif;
				font-weight: normal;
			}
			
			.SidebarTitle {
				font-family: 'Raleway', sans-serif;
				font-weight: bold;
				font-size: 19px;
			}
			
			.ActivityText {
				font-family: 'Raleway', sans-serif;
				font-weight: normal;
				font-size: 18px;
			}
			
			.TimeLabelText {
				font-family: 'Josefin Sans', sans-serif;
				font-weight: normal;
				font-style: italic;
				font-size: 14px;
			}
			
			.ListContainer {
				padding: 5px;
			}
			
			.ListItem {
				
			}
			
			.ListItem:hover{
				//background-color: #d3d3d3;
			}
			
			body{
				background-color: #eeeeee;
			}
			
			hr {
				border: 0; border-top: 1px solid #d3d3d3;
			}

			
		</style>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		<div class="mainBody">

			<span class="SidebarTitle" style="">Recent Activity</span>

			<hr>
			
			<?php
				$currentDate = new DateTime();
				for ($i = 0; $i < count($activities); $i++) { 
			  	  $object = $activities[$i];
				  echo "<div class=\"ListItem\">"; // start list item
			  	  echo "<span class=\"ActivityText\">  " . $object->get("activityMessage") . "</span><span style=\"float:right;clear:right;display:inline;\" class=\"TimeLabelText\">" . getTimePassed($currentDate, $object->getCreatedAt()) . "</span>" . "<hr />";
				  //echo "<span style=\"float:right;clear:right;display:inline;\">d</span>";
				  echo "</div>"; // end list item
				}
			?>
			
		</div>
		
		<div class="contactList">
			<?php
				if($currentUser->get("privilegeLevel") < 1){
			?>
					<div class="panel panel-default table-responsive" style="border-radius:5px;">
						<table class="table table-bordered">
							<tr class="active">
								<th>
									<a href="#" class="tableHeader SidebarTitle">Contacts</a>
									<a class="glyphLink" href="about.html" style="float:right;">
										<span class="glyphicon glyphicon-plus" style="color:#000;" aria-hidden="true"></span>
									</a>
								</th>
							</tr>
							<?php
								for ($i = 0; $i < count($modules); $i++) { 
							  	  $object = $modules[$i];
							  	  echo "<tr><td><a class=\"SidebarText\" href=\"#\">" . $object->get("moduleOrganizer") . "</a></td></tr>";
								}
							?>
						</table>
					</div>
			<?php
				}
			?>
			
		</div>
		
		<div class="moduleList">
			<div class="panel panel-default table-responsive" style="border-radius:5px;">
				<table class="table table-bordered">
					<tr class="active">
						<th>
							<a href="moduleList.php" class="tableHeader SidebarTitle">Modules</a>
							<a class="glyphLink" href="editModules.php" style="float:right;">
								<span class="glyphicon glyphicon-edit" style="color:#000;" aria-hidden="true"></span>
							</a>
						</th>
					</tr>
					<?php
						for ($i = 0; $i < count($modules); $i++) { 
					  	  $object = $modules[$i];
					  	  echo "<tr><td><a class=\"SidebarText\" href=\"testList.php?index=" . $i . "\">" . $object->get("moduleName") . "</a></td></tr>";
						}
					?>
				</table>
			</div>
			
			<?php
				if($currentUser->get("privilegeLevel") > 0){
			?>
			
			<a href="makeTest.php" role="button" class="btn btn-primary btn-lg" style="margin:left:35%; margin-right:700%; width:30%;">
			  <img src="web/images/newTest.png">
			</a>
			
			<?php
				}
			?>
			
		</div>
		
		
		
		
	</body>
</html>