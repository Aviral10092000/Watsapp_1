<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
require_once "config.php";



$sql = "UPDATE messagelist SET status='read' WHERE reciverId = ? AND senderId = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss",$param_status_reciverId,$param_status_senderId);
$param_status_reciverId = 'aviral';
$param_status_senderId = 'arvind';
$stmt->execute();
$stmt->store_result();
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	echo 'POSTED';
	$sql = "INSERT INTO messagelist(senderId,reciverId,message,type,status,deleted) VALUES (?,?,?,?,?,?)";
	$stmt = $mysqli->prepare($sql);
	$stmt->bind_param("sssssi",$param_senderId,$param_reciverId,$param_message,$param_type,$param_status,$param_deleted);
	$param_senderId = 'aviral';
	$param_reciverId = 'arvind';
	$param_message = $_POST['message'];
	$param_type = 'text';
	$param_status = 'unread';
	$param_deleted = 1;
	$stmt->execute();
	$stmt->store_result();
	//$_SESSION['chatingGuy'] = $_POST['chatingGuy']; 
}



?>