<?php
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: tasks.php"); // Redirecting To Home Page
}
?>   