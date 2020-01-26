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
if($_SESSION['username']==$_SESSION['friendname'])
{
  
  echo '<!DOCTYPE html>
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
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Settings</a>
  <a class="navbar-brand" href="#">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    </ul>
  </div>
</nav>
  <center id="card_area">
    <div class="card" style="width: 18rem; margin : 10px;">
      <img class="card-img-top" src="default_img.png">
      <div class="card-body">
      
      <h5 class="card-title">'.$_SESSION["friendname"].'</h5>
      </div>
  ``  </div>
  </center>

</body>
</html>';

}

else
{
  $sql = "SELECT * FROM contactlist WHERE senderId = ? AND reciverId = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("ss",$param_senderId,$param_reciverId);
  $param_senderId = $_SESSION['username'];
  $param_reciverId = $_SESSION['friendname'];
  $stmt->execute();
  $stmt->store_result();
  if($stmt->num_rows==1)
  {
    $sql = "SELECT * FROM contactlist WHERE senderId = ? AND reciverId = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss",$param_senderId,$param_reciverId);
    $param_senderId = $_SESSION['friendname'];
    $param_reciverId = $_SESSION['username'];
    $stmt->execute();
    $stmt->store_result();
    if($stmt->num_rows==0)
    {
      echo '<!DOCTYPE html>
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
    <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Settings</a>
      <a class="navbar-brand" href="netapp.php">Home</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>


      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        </ul>
      </div>
    </nav>
      <center id="card_area">
        <div class="card" style="width: 18rem; margin : 10px;">
          <img class="card-img-top" src="default_img.png">
          <div class="card-body">
          
          <h5 class="card-title">'.$_SESSION["friendname"].'</h5>
          <a href="#"><button class="btn btn-primary" type="button" disabled>Friend Request Sent</button></a>
          
          </div>
      ``  </div>
      </center>

      </body>
      </html>';
    }
  else
  {
    
  echo '<!DOCTYPE html>
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
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Settings</a>
    <a class="navbar-brand" href="#">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      </ul>
    </div>
  </nav>
    <center id="card_area">
      <div class="card" style="width: 18rem; margin : 10px;">
        <img class="card-img-top" src="default_img.png">
        <div class="card-body">
        
        <h5 class="card-title">'.$_SESSION["friendname"].'</h5>
        <a href="#"><button class="btn btn-primary" type="button" disabled>Friend</button></a>
        
        </div>
    ``  </div>
    </center>

    </body>
    </html>';    
    }
  }
  else
  {
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
  <body>
  	<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Settings</a>
    <a class="navbar-brand" href="#">Home</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>


    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
      </ul>
    </div>
  </nav>
  	<center id="card_area">
  		<div class="card" style="width: 18rem; margin : 10px;">
    		<img class="card-img-top" src="default_img.png">
    		<div class="card-body">
    		
      	<h5 class="card-title">'.$_SESSION["friendname"].'</h5>
        <form action="send_request.php" method="post">
      	<button class="btn btn-primary" type="submit">Send Friend Request</button>
      	</form>
    		</div>
  	``	</div>
  	</center>

  </body>
  </html>
  ';
  
  }
}
?>