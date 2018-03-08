<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
require '../../config/dbconnect.php';
// Selecting Database
session_start();// Starting Session

$loginsession = $_SESSION["login_user"];

//one perfect query to rule them all
$totaluserquery = mysqli_query($db,"
select 
a.email, a.hashpass, a.created, a.last_login
from users a
where a.id = $loginsession
;
");


$tq = mysqli_query($db, "select * from tasks a where a.userid = $loginsession");

$row_total = mysqli_fetch_assoc($totaluserquery); //gets data from query

?>