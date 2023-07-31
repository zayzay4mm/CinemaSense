<?php
// delete account
function delete_account() {
   global $conn,$page,$id;
      //check password
   $sql = "select * from admin where id='$id'";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
         $username = $row["username"];
         $profile = $row["profile"];
         unlink("../assets/images/profile/$profile");
      }
   }
   $sql = "select * from posts where username='$username'";
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
   }
   $sql = "delete from admin where username='$username'";
   $result = $conn->query($sql);
   $sql = "delete from posts where username='$username'";
   $result = $conn->query($sql);
   if ($result === TRUE) {
      alert_redirect("Success","success","manage_admin.php?page=$page");
    }
}
if (isset($_GET["delete"])) {
   if ($role != "administrator") {
      exit();
   }  
   $page = $_GET["page"];
   $id = $_GET["delete"];
   delete_account();
}
?>