<?php

require '../../config/dbconnect.php';

session_start(); // Starting Session
	$error=''; // Variable To Store Error Message
	
if (isset($_POST['submit'])) {
if (empty($_POST['username']) || empty($_POST['password'])) {
	$error = "Username or Password is null. Come on, what are you doing?";
}
else
{
	// Define $username and $password
	$username=strtoupper($_POST['username']);
	$password=$_POST['password'];

	//query to check for account
	$query = mysqli_query($db,"select * from users where email = '$username'");
	$check = mysqli_num_rows($query); //counts how many rows returned by query
	if ($check == 1) { //makes sure only one account is returned
		$row = mysqli_fetch_assoc($query); //gets data from query
		$created = $row["created"]; 
		$oldpass = $row["hashpass"];
		$userid = $row["ID"];
		//sets last_login value
		if ($row["last_login"] > 0){
			$lastlogin = $row["last_login"];
		}else{
			$lastlogin = "RIGHT NOW LOL";
		};
		
		//AUTHENTICATE USER - make sure password is correct
		if(password_verify($password, $oldpass)){
			$_SESSION["login_user"]="$userid"; // Initializing Session
			$_SESSION["prev_login"]="$lastlogin";
			mysqli_query($db,"update users set last_login = NOW() WHERE id = '$userid'"); //set last login
			$_SESSION['fullrecord'] = mysqli_fetch_assoc($query);
			header("location: profile.php"); // Redirecting To Other Page
			
		}else{
			$error = "Account found but password incorrect. Please check and try again";
		};
		
	} else {
		$error = "Account not found. Please check and try again";
	};
mysqli_close($db); // Closing Connection
}
}elseif ((isset($_POST['create']))){ //sends the person to the create page if they hit that button.
	header("location: createuser.php");
};

?>