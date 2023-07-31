<?php
include_once('session_check.inc.php');
if (isset($_POST["post"]) and $_FILES["image"]["size"] > 100) {
   $image = $_FILES["image"]["name"];
   $image_tmp = $_FILES["image"]["tmp_name"];
   $category = $_POST["category"];
   $title = mysqli_real_escape_string($conn,($_POST["title"]));
   $rating = $_POST["rating"];
   $content = mysqli_real_escape_string($conn,($_POST["content"]));
   $album = $_FILES["album"]["name"];
   $album_tmp = $_FILES["album"]["tmp_name"];
   $images = array();
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
   function allowed_album() {
      global $allowed_exts,$album,$album_tmp;
      $allowed = true;
      foreach ($album as $key=>$val) {
        //single image 
        $img = $album[$key];
        $ext = pathinfo($img,PATHINFO_EXTENSION);
        if (getimagesize($album_tmp[$key]) == false) {
           $allowed = false;
           break;
        }
        if (!in_array($ext,$allowed_exts)) {
           $allowed = false;
           break;
        }
      }
      if ($allowed == true) {
         return true;
      } else {
         return false;
      }
   }
   //post 
   function post() {
      global $conn,$image,$image_tmp,$category,$title,$rating,$content,$album,$album_tmp;
      $name = md5(uniqid().'_'.pathinfo($image,PATHINFO_BASENAME));
      $ext = pathinfo($image,PATHINFO_EXTENSION);
      $image = $name.".".$ext;
      move_uploaded_file($image_tmp,"../assets/images/uploads/$image");
      $images = array();
      foreach ($album as $key=>$val) {
        $img = $album[$key];
        $name = md5(uniqid().'_'.pathinfo($img,PATHINFO_BASENAME));
        $ext = pathinfo($img,PATHINFO_EXTENSION);
        $img = $name.".".$ext;
        array_push($images,$img);
        move_uploaded_file($album_tmp[$key],"../assets/images/uploads/$img");
      }
      $serialized_album = serialize($images);
      //user info 
      $username = $_SESSION["username"];
      $author = $_SESSION["author"];
      $profile = $_SESSION["profile"];
      $posted_time = time();
      $sql = "insert into posts (image,category,title,rating,content,album,username,author,profile,posted_time) values ('$image','$category','$title','$rating','$content','$serialized_album','$username','$author','$profile',$posted_time)";
      if ($conn->query($sql) === TRUE) {
         #echo "<p class='text-center mt-2 alert alert-success'> Post has been added !</p>";
         alert("Post has been added !","success");
      } else {
        #echo "<p class='text-center mt-2 alert alert-danger'>Something went wrong !</p>";
        alert("Something went wrong !","error");
      }
   }
   //check security
   if (allowed_image() and allowed_album()) {
      post();
   } else {
     echo "<p class='text-center mt-2 alert alert-danger'>Upload Failed : .jpg , jpeg and png are allowed !</p>";
   }
}
?>