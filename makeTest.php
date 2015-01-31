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

		$(document).ready(function(){
			$('#submitButton').click(function(){
				saveQuestion();
			});
		
			$('#doneButton').click(function(){
				window.location.href = 'index.php';
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
		     $.ajax({
		          type: "POST",
		          url: 'addQuestion.php',
		 data:{question:$('#question').val(), opt1:$('#opt1').val(), opt2:$('#opt2').val(), opt3:$('#opt3').val(), opt4:$('#opt4').val(), answer:$('#answer').val(), code:$('#modCode').val(), title:$('#testTitle').val(), gradeable:$('#gradeable').val()},
		          success:function(html) {
		            alert(html);
		          }

		     });
		 }
		
		</script>
		<form method="POST" style="margin-top:20px"> 
			<div class="col-xs-6">
				Question:<br />
				<input type="text" class="pure-control-group form-control" name="question" id="question" placeholder="Question" aria-describedby="basic-addon1"><br />
			
				Option 1:<br />
				<input type="text" class="pure-control-group form-control" name="opt1" id="opt1" placeholder="Option" aria-describedby="basic-addon1"><br />
			
				Option 2:<br />
				<input type="text" class="pure-control-group form-control" name="opt2" id="opt2" placeholder="Option" aria-describedby="basic-addon1"><br />
			
				Option 3:<br />
				<input type="text" class="pure-control-group form-control" name="opt3" id="opt3" placeholder="Option" aria-describedby="basic-addon1"><br />
			
				Option 4:<br />
				<input type="text" class="pure-control-group form-control" name="opt4" id="opt4" placeholder="Option" aria-describedby="basic-addon1"><br />
			
				Answer:<br />
				<input type="text" class="pure-control-group form-control" name="answer" id="answer" placeholder="Correct Answer" aria-describedby="basic-addon1"><br />
				
				<button type="button" id="submitButton" data-toggle="modal" data-target="#myModal">Submit</button>
			
			</div>
			
			<div class="col-xs-3" style="float:right; clear:right;">
				Module Code:<br />
				<input type="text" class="pure-control-group form-control" name="modCode" id="modCode" placeholder="Module Code" aria-describedby="basic-addon1"><br />
				
				Test title:<br />
				<input type="text" class="pure-control-group form-control" name="testTitle" id="testTitle" placeholder="Title" aria-describedby="basic-addon1"><br />
				
				<select name="gradeable" id="gradeable">
				  <option value="gradeable">Gradeable</option>
				  <option value="practice">Practice</option>
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




