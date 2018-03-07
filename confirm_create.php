<html> 
<head>
<title> confirm creation </title>
<link rel="stylesheet" type="text/css" href="styles/taskpage.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php

require ('../../config/dbconnect.php');

$username = strtoupper($_POST['username']);
$password = $_POST['password'];
$hashpass = password_hash($password, PASSWORD_BCRYPT);

//insert data in to database
//check to make sure email address is valid. No use collecting some BS. 
if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
	$insertmessage = "Invalid email format. Please Try again.";
	 
//check to make sure password is long enough
}else if (strlen($password) < 6){
	$insertmessage = "Invalid password - must be at least 6 characters. Please Try Again.";

//check to make sure email hasn't already been used
}else if (mysqli_num_rows(mysqli_query($db,"select * from users where email = '$username'")) > 0){
	$insertmessage = "Email already in use. Please try an email that hasn't been used before.";

//if everything is good, create the credentials. 
}else{
	//create login credentials
	mysqli_query($db,"INSERT INTO users (email,hashpass,created) VALUES 
	('$username','$hashpass',NOW())");
	//confirm that the account was created
	if (mysqli_num_rows(mysqli_query($db,"select * from users where email = '$username'")) <> 1){
		$insertmessage = "ACCOUNT NOT CREATED TRY AGAIN";
	}else{
		$insertmessage = "Account Created.";
	}
}
//close db connection
mysqli_close($db);

?>

</head>
<body>
<center>
<br>
<h1> CREATION RESULT </h1>
<?php echo "$message"; ?>
<br /> <br />
<?php echo "<H2>$insertmessage</H2>"; ?>
<br /> <br />
<form action="tasks.php" method="post">
<input type="submit" name="gohome" value="Go Home" />
</form>
<form action="createuser.php" method="post">
<input type="submit" name="gocreate" value="Back To Create" />

</center>
</body>
</html>