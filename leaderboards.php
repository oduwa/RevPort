<?php
	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	use Parse\ParseObject;
	use Parse\ParseQuery;
	use Parse\ParseRelation;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg','N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	
	session_start();
	$modules = $_SESSION["modules"];
	
	
?>

<html>
	<head>
		<title>RevPort Leaderboards</title>
		<?php include 'includes.php';?>
		
		<style>
		</style>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<form class="horizontalCenter" name="leaderboardForm">
			<select name="module" id="moduleSelect">
				<option value=""> --- </option>
				<?php
					for ($i = 0; $i < count($modules); $i++){
						$module = $modules[$i];
						echo "<option value=\"" . $module->get("moduleCode") . "\">" . $module->get("moduleCode") . " - " . $module->get("moduleName") . "</option>";
					}
				?>
			</select>
		</form>
		<br />
		
		<div id="rankingContent" class="horizontalCentemr">
			
		</div>
		
	</body>
</html>