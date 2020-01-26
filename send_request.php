<?php
  session_start();
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
  }
  require_once "config.php";
  $sql = "INSERT INTO contactlist (senderId,reciverId) VALUES (?,?)";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("ss",$param_senderId,$param_reciverId);

  $param_senderId = $_SESSION["username"];
  $param_reciverId = $_SESSION["friendname"];
  echo $param_senderId;
  echo $param_reciverId;
  $stmt->execute();
  $stmt->store_result();
  header("location: friend_status.php");
  exit();
?>