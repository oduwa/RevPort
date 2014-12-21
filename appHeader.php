<?php
	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
	}

	$username = $_SESSION["username"];
?>
	
		<!---start-wrap---->
		<!------start-768px-menu---->
			<div id="page">
					<div id="header" >
						<a class="navicon" href="#menu-left"> </a>
					</div>
					<nav id="menu-left">
						<ul>
							<li><a href="index.html">Home</a></li>
							<li><a href="about.html">About</a></li>
							<li><a href="features.html">Features</a></li>
							<div class="clear"> </div>
						</ul>
					</nav>
			</div>
		<!------start-768px-menu---->
			<!---start-header---->
			<div class="header" style="padding: 0.3em 0em;">
				<div class="wrap">
				<div class="header-left" style="margin-top: 0em;">
					<div class="logo">
						<a href="home.php" style="font-size: 0em;"><img src="web/images/uea_logo.png" height="40"  alt="UEA RevPort" /></a>
					</div>
				</div>
				<div class="header-right">
					<div class="top-nav" style="float:right;">
						<ul>
							<li class="navListItem"><a class="navLink" href="moduleList.php" style="padding: 0.3em 1.8em;">Tests</a></li>
							<li class="navListItem"><a class="navLink" href="about.html" style="padding: 0.3em 1.8em;">Board</a></li>
							<li class="dropdown" style="display:inline-block;">
						  		<button type="button" class="btn btn-link dropdown-toggle navButton" data-toggle="dropdown" aria-expanded="true" id="dropdownMenu2" 
								style="padding: 0.3em 1.8em;">
						  		    <?php
						  		    	if($username){
											echo $username;
										}
										else{
											echo "Profile";
										}
						  		    ?> <span class="caret"></span>
						  		  </button>
						  		  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
						  		    <li><a href="#">My Profile</a></li>
						  		    <li><a href="#" data-toggle="modal" data-target="#logOutModal">Log Out</a></li>
						  		  </ul>
							</li>
							<li class="navListItem">
								<a href="#"><span class="glyphicon glyphicon-stats" aria-hidden="true" style="padding-left:1.6em;color:#fff;"></span></a>
							</li>
						</ul>
					</div>
						
					<div class="clear"> </div>
				</div>
				<div class="clear"> </div>
				</div>
				<div class="clear"> </div>
			</div>
			</div>
			<!---//End-header---->
			
			<!-- Modal -->
				<div class="modal fade" id="logOutModal" tabindex="-1" role="dialog" aria-labelledby="logOutModalLabel" aria-hidden="true">
				  <div class="modal-dialog">
				    <div class="modal-content">
				      <div class="modal-body">
						  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color:#e11;"></span> Are you sure you want to log out?
				      </div>
	  			    <div class="modal-footer">
	  			      <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
	  			      <button class="btn btn-primary" data-dismiss="modal" id="logoutConfirmButton">Yes</button>
	  			    </div>
				    </div>
				  </div>
				</div>
			<script>
			$('#logoutConfirmButton').click(function(){
				// prepare js sdk for use
				Parse.initialize("ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso", "nwbeFPq6tz314WF0FaG2LrvkZ6PvJSJGgOwusG1e");
				
				// log out php sdk
				myAjax();
				
				// log out js sdk
				Parse.User.logOut();
				
				window.location.href = 'index.php';
			});
			
			function myAjax() {
			      $.ajax({
			           type: "POST",
			           url: 'logOut.php',
			           data:{},
			           success:function(html) {
			             alert(html);
			           }

			      });
			 }
			</script>