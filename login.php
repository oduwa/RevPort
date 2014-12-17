<?php

	//echo "do you wanna do you wanna be ... happy?";
		
	$username = $_POST["username_LogIn"];
	$password = $_POST["password_LogIn"];

	require 'ParseSDK/autoload.php';
	use Parse\ParseClient;
	ParseClient::initialize('ORixDHh6POsBCVYXFjdHMcxkCEulj9XmSvLYgVso', 'NMfDfqPynXaaHDRcHibZE7rPMphVkwj1Hg1GCWLg', 'N147DUpf2AeVi3JzTbTlAtEitazlDynM0eLzfJR7');

	// log in
	use Parse\ParseUser;
	try {
	  $user = ParseUser::logIn($username, $password);
	  // Do stuff after successful login.
	}
	catch (ParseException $error) {
	  // The login failed. Check error to see why.
	  header("Location: error.php");
	  exit();
	}

	// set session storage
	//use Parse\ParseSessionStorage;
	session_start();
	//ParseClient::setStorage( new ParseSessionStorage() );

	$_SESSION["username"] = $username;
	$_SESSION["password"] = $password;
	$_SESSION["currentUser"] = $user;

	// Redirect to the results page without the user ever knowing this page was navigated to
	header("Location: home.php");


?>	  