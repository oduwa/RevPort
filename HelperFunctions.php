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
	$timeUnit = (round($timeSince) == 1) ? "minute" : "minutes";
	if($timeSince > 59){
		$timeSince = $timeSince/60;
	    $timeUnit = (round($timeSince) == 1) ? "hour" : "hours";
		
		if($timeSince > 23){
			$timeSince = $timeSince/24;
		    $timeUnit = (round($timeSince) == 1) ? "day" : "days";
			
			if($timeSince > 6){
				$timeSince = $timeSince/7;
			    $timeUnit = (round($timeSince) == 1) ? "week" : "weeks";
			}
		}
	}
	
	
	$result = round($timeSince) . " " . $timeUnit . " ago";
	return $result;
}



function getStartingIndexForPage($pageNumber){
	if($pageNumber < 5){
		return 0;
	}
	else{
		$startingIndex = ($pageNumber-5)+1;
		return $startingIndex;
	}
}





	
?>