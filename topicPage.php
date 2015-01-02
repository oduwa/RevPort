<?php
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	session_start();
	
	// Get REQUEST variables
	$page = 1;
	if(isset($_GET["page"])){
		$page = $_GET["page"];
	}
	
	if(!isset($_GET["topicId"])){
		header("Location: error.php?msg=Topic could not be found");
		exit();
	}
	$topicId = $_GET["topicId"];
	
	
	// Get topic object
	$query = new ParseQuery("Topic");
	$query->equalTo("objectId", $topicId);
	$topic = $query->first();
	
	// Get posts under topic
	$postRelation = $topic->getRelation("posts");
	$postRelationQuery = $postRelation->getQuery();
	$postRelationQuery->className = "Post";
	$postRelationQuery->ascending("createdAt");
	$postRelationQuery->limit(10);
	if($page != 1){
		$skipMultiplier = ($page-1);
		$postRelationQuery->skip(10*$skipMultiplier);
	}
	$posts = $postRelationQuery->find();
	
	// Get total number of posts for paginator
	$topicCount = $topic->get("postCount");
	
	// Helper functions
	include "HelperFunctions.php";
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Test Results</title>
		<?php include 'includes.php';?>
		<!-- Spinner -->
		<script src="web/bootstrap/js/spin.js"></script>
		<script type="text/javascript" src="Spinner/assets/fd-slider/fd-slider.js"></script>
		<script src="Spinner/spin.min.js"></script>
		
		<style>
			td.meta{
				padding:20px;
				background-color: #cdd9e4;
				width: 15%;
			}
			td.msg{
				padding:20px;
				//background-color:#e6e6e6;
				text-align: left;
			}
			
			.meta-text{
				font-size: 14px; 
				display: block; 
				border-right: 1px solid #d9d9d9;
				vertical-align: top;
				line-height: 17px;
				text-align: center; 
			}
			
			.leftSideButton{
				margin-top:20px;
			}
			
			.paginator{
				float:right;
				clear:right;
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
			
				
				
				$('#postMessageButton').click(function(){
					// check for input
					if($("#postMessageArea").val().trim() === ""){
						alert("You did not enter a message");
						return false;
					}
					
					spinner.spin(target);
					
					// create new post 
					var Post = Parse.Object.extend("Post");
					var post = new Post();
					post.set("posterUsername", <?php echo "\"" . $_SESSION["username"] . "\"" ?>);
					post.set("postMessage", $("#postMessageArea").val().trim());
					
					// get user object
					Parse.User.logIn(<?php echo "\"" . $_SESSION["username"] . "\"" ?>, <?php echo "\"" . $_SESSION["password"] . "\"" ?>).then(function(user){
					
						return post.save();
					
					}).then(function(post){
						// get topic
						var query = new Parse.Query("Topic");
						query.equalTo("objectId", <?php echo "\"" . $topicId . "\"" ?>);
						
						return query.find();
					}, function(postSaveError) {
	  				  	// the save failed.
						endInput();
						$("#modalDismissButton").click();
						alert("Seems like an error occured creating your post. Please try again later");
					}).then(function(topicResults){
						// Add post to topic
						if(topicResults.length < 1){
							endInput();
							alert("Seems like an error occured creating your post. Please try again later");
							return false;
						}
						
						var topic = topicResults[0];
						var postRelation = topic.relation("posts");
						postRelation.add(post);
						topic.increment("postCount");
						
						return topic.save();
					}, function(topicFetchError) {
  				  		// the save failed.
						endInput();
						alert("Seems like an error occured creating your post. Please try again later");
					}).then(function(){
						// DONE!
						endInput();
						window.location.href = "topicPage.php?topicId=<?php echo $topicId; ?>&page=<?php echo $page; ?>";
					}, function(topicSaveError) {
  				  		// the save failed.
						endInput();
						alert("Seems like an error occured creating your post. Please try again later");
					})
					
					
					
					// clear text field
					$("#postMessageArea").val("");
				});
				
				function endInput(){
					// clear text field
					$("#postMessageArea").val("");
					
					// dismiss modal
					$("#modalDismissButton").click();
					
					// stop spinner
					spinner.spin();
				}
			});
			
			function trackTopic(){
				spinner.spin(target);

				// get user object
				Parse.User.logIn(<?php echo "\"" . $_SESSION["username"] . "\"" ?>, <?php echo "\"" . $_SESSION["password"] . "\"" ?>).then(function(user){
				
					// get topic
					var query = new Parse.Query("Topic");
					query.equalTo("objectId", <?php echo "\"" . $topicId . "\"" ?>);
					
					return query.find();
				
				}).then(function(topicResults){
					// Add topic to users tracked topics
					if(topicResults.length < 1){
						endInput();
						alert("Seems like an error occured creating your post. Please try again later");
						return false;
					}
					
					var topic = topicResults[0];
					var user = Parse.User.current();
					var relation = user.relation("trackedTopics");
					relation.add(topic);
					
					return user.save();
				}, function(topicFetchError) {
  				  	// the save failed.
					spinner.spin();
					alert("Could not track this post. Please try again later");
				}).then(function(topicResults){
					// DONE
					spinner.spin();
					alert("The topic is now being tracked");
				}, function(userSaveError) {
  				  	// the save failed.
					spinner.spin();
					alert("Could not track this post. Please try again later");
				});
			}
			
		</script>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<div id="spinnerContainer" class="screenCentered"></div>
		
		<div class="table-responsivme" style="margin-left:3%; margin-right:3%; margin-top:5px;">
			<h3 class="text-info"><?php echo $topic->get("topicTitle"); ?></h3>
			<hr />
			
			<div style="float:left;">
				<button type="button" class="btn btn-default btn-sm leftSideButton" onclick="trackTopic()">
				  <span class="glyphicon glyphicon-flag" aria-hidden="true"></span> Track Topic
				</button>
				<button type="button" class="btn btn-default btn-sm btn-success leftSideButton" data-toggle="modal" data-target="#myModal">
				  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Post New Message
				</button>
			</div>
			
			<nav class="paginator">
			  <ul class="pagination pagination-sm">
			    <li>
			      <a href="<?php if($page > 1){$dest = $page-1; echo "topicPage.php?topicId=" . $topic->getObjectId() . "&page=" . $dest;}else{echo "#";} ?>" aria-label="Previous">
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
								echo "<li class=\"active\" ><a href=\"topicPage.php?topicId=" . $topic->getObjectId() . "&page=" . $pos . "\">" . $pos . "</a></li>";
							}
							else{
								echo "<li><a href=\"topicPage.php?topicId=" . $topic->getObjectId() . "&page=" . $pos . "\">" . $pos . "</a></li>";
							}
						}
					}
				?>
			    <!-- <li class="active"><a href="#">1</a></li>
			    <li><a href="#">2</a></li>
			    <li><a href="#">3</a></li>
			    <li><a href="#">4</a></li>
			    <li><a href="#">5</a></li> -->
			    <li>
			      <a href="<?php if($page<$pageCount){$dest = $page+1; echo "topicPage.php?topicId=" . $topic->getObjectId() . "&page=" . $dest;}else{echo "#";} ?>" aria-label="Next">
			        <span aria-hidden="true">&raquo;</span>
			      </a>
			    </li>
			  </ul>
			</nav>
			
			<table class="table-bordered table-striped" width="100%" style="margin-top:10px;">
				<?php
					for ($i = 0; $i < count($posts); $i++){
						$post = $posts[$i];
						
						echo "<tr>";
							// Left column (info & metadata)
							echo "<td class=\"meta\">";
								echo "<span class=\"meta-text\">". $post->get("posterUsername") ."</span>";
								echo "<span class=\"meta-text\">Posted ". $post->getCreatedAt()->format("d/m/y") ."</span>";
								echo "<span class=\"meta-text\">Posted ". $post->getCreatedAt()->format("h:i:s A") ."</span>";
								echo "<span class=\"meta-text\"><a href=\"#\">Report</a></span>";
								echo "<span class=\"meta-text\"><a href=\"#\">Quote</a></span>";
							echo "</td>";
							
							// Right Column (message)
							echo "<td class=\"msg\">";
								echo nl2br($post->get("postMessage"));
							echo "</td>";
						echo "</tr>";
					}
				?>
			</table>
			<br /><br />
		</div>
		
		
		
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
			  <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h3 class="modal-title text-info"><?php echo $topic->get("topicTitle"); ?><br /></h3>
			  </div>
		      <div class="modal-body">
				  <div class="form-group" style="margin-top:15px;">
					<textarea class="form-control" rows="15" id="postMessageArea" placeholder="Your message here" maxlength="2000"></textarea><br />
				  </div>
		      </div>
		    <div class="modal-footer">
		      <button type="button" id="modalDismissButton" class="btn btn-default" data-dismiss="modal">Cancel</button>
		      <button class="btn btn-primary" id="postMessageButton">Post Message</button>
		    </div>
		    </div>
		  </div>
		</div>

		
	</body>
</html>