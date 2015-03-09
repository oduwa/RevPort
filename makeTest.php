<?php
	
		//$question = $_POST["question"];
		//$option1 = $_POST["opt1"];
		//$answer = $_POST["answer"];
		
		// save to parse
		
		// suggest add another question
?>
<!DOCTYPE HTML>
<html>
	<head>
		<?php include 'includes.php';?>
		<!-- Fancy Select -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
		<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	
	<body>
		<?php include 'appHeader.php';?>
		
		<script type="text/javascript">

		var questionType = "regular";

		$(document).ready(function(){
			$('#submitButton').click(function(){
				if($('#question').val() === "" || $('#modCode').val() === "" || $('#testTitle').val() === "" || $('#testTitle').val() === "" || ($('#answer').val() === "" && questionType === "regular") || ($('#opt1').val() === "" && questionType === "regular") || ($('#opt2').val() === "" && questionType === "regular") || ($('#opt3').val() === "" && questionType === "regular") || ($('#opt4').val() === "" && questionType === "regular")){
					alert("Please complete all fields");
				}
				else{
					saveQuestion();
				}
			});
		
			$('#doneButton').click(function(){
				window.location.href = 'home.php';
			});
			
			$('#questionConfirmButton').click(function(){
				$('#question').val("");
				$('#opt1').val("");
				$('#opt2').val("");
				$('#opt3').val("");
				$('#opt4').val("");
				$('#answer').val("");
			});
		});
		
		function saveQuestion() {
			if(questionType === "regular"){
	   		     $.ajax({
	   		          type: "POST",
	   		          url: 'addQuestion.php',
	   		 data:{questionType:questionType, question:$('#question').val(), opt1:$('#opt1').val(), opt2:$('#opt2').val(), opt3:$('#opt3').val(), opt4:$('#opt4').val(), answer:$('#answer').val(), code:$('#modCode').val(), title:$('#testTitle').val(), gradeable:$('#gradeable').val()},
	   		          success:function(html) {
	   		            //alert(html);
	   		          }

	   		     });
			}
			else if(questionType === "boolean"){
	   		     $.ajax({
	   		          type: "POST",
	   		          url: 'addQuestion.php',
	   		 data:{questionType:questionType, question:$('#question').val(), opt1:"", opt2:"", opt3:"", opt4:"", answer:$('#answer2').val(), code:$('#modCode').val(), title:$('#testTitle').val(), gradeable:$('#gradeable').val()},
	   		          success:function(html) {
	   		            //alert(html);
	   		          }

	   		     });
			}
			else if(questionType === "single"){
   		     $.ajax({
   		          type: "POST",
   		          url: 'addQuestion.php',
   		 data:{questionType:questionType, question:$('#question').val(), opt1:"", opt2:"", opt3:"", opt4:"", answer:$('#answer3').val(), code:$('#modCode').val(), title:$('#testTitle').val(), gradeable:$('#gradeable').val()},
   		          success:function(html) {
   		            //alert(html);
   		          }

   		     });
			}
			
		 }
		 
		 function showTrueFalseQuestionInput(){
             var dropdown = document.getElementById("questionTypeSelect");
             var selected = dropdown.options[dropdown.selectedIndex].value;
			 
			 if(selected == 0){
			 	// Selected 4 options 1 answer
                 document.getElementById('trueFalseQuestionOptions').style.display = 'none';
                 document.getElementById('regularQuestionOptions').style.display = 'block';
				 document.getElementById('singleAnswerQuestionOptions').style.display = 'none';
				 questionType = "regular";
			 }
			 else if(selected == 1){
			 	// selected true or false
                 document.getElementById('trueFalseQuestionOptions').style.display = 'block';
                 document.getElementById('regularQuestionOptions').style.display = 'none';
				 document.getElementById('singleAnswerQuestionOptions').style.display = 'none';
				 questionType = "boolean";
			 }
			 else if(selected == 2){
			 	// selected single answer type
                 document.getElementById('trueFalseQuestionOptions').style.display = 'none';
                 document.getElementById('regularQuestionOptions').style.display = 'none';
				 document.getElementById('singleAnswerQuestionOptions').style.display = 'block';
				 questionType = "single";
			 }
		 }
		
		</script>
		 
		<form method="POST" style="margin-top:20px"> 
			<div class="col-xs-6">
				Question:<br />
				<input type="text" class="pure-control-group form-control" name="question" id="question" placeholder="Question" aria-describedby="basic-addon1" required><br />
			
				<div id="regularQuestionOptions">
				Option 1:<br />
				<input type="text" class="pure-control-group form-control" name="opt1" id="opt1" placeholder="Option" aria-describedby="basic-addon1" required><br />
			
				Option 2:<br />
				<input type="text" class="pure-control-group form-control" name="opt2" id="opt2" placeholder="Option" aria-describedby="basic-addon1" required><br />
			
				Option 3:<br />
				<input type="text" class="pure-control-group form-control" name="opt3" id="opt3" placeholder="Option" aria-describedby="basic-addon1" required><br />
			
				Option 4:<br />
				<input type="text" class="pure-control-group form-control" name="opt4" id="opt4" placeholder="Option" aria-describedby="basic-addon1" required><br />
			
				Answer:<br />
				<input type="text" class="pure-control-group form-control" name="answer" id="answer" placeholder="Correct Answer" aria-describedby="basic-addon1" required><br />
				</div>
				
				<div id="trueFalseQuestionOptions" style="display:none;">
				Answer:<br />
				<select name="answer2" id="answer2">
				  <option value="true">True</option>
				  <option value="false">False</option>
				</select><br /><br />
				</div>
				
				<div id="singleAnswerQuestionOptions" style="display:none;">
				Answer:<br />
				<input type="text" class="pure-control-group form-control" name="answer3" id="answer3" placeholder="Correct Answer" aria-describedby="basic-addon1" required><br />
				</div>
				
				<button type="button" id="submitButton" data-toggle="modal" data-target="#myModal">Submit</button>
			
			</div>
			
			<div class="col-xs-3" style="float:right; clear:right;">
				Module Code:<br />
				<input type="text" class="pure-control-group form-control" name="modCode" id="modCode" placeholder="Module Code" aria-describedby="basic-addon1" required><br />
				
				Test title:<br />
				<input type="text" class="pure-control-group form-control" name="testTitle" id="testTitle" placeholder="Title" aria-describedby="basic-addon1" required><br />
				
				<select name="gradeable" id="gradeable">
				  <option value="gradeable">Gradeable</option>
				  <option value="practice">Practice</option>
				</select><br />
				
				<select name="questionTypeSelect" id="questionTypeSelect" onClick="showTrueFalseQuestionInput()">
				  <option value="0">4 options 1 answer</option>
				  <option value="1">True or False</option>
				  <option value="2">Single Answer</option>
				</select>
			</div>
			

		</form>

		<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-body">
					  <span class="glyphicon glyphicon-question-sign" aria-hidden="true" style="color:#e11;"></span> Add another question?
			      </div>
  			    <div class="modal-footer">
  			      <button type="button" class="btn btn-default" data-dismiss="modal" id="doneButton">No</button>
  			      <button class="btn btn-primary" data-dismiss="modal" id="questionConfirmButton">Yes</button>
  			    </div>
			    </div>
			  </div>
			</div>
			
			
	</body>
</html>




