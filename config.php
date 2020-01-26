<?php
	clearstatcache();

$mysqli = new mysqli("localhost","aviral","123","netapp");

if($mysqli === false)
{
	die("ERROR CONNECTING TO MySQL".$mysqli->connect_error);
}

?>