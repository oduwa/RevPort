<?php
	if(isset($_GET["msg"])){
		$errorMsg = $_GET["msg"];
		echo "An error occured. " . $errorMsg;
	}
	else{
		echo "An error occured. Sorry, try again.";
	}
	
?>