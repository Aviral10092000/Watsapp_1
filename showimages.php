<?php 


// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$count = 0;

header("Cache-Control: no-cache, no-store, must-revalidate");
require_once "config.php";



	$message = '<div id="imagearea" onmouseleave="deletethisdiv()"><table><tr>';
	$sql = "SELECT * FROM images WHERE username='".$_SESSION['username']."'";
	$r = $mysqli->query($sql);
	while($row = $r->fetch_assoc())
	{
		$date = date('m/d/Y',strtotime($row['created']));
		//echo $date;
		$date = strtotime($date);
		//echo $date;
		//echo $_POST['date'];
		
		$date_compare = date('m/d/Y',strtotime($_POST['date'])); 
		$date_compare = strtotime($date_compare);
		//echo $date_compare;
		if($date_compare==$date)
		{
			$message .= '<td>
  					<div height="100px" width="100px">
  					<img width="100px"  height="100px" src="upload\\'.$row["imageLocation"].'">
  					</div>
  					</td>';	
  					$count++;
  					if($count%10==0)
  					{
  						$message .=  '</tr><tr>';
  					}
			
			continue;
		}
		break;
	}
	header("Cache-Control: no-cache, no-store, must-revalidate");
	$message = $message.'</tr></table></div>';
	echo $message;




	//echo $_POST['date'];
?>