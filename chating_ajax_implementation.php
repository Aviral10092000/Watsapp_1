<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$chatingGuy = 'arvind';
require_once "config.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Chating</title>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
        div.container-fluid {
  		float:left;
		overflow-y: auto;
		height: 100px;
		}
    </style>
</head>
<body onload="check_message()">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a href='clear.php' class="navbar-brand" href="#">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<a class="navbar-brand" href="welcome.php">Settings</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</nav>
</nav>
	<div class="alert alert-success" role="alert">
  <center><h4 class="alert-heading"><?php echo $chatingGuy; ?></h4></center>
</div>
  	<div class="container-fluid" style="height: 520px; " id="message_area">
      <?php
      $flag_for_read = 1;
      $sql = "SELECT created_at,senderId,reciverId,message,status FROM messagelist WHERE (senderId = '".$chatingGuy."' AND reciverId = '".$_SESSION['username']."') OR (senderId ='".$_SESSION['username']."' AND reciverId = '".$chatingGuy."')";
          $result = $mysqli->query($sql);
          while($row = $result->fetch_assoc())
          {
          if($row['status']=='unread' && $flag_for_read == 1 && $row['senderId']!=$_SESSION['username'])
          {
            $flag_for_read = 0;
            echo '<nav aria-label="breadcrumb" id="removeBreadcrumb">
                  <ol class="breadcrumb">
                  <center><li class="breadcrumb-item active" aria-current="page">Unread Message(s)</li></center>
                  </ol>
                  </nav>
                  <hr>
                  ';
          }
            if($row['senderId']==$_SESSION['username'])
            {
              echo '<div align="right"><div class="card" style="width: 18rem;">
              <div align="left" class="card-body">
              <p class="card-text">'.$row["message"].'</p>
              </div>
              </div>
              </div><br>';
            }
            else if($row['reciverId']==$_SESSION['username'])
            {
              echo '<div align="left"><div class="card" style="width: 18rem;">
              <div align="left" class="card-body">
              <p class="card-text">'.$row["message"].'</p>
              </div>
              </div>  
              </div><br>';
            }

        }
        
      ?>
	</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="upload.php">Upload<span class="sr-only">(current)</span></a>
      </li>
  	</ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Type text here" aria-label="Search" style="width : 800px;" name='message' value='' id='message'>
      <input type="hidden" value="<?php echo $chatingGuy ?>" name="chatingGuy">
      <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="store_message()">Send</button>
    </form>
  </div>
</nav>
<script type="text/javascript">
  function store_message()
  {
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    }
  };
    xhttp.open("POST", "store_message_ajax.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var message_value = document.getElementById('message').value;
    message = "message=" + message_value;
    xhttp.send(message);
    message_area.innerHTML +='<div align="right"><div class="card" style="width: 18rem;"><div align="left" class="card-body"><p class="card-text">'+ message_value + '</p></div></div></div><br>';
    var element = document.getElementById("message_area");
    element.scrollTop = element.scrollHeight;
    return false;
  }
  function check_message
  {
    
  }
</script>
</body>
</html>
<?php 
   
?>