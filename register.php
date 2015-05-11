<?php
	function destroySession(){
		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}

		// Finally, destroy the session.
		session_destroy();
	}
	//destroySession();
	
	$username = $_POST["username_SignUp"];
	$password = $_POST["password_SignUp"];
	$email = $_POST["email_SignUp"];

	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg', 'N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	
	use Parse\ParseUser;
	use Parse\ParseQuery;
 
	$user = new ParseUser();
	$user->set("username", $username);
	$user->set("password", $password);
	$user->set("email", $email);
	
	/* Count existing username and email that are the same as the one the user entered */
	$query = ParseUser::query();
	$query->equalTo("username", $username);
	$sameUsernameCount = $query->count();
	$query = ParseUser::query();
	$query->equalTo("email", $email);
	$sameEmailCount = $query->count();
	
	echo $sameEmailCount;
	
	/* Check email validity */
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL);
	
	
	//use Parse\ParseSessionStorage;
	// set session storage
	session_start();
	//ParseClient::setStorage( new ParseSessionStorage() );
 
	try {
	  $user->signUp();
	} catch (ParseException $ex) {
	  // Show the error message somewhere and let the user try again.
	  echo "Login Error: " . $ex->getCode() . " " . $ex->getMessage();
	}
	
	
	
	if($sameUsernameCount > 0 || $sameEmailCount > 0){
		header("Location: index.php?error=signupError");
		exit();
	}
	
	if(empty($email)){
		header("Location: index.php?error=emailError");
		exit();
	}
	

	$_SESSION["username"] = $username;
	$_SESSION["password"] = $password;
	$_SESSION["currentUser"] = $user;
	
	// Redirect to the results page without the user ever knowing this page was navigated to
	header("Location: moduleSelect.php");
?>	  


