<?php
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	
	$query = new ParseQuery("Module");
	$allModules = $query->find();
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
		</script>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<!-- Start Seach Bars -->
		<div class="row">
			<div id="leftSearch">
				<div class="col-xs-6">
					<div class="input-group">
					            <input type="text" class="form-control">
					            <div class="input-group-btn">
					                <button id="leftSearchButton" tabindex="-1" class="btn btn-default" type="button">Search Tags</button>
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
				<select name="module" class="selectpicker" data-live-search="true" data-width="auto" id="moduleSelect" onchange="showRankings(this.value)">
					<option value=""> Module Filter </option>
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
			<button type="button" class="btn btn-default btn-sm btn-success addTopicButton">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> New Topic
			</button>
			
			<nav class="paginator">
			  <ul class="pagination pagination-sm">
			    <li>
			      <a href="#" aria-label="Previous">
			        <span aria-hidden="true">&laquo;</span>
			      </a>
			    </li>
			    <li class="active"><a href="#">1</a></li>
			    <li><a href="#">2</a></li>
			    <li><a href="#">3</a></li>
			    <li><a href="#">4</a></li>
			    <li><a href="#">5</a></li>
			    <li>
			      <a href="#" aria-label="Next">
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
		      <table class="table table-striped">
		        <thead>
		          <tr style="background:#3183b4;">
		            <th></th>
		            <th>Topic</th>
					<th>Created by</th>
					<th>Msgs</th>
		          </tr>
		        </thead>
		        <tbody>
		          <tr>
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
		          </tr>
		        </tbody>
		      </table>
		</div>
		<!-- End Topics -->
		
		
		
		
		
		
		
		
		
		
	</body>
</html>