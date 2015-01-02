<?php
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	session_start();
	
	if(isset($_SESSION["allModules"])){
		$allModules = $_SESSION["allModules"];
	}
	else{
		$query = new ParseQuery("Module");
		$allModules = $query->find();
	}
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>New Topic</title>
		<?php include 'includes.php';?>
		<!-- Spinner -->
		<script src="web/bootstrap/js/spin.js"></script>
		<script type="text/javascript" src="Spinner/assets/fd-slider/fd-slider.js"></script>
		<script src="Spinner/spin.min.js"></script>
		<!-- Fancy Select -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
		
		<style>
			.pageContainer{
				margin-left:5%;
				margin-right:5%;
			}
			
			.close {
			  font-size: 20px;
			  font-weight: bold;
			  line-height: 18px;
			  color: #000000;
			  text-shadow: 0 1px 0 #ffffff;
			  opacity: 0.2;
			  filter: alpha(opacity=20);
			  text-decoration: none;
			}
			.close:hover {
			  color: #000000;
			  text-decoration: none;
			  opacity: 0.4;
			  filter: alpha(opacity=40);
			  cursor: pointer;
			}
		</style>
		
		<script>
			Parse.initialize("ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso", "nwbeFPq6tz314WF0FaG2LrvkZ6PvJSJGgOwusG1e");
			var tags = [];
			var spinner;
			var target;
			
			$(document).ready(function(){
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
				spinner.spin();
				
				$('#addTagButton').click(function(){
					// check for input
					if($("#tagInput").val().trim() === ""){
						return false;
					}
					
					// get tag entered
					var newTag = $("#tagInput").val();
					
					// check that it hasnt already been added before adding it
					if($.inArray(newTag, tags) == -1){
						tags[tags.length] = newTag;
						$("#tagGroup").append("<span id=\"" + newTag + "\"  class=\"label label-primary\"><button onclick=\"removeTagWithId('"+newTag+"')\"><span style=\"color:#f00;\" aria-hidden=\"true\">&times;</span></button>" + newTag + "</span>\n");
					}
					
					// clear text field
					$("#tagInput").val("");
				});
			});
			
			function removeTagWithId(id){
				//remove tag from array
				for(var i = 0; i < tags.length; i++){
					if(tags[i] === id){
						tags[i] = "";
					}
				}
				$("#"+id).html("");
			}
			
			function showTags(){
				var str = "";
				for(var i = 0; i < tags.length; i++){
					str = str + tags[i] + " ";
				}
				alert(str);
			}
			
			function createTopic(){
				spinner.spin(target);
				
				// check that required fields are filled
			    if ($('#topicTitleField').val().trim()==="") {
					alert("You must enter a title for your topic");
					spinner.spin();
					return false;
			    }
			    if ($('#moduleSelect').val().trim()==="") {
					alert("You must enter a module under which your topic belongs");
					spinner.spin();
					return false;
			    }
			    if ($('#topicTitleArea').val().trim()==="") {
					alert("Please enter a message for your topic");
					spinner.spin();
					return false;
			    }
				
				// create post (to be added to topic relation)
				var Post = Parse.Object.extend("Post");
				var post = new Post();
				post.set("posterUsername", <?php echo "\"" . $_SESSION["username"] . "\"" ?>);
				post.set("postMessage", $('#topicTitleArea').val());
				
				// save
				Parse.User.logIn(<?php echo "\"" . $_SESSION["username"] . "\"" ?>, <?php echo "\"" . $_SESSION["password"] . "\"" ?>).then(function(user){
					
					return post.save();
					
				}).then(function(post){
					// create new topic
					var Topic = Parse.Object.extend("Topic");
					var topic = new Topic();
					topic.set("topicPoster", <?php echo "\"" . $_SESSION["username"] . "\"" ?>);
					topic.set("topicTitle", $('#topicTitleField').val());
					topic.set("isPinned", false);
					topic.set("postCount", 1);
					topic.set("tags", [$('#moduleSelect').val()]);
					for(var i = 0; i < tags.length; i++){
						topic.addUnique("tags", tags[i]);
					}
					
					// add post to topic
					postRelation = topic.relation("posts");
					postRelation.add(post);
					return topic.save();
				}, function(postSaveError) {
  				  	// the save failed.
					spinner.spin();
					alert("Seems like an error occured creating your topic. Please try again later");
				}).then(function(){
					
					// add activity
					var Activity = Parse.Object.extend("Activity");
					var newActivity = new Activity();
					var activityMessage = "created the topic " + $('#topicTitleField').val() + "on the message board";
					newActivity.set("activityMessage", activityMessage);
					
					return newActivity.save();
				}, function(topicSaveError) {
  				  	// the save failed.
					spinner.spin();
					alert("Seems like an error occured creating your topic. Please try again later");
				}).then(function(savedActivity){
					
					// add activity to user
					var currentUser = Parse.User.current();
					var activityRelation = currentUser.relation("activities");
					activityRelation.add(savedActivity);
					
	 				return currentUser.save();
				}).then(function(savedUser){
					// done
					spinner.spin();
					window.location.href = "boardTopics.php";
				});
			}
		</script>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<div id="spinnerContainer" class="screenCentered"></div>
		
		<div class="pageContainer">
			<h3 class="text-info">CREATE NEW TOPIC</h3>
			<hr />
			
			<p class="text-muted">To create a new topic, enter a title and a relating module for the topic below and create the first message. You can also add tags to the topic.</p>
			
			
			<div class="col-xs-8" style="margin-top:20px">
				Topic:<br />
				<input type="text" class="pure-control-group form-control" id="topicTitleField" placeholder="Topic" aria-describedby="basic-addon1" maxlength="100"><br />
				
				Module:<br />
				<select name="module" class="selectpicker" data-live-search="true" data-width="auto" id="moduleSelect" onchange="selectModule(this.value)">
					<option value=""> Select Module </option>
					<?php
						for ($i = 0; $i < count($allModules); $i++){
							$module = $allModules[$i];
							echo "<option value=\"" . $module->get("moduleCode") . "\">" . $module->get("moduleCode") . " - " . $module->get("moduleName") . "</option>";
						}
					?>
				</select><br /><br />
				
				Message:<br />
				<textarea class="form-control" rows="15" id="topicTitleArea" placeholder="Your message here" maxlength="2000"></textarea><br />
				
				<div class="pull-left" id="tagGroup">
				<label for="tags">Tags: </label> 
				<!-- <span id="jd"  class="label label-primary"><button><span style="color:#f00;" aria-hidden="true">&times;</span></button>Primary</span> -->
				</div>
				<button class="pull-right" data-toggle="modal" data-target="#myModal">Add Tag</button>
				
				<br /><br /><br /><br /><br />
				<button onclick="showTags()">X</button>
				<button onclick="createTopic()">Y</button>
			</div>
		</div>
		
		<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-body">
					  <div class="form-group" style="margin-top:15px;">
					  	<label for="tag" class="control-label">Add Tag:</label>
					  	<input type="text" class="form-control" id="tagInput">
					  </div>
			      </div>
  			    <div class="modal-footer">
  			      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  			      <button class="btn btn-primary" data-dismiss="modal" id="addTagButton">Add</button>
  			    </div>
			    </div>
			  </div>
			</div>
		
		
	</body>
</html>



