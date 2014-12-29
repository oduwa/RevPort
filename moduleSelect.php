
<?php
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg', 'N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');

	use Parse\ParseQuery;
	$query = new ParseQuery("Module");
	$results = $query->find();
	
	$signupIsHappening = true;
	if(isset($_GET["signupIsHappening"])){
		$signupIsHappening = false;
	}
	session_start();

?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Module Select</title>
		<?php include 'includes.php';?>
		<!-- Spinner -->
		<script src="web/bootstrap/js/spin.js"></script>
		<script type="text/javascript" src="Spinner/assets/fd-slider/fd-slider.js"></script>
		<script src="Spinner/spin.min.js"></script>
		
		
		<script type="text/javascript">
		$(document).ready(function(){
			// Setup activity indicator
			var opts = {
			  lines: 13, // The number of lines to draw
				length: 4,//20, // The length of each line
				width: 3,//10, // The line thickness
				radius: 6,//30, // The radius of the inner circle
			  corners: 1, // Corner roundness (0..1)
			  rotate: 0, // The rotation offset
			  direction: 1, // 1: clockwise, -1: counterclockwise
			  color: '#000', // #rgb or #rrggbb or array of colors
			  speed: 1, // Rounds per second
			  trail: 60, // Afterglow percentage
			  shadow: false, // Whether to render a shadow
			  hwaccel: false, // Whether to use hardware acceleration
			  className: 'spinner', // The CSS class to assign to the spinner
			  zIndex: 2e9, // The z-index (defaults to 2000000000)
			  top: '50%', // Top position relative to parent
			  left: '50%' // Left position relative to parent
			};
			target = document.getElementById('spinnerContainer');
			spinner = new Spinner(opts);
			spinner.spin(target);
			
			Parse.initialize("ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso", "nwbeFPq6tz314WF0FaG2LrvkZ6PvJSJGgOwusG1e");
			var currentUser = Parse.User.current();
			Parse.User.logIn(<?php echo "\"" . $_SESSION["username"] . "\"" ?>, <?php echo "\"" . $_SESSION["password"] . "\"" ?>, {
			  success: function(user) {
			    // Do stuff after successful login.
				  spinner.spin();
			  },
			  error: function(user, error) {
			    // The login failed. Check error to see why.
				  spinner.spin();
				  alert("An error occured. Please try to manage your modules again later.");
				  window.location.href = "home.php";
			  }
			});
		});
		
		function clicked(x, code){
			if (document.getElementById(x).checked) {
				// user just checked the box
				handleModule(code, true);
			} 
			else {
				// user just unchecked the box
				handleModule(code, false);
			}
		    
		}
		
		function myAjax(code, checked) {
			// NOT USED
		      $.ajax({
		           type: "POST",
		           url: 'addModuleFunction.php',
		           data:{moduleCode:code, checked:checked},
		           success:function(html) {
		             alert(html);
		           }

		      });
		 }
		 
		 function handleModule(code, checked){
			 spinner.spin(target);
			 Parse.initialize("ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso", "nwbeFPq6tz314WF0FaG2LrvkZ6PvJSJGgOwusG1e");
			 var Module = Parse.Object.extend("Module");
			 var query = new Parse.Query(Module);
			 query.equalTo("moduleCode", code);
			 query.find({
			   success: function(results) 
			   {
				 if(results.length > 0){
	 				var currentUser = Parse.User.current();
	 				var moduleRelation = currentUser.relation("modules");
					var Activity = Parse.Object.extend("Activity");
					var newActivity = new Activity();
					var activityMessage = "";
					var alertMessage = ""
					
					if(checked){
						alertMessage = "Added " + code;
		 				moduleRelation.add(results[0]);
						activityMessage = "added the module:  " + results[0].get("moduleCode") + " - " + results[0].get("moduleName") + ".";
					}
					else{
						alertMessage = "Removed " + code;
		 				moduleRelation.remove(results[0]);
						activityMessage = "removed the module:  " + results[0].get("moduleCode") + " - " + results[0].get("moduleName") + ".";
					}
					
					// save activity
					newActivity.set("activityMessage", activityMessage);
					newActivity.save().then(function(savedActivity){
						var activityRelation = currentUser.relation("activities");
						activityRelation.add(savedActivity);
   		 				return currentUser.save();
				    }).then(function(){
						alert(alertMessage);
						spinner.spin();
					});
				 }
				 else{
				 	spinner.spin();
				 }
 
			   },
			   error: function(error) 
			   {
				   spinner.spin();
			     alert("Error: " + error.code + " " + error.message);
			   }
			 });
		 }

		</script>
		 
		 <style>
		 	#headingContainer{
		 		margin-left:30%;
				margin-right:30%;
				padding-top:1em;
		 	}
			
		 	#buttons{
		 		float:right;
				margin-top:15px;
				margin-bottom:15px;
				margin-left:35px;
				margin-right:5px;
		 	}
		 </style>
	</head>
	
	<body>
		<div id="spinnerContainer" class="screenCentered"></div>
		
		<div id="headingContainer">
			<h3 style="color:#468cc8; font-size:1.8em;"> Select the modules you are taking or are interested in </h3><br />
		</div>
		
		<div id="tableAndBtnContainer" style="margin-left:30%; margin-right:30%">
			<table class="pure-table">
			    <thead>
			        <tr>
			            <th>Module Code</th>
			            <th>Module Name</th>
			            <th>Module Organizer</th>
						<th></th>
			        </tr>
			    </thead>

			    <tbody>
					<?php
						for ($i = 0; $i < count($results); $i++) { 
					 	   $object = $results[$i];
					   
						   if($i % 2 != 0){
					?>
					<tr class="pure-table-odd">
					<?php
							}
							else{
					?>
					<tr>
					<?php
							}
					?>
			            <td><?php echo $object->get("moduleCode")?></td>
			            <td><?php echo $object->get("moduleName")?></td>
						<td><?php echo $object->get("moduleOrganizer")?></td>
						<td><?php echo "<input type=\"checkbox\" onclick=\"clicked(".$i.",'".$object->get("moduleCode")."')\" id=\"".$i."\">"; ?></td>
			        </tr>

					<?php } ?>
			    </tbody>
			</table>
		
			<div id="buttons">
				<?php
					if($signupIsHappening){
						echo "<a class=\"btn btn-default\" href=\"home.php\" role=\"button\">Skip</a>";
					}
				?>
				<a class="btn btn-primary" href="home.php" role="button">Confirm Selections</a>
			</div>
		</div>
			
	</body>
</html>

