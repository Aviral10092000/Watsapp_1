<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}



if(isset($_SESSION['chatingGuy']) && $_SESSION['chatingGuy']!="")
{
  $chatingGuy = $_SESSION['chatingGuy'];
}
else
{
  $chatingGuy = $_POST['chatingGuy'];
}
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
  <a href='clear.php' class="navbar-brand">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
<a class="navbar-brand" href="welcome.php">Settings</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
</nav>
	<div class="alert alert-success" role="alert">
  <center><h4 class="alert-heading"><?php echo $chatingGuy; ?></h4></center>
</div>
  	<div class="container-fluid" style="height: 520px; " id='message_area'>
      <?php
      $flag_for_read = 1;
      $sql = "SELECT created_at,senderId,reciverId,message,status,type FROM messagelist WHERE (senderId = '".$chatingGuy."' AND reciverId = '".$_SESSION['username']."') OR (senderId ='".$_SESSION['username']."' AND reciverId = '".$chatingGuy."')";
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
                  <hr>
                  </nav>
                  
                  ';
          }
            if($row['senderId']==$_SESSION['username'])
            {
              if($row['type']=='text')
              {
                echo '<div align="right"><div class="card" style="width: 18rem;">
                <div align="left" class="card-body">
                <p class="card-text">'.$row["message"].'</p>
                </div>
                </div>
                </div><br>';
              }
              else if($row['type']=='image')
              {

  

                echo '<div align="right">
                <a target="_blank" href="upload/'.$row["message"].'">
                <img width="200px" height="200px" src="upload/'.$row["message"].'">
                </a>
                </div><br>';
              }

            }
            else if($row['reciverId']==$_SESSION['username'])
            {
              if($row['type']=='text')
              {
                echo '<div align="left"><div class="card" style="width: 18rem;">
                <div align="left" class="card-body">
                <p class="card-text">'.$row["message"].'</p>
                </div>
                </div>  
                </div><br>';
              }
              else if($row['type']=='image')
              {
                echo '<div align="left">
                <img width="200px" height="200px" src="upload/'.$row["message"].'">
                </div><br>';
              }
            }

        }
        
      ?>
	</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <form id='name' method="POST" action="uploadChating.php">
          <input type="hidden" name="chatingGuy" value=<?php echo '"'; echo $chatingGuy; echo '"'; ?>>
          <button class="nav-link" type="submit">Upload<span class="sr-only">(current)</span></button>
        </form>
      </li>
  	</ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Type text here" aria-label="Search" style="width : 800px;" name='message' value='' id='message'>
      <input type="hidden" value="<?php echo $chatingGuy ?>" name="chatingGuy" id='chatingGuy'>
      <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="store_message()">Send</button>
    </form>
  </div>
</nav>
<script type="text/javascript">
  
  function check_message()
  {
    
    beginning = setInterval("alertFunc()", 3000);  
    reloadAction = setInterval("reload_action()", 1000);
    mark_as_read();
  }
  
  function store_message()
  {
    
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    }
  };
    
    var message_value = document.getElementById('message').value;
    message = "message=" + encodeURIComponent(message_value);
    chatingGuy = "chatingGuy=" + encodeURIComponent(document.getElementById('chatingGuy').value);
    message_sent = message + '&' + chatingGuy;
    xhttp.open("POST", "store_message.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(message_sent);
    var message_area = document.getElementById("message_area");
    message_area.innerHTML +='<div align="right"><div class="card" style="width: 18rem;"><div align="left" class="card-body"><p class="card-text">'+ message_value + '</p></div></div></div><br>';
    message_area.scrollTop = message_area.scrollHeight;
    return false;
  }


  function alertFunc() 
  {
    
    removeBreadcrumb = document.getElementById('removeBreadcrumb');
    if(removeBreadcrumb!=undefined)
    removeBreadcrumb.parentNode.removeChild(removeBreadcrumb);

    clearInterval(beginning);
  }
  function sound() {
  this.sound = document.createElement("audio");
  this.sound.src = "stairs.mp3";
  this.sound.setAttribute("preload", "auto");
  this.sound.setAttribute("controls", "none");
  this.sound.style.display = "none";
  document.body.appendChild(this.sound);
  this.play = function(){
    this.sound.play();
  }
  this.stop = function(){
    this.sound.pause();
  }
}
  function reload_action()
  {
    var message_area = document.getElementById("message_area");
    message_area.scrollTop = message_area.scrollHeight;
     var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) 
    {
      var length = message_area.innerHTML;
      message_area.innerHTML += this.responseText;
      if(length==message_area.innerHTML)
      {
        mySound = new sound();
      mySound.play();
      }

    }
  };
    xhttp.open("POST","check_if_message_there.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    message = "friend=" + "<?php echo $chatingGuy; ?>";
    xhttp.send(message);
    mark_as_read();
  }
  function mark_as_read()
  {
    var x = 1;
    ;<?php 
      $sql = "UPDATE messagelist SET status='read' WHERE senderId='".$chatingGuy."' AND reciverId='".$_SESSION['username']."' AND status='unread'";
      $stmt = $mysqli->prepare($sql);
      $stmt->execute();
      $stmt->store_result();
    ?>;
  }
  function getcontents()
  {
    console.log("1");
  }
  
</script>
</body>
</html>