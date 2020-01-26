<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";

$count = 0;
$sql = "SELECT senderId FROM contactlist WHERE reciverId = '".$_SESSION['username']."'";

echo '
<!DOCTYPE html>
<html>
<head>
	<title>Whatsaap</title>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body id="content_area">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="welcome.php">Settings</a>
  <a class="navbar-brand" href="netapp.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  </nav>
';
$flag = 0;
$r = $mysqli->query($sql);
echo '<table><tr>';
while($row = $r->fetch_assoc())
{
  
	$sql_request_check = "SELECT * FROM contactlist WHERE senderId='".$_SESSION['username']."' AND reciverId='".$row['senderId']."'";
	$stmt = $mysqli->prepare($sql_request_check);
  	$stmt->execute();
  	$stmt->store_result();
  	if($stmt->num_rows==0)
  	{
      $flag = 1;
  		echo '<td><div class="card" style="width: 18rem; margin : 10px;">
  		<img class="card-img-top" src="default_img.png">
  		<div class="card-body">
    	<h5 class="card-title">'.$row['senderId'].'</h5>
    	<form action="accept_decline.php" method="POST">
    	<button class="btn btn-primary" type="submit" name="'.$row['senderId'].'" value="accept">Accept</button>
    	<button class="btn btn-primary" type="submit" name="'.$row['senderId'].'" value="decline">Decline</button>
    	</form>
  		</div>
	``	</div></td>';
  		$count++;
  		if($count%4==0)
  		{
  			echo '</tr><tr>';
  		}
  	}
}
if($flag==1)
echo '</tr></table>';
else
{
  echo '<div class="alert alert-light" role="alert">
  <center>
      No Friend Request Currently
  </center>
</div>';
}



?>