<?php
	$username = $_POST["username_SignUp"];
	$password = $_POST["password_SignUp"];
	$email = $_POST["email_SignUp"];

	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg', 'N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');
	
	use Parse\ParseUser;
 
	$user = new ParseUser();
	$user->set("username", $username);
	$user->set("password", $password);
	$user->set("email", $email);
	
	use Parse\ParseSessionStorage;
	// set session storage
	session_start();
	ParseClient::setStorage( new ParseSessionStorage() );
 
	try {
	  $user->signUp();
	} catch (ParseException $ex) {
	  // Show the error message somewhere and let the user try again.
	  echo "Error: " . $ex->getCode() . " " . $ex->getMessage();
	}

	$_SESSION["username"] = $username;
	$_SESSION["password"] = $password;
	$_SESSION["currentUser"] = $user;
	
	// Redirect to the results page without the user ever knowing this page was navigated to
	header("Location: moduleSelect.php");


?>	  