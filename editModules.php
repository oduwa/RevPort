<?php
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseUser;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	session_start();

	if(isset($_SESSION["modules"]) && !isset($_GET["refreshModules"])) {
	    // Its all good!
		$modules = $_SESSION["modules"];
	}
	else {
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

<html>
	<head>
		<title>UEA RevPort - Edit Modules</title>
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
					display: block;
				    margin-top: 1px;
				    margin-bottom: 0;
					margin-left: 8px;
				    font-size: 13px;
				    color: #888;
			}
			
			.moduleMeta{
				margin-top: 40px;
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
			  
			  echo "<span class=\"moduleMeta\"><button type=\"button\" class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#myModal\" onclick=\"setSelectedCode('" . $object->get("moduleCode") . "')\">Remove</button></span>
			  <br />";
		  	  echo "<a href=\"testList.php?index=" .$i. "\"><span class=\"moduleCode\">" . $object->get("moduleCode") . "</span></a><br />";
			  echo "<span class=\"moduleName\">" . $object->get("moduleName") . "</span><br />";
			  echo "<span class=\"moduleOrganizer\">" . $object->get("moduleOrganizer") . "</span><br />";
			  echo "<hr />";
			}
		?>
		
		<a href="moduleSelect.php?signupIsHappening=0" role="button" class="btn btn-success btn-lg" style="float:right; clear:right margin-top: 40px; margin-bottom: 40px; margin-right:20px;">
		  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Module
		</a>

		
		<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-body">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color:#e11;"></span> Are you sure you want to remove this module from your list?
			      </div>
  			    <div class="modal-footer">
  			      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
  			      <button class="btn btn-primary" data-dismiss="modal" id="deleteConfirmButton">Yes</button>
  			    </div>
			    </div>
			  </div>
			</div>
			
			
			<script>
				var indexSelected = 1000;
				var codeSelected = "";
			
				$(document).ready(function(){
				
					$('#deleteConfirmButton').click(function(){
						removeModule(codeSelected);
					});
				
				});
			
				function setSelectedIndex(i){
					indexSelected = i;
				}
				
				function setSelectedCode(code){
					codeSelected = code;
				}
			
				function removeModulePHP(indexToRemove){
					// NOT USED
			      $.ajax({
			           type: "POST",
			           url: 'removeModuleFunction.php',
			           data:{index: indexToRemove},
			           success:function(html) {
			             alert(html);
						 //window.location.href = "editModules.php?refreshModules=1";
			           }

			      });
				}
				
	   		 function removeModule(code){
	   			 Parse.initialize("ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso", "nwbeFPq6tz314WF0FaG2LrvkZ6PvJSJGgOwusG1e");
	   			 var Module = Parse.Object.extend("Module");
	   			 var query = new Parse.Query(Module);
	   			 query.equalTo("moduleCode", code);
	   			 query.find({
	   			   success: function(results) 
	   			   {
	   				 if(results.length > 0){
	   	 				var currentUser = Parse.User.current();
	   	 				var relation = currentUser.relation("modules");
					
   						alert("Removed " + code);
   		 				relation.remove(results[0]);
   		 				currentUser.save();
						window.location.href = "editModules.php?refreshModules=1";
	   				 }

			     
	   			   },
	   			   error: function(error) 
	   			   {
	   			     alert("Error: " + error.code + " " + error.message);
	   			   }
	   			 });
			 }
			</script>
			
	</body>
	
	
	
</html>





