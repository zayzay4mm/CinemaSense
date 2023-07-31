<?php
include_once('session_check.inc.php');
if (isset($_POST["update"])) {
   function update_username() {
      global $conn,$email,$username,$new_username,$password;
      //check password
      // uid come from session variable
      $sql = "select * from admin where email='$email' and password='$password'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
         //check username already exits or not
         $sql = "select * from admin where username='$new_username'";
         $result = $conn->query($sql);
         if ($result->num_rows == 0) {
            //update username
            $sql = "update admin set username='$new_username' where username='$username' and password='$password'";
            $result = $conn->query($sql);
            if ($result === TRUE) {
               $_SESSION["username"] = $new_username;
               alert_redirect("Success","success","profile.php");
            }
            //update posts' username 
            $sql = "update posts set username='$new_username' where username='$username'";
            $result = $conn->query($sql);
         } else {
            alert_redirect("Username already exits","error","profile.php?profile=username");
         }
      } else {
         alert_redirect("Incorrect Password","error","profile.php?profile=username");
      }
   }
   //update email
   function update_email() {
      global $conn,$email,$username,$password;
      //check password
      // uid come from session variable
      $sql = "select * from admin where username='$username' and password='$password'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
         //check username already exits or not
         $sql = "select * from admin where email='$email'";
         $result = $conn->query($sql);
         if ($result->num_rows == 0) {
            //update username
            $sql = "update admin set email='$email' where username='$username'";
            $result = $conn->query($sql);
            if ($result === TRUE) {
               $_SESSION["email"] = $email;
               alert_redirect("Success","success","profile.php");
            }
         } else {
            alert_redirect("Email already exits","error","profile.php?profile=email");
         }
      } else {
         alert_redirect("Incorrect Password","error","profile.php?profile=email");
      }
   }   
   function update_password() {
      global $conn,$username,$old_password,$new_password;
      //check password
      $sql = "select * from admin where username='$username' and password='$old_password'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
         //update password
         $sql = "update admin set password='$new_password' where username='$username' and password='$old_password'";
            $result = $conn->query($sql);
         if ($result === TRUE) {
            alert_redirect("Success","success","profile.php");
          }
      } else {
         alert_redirect("Incorrect Password","error","profile.php?profile=password");
      }
   }   
   // update name
   function update_name() {
      global $conn,$username,$name,$password;
      //check password
      $sql = "select * from admin where username='$username' and password='$password'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
         //update name
         $sql = "update admin set full_name='$name' where username='$username' and password='$password'";
            $result = $conn->query($sql);
         if ($result === TRUE) {
            $_SESSION["author"] = $name;
            alert_redirect("Success","success","profile.php");
          }
         $sql = "update posts set author='$name' where username='$username'";
         $result = $conn->query($sql);
      } else {
         alert_redirect("Incorrect Password","error","profile.php?profile=name");
      }
   }     
   // update image
   function update_image() {
      global $conn,$username,$image_name,$image_tmp,$profile,$password;
      //check password
      $sql = "select * from admin where username='$username' and password='$password'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
         move_uploaded_file($image_tmp,"../assets/images/profile/$image_name");
         unlink("../assets/images/profile/$profile");
         //update name
         $sql = "update admin set profile='$image_name' where username='$username' and password='$password'";
            $result = $conn->query($sql);
         if ($result === TRUE) {
            $_SESSION["profile"] = $image_name;
            alert_redirect("Success","success","profile.php");
          }
         $sql = "update posts set profile='$image_name' where username='$username'";
         $result = $conn->query($sql);
      } else {
         alert_redirect("Incorrect Password","error","profile.php?profile=image");
      }
   }
   // delete account
   function delete_account() {
      global $conn,$profile,$username,$name,$password;
      //check password
      $sql = "select * from admin where username='$username' and password='$password'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
         //delete all posts  of the user
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
         $sql = "delete from posts where username='$username'";
         $result = $conn->query($sql);
         unlink("../assets/images/profile/$profile");
         $sql = "delete from admin where username='$username'";
          $result = $conn->query($sql);
          if ($result === TRUE) {
             unset($_SESSION["login"]);
             alert_redirect("Success","success","login.php");
          }
      } else {
         alert_redirect("Incorrect Password","error","profile.php?profile=delete");
      }
   }        
   //alllowed extensions
   $allowed_exts = array("jpg","jpeg","png","gif");
   //check extensions
   function allowed_image() {
      global $allowed_exts,$image,$image_tmp;
      $ext = pathinfo($image,PATHINFO_EXTENSION);
      if (getimagesize($image_tmp) == false) {
         return false;
        }
      if (in_array($ext,$allowed_exts)) {
         return true;  
      }
   }   
   if (isset($_POST["username"]) and isset($_POST["password"])) {
      $new_username = mysqli_real_escape_string($conn,$_POST["username"]);
      $password = md5(mysqli_real_escape_string($conn,$_POST["password"]));
       update_username();
   } elseif (isset($_POST["new_password"]) and isset($_POST["old_password"])) {
      $new_password = md5(mysqli_real_escape_string($conn,$_POST["new_password"]));
      $old_password = md5(mysqli_real_escape_string($conn,$_POST["old_password"]));
       update_password();
   } elseif (isset($_POST["email"]) and isset($_POST["password"])) {
      $email = mysqli_real_escape_string($conn,$_POST["email"]);
      $password = md5(mysqli_real_escape_string($conn,$_POST["password"]));
       update_email();
   } elseif (isset($_POST["name"]) and isset($_POST["password"])) {
      $name = mysqli_real_escape_string($conn,$_POST["name"]);
      $password = md5(mysqli_real_escape_string($conn,$_POST["password"]));
       update_name();
   } elseif (isset($_FILES["file"]) and $_FILES["file"]["size"] > 1000 and isset($_POST["password"])) {
      $image = $_FILES["file"]["name"];
      $image_name = md5(time().'_'.pathinfo($image,PATHINFO_BASENAME)).'.jpg';
      $image_tmp = $_FILES["file"]["tmp_name"];
      $password = md5(mysqli_real_escape_string($conn,$_POST["password"]));
      if (allowed_image()) {
          update_image();
      } else {
          alert_redirect("Upload Failed : .jpg , jpeg and png are allowed !","error","profile.php?profile=image");
      }
   } elseif (isset($_POST["account_delete"]) and isset($_POST["password"])) {
      $password = md5(mysqli_real_escape_string($conn,$_POST["password"]));
       if ($role != "administrator") {
          delete_account();
       }
   }
}
?>