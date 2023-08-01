<?php include_once('session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> CinemaSense - Admin </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php include_once('../includes/head.inc.php'); ?>
</head>
<body class="d-flex flex-column min-vh-100 mt-8">
<?php 
include_once('../includes/admin_header.inc.php');
include_once('../includes/conn.inc.php');
include_once('../includes/edit_post.inc.php');
$username = $_SESSION["username"];
if (isset($_GET["id"])) {
   $id = mysqli_real_escape_string($conn,$_GET["id"]);
   $sql = "select * from posts where username='$username' and id=$id";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         $id = $row["id"];
         $old_img = $row["image"];
         $category = $row["category"];
         $title = htmlspecialchars($row["title"]);
         $rating = $row["rating"];
         $content = htmlspecialchars($row["content"]);
         $old_alb = $row["album"];
      }
   } else {
     exit();
   }
}
?>
<div class="container">
<form action="" method="POST" enctype="multipart/form-data">    
<div class="row p-2 mx-auto mt-2 mb-2 form-frame shadow-lg">
  <h5 class="text-center title">Edit Post</h5>
<div class="col-sm-12 mb-2 col-md-12">  
 <img class="image-view img-thumbnail d-block mx-auto" src='../assets/images/uploads/<?php echo $old_img; ?> '>
</div>  
<div class="col-sm-12 mb-2 col-md-6">  
 <div class="d-flex justify-content-between align-items-center">
 <i class="fa-solid fa-image album-icon"></i>
 <input class="form-control album" type="file" name="image"/>
 </div>   
</div>
<div class="col-sm-12 col-md-6 mb-2">
  <select class="form-select form-select-sm" name="category">
    <?php 
    $categories = array("Action","War","Comedy", "Drama","Science Fiction (Sci-Fi)","Fantasy","Horror","Thriller","Romance","Adventure","Animation","Mystery","Crime");
    foreach ($categories as $cate) {
       if ($category == $cate) {
          echo "<option selected>$cate</option>";
       } else {
          echo "<option>$cate</option>";
       }
    }
    ?>
  </select>
</div>
 
 <div class="col-sm-12 col-md-6">
 <input class="form-control" type="text" name="title" placeholder="Title" value="<?php echo $title; ?>"/>
 </div>
<div class="col-sm-12 col-md-6 mt-2 mb-2">
  <div class="d-flex justify-content-between">
  <div class="">
    <i class="fa-solid fa-star"></i>
    <i class="fa-solid fa-star"></i>
    <i class="fa-solid fa-star"></i>
    <i class="fa-regular fa-star"></i>
    <i class="fa-regular fa-star"></i>
  </div>
  <select class="form-select form-select-sm rating" name="rating">
  <?php 
   $ratings = array(1,2,3,4,5);
   foreach ($ratings as $rate) {
      if ($rating == $rate) {
         echo "<option selected>$rate</option>";
      } else {
         echo "<option>$rate</option>";
      }
   }
  ?>
  </select>
  </div>
 </div>
 <div class="col-sm-12">
  <textarea class="col-sm-12 form-control editor" type="text" name="content" placeholder="Description"><?php echo $content;?></textarea> 
  <input type="hidden" name="id" value='<?php echo $id;?>'/> 
  <input type="hidden" name="old_image" value='<?php echo $old_img;?>'/> 
  <input type="hidden" name="old_album" value='<?php echo $old_alb;?>'/> 
 </div>
 <?php
   echo "<!-- carousel -->
   <div class='container-fluid col-md-6 mt-2'>
   <div class='row'>  
   <div class='carousel slide ms-auto me-auto' id='image-slide' data-bs-ride='carousel'>
      <div class='carousel-indicators'>";
         $loop = 0;
         foreach (unserialize($old_alb) as $key) {
           if ($loop > 0) {
              echo "<button type='button' data-bs-target='#image-slide' data-bs-slide-to='$loop'></button>";
           } else {
              echo "<button type='button' class='active' data-bs-target='#image-slide' data-bs-slide-to='$loop'></button>";
           }
           $loop = $loop + 1;
         }
   echo"</div>
     <div class='carousel-inner mb-2 rounded'>";
   $loop = 0;
   foreach (unserialize($old_alb) as $img) {
      $loop = $loop + 1;
      if ($loop > 1) {
         echo "<div class='carousel-item'><a href='#'><img class='d-block w-100' src='../assets/images/uploads/$img'/></a></div>";
      } else {
         echo "<div class='carousel-item active'><a href='#'><img class='d-block w-100' src='../assets/images/uploads/$img'/></a></div>";
      }
   }
   echo "</div>
   </div>
   </div>
   </div>";
?>
 <div class="d-flex mt-2 justify-content-between align-items-center">
 <i class="fa-regular fa-images album-icon"></i>
 <input class="form-control album" type="file" name="album[]" multiple/>
 </div> 
 <input type="submit" class="btn btn-outline-info mt-2" name="post" value="POST">
</div>
</form>
</div>
<?php include_once('../includes/footer.inc.php'); ?>
</body>
</html>
