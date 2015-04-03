<?php
	
require 'ParseSDK/autoload.php';
use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseRelation;
ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');

$index = $_GET["index"];

session_start();
$currrentUser = $_SESSION["currentUser"];
$modules = $_SESSION["modules"];
$module = $modules[$index];

// Get test relation from module
$testRelation = $module->getRelation("tests");
$query = $testRelation->getQuery();
$query->className = "Test";
$tests = $query->find();

// Cache retrieved tests in session
$_SESSION["tests"] = $tests;





	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>UEA RevPort <?php echo $module->get("moduleCode") . " - " . $module->get("moduleName") ?></title>
		<?php include 'includes.php';?>
		
		<style>
			.testTitle{
					padding: 3px;
					margin: 0 0 8em;
					margin-left: 8px;
				    font-size: 18px;
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
		
			.questionCount{
					padding: 3px;
					margin-left: 8px;
					display: block;
				    margin-top: 1px;
				    margin-bottom: 0;
				    font-size: 13px;
				    color: #888;
			}
		
			.mark{
				margin-top: 25px;
				margin-right:20px;
				float: right;
				font-size: 12px;
				font-weight: bold;
				background-color:transparent;
				color: #888;
				clear: right;
			}
			
			.gradeableLabel{
				display: inline-block;
				padding: 4px 5px 3px;
				margin-left: 2px;
				font-size: 11px;
				font-weight: 100;
				line-height: 11px;
				color: #a1882b;
				text-transform: uppercase;
				vertical-align: middle;
				background-color: #ffefc6;
				border-radius: 3px;
			}
			
			.practiceLabel{
				display: inline-block;
				padding: 4px 5px 3px;
				margin-left: 2px;
				font-size: 11px;
				font-weight: 100;
				line-height: 11px;
				color: #777;
				text-transform: uppercase;
				vertical-align: middle;
				background-color: #e6e6e6;
				border-radius: 3px;
			}
			
			.ListContainer {
				padding: 5px;
			}
			
			.ListItem {
				
			}
			
			.ListItem:hover {
				background-color: #d3d3d3;
			}
			
		</style>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<div class="ListContainer">
		
		<hr />
		<?php
			// for each test, get its id and get its question relation with it
			for ($i = 0; $i < count($tests); $i++) { 
			  $object = $tests[$i];
			  $objectId = $object->getObjectId();
  
			  $testQuery = new ParseQuery("Test");
			  $testQuery->equalTo("objectId", $objectId);
			  $test = $testQuery->find()[0];
			  
			  // replace the test in memory with the one whose relation contains questions
			  $tests[$i] = $test;
			  
			  // Get the questions in each test so we can show the count
			  $questionRelation = $test->getRelation("questions");
			  $query = $questionRelation->getQuery();
			  $query->className = "Question";
			  $questions = $query->find();
			  
			  // Get the scores for any test attempted
			  $mark = -1;
			  $attempters = $test->get("attempters");
			  if(in_array($currrentUser->get("username"), $attempters)){
				  $scoreRelation = $test->getRelation("scores");
				  $scoreQuery = $scoreRelation->getQuery();
				  $scoreQuery->equalTo("username", $currrentUser->get("username"));
				  $scoreQuery->className = "Score";
				  $scores = $scoreQuery->find();
				  if(count($scores) > 0){
					  $score = $scores[0];
					  $mark = $score->get("mark");
				  }
			  }

			  // Output
			  echo "<div class=\"ListItem\" onclick=\"location.href='test.php?testIndex=" . $i . "&moduleIndex=" . $index . "'\">";

			  if(empty($mark)){$mark = "0";}
			  if($mark != -1){$mark = $mark . "%";}			  
			  echo "<span class=\"mark\">" . $mark . "</span><br />";
			  
			  $testHeader = "<a href=\"test.php?testIndex=" . $i . "&moduleIndex=" . $index . "\"><span class=\"testTitle\">" . $object->get("testTitle") . "</span></a>";
			  if($object->get("gradeable") == true){
			  	$testHeader = $testHeader . "<span class=\"gradeableLabel\">Gradeable</span>";
			  }
			  else{
			  	$testHeader = $testHeader . "<span class=\"practiceLabel\">Practice</span>";
			  }
			  echo $testHeader . "<br />";
			  
			  echo "<span class=\"questionCount\">Questions: " . count($questions) . "</span><br />";
			  
			  echo "</div>";
			  
			  echo "<hr />";
			}
		?>
		
	</div>
	</body>
</html>



