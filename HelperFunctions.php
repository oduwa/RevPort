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

	
?>