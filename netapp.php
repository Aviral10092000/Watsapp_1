<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "config.php";
$friendname = "";
$friendname_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{

	if(isset($_POST["friendname"]))
	{
		if(empty(trim($_POST["friendname"])))
		{
			$friendname_err = "Please enter the Friend's name correctly.";
			echo '<script type="text/javascript">
					alert("'.$friendname_err.'");
					</script>' ;
		}
		else
		{
			$friendname = trim($_POST["friendname"]);
			$sql = 'SELECT * FROM users WHERE username = ?';
			if($stmt = $mysqli->prepare($sql))
			{
				$stmt->bind_param("s",$friendname);
				if($stmt->execute())
				{
					$stmt->store_result();
					if($stmt->num_rows == 1)
					{
						$_SESSION["friendname"] = trim($_POST["friendname"]);
						header('location: friend_status.php');
						exit;
						
					}
					else
					{
						$friendname_err = "Friend Not Found.";
						echo '<script type="text/javascript">
						alert("'.$friendname_err.'");
						</script>' ;
					}
				}
			}
		}
	}

	
}

$count = 0;
$sql = "SELECT senderId FROM contactlist WHERE reciverId = '".$_SESSION['username']."'";
$r = $mysqli->query($sql);
while($row = $r->fetch_assoc())
{
	$sql_request_check = "SELECT * FROM contactlist WHERE senderId='".$_SESSION['username']."' AND reciverId='".$row['senderId']."'";
	$stmt = $mysqli->prepare($sql_request_check);
  	$stmt->execute();
  	$stmt->store_result();
  	if($stmt->num_rows==0)
  	{
  		$count++;
  	}
}

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
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="welcome.php">Settings</a>
  <a class="navbar-brand" href="see_request.php">Friend Request&nbsp;<span class="badge badge-pill badge-info" id='friend_request'><?php echo $count; ?></span></a>
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
			
<?php
	$print_friend_templates = 0;
	$sql = "SELECT reciverId FROM contactlist WHERE senderId = '".$_SESSION['username']."'";
	$r = $mysqli->query($sql);
	echo '<center><table><tr>';
	while($row = $r->fetch_assoc())
	{
		foreach ($row as $key => $value) {
		$print_friend_templates++;
		echo '<td>
		<div class="card" style="width: 18rem;" onmouseleave="insertimage()">
  <img class="card-img-top" src="default_img.png" >
  <div class="card-body">
  <center>
    <h5 class="card-title">'.$value.'</h5>
    <form action="chating.php" method="POST">
    <input type="hidden" name="chatingGuy" value="'.$value.'">
    <button class="btn btn-primary">Start Chating</button>
    </form>
    </center>
  </div>
</div>';
	$flag_for_unread = 0;
	$sql = "SELECT status,senderId FROM messagelist WHERE reciverId = '".$_SESSION['username']."'";
          $result = $mysqli->query($sql);
          while($row = $result->fetch_assoc())
          {
          	if($row['status']=='unread' && $row['senderId']==$value)
          	{
          		echo '<div class="alert alert-info" role="alert">
  						New Message(s), Check It Out!.
						</div>';
						$flag_for_unread = 1;
						break;
						
          	}
          }
          if($flag_for_unread==0)
          {
          	echo '<div class="alert alert-info" role="alert">
  						No New Message(s) Currently.
						</div>';
          }
		echo '</td>';
		if($print_friend_templates%4==0)
		{
			echo '</tr><tr>';
		}
		}
	}
	echo '</tr></table>'
?>
<br>
<br>
<br>
<br>
<center><h2>Your Activities</h2></center>
<hr>
<div class="container-fluid" id='yourStuff'>
<form action='uploadImage.php' method="POST">
	<?php 
		$count = 0;
		$sql = "SELECT * FROM images WHERE username='".$_SESSION['username']."'";
		echo '</center><table><tr>';
		$r = $mysqli->query($sql);
		$cureent_date = date("m/d/Y");
		$cureent_date = strtotime($cureent_date);
		$first = 0;
		while($row = $r->fetch_assoc())
		{

			$date = $row["created"];
			$date = strtotime($date);
			$date = date("m/d/Y",$date);
			$date = strtotime($date);
			if($first==0)
			{
				$first = 1;
				$cureent_date = $date;
			
			
			echo '<td>
					<center>
					<div class="alert alert-primary" role="alert">
  							'.date("Y.m.d",$date).'
  					
					</div>
  					<div height="100px" width="100px">
  					<input type="hidden" value="'.date("m/d/Y",$date).'">
  					<img width="100px"  height="100px" src="upload\\'.$row["imageLocation"].'" ondblclick="showallimages(this)" ondragstart="get(this)" onmouseup="deleteC()">
  					</div>
  					</td>
  					</center>';	
  					$count++;
  					if($count%10==0)
  					{
  						echo '</tr><tr>';
  					}
  					
  			}
  			if($cureent_date!=$date)
  			{
  				echo '<td>
					<center>
					<div class="alert alert-primary" role="alert" value="'.$date.'">
  							'.date("Y.m.d",$date).'
					</div>
  					<div height="100px" width="100px">
  					<input type="hidden" value="'.date("m/d/Y",$date).'">
  					<img width="100px"  height="100px" src="upload\\'.$row["imageLocation"].'" ondblclick="showallimages(this)" ondragstart="get(event)" onmouseup="deleteC()">
  					</div>
  					</td>
  					</center>';	
  					$count++;
  					if($count%10==0)
  					{
  						echo '</tr><tr>';
  					}
  					$cureent_date = $date;
  			}
			
		}
		echo '</tr></table><center>'
	?>

	<input class="btn btn-primary" type="Submit" value="Add Images!">
</form>
<br>
<br>
</div>
<script type="text/javascript">
	

function showallimages(element)
{
	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) 
    {
      div = document.getElementById('yourStuff');
      console.log(this.responseText);
      div.innerHTML += this.responseText;

    }
  };
  /*
    xhttp.open("POST","ajax_info.txt", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    message = "friend=aviral"
    xhttp.send(message);
	*/
	div = element.previousElementSibling;
	value = div.value;
	//console.log(div.value);
	//console.log(value);
	message = "date=" + value;
	console.log(message);
	xhttp.open("POST","showimages.php",true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(message);
	console.log("send");
}
image_value = "";
function get(image)
{
	console.log(image);
    image_value = image.src;
    console.log(image_value);
    console.log("get");
}

function deleteC()
{
	
}
function insertimage()
{
	console.log("insert");
	var xhttp = new XMLHttpRequest();
	console.log("insert");
	value = image_value;
	console.log(value);
    xhttp.onreadystatechange = function() {
    
    if (this.readyState == 4 && this.status == 200) 
    {
      alert("Image Shared!");

    }
	}
    message = "&image=" + value;
	console.log(message);
	//xhttp.open("POST","inserttheImage.php",true);
	//xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	//xhttp.send(message);
	
}
</script>
</body>
</html>