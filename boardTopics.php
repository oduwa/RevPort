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
	if(isset($_GET["filter"])){
		$filter = $_GET["filter"];
	}
	if(isset($_GET["searchType"]) && isset($_GET["search"])){
		$searchType = $_GET["searchType"];
		$searchText = $_GET["search"];
	}
	
	// Get all modules
	$query = new ParseQuery("Module");
	$allModules = $query->find();
	$_SESSION["allModules"] = $allModules;
	
	// Get pinned topics
	$query = new ParseQuery("Topic");
	$query->equalTo("isPinned", true);
	$pinnedTopics = $query->find();
	
	// Get total number of topics for paginator
	$query = new ParseQuery("Topic");
	$query->equalTo("isPinned", false);
	$topicCount = $query->count();
	
	// Get first page of topics
	$query = new ParseQuery("Topic");
	$query->equalTo("isPinned", false);
	$query->descending("updatedAt");
	$query->limit(10);
	if($page != 1){
		$skipMultiplier = ($page-1);
		$query->skip(10*$skipMultiplier);
	}
	if(isset($_GET["filter"]) && $filter !== "all"){
		$query->equalTo("tags", $filter);
	}
	else if(isset($_GET["searchType"]) && isset($_GET["search"])){
		if($searchType === "tag"){
			$query->equalTo("tags", $searchText);
		}
		else if($searchType === "topic"){
			$query->startsWith("topicTitle", $searchText);
		}
	}
	$topics = $query->find();
	
	// Helper functions
	include "HelperFunctions.php";
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Discussion Board</title>
		<?php include 'includes.php';?>
		<!-- Fancy Select -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
		
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
				margin-left:6%;
				margin-top:20px;
			}
			
			.paginator{
				float:right;
				clear:right;
				margin-right:6%;
			}
		
			@media only screen and (max-width:1440px) and (min-width:1024px) {
				#leftSearch{
					margin-left:8%;
				}
			
				#rightSearch{
					margin-right:10%;
					float:right;
				}
			}
		</style>
		
		<script>
			var searchType = "Search Tags";
			
			function updateLeftSearchButton(newText){
				searchType = newText;
				$("#leftSearchButton").text(newText);
			}
			
			function moduleFilter(modCode){
				window.location.href="boardTopics.php?filter=" + modCode;
			}
			
			function search(){
				// check that search field isnt empty
			    if ($('#searchField').val().trim()==="") {
					alert("You must enter something to search for");
					return false;
			    }
				
				searchText = $('#searchField').val().trim();
				if(searchType === "Search Tags"){
					window.location.href="boardTopics.php?search=" + searchText + "&searchType=tag";
				}
				else if(searchType === "Search Topics"){
					window.location.href="boardTopics.php?search=" + searchText + "&searchType=topic";
				}
			}
		</script>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<!-- Start Seach Bars -->
		<div class="row">
			<div id="leftSearch">
				<div class="col-xs-6">
					<div class="input-group">
					            <input type="text" class="form-control" id="searchField">
					            <div class="input-group-btn">
					                <button id="leftSearchButton" tabindex="-1" class="btn btn-default" type="button" onClick="search()">Search Tags</button>
					                <button tabindex="-1" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button">
					                    <span class="caret"></span>
					                    <span class="sr-only">Toggle Dropdown</span>
					                </button>
					                <ul class="dropdown-menu pull-right">
					                    <li><a onClick="updateLeftSearchButton('Search Tags');return false;" href="#">Search Tags</a></li>
					                    <li><a onClick="updateLeftSearchButton('Search Topics');return false;" href="#">Search Topics</a></li>
					                </ul>
					            </div>
					 </div>
			 	</div>
			</div>
			

			<div id="rightSearch">
				<select name="module" class="selectpicker" data-live-search="true" data-width="auto" id="moduleSelect" onchange="moduleFilter(this.value)">
					<option value=""> Module Filter </option>
					<option value="all"> All Modules </option>
					<?php
						for ($i = 0; $i < count($allModules); $i++){
							$module = $allModules[$i];
							echo "<option value=\"" . $module->get("moduleCode") . "\">" . $module->get("moduleCode") . " - " . $module->get("moduleName") . "</option>";
						}
					?>
				</select>
			</div>
		</div>
		<!-- End Seach Bars -->
		
		
		<!-- Start Control and navigation -->
		<div class="controlContainerrr">
			<button type="button" class="btn btn-default btn-sm btn-success addTopicButton" onclick="window.location.href='newTopic.php'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> New Topic
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
			    <!-- <li class="active" ><a href="#">1</a></li>
			    <li><a href="#">2</a></li>
			    <li><a href="#">3</a></li>
			    <li><a href="#">4</a></li>
			    <li><a href="#">5</a></li> -->
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
			<?php
				if(isset($filter) && $filter !== "all"){
					echo "<h3 class=\"text-info\">Filter: ". $filter ."</h3>";
				}
				else if(isset($_GET["searchType"]) && isset($_GET["search"])){
					echo "<h3 class=\"text-info\">Tag: ". $searchText ."</h3>";
				}
			?>        
		      <table class="table table-striped" style="border: 6px solid #3183b4;">
		        <thead>
		          <tr style="background:#3183b4;">
		            <th></th>
		            <th>Topic</th>
					<th>Created by</th>
					<th>Msgs</th>
		          </tr>
		        </thead>
		        <tbody>
					<!-- Pinned Topics -->
					<?php
						for ($i = 0; $i < count($pinnedTopics); $i++){
							$topic = $pinnedTopics[$i];
							echo "<tr>";
							echo "<td>". "-" ."</td>";
							echo "<td>". $topic->get("topicTitle") ."</td>";
							echo "<td>". $topic->get("topicPoster") ."</td>";
							echo "<td>". 0 ."</td>";
							echo "</tr>";
						}
					?>
					<!-- normal topics -->
					<?php
						for ($i = 0; $i < count($topics); $i++){
							$topic = $topics[$i];
							$pos = $i + 1;
							echo "<tr>";
							echo "<td>". $pos ."</td>";
							echo "<td><a href=\"topicPage.php?topicId=" . $topic->getObjectId() . "\">". $topic->get("topicTitle") ."</a></td>";
							echo "<td>". $topic->get("topicPoster") ."</td>";
							echo "<td>". 0 ."</td>";
							echo "</tr>";
						}
					?>
		          <!-- <tr>
		            <td>1</td>
		            <td>A Topic</td>
					<td>Anna</td>
					<td>2</td>
		          </tr>
		          <tr>
		            <td>2</td>
		            <td>Some other Topic</td>
					<td>Debbie</td>
					<td>1</td>
		          </tr>
		          <tr>
		            <td>3</td>
		            <td>t to the opic</td>
					<td>John</td>
					<td>16</td>
		          </tr> -->
		        </tbody>
		      </table>
		</div>
		<!-- End Topics -->
		
		
		
		
		
		
		
		
		
		
	</body>
</html>