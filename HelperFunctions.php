<?php
	
function changeNumberToLetter($number){
	$letter = "";
	
	switch ($number) {
	    case 0:
	        $letter = "A";
	        break;
	    case 1:
	        $letter = "B";
	        break;
	    case 2:
	        $letter = "C";
	        break;
		case 3:
		    $letter = "D";
		    break;
		case 4:
			$letter = "E";
			break;	
	    default:
	        $letter = "";
	}
	
	return $letter;
}


function getTimePassed($currentDateTime, $targetDateTime){
	$result = "";
	
	$currentTimeStamp = $currentDateTime->getTimeStamp();
	$targetTimeStamp = $targetDateTime->getTimeStamp();
	
	$timeStampDifference = $currentTimeStamp - $targetTimeStamp;
	$timeUnit = "minutes";
	$timeSince = $timeStampDifference/60;
	if($timeSince > 59){
		$timeSince = $timeSince/60;
	    $timeUnit = "hours";
		
		if($timeSince > 23){
			$timeSince = $timeSince/24;
		    $timeUnit = "days";
		}
	}
	
	
	$result = round($timeSince) . " " . $timeUnit . " ago";
	return $result;
}
	
?>