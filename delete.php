<?php

require 'session.php';

session_start(); // Starting Session
$login_session = $_SESSION["login_user"];
$deltask = $_GET['taskseqnum'];
$getname = mysqli_fetch_assoc(mysqli_query($db,"select * from tasks where userid = $login_session and taskseqnum = $deltask"));
$delname = $getname['taskname'];

if (!isset($_SESSION['login_user']) || $_SESSION['login_user'] == ''){
header("location: tasks.php");}

$delq = mysqli_query($db,"delete from tasks where userid = $login_session and taskseqnum = $deltask");

if ($delq){
	$_SESSION['lasterror'] = "Task \"$delname\" deleted successfully";
	header("location: profile.php");
}else{
	$_SESSION['lasterror'] = "ERROR - Task \"$delname\" not deleted";
	header("location: profile.php");
}

?>