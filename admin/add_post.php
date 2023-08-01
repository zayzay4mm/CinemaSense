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
include_once('../includes/alert.inc.php');
include_once('../includes/add_post_inc.php'); 
?>
<div class="container">
<form action="" method="POST" enctype="multipart/form-data">    
<div class="row p-2 mx-auto mt-2 form-frame shadow-lg">
  <h5 class="text-center title">Add Post</h5>
<div class="col-sm-12 mb-2 col-md-6">  
 <div class="d-flex justify-content-between align-items-center">
 <i class="fa-solid fa-image album-icon"></i>
 <input class="form-control album" type="file" name="image"/>
 </div>   
</div>
<div class="col-sm-12 col-md-6 mb-2">
  <select class="form-select form-select-sm" name="category">
   <option value="Action">Type</option>
   <option>Action</option>
   <option>War</option>
   <option>Comedy</option>
   <option>Drama</option>
   <option>Science Fiction (Sci-Fi)</option>
   <option>Fantasy</option>
   <option>Horror</option>
   <option>Thriller</option>   
   <option>Romance</option>
   <option>Adventure</option>      
   <option>Mystery</option>    
   <option>Crime</option>       
   <option>Animation</option>       
  </select>
</div>
 
 <div class="col-sm-12 col-md-6">
 <input class="form-control" type="text" name="title" placeholder="Title"/>
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
   <option>Rating</option>
   <option>0</option>
   <option>1</option>
   <option>2</option>
   <option>3</option>
   <option>4</option>
   <option>5</option>
  </select>
  </div>
 </div>
 <div class="col-sm-12">
  <textarea class="col-sm-12 form-control editor" type="text" name="content" placeholder="Description"></textarea> 
 </div>
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
