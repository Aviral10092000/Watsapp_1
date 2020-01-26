<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";
?>
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
<body id='content_area'>

  <body id='content_area'>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="welcome.php">Settings</a>
  <a class="navbar-brand" href="see_request.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    </ul>
    <form class="form-inline my-2 my-lg-0" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <input class="form-control mr-sm-2" placeholder="Search" aria-label="Search" name="friendname" value="" style = "width: 30rem;">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search Friends</button></a>
    </form>
  </div>
</nav>
    
  <form action="uploadMessageImage.php" method="post" enctype="multipart/form-data">

        <div class="alert alert-info" role="alert">
          <center>Share Images</center>
        </div>
        <br>
        <br>
        <br>
        <br>

        <div class="input-group mb-3">
          <input type="hidden" name="chatingGuy" value="<?php echo $_POST['chatingGuy']; ?>">
        <div class="input-group">
  <div class="custom-file">
    <input type="file" class="custom-file-input" id="fileName" name='image' value="" onchange="changeLabel()">
    <label class="custom-file-label" for="inputGroupFile04" id='file_uploaded'>Choose file</label>
  </div>
</div>
        <br>
          <br>
          <br>
        

<button class="btn btn-outline-secondary" type="submit" name="submit" value="UPLOAD">Share</button>

  </form>
  
</div>

<script type="text/javascript">

function changeLabel()
{
  document.getElementById('file_uploaded').innerHTML = document.getElementById('fileName').value;
}

</script>
</body>
</html>