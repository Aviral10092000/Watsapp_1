<?php 

	session_start();
	require_once "config.php";
	
	$sql = "INSERT INTO messagelist(senderId,reciverId,message,type,status,deleted) VALUES ('".$_SESSION['username']."','".$_SESSION['chatingGuy']."','Hi!','text','unread',1)";
	$stmt = $mysqli->prepare($sql);
	$stmt->execute();
	$stmt->store_result();

echo 'Check the database';
?>
