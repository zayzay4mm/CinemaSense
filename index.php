<!DOCTYPE html>
<html lang="en">
<head>
  <title> Blog </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php include_once('includes/head.inc.php'); ?>
</head>
<body class="d-flex flex-column min-vh-100 mt-8">
<?php 
if (empty($_GET['col'])) {
   echo "<script>
var width = window.innerWidth;
if (width >= 768 ) {
  window.location.href = 'index.php?col=3';
}</script>";
}
if (isset($_GET['col'])) {
   $column = $_GET['col'];
} else {
   $column = 2;
}
?>
<?php include_once('includes/conn.inc.php'); ?>
<!-- navbar -->
<?php include_once('includes/header.inc.php'); ?>
<?php include_once('includes/max_chars.inc.php'); ?>
<?php include_once('includes/time.inc.php'); ?>
<!-- carousel -->
<div class="container-fluid">
<div class="row">  
<div class="carousel slide col-md-6 ms-auto me-auto" id="image-slide" data-bs-ride="carousel">
<div class="carousel-indicators">
  <button type="button" class="active" data-bs-target="#image-slide" data-bs-slide-to="0"></button>
  <button type="button" data-bs-target="#image-slide" data-bs-slide-to="1"></button>
  <button type="button" data-bs-target="#image-slide" data-bs-slide-to="2"></button>
  <button type="button" data-bs-target="#image-slide" data-bs-slide-to="3"></button>
  <button type="button" data-bs-target="#image-slide" data-bs-slide-to="4"></button>
</div>
<div class="carousel-inner home-image-slide">
<?php 
  $sql = "select image from posts order by id desc limit 5";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
     $loop = 0;
     while ($row = $result->fetch_assoc()) {
        $loop = $loop + 1;
        $image = $row["image"];
        if ($loop > 1) {
           echo "<div class='carousel-item'><img class='d-block w-100' src='assets/images/uploads/$image'/></div>";
        } else {
           echo "<div class='carousel-item active'><img class='d-block w-100' src='assets/images/uploads/$image'/></div>";
        }
     }
  }
?>
</div>
</div>
</div>
</div>
<div class="container-fluid mt-2">
<?php include_once('includes/movies.inc.php'); ?>  
<?php
$menu_list = array("Action","War","Comedy", "Drama","Science Fiction (Sci-Fi)","Fantasy","Horror","Thriller","Romance","Adventure","Animation","Mystery","Crime");
$loop = 0;
foreach ($menu_list as $menu) {
   $loop = $loop + 1;
   $sql = "select count(*) as count from posts where category='$menu'";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) { 
         $count = $row["count"];
      } 
   } 
   if ($count > 0) {
      $display = 'd-block';
   } else {
     $display = 'd-none';
   }
   echo '<!-- '.$menu.' -->';
   if ($loop > 1) {
      echo "<hr class='mt-1 $display'/>";
   }
   echo '<div class="d-flex mb-2 '.$display.' justify-content-between align-items-center mark-heading"><span class="ms-1">'.$menu.'</span> <a class="btn btn-sm btn-danger" href="home.php?category='.urlencode($menu).'">Sell All <span class="badge rounded-pill bg-white text-dark">'.$count.'</span></a>
    </div>
    <!-- post -->
    <div class="container-fluid">
    <div class="row">';
    $sql = "select * from posts where category='$menu' order by id desc limit $column";
     $result = $conn->query($sql);
     if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $id = $row["id"];
          $image = $row["image"];
          $type = $row["category"];
          $title = maxTitleChars(htmlspecialchars($row["title"]),50);
          $rating = (int)$row["rating"];
          $content = maxContentChars(htmlspecialchars($row["content"]),100);
          $posted_time = time() - $row["posted_time"];
          $author = $row["author"];
          $profile = $row["profile"];
     echo "
     <div class='col-6 col-md-4 p-1'>
     <div class='card shadow overflow-hidden'>
       <img class='post-img' src='assets/images/uploads/$image'/>
       <div class='card-header' style='border:none'>
       <div class='d-flex justify-content-between align-items-center'>
         <div class=''>
           <img class='author-profile' src='assets/images/profile/$profile'/><span class='ms-2 post-author'>$author</span>
         </div>
         <div class=''>";
         for ($i=0; $i < 5; $i++) {
             if ($i >= $rating) {
                echo "<i class='fa-regular fa-star post-icon'></i>";
             } else {
                echo "<i class='fa-solid fa-star post-icon'></i>";
             }
          }
         echo "</div>
       </div>
       </div>
       <div class='card-body post-details'>
         <h6 class='card-title post-title'>$title</h6>
         <div class='card-text post-content'>$content</div>
         <div class='d-flex justify-content-between align-items-center mt-1'>
           <div class='d-flex align-items-center'>
             <i class='fa-solid fa-clock'></i>  
             <span class='ms-1 post-date'>";
             echo timeAgo($posted_time);
             echo "</span>
           </div>
           <a class='btn btn-outline-danger post-link' href='page.php?id=$id'>Read More</a>
         </div>
       </div>
     </div>
     </div>";
    }
    }
    echo "
    </div>
    </div>";
}
?>
</div>
<?php include_once('includes/footer.inc.php'); ?>
</body>
</html>