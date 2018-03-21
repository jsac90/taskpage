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
//get seqnum from the url
$edittask = $_GET['taskseqnum'];

//gets old values to plug in to form
$oldquery = mysqli_query($db,"select * from tasks where userid = $login_session and taskseqnum = $edittask");
$old_total = mysqli_fetch_assoc($oldquery); 
$oldtaskname = $old_total['taskname'];
$oldtaskdesc = $old_total['taskdesc'];
$rawoldduedate = $old_total["duedate"];

IF (EMPTY($rawoldduedate)) {
		$oldduedate = 'NULL';
	} ELSE {
		$oldduedate = date('Y-m-d',strtotime($old_total["duedate"]));
	}

//code to update values in table with new values
if (isset($_POST['updatetask']) && !EMPTY($_POST['taskname'])){
	$taskname = $_POST['taskname'];
	$taskdesc = $_POST['taskdesc'];
	$duedate = $_POST['duedate'];
	//have to pull the var from post because everything is terrible
	$edittask2 = $_POST['posttaskseqnum'];
	
	IF (EMPTY($rawoldduedate)) {
		$sqldate = 'NULL';
	} ELSE {
		$sqldate="'".date("Y-m-d H:i:s",strtotime($duedate))."'";
	}
	
	$ff = mysqli_query($db,"UPDATE tasks 
	SET taskname = '$taskname',
		taskdesc = '$taskdesc',
		lastupdt = NOW(),
		updateby = '$login_session',
		duedate = '$duedate'
	WHERE taskseqnum = $edittask2 and userid = $login_session");
	
	if($ff){
		$_SESSION['lasterror'] = "Updated task \"$taskname\".";
	}else{
		$_SESSION['lasterror'] = "UPDATE FAILED! $edittask2";
	}
	
	//$_SESSION['lasterror'] = "Updated task \"$taskname\".";
	header("location: profile.php");
} elseif (isset($_POST['updatetask']) && EMPTY($_POST['taskname'])) {
	$nameerror = "ERROR - TASK NAME MUST NOT BE NULL";
}


mysqli_close($db); // Closing Connection

?>

<title>EDIT task - <?php echo"$email" ?></title>
</head>
<body>
<center>
<br /> <br />
<b>YOUR USER ID - <?PHP echo "$login_session" ?></b>
<br /> <br />
<h2><font color="red"><?PHP echo "$nameerror" ?></font></h2>

<br /> <br />
<form action="edit.php" method="post">
Task Name <br> <input type="text" name="taskname" value="<?php echo "$oldtaskname"; ?>" /> <BR><bR>
Task Description <br> <textarea name="taskdesc" rows="10" cols="30"><?php echo "$oldtaskdesc"; ?></textarea><BR><bR>
Due Date <br> <input type="date" name="duedate" value="<?php echo "$oldduedate"; ?>"/> <BR><bR>
<input type="hidden" name="posttaskseqnum" value="<?php echo "$edittask"; ?>" />


<br><Br>
<input name="updatetask" type="submit" value="UPDATE TASK">
</form>

<form action="profile.php" method="post">
<input name="cancel" type="submit" value="CANCEL">
</form>

</center>


</body>
</html>