<?php
if (isset($_POST["register"]) and $_FILES["image"]["size"] > 1000) {
   $username = mysqli_real_escape_string($conn,$_POST["username"]);
   $full_name = mysqli_real_escape_string($conn,$_POST["full_name"]);
   $email = mysqli_real_escape_string($conn,$_POST["email"]);
   $password = md5($_POST["password"]);
   $image_name = $_FILES["image"]["name"];
   $image_tmp = $_FILES["image"]["tmp_name"];
   //alllowed extensions
   $allowed_exts = array("jpg","jpeg","png");
   //check extensions
   function allowed_image() {
      global $allowed_exts,$image_name,$image_tmp;
      $ext = pathinfo($image_name,PATHINFO_EXTENSION);
      if (getimagesize($image_tmp) == false) {
         return false;
        }
      if (in_array($ext,$allowed_exts)) {
         return true;  
      }
   }
   if (allowed_image()) {
      $ext = pathinfo($image_name,PATHINFO_EXTENSION);
      $profile = md5(time().'_'.$image_name).".$ext";
      move_uploaded_file($image_tmp,"../assets/images/profile/$profile");
      $sql = "insert into admin (email,username,password,full_name,profile,role,last_login) values ('$email','$username','$password','$full_name','$profile','admin',curdate())";
      $result = $conn->query($sql);
      if ($result === TRUE) {
         alert_redirect("Success","success","login.php");
      }
   } else {
     alert_redirect("Upload Failed : Only .jpg , jpeg and png are allowed !","error","");
   }
}
?>