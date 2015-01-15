<?php
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	use Parse\ParseRelation;
	use Parse\ParseUser;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	session_start();
	
	// Log in again to get any updated user details
	try {
	  $user = ParseUser::logIn($_SESSION["username"], $_SESSION["password"]);
	  $_SESSION["currentUser"] = $user;
	  // Do stuff after successful login.
	}
	catch (ParseException $error) {
	  // The login failed. Check error to see why.
	  header("Location: error.php");
	  exit();
	}
	
	// Get REQUEST variables
	$page = 1;
	if(isset($_GET["page"])){
		$page = $_GET["page"];
	}
	
	// Get users tracked topics
	$topicRelation = $user->getRelation("trackedTopics");
	$topicQuery = $topicRelation->getQuery();
	$topicQuery->className = "Topic";

	// Get total number of topics for paginator
	$topicCount = $topicQuery->count();
	
	// Get first page of topics
	$topicQuery->descending("updatedAt");
	$topicQuery->limit(10);
	if($page != 1){
		$skipMultiplier = ($page-1);
		$topicQuery->skip(10*$skipMultiplier);
	}
	$topics = $topicQuery->find();

	// Helper functions
	include "HelperFunctions.php";
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Discussion Board</title>
		<?php include 'includes.php';?>
		<!-- Spinner -->
		<script src="web/bootstrap/js/spin.js"></script>
		<script type="text/javascript" src="Spinner/assets/fd-slider/fd-slider.js"></script>
		<script src="Spinner/spin.min.js"></script>
		
		<style>
			.row{
				margin-top:10px;
			}
			
			.topicContainer{
				margin-left:5%;
				margin-right:5%;
				margin-top:25px;
			}
			
			.controlContainer{
				margin-left:6%;
				margin-right:6%;
				margin-top:20px;
			}
			
			.addTopicButton{
				margin-left:0%;
				margin-top:20px;
			}
			
			.trackedTopicsButton{
				margin-left:6%;
				margin-top:20px;
			}
			
			.paginator{
				float:right;
				clear:right;
				margin-right:6%;
			}
		
			#leftSearch, #rightSearch{
				margin-left:8%;
			}

			/* Desktop Layout */
			@media only screen and (max-width:1440px) and (min-width:1024px) {
				#rightSearch{
					margin-left:0%;
					margin-right:10%;
					float:right;
				}
			}
			
			/* Mobile Layout */
			@media only screen and (max-width:768px) and (min-width:240px) {
				.topicContainer{
					margin-left:0%;
					margin-right:0%;
					margin-top:0px;
				}
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
			});
			
			function untrackTopic(topicId){
				spinner.spin(target);

				// get user object
				Parse.User.logIn(<?php echo "\"" . $_SESSION["username"] . "\"" ?>, <?php echo "\"" . $_SESSION["password"] . "\"" ?>).then(function(user){
			
					// get topic
					var query = new Parse.Query("Topic");
					query.equalTo("objectId", topicId);
				
					return query.find();
			
				}).then(function(topicResults){
					// Remove topic from users tracked topics
					if(topicResults.length < 1){
						spinner.spin();
						alert("Seems like an error occured untracking this post. Please try again later");
						return false;
					}
				
					var topic = topicResults[0];
					var user = Parse.User.current();
					var relation = user.relation("trackedTopics");
					relation.remove(topic);
				
					return user.save();
				}, function(topicFetchError) {
				  	// the save failed.
					spinner.spin();
					alert("Could not un-track this post. Please try again later");
				}).then(function(topicResults){
					// DONE
					spinner.spin();
					window.location.href = "trackedTopics.php";
				}, function(userSaveError) {
				  	// the save failed.
					spinner.spin();
					alert("Could not un-track this post. Please try again later");
				});
			}
		</script>
		
	</head>
	
	<body>
		<?php include 'appHeader.php';?>

		<div id="spinnerContainer" class="screenCentered"></div>
		
		<!-- Start Control and navigation -->
		<div class="controlContainerrr">
			<button type="button" class="btn btn-default btn-sm trackedTopicsButton" onclick="window.location.href='boardTopics.php';">
			   Topic List
			</button>
			
			
			<nav class="paginator">
			  <ul class="pagination pagination-sm">
			    <li>
			      <a href="<?php if($page > 1){$dest = $page-1; echo "boardTopics.php?page=" . $dest;}else{echo "#";} ?>" aria-label="Previous">
			        <span aria-hidden="true">&laquo;</span>
			      </a>
			    </li>
				
				<?php
					$pageCount = ceil($topicCount/10);
					$pageCount = ($pageCount == 0) ? 1 : $pageCount;
					$startingIndex = getStartingIndexForPage($page);
					for ($i = $startingIndex; $i < $startingIndex+5; $i++){
						$pos = $i+1;
						if($pos <= $pageCount){
							if($pos == $page){
								echo "<li class=\"active\" ><a href=\"boardTopics.php?page=" . $pos . "\">" . $pos . "</a></li>";
							}
							else{
								echo "<li><a href=\"boardTopics.php?page=" . $pos . "\">" . $pos . "</a></li>";
							}
						}
					}
				?>
				
			    <li>
			      <a href="<?php if($page<$pageCount){$dest = $page+1; echo "boardTopics.php?page=" . $dest;}else{echo "#";} ?>" aria-label="Next">
			        <span aria-hidden="true">&raquo;</span>
			      </a>
			    </li>
			  </ul>
			</nav>
			<br />
		</div>
		<!-- End Control and navigation -->
		
		
		<!-- Start Topics -->
		<div class="table-responsive topicContainer">         
		      <table class="table table-striped" style="border: 6px solid #B4B5BE;">
		        <thead>
		          <tr style="background:#B4B5BE;">
		            <th></th>
		            <th>Topic</th>
					<th>Created by</th>
					<th>Msgs</th>
		          </tr>
		        </thead>
		        <tbody>
					<!-- normal topics -->
					<?php
						for ($i = 0; $i < count($topics); $i++){
							$topic = $topics[$i];
							$pos = $i + 1;
							$postCount = $topic->get("postCount");
							if(empty($postCount)){$postCount = "0";}
							echo "<tr>";
							echo "<td>". "<button type=\"button\" class=\"btn btn-danger btn-xs\" onclick=\"untrackTopic('" . $topic->getObjectId() . "')\"><span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span></button>" ."</td>";
							echo "<td><a href=\"topicPage.php?topicId=" . $topic->getObjectId() . "\">". $topic->get("topicTitle") ."</a></td>";
							echo "<td>". $topic->get("topicPoster") ."</td>";
							echo "<td>". $postCount ."</td>";
							echo "</tr>";
						}
					?>

		        </tbody>
		      </table>
		</div>
		<!-- End Topics -->
		
		
		
		
		
		
		
		
		
		
	</body>
</html>