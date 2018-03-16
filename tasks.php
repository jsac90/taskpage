<html>
<head>

<link rel="stylesheet" type="text/css" href="styles/taskpage.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Page</title>

<?php
include('login.php'); // Includes Login Script


//this section will automatically redirect the user to their profile if they are logged in. :-)

if(isset($_COOKIE['jstaskpagelogin'])){
	$_SESSION['login_user'] = $_COOKIE['jstaskpagelogin'];
	header("location: profile.php");
}

if(isset($_SESSION['login_user'])){
header("location: profile.php");
}




//if you need to be able to create an account add the following back to the form above the error:

//<input name="create" type="submit" value="Create Account">
//<br /><br />
?>

</head>
<body>
<center>

<h1> Please Log In </h1>

<form action="" method="post">
<label>Email Address: </label><br>
<input type="text" name="username">
<br><br>
<label>Password: </label><br>
<input type="password" name="password">
<br /> <br />
<input name="submit" type="submit" value="Log In">
<br /> <br />
<font color="red"><?php echo $error; ?></font>
</form>

</center>
</body>
</html>