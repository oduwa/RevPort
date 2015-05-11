<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE HTML>
<html>
	<head>
		<title>UEA Revision Portal</title>
		<?php include 'includes.php';?>
		<!-- <link href="web/css/style.css" rel='stylesheet' type='text/css' /> -->
		<!--768px-menu-->
	</head>
	<body style="background-color: #fff">
			<?php include 'indexHeader.php';?>
			<!----start-banner---->
			<div class="text-slider">
				<div class="wrap"> 
			<!--start-da-slider-->
			<div id="da-slider" class="da-slider">
					<div class="da-slide">
						<h2>Test Your Knowledge.</h2>
						<p style="margin-top:0.5em;">Attempt test exercises with solutions</p>
						<a style="margin-top:0.5em;" href="about.html" class="da-link">Find out More</a>
					</div>
					<div class="da-slide">
						<h2>Learn From Others.</h2>
						<p style="margin-top:0.5em;">Share material on discussion boards</p>
						<a style="margin-top:0.5em;" href="about.html" class="da-link">Find out More</a>
					</div>
					<div class="da-slide">
						<h2>Log Your Progress.</h2>
						<p style="margin-top:0.5em;"> Compete with your Friends</p>
						<a style="margin-top:0.5em;" href="about.html" class="da-link">Find out More</a>
					</div>
					<div class="da-slide">
						<h2>Connect With Lecturers.</h2>
						<p style="margin-top:0.5em;">Easy contact with lecturers</p>
						<a style="margin-top:0.5em;" href="about.html" class="da-link">Find out More</a>
					</div>
					<div class="da-slide">
						<h2>Extra Material.</h2>
						<p style="margin-top:0.5em;"> View additional content added by your lecturers</p>
						<a style="margin-top:0.5em;" href="about.html" class="da-link">Find out More</a>
					</div>
					<nav class="da-arrows">
						<span class="da-arrows-prev"> </span>
						<span class="da-arrows-next"> </span>
					</nav>
			</div>
				<script type="text/javascript" src="web/js/jquery.cslider.js"></script>
				<script type="text/javascript">
					$(function() {
						$('#da-slider').cslider({
							autoplay	: true,
							bgincrement	: 450
						});
					
					});
				</script>
			 </div>
			</div>
				<!---//End-da-slider---->


					<div class="mid-grids">
						<div class="wrap">
						<div class="mid-grids-left">
							<img src="web/images/divices.png" title="divices" />
							<span> </span>
						</div>
						<div class="mid-grids-right">
							<h3> Get <span>RevPort</span> for your mobile</h3>
							<p>The RevPort app is now available for i<big>OS</big> devices.</p>
							<ul class="fea">
								<li><a href="#"><i>Manage</i> your modules</a></li>
								<li><a href="#"><i>Take</i> tests on the go </a></li>
								<li><a href="#"><i>Track</i> your activity</a></li>
							</ul>
							
						</div>
						<div class="clear"> </div>
					</div>
				</div>
						
				
				<div class="footer-grids">
					<div class="wrap">
						<div class="footer-grid">
							<h3>Quick Links</h3>
							<ul>
								<li><a href="#">About Features</a></li>
								<li><a href="#">Login</a></li>
								<li><a href="#">Sign Up</a></li>
							</ul>
						</div>
						<div class="footer-grid">
							<h3>More</h3>
							<ul>
								<li><a href="#">FAQ</a></li>
								<li><a href="#">Support</a></li>
								<li><a href="#">Privacy Policy</a></li>
								<li><a href="#">Terms and Conditions</a></li>
							</ul>
						</div>
						<div class="footer-grid">
							<h3>Connect With Us</h3>
							<ul class="social-icons">
								<li><a class="facebook" href="#"> </a></li>
								<li><a class="twitter" href="#"> </a></li>
								<li><a class="youtube" href="#"> </a></li>
							</ul>
						</div>
						<div class="footer-grid">
							<h3>Newsletter</h3>
							<p>Subscribe to our newsletter to keep up-to-date with all the latest news.</p>
							<form>
								<input type="text" class="text" value="Your Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Your Name';}">
								<input type="text" class="text" value="Your Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Your Email';}">
								<input type="submit" value="subscribe" />
							</form>
						</div>
						<div class="clear"> </div>
					</div>
				</div>
				
				<?php include 'footer.php' ?>
				<!---//End-bottom-footer-grids---->
			</div>
			<!----//End-content--->
		<!---//End-wrap---->
			

			<!-- Modal -->
			<!--
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
			      </div>
			      <div class="modal-body">
  			      <form id="modalForm" method="POST">
  
  			      <input type="hidden" name="modalForm" value="1">
  
  			      <table>
  			        <tbody><tr><td>Title</td><td><input class="form-control" type="text" name="title" id="title" /></td></tr>
  			        <tr><td>Introudction</td><td><textarea class="form-control" name="contect" style="width:300px;height:100px"></textarea></td></tr>
  			      </tbody></table>
  			      </form>
			      </div>
  			    <div class="modal-footer">
  			      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  			      <button class="btn btn-primary" data-dismiss="modal" id="modalFormSubmit">Save changes</button>
  			    </div>
			    </div>
			  </div>
			</div>
			-->
				<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title" id="loginModalLabel">UEA RevPort</h4>
				      </div>
				      <div class="modal-body">
	  			      <form class="pure-form pure-form-aligned" id="modalLoginForm" method="POST" action="login.php">
  
						<fieldset>
						        <div class="pure-control-group">
						            <label for="name">Username: </label>
						            <input name="username_LogIn" id="username_LogIn" type="text" placeholder="Username">
						        </div>

						        <div class="pure-control-group">
						            <label for="password">Password: </label>
						            <input name="password_LogIn" id="password_LogIn" type="password" placeholder="Password">
						        </div>
						</fieldset>
  
	  			      <input type="hidden" name="formType" value="1">
					  
	  			      </form>
				      </div>
	  			    <div class="modal-footer">
	  			      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  			      <button class="btn btn-primary" data-dismiss="modal" id="loginFormSubmit">Log In</button>
	  			    </div>
				    </div>
				  </div>
				</div>
			<script>
			$('#loginFormSubmit').click(function(){
			    if ($('#username_LogIn').val()==="") {
			      // invalid
			      $('#username_LogIn').next('.help-inline').show();
			      return false;
			    }
				else if($('#password_LogIn').val()==="") {
			      // invalid
			      $('#password_LogIn').next('.help-inline').show();
			      return false;
			    }
			    else {
			      // submit the form here
	 		       $('#modalLoginForm').submit();
	 			   return true;
			   }
      
			});
			</script>
			
			
			<!-- SIGNUP -->
				<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				        <h4 class="modal-title" id="signupModalLabel">UEA RevPort</h4>
				      </div>
				      <div class="modal-body">
	  			      <form class="pure-form pure-form-aligned" id="modalSignupForm" method="POST" action="register.php">
  
						<fieldset>
						        <div class="pure-control-group">
						            <label for="name">Username: </label>
						            <input name="username_SignUp" id="username_SignUp" type="text" placeholder="Username">
						        </div>

						        <div class="pure-control-group">
						            <label for="password">Password: </label>
						            <input name="password_SignUp" id="password_SignUp" type="password" placeholder="Password">
						        </div>
								
								<div class="pure-control-group">
								    <label for="email">Email Address: </label>
								    <input name="email_SignUp" id="email_SignUp" type="email" placeholder="Email Address">
								</div>
						</fieldset>
  
	  			      <input type="hidden" name="formType" value="2">
					  
	  			      </form>
				      </div>
	  			    <div class="modal-footer">
	  			      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	  			      <button class="btn btn-primary" data-dismiss="modal" id="signupFormSubmit">Sign Up</button>
	  			    </div>
				    </div>
				  </div>
				</div>
			<script>
			$('#signupFormSubmit').click(function(){
			    if ($('#username_SignUp').val()==="") {
			      // invalid
			      $('#username_SignUp').next('.help-inline').show();
				  alert("eolo");
			      return false;
			    }
				else if($('#pasword_SignUp').val()==="") {
			      // invalid
			      $('#password_SignUp').next('.help-inline').show();
			      return false;
			    }
				else if($('#email_SignUp').val()==="") {
			      // invalid
			      $('#email_SignUp').next('.help-inline').show();
			      return false;
			    }
			    else {
			      // submit the form here
	 		       $('#modalSignupForm').submit();
	 			   return true;
			   }
	  
			});
			</script>
			
  
  		<!-- Modal -->
  		<button style="display:none;" id="invisiButton" data-toggle="modal" data-target="#myModal">Invisible Button To Trigger Warning Modal :D</button>
  			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  			  <div class="modal-dialog"> 
  			      <div class="modal-content">
  				  <div class="modal-header">
  				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  				        <h4 class="modal-title"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color:#e11;"></span> FAILED TO LOGIN<br /></h4>
  				  </div>
  			      <div class="modal-body">
  					  Your username or password is incorrect.
  			      </div>
    			    <div class="modal-footer">
    			      <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
    			    </div>
  			    </div>
  			  </div>
  			</div>
			
	  		<button style="display:none;" id="invisiButton2" data-toggle="modal" data-target="#myModal2">Invisible Button To Trigger Signup Warning Modal :D</button>
	  			<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  			  <div class="modal-dialog"> 
	  			      <div class="modal-content">
	  				  <div class="modal-header">
	  				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  				        <h4 class="modal-title"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color:#e11;"></span> FAILED TO SIGN UP<br /></h4>
	  				  </div>
	  			      <div class="modal-body">
	  					  That username or email is taken.
	  			      </div>
	    			    <div class="modal-footer">
	    			      <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
	    			    </div>
	  			    </div>
	  			  </div>
	  			</div>
				
		  		<button style="display:none;" id="invisiButton3" data-toggle="modal" data-target="#myModal3">Invisible Button To Trigger Email Warning Modal :D</button>
		  			<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  			  <div class="modal-dialog"> 
		  			      <div class="modal-content">
		  				  <div class="modal-header">
		  				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  				        <h4 class="modal-title"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color:#e11;"></span> FAILED TO SIGN UP<br /></h4>
		  				  </div>
		  			      <div class="modal-body">
		  					  Invalid email.
		  			      </div>
		    			    <div class="modal-footer">
		    			      <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
		    			    </div>
		  			    </div>
		  			  </div>
		  			</div>
			
			
			<?php
				
				if(isset($_GET["error"])){
					$errorType = $_GET["error"];
				}
				else{
					$errorType = "";
				}
				

				if($errorType === "loginError"){
			?>
					
			<script type="text/javascript">
				$('#invisiButton').trigger('click')
			</script>
					
			<?
				}
				else if($errorType === "signupError"){
					
			?>
			
			<script type="text/javascript">
				$('#invisiButton2').trigger('click')
			</script>
					
			<?
				}
				else if($errorType === "emailError"){
				
			?>
			
			<script type="text/javascript">
				$('#invisiButton3').trigger('click')
			</script>
  
		<?
			}
			
		?>
			
	</body>
</html>

