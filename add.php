<html>
<head>

<link rel="stylesheet" type="text/css" href="styles/taskpage.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 

include 'session.php';
require ('../../config/dbconnect.php');
session_start(); // Starting Session


$login_session = $_SESSION["login_user"];
$date = date('Y-m-d H:i:s');
$email = $row_total['email'];
$nameerror = '';

if (!isset($_SESSION['login_user']) || $_SESSION['login_user'] == ''){
	header("location: tasks.php");
};

if (isset($_POST['savetask']) && !EMPTY($_POST['taskname'])){
	$taskname = $_POST['taskname'];
	$taskdesc = $_POST['taskdesc'];
	$duedate = $_POST['duedate'];
	IF (EMPTY ($duedate)) {
		$sqldate = 'NULL';
	} ELSE {
		$sqldate="'".date("Y-m-d H:i:s",strtotime($duedate))."'";
	}

	mysqli_query($db,"INSERT INTO tasks (userid, taskname,createdby,taskdesc,duedate) VALUES 
	('$login_session','$taskname','$login_session','$taskdesc',$sqldate)");
	$_SESSION['lasterror'] = "Created task \"$taskname\".";
	//$_SESSION['lasterror'] = "$duedate"; //used this for testing the date 
	header("location: profile.php");
} elseif (isset($_POST['savetask']) && EMPTY($_POST['taskname'])) {
	$nameerror = "ERROR - TASK NAME MUST NOT BE NULL";
}


mysqli_close($db); // Closing Connection

?>

<title>ADD tasks - <?php echo"$email" ?></title>
</head>
<body>
<center>
<br /> <br />
<b>YOUR USER ID - <?PHP echo "$login_session" ?></b>
<br /> <br />
<h2><font color="red"><?PHP echo "$nameerror" ?></font></h2>

<br /> <br />
<form action="add.php" method="post">
Task Name <br> <input type="text" name="taskname" /> <BR><bR>
Task Description <br> <textarea name="taskdesc" rows="10" cols="30"></textarea><BR><bR>
Due Date <br> <input type="date" name="duedate" placeholder="date" /> <BR><bR>


<br><Br>
<input name="savetask" type="submit" value="SAVE TASK">
</form>

<form action="profile.php" method="post">
<input name="cancel" type="submit" value="CANCEL">
</form>

</center>


</body>
</html>