<?php 

session_start();
$_SESSION['username'] = 'aviral';
$_SESSION['chatingGuy'] = 'arvind';

?>

<!DOCTYPE html>
<html>
<body>

<div id="demo">
<h1>The XMLHttpRequest Object</h1>
<button type="button" onclick="loadDoc()">Change Content</button>
</div>

<script>

function loadDoc() {
  var xhttp = new XMLHttpRequest();
  
  xhttp.open("GET", "ajax_info.php", true);
  xhttp.send();
}



</script>
</body>
</html>
