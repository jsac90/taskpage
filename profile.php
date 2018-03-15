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
$taskcount = mysqli_num_rows($tq);
$pastduecount = 
mysqli_num_rows(mysqli_query($db, 
"select a.*
from tasks a 
where a.userid = $login_session and
timestampdiff(DAY,sysdate(),DUEDATE)+1 <= 0 
order by isnull(duedate) asc, duedate asc"));

if ($pastduecount == 1){
	$pastduesentence = "1 TASK IS PAST DUE!";
} elseif ($pastduecount > 1) {
	$pastduesentence = "$pastduecount TASKS ARE PAST DUE!";
}

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
<h2>Welcome Back, <?php echo "$email"; ?></h2>
<br /> <br />
You currently have <b><?php echo "$taskcount"; ?></b> open tasks! <BR>
<font color="red"><b><?php if ($pastduecount > 0){echo "$pastduesentence";} ?></b></font><br><br>

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
	if (empty($row['duedate'])){
		$taskduedate = 'None!';
	} else {
		$taskduedate = $row['duedate'];
	}
	$daysuntildue = $row['diff'];
	
	if ($daysuntildue <=0 && !empty($row['duedate'])){
		$taskname = '<FONT COLOR=RED>'.$taskname.'</FONT>';
	} elseif ($daysuntildue <= 2 && $daysuntildue > 0){
		$taskname = '<FONT COLOR=ORANGE>'.$taskname.'</FONT>';
	} elseif (empty($row['duedate'])){
		$taskname = '<FONT COLOR=#06a837>'.$taskname.'</FONT>';
	}
	
	echo 
	"
	<b>$taskname</b> <br> 
	Due Date: $taskduedate <br>
	Created on $created.<Br><br>
	Days until due: $daysuntildue <br><br>
	<u>Description:</u> <br>$taskdesc<br><br>
	"; 
	
?>
<a href="edit.php?taskseqnum=<?php echo "$taskseqnum";?>"> edit this task </a> <br>
<a href="delete.php?taskseqnum=<?php echo "$taskseqnum";?>"> delete this task </a>

<?php

echo"<br><br>---------------------------------------------------------------------<br><Br>";
}

?>


</center>

<?php unset($_SESSION['lasterror']); ?>
</body>
</html>