<?php
	
require 'ParseSDK/autoload.php';
use Parse\ParseClient;
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseRelation;
ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');

$index = $_GET["index"];

session_start();
$modules = $_SESSION["modules"];
$module = $modules[$index];

// Get test relation from module
$testRelation = $module->getRelation("tests");
$query = $testRelation->getQuery();
$query->className = "Test";
$tests = $query->find();





	
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
				    font-size: 18px;
					font-weight: 600;
					color:#4183c4;
			}
		
			.moduleName{
					padding: 3px;
				    font-style: normal;
				    font-weight: bold;
				    border-radius: 3px;
					color: #666;
			}
		
			.questionCount{
					padding: 3px;
					display: block;
				    margin-top: 1px;
				    margin-bottom: 0;
				    font-size: 13px;
				    color: #888;
			}
		
			.moduleMeta{
				margin-top: 6px;
				margin-right:20px;
				float: right;
				font-size: 12px;
				font-weight: bold;
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
		</style>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<hr />
		<?php
			// for each test, get its id and get its question relation with it
			for ($i = 0; $i < count($tests); $i++) { 
			  $object = $tests[$i];
			  $objectId = $object->getObjectId();
  
			  $testQuery = new ParseQuery("Test");
			  $testQuery->equalTo("objectId", $objectId);
			  $test = $testQuery->find()[0];
			  $questionRelation = $test->getRelation("questions");
			  $query = $questionRelation->getQuery();
			  $query->className = "Question";
			  $questions = $query->find();
			  
			  /* UNCOMMENT TO USE STAR TO DENOTE GRADEABLE TEST
			  $testHeader = "<a href=\"#\"><span class=\"testTitle\">" . $object->get("testTitle") . "</span></a>";
			  if($object->get("gradeable") == true){
			  	$testHeader = $testHeader . "<span class=\"glyphicon glyphicon-star\" aria-hidden=\"true\" style=\"margin-left:6px; color:#ffefc6;\"></span>";
			  }
			  echo $testHeader . "<br />";
			  */
			  
			  $testHeader = "<a href=\"#\"><span class=\"testTitle\">" . $object->get("testTitle") . "</span></a>";
			  if($object->get("gradeable") == true){
			  	$testHeader = $testHeader . "<span class=\"gradeableLabel\">Graded</span>";
			  }
			  echo $testHeader . "<br />";
			  
			  echo "<span class=\"questionCount\">Questions: " . count($questions) . "</span><br />";
			  echo "<hr />";
			}
		?>
	</body>
</html>



