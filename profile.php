<html>
<head>

<link rel="stylesheet" type="text/css" href="styles/taskpage.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php 

include 'session.php';

session_start(); // Starting Session

$errormessage = $_SESSION['lasterror'];

$login_session = $_SESSION["login_user"];
$prevlogin = $_SESSION["prev_login"];
$email = $row_total['email'];
$createdate = $row_total['account_created']; 
$currentlogin = $row_total['last_login'];
$error = "";
$date = date('Y-m-d H:i:s');
$taskname = $task_total['taskname'];

if (!isset($_SESSION['login_user']) || $_SESSION['login_user'] == ''){
	header("location: tasks.php");
};

if(isset($errormessage)){
	$error = $errormessage;
}else{
	$error = "";
};


mysqli_close($db); // Closing Connection

?>

<title>Your tasks - <?php echo"$email" ?></title>
</head>
<body>
<center>
<br />
<h2><font color="red"><?php echo "$error"; ?></font></h2>
<br /> <br />
<b>Welcome Back, <?php echo "$email"; ?></b>
<br /> <br />

<form action="add.php" method="post">
<input name="add" type="submit" value="ADD A TASK">
</form>

<form action="logout.php" method="post">
<input name="logout" type="submit" value="Log Out">
</form>

<br><BR>
<?php



$rows = array();
while ($row = mysqli_fetch_array($tq)){
	$rows[] = $row;
}

foreach ($rows as $row){
	$taskname = strtoupper($row['taskname']);
	$created = $row['created'];
	$taskdesc = $row['taskdesc'];
	$taskseqnum = $row['taskseqnum'];
	echo 
	"<b>Task #$taskseqnum - $taskname</b> <br> 
	Created on $created.<Br>
	Description: $taskdesc<br><Br>
	"; 
}

$testing = $tt['taskname'];
echo "$testing"; 

?>


</center>

<?php unset($_SESSION['lasterror']); ?>
</body>
</html>