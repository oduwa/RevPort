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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	</head>
	
	<body>
		
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
		 data:{question:$('#question').val(), opt1:$('#opt1').val(), opt2:$('#opt2').val(), opt3:$('#opt3').val(), opt4:$('#opt4').val(), answer:$('#answer').val(), code:$('#modCode').val(), title:$('#testTitle').val()},
		          success:function(html) {
		            alert(html);
		          }

		     });
		 }
		
		</script>
		<form method="POST">
			Question: <input type="text" name="question" id="question"><br />
			Option 1: <input type="text" name="opt1" id="opt1"><br />
			Option 2: <input type="text" name="opt2" id="opt2"><br />
			Option 3: <input type="text" name="opt3" id="opt3"><br />
			Option 4: <input type="text" name="opt4" id="opt4"><br />
			Correct Answer: <input type="text" name="answer" id="answer"><br />
			
			<div style="float:right; clear:right;">
				Module Code: <input type="text" name="modCode" id="modCode"><br />
				Test title: <input type="text" name="testTitle" id="testTitle"><br />
			</div>
			<button type="button" id="submitButton" data-toggle="modal" data-target="#myModal">X</button>
			<input type="submit" value="Submit" >
			<!-- data-toggle="modal" data-target="#myModal" -->
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




