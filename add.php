<html>
<head>

<link rel="stylesheet" type="text/css" href="styles/taskpage.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 

include 'session.php';

session_start(); // Starting Session

$login_session = $_SESSION["login_user"];
$date = date('Y-m-d H:i:s');
$email = $row_total['email'];

if (!isset($_SESSION['login_user']) || $_SESSION['login_user'] == ''){
	header("location: tasks.php");
};

if (isset($_POST['login_user']) || $_SESSION['login_user'] == ''){
	header("location: tasks.php");
};

mysqli_close($db); // Closing Connection

?>

<title>ADD tasks - <?php echo"$email" ?></title>
</head>
<body>
<center>
<br /> <br />
<b>YOUR USER ID - <?PHP echo "$login_session" ?></b>
<br /> <br />

<form action="" method="post">
Task Name <br> <input type="text" name="taskname" /> <BR><bR>
Task Description <br> <textarea name="DESC" rows="10" cols="30"></textarea><BR><bR>
Due Date <br> <input type="date" name="duedate" /> <BR><bR>


<br><Br>
<input name="savetask" type="submit" value="SAVE TASK">
</form>

<form action="profile.php" method="post">
<input name="cancel" type="submit" value="CANCEL">
</form>

</center>


</body>
</html>