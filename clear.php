<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

if(isset($_SESSION['chatingGuy']))
{
	$_SESSION['chatingGuy'] = "";
}

header("location: netapp.php");

?>