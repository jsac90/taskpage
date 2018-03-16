<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
// set the expiration date to one hour ago
setcookie("jstaskpagelogin", "", time() - 3600);
header("Location: tasks.php"); // Redirecting To Home Page
}
?>   