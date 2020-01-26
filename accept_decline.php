<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true))
{
    header("location: netapp.php");
    exit;
}

require_once "config.php";

if($_SERVER["REQUEST_METHOD"]=="POST")
{
	foreach($_POST as $key=>$value){
    {
    	if($value=='accept')
    	{
    		$sql = "INSERT INTO contactlist(senderId,reciverId) VALUES(?,?)";
    		$stmt = $mysqli->prepare($sql);
    		$stmt->bind_param("ss",$param_senderId,$param_reciverId);
    		$param_senderId = $_SESSION['username'];
    		$param_reciverId = $key;
    		$stmt->execute();
    		$stmt->store_result();

    	}
    	else
    	{
    		$sql = "DELETE FROM contactlist WHERE senderId=? AND reciverId=?";
    		$stmt = $mysqli->prepare($sql);
    		$stmt->bind_param("ss",$param_senderId,$param_reciverId);
    		$param_reciverId = $_SESSION['username'];
    		$param_senderId = $key;
    		$stmt->execute();
    		$stmt->store_result();
    	}
    }
}

header("location: see_request.php");
}

?>