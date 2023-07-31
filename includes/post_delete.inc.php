<?php 
if (isset($_GET["delete"])) {
   $page = $_GET["page"];
   $id = mysqli_real_escape_string($conn,$_GET["delete"]);
   if ($role == "administrator") {
      $sql = "select * from posts where id='$id'";
   } else {
      $sql = "select * from posts where username='$username' and id='$id'";
   }
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         $image = $row["image"];
         $album = unserialize($row["album"]);
         unlink("../assets/images/uploads/$image");
         foreach ($album as $img) {
            unlink("../assets/images/uploads/$img");
         }
      }
   } else {
     exit();
   }
   $sql = "delete from posts where id='$id'";
   $result = $conn->query($sql);
   if ($result === TRUE) {
      alert_redirect("Success","success","index.php?page=$page");
   }
}
?>