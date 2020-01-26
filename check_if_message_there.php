 <?php
      session_start();
      $chatingGuy = $_POST['friend'];
      require "config.php";
      $sql = "SELECT * FROM messagelist WHERE senderId='".$chatingGuy."' AND reciverId='".$_SESSION['username']."' AND status='unread'";
      $stmt = $mysqli->prepare($sql);
         $stmt->execute();
         $stmt->store_result();
      $result = $mysqli->query($sql);
      while(($row = $result->fetch_assoc()))
      {
        echo '\'<div align="left"><div class="card" style="width: 18rem;"><div align="left" class="card-body"><p class="card-text">'.$row["message"].'</p></div></div></div><br>\';';
         $sql = "UPDATE messagelist SET status='read' WHERE senderId='".$chatingGuy."' AND reciverId='".$_SESSION['username']."' AND status='unread'";
         $stmt = $mysqli->prepare($sql);
         $stmt->execute();
         $stmt->store_result();
         $stmt->close();
         $mysqli->close();
         header("Cache-Control: no-cache, no-store, must-revalidate");
         $mysqli = new mysqli("localhost","aviral","123","netapp");
      }
      
?>