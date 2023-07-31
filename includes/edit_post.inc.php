<?php
include_once('session_check.inc.php');
$cat = $_GET["category"];
$page = $_GET["page"];
if (isset($_POST["post"])) {
   $id = mysqli_real_escape_string($conn,$_POST["id"]);
   $old_image = $_POST["old_image"];
   $old_album = $_POST["old_album"];
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
      if ($image != false) {
      $ext = pathinfo($image,PATHINFO_EXTENSION);
      if (getimagesize($image_tmp) == false) {
         return false;
        } 
      if (in_array($ext,$allowed_exts)) {
         return true;  
      }
      }
   }
   function allowed_album() {
      global $allowed_exts,$album,$album_tmp;
      if ($album != false) {
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
   }
   //update all
   function update_all() {
      global $cat,$page,$id,$old_image,$old_album,$conn,$image,$image_tmp,$category,$title,$rating,$content,$album,$album_tmp;
      $name = md5(time().'_'.pathinfo($image,PATHINFO_BASENAME));
      $ext = pathinfo($image,PATHINFO_EXTENSION);
      $image = $name.".".$ext;
      move_uploaded_file($image_tmp,"../assets/images/uploads/$image");
      $images = array();
      foreach ($album as $key=>$val) {
        $img = $album[$key];
        $name = md5(time().'_'.pathinfo($img,PATHINFO_BASENAME));
        $ext = pathinfo($img,PATHINFO_EXTENSION);
        $img = $name.".".$ext;
        array_push($images,$img);
        move_uploaded_file($album_tmp[$key],"../assets/images/uploads/$img");
      }
      $serialized_album = serialize($images);
      $sql = "update posts set image='$image',category='$category',title='$title',rating='$rating',content='$content',album='$serialized_album' where id='$id'";
      if ($conn->query($sql) === TRUE) {
         unlink("../assets/images/uploads/$old_image");
         foreach (unserialize($old_album) as $val) {
            unlink("../assets/images/uploads/$val");
         }
         echo "<script>
         swal({
           text: 'Post has been updated !',
           icon: 'success',
         }).then(function(){
           window.location = 'index.php?category=$cat&page=$page';
         });
         </script>";
      } else {
        echo "<p class='text-center mt-2 alert alert-danger'>Something went wrong !</p>";
      }
   }
   //update image 
   function update_image() {
      global $cat,$page,$id,$old_image,$old_album,$conn,$image,$image_tmp,$category,$title,$rating,$content;
      $name = md5(time().'_'.pathinfo($image,PATHINFO_BASENAME));
      $ext = pathinfo($image,PATHINFO_EXTENSION);
      $image = $name.".".$ext;
      move_uploaded_file($image_tmp,"../assets/images/uploads/$image");
      $sql = "update posts set image='$image',category='$category',title='$title',rating='$rating',content='$content',album='$old_album' where id='$id'";
      if ($conn->query($sql) === TRUE) {
         unlink("../assets/images/uploads/$old_image");
         echo "<script>
         swal({
           text: 'Post has been updated !',
           icon: 'success',
         }).then(function(){
           window.location = 'index.php?category=$cat&page=$page';
         });
         </script>";
      } else {
        echo "<p class='text-center mt-2 alert alert-danger'>Something went wrong !</p>";
      }
   }   
   // update album 
   function update_album() {
      global $cat,$page,$id,$old_image,$old_album,$conn,$category,$title,$rating,$content,$album,$album_tmp;
      $images = array();
      foreach ($album as $key=>$val) {
        $img = $album[$key];
        $name = md5(time().'_'.pathinfo($img,PATHINFO_BASENAME));
        $ext = pathinfo($img,PATHINFO_EXTENSION);
        $img = $name.".".$ext;
        array_push($images,$img);
        move_uploaded_file($album_tmp[$key],"../assets/images/uploads/$img");
      }
      $serialized_album = serialize($images);
      $sql = "update posts set image='$old_image',category='$category',title='$title',rating='$rating',content='$content',album='$serialized_album' where id='$id'";
      if ($conn->query($sql) === TRUE) {
         foreach (unserialize($old_album) as $val) {
           unlink("../assets/images/uploads/$val");
         }
         echo "<script>
         swal({
           text: 'Post has been updated !',
           icon: 'success',
         }).then(function(){
           window.location = 'index.php?category=$cat&page=$page';
         });
         </script>";
      } else {
        echo "<p class='text-center mt-2 alert alert-danger'>Something went wrong !</p>";
      }
   }
   // update content
   function update_content() {
      global $cat,$page,$id,$old_image,$conn,$category,$title,$rating,$content,$old_album;
      $sql = "update posts set image='$old_image',category='$category',title='$title',rating='$rating',content='$content',album='$old_album' where id='$id'";
      if ($conn->query($sql) === TRUE) {
         echo "<script>
         swal({
           text: 'Post has been updated !',
           icon: 'success'
         }).then(function(){
           window.location = 'index.php?category=$cat&page=$page';
         });
         </script>";
      } else {
        echo "<p class='text-center mt-2 alert alert-danger'>Something went wrong !</p>";
      }
   }
   //check security
   if ($_FILES["image"]["size"] < 1000 and array_sum($_FILES["album"]["size"]) < 1000) {
      update_content();
   } elseif ($_FILES["image"]["size"] > 1000 and array_sum($_FILES["album"]["size"]) > 1000) {
      if (allowed_image() and allowed_album()) {
         update_all();
      } else {
        echo "<p class='text-center mt-2 alert alert-danger'>Upload Failed : .jpg , jpeg and png are allowed !</p>";
      }
   } elseif ($_FILES["image"]["size"] > 1000 and array_sum($_FILES["album"]["size"]) < 1000) {
      if (allowed_image()) {
          update_image();
      } else {
        echo "<p class='text-center mt-2 alert alert-danger'>Upload Failed : .jpg , jpeg and png are allowed !</p>";
      }
   } elseif ($_FILES["image"]["size"] < 1000 and array_sum($_FILES["album"]["size"]) > 1000) {
      if (allowed_album()) {
         update_album();
      } else {
        echo "<p class='text-center mt-2 alert alert-danger'>Upload Failed : .jpg , jpeg and png are allowed !</p>";
      }
   } else {
      echo "<p class='text-center mt-2 alert alert-danger'>Upload Failed : .jpg , jpeg and png are allowed !</p>";
   }
}
?>