<?php
session_start();
setcookie('jstaskpagelogin','', time() - 3600,'/');
unset($_COOKIE['jstaskpagelogin']);
if(session_destroy()) // Destroying All Sessions
{
// set the expiration date to one hour ago
header("Location: tasks.php"); // Redirecting To Home Page
}
?>   