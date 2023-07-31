<?php
include_once('session_check.inc.php');
// delete account
function delete_selected_account() {
   global $conn,$page,$id,$username;
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
      return true;
    } else {
      return false;
    }
}
if (isset($_POST["del"]) and isset($_POST["ids"]) and count($_POST["ids"]) > 0) {
   if ($role != "administrator") {
      exit();
   }
   $ids = $_POST["ids"];
   $count = count($_POST["ids"]);
   $success = true;
   foreach ($ids as $id) {
      if (!delete_selected_account($id)){
         $success = false;
        break;
      }
   }
   if ($success == true) {
      if ($count < $return_rows) {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
      } elseif ($count == $return_rows) {
          if (isset($_GET["page"])) {
             if ($_GET["page"] == 1) {
                $page = 1;
             } else {
                $page = (int)$_GET["page"] - 1;
             }
          } else {
             $page = 1;
          }   
       }
     alert_redirect("Success","success","manage_admin.php?page=$page");
    } else {
       alert("Something went wrong !","error","manage_admin.php?page=$page");
    }   
}
?>