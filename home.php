<?php 
ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> CinemaSense - Home </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php include_once('includes/head.inc.php'); ?>
</head>
<body class="d-flex flex-column min-vh-100 mt-8">
<?php include_once('includes/conn.inc.php'); ?>  
<?php include_once('includes/header.inc.php'); ?>
<?php include_once('includes/max_chars.inc.php'); ?>
<?php include_once('includes/time.inc.php'); ?>
<?php 
$limit = 12;
if (isset($_GET["page"])) {
   $page = (int)$_GET['page'];
   $start = ($page - 1) * $limit;
   $page = $page + 1;
   $end = $start + $limit;
} else {
   $page = 2;
   $start = 0;
   $end = $start + $limit;
}
$previous = $page - 2;
$next = $page;
if (isset($_GET['category'])) {
   $category = urldecode($_GET['category']);
   $category = mysqli_real_escape_string($conn,$_GET['category']);
   //total
   if ($category == "All") {
      $sql = "select count(*) as total from posts";
   } else {
      $sql = "select count(*) as total from posts where category='$category'";
   }
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         $total = $row["total"];
      }
   }
   //return count
   if ($category == "All") {
      $sql = "select * from posts limit 0,$end";
   } else {
      $sql = "select * from posts where category='$category' limit 0,$end";
   }
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      $count = $result->num_rows;
   }
   echo "
   <div class='container-fluid'>
   <div class='d-flex justify-content-between align-items-center mark-heading'>
      <span class='ms-1'> $category </span><span class='badge rounded-pill bg-danger text-white'>$count / $total</span>
   </div>

   <div class='container-fluid mb-2'>
   <div class='row'>";
    if ($category == "All") {
       $sql = "select * from posts order by id desc limit $start,$limit";
    } else {
       $sql = "select * from posts where category='$category' order by id desc limit $start,$limit";
    }
     $result = $conn->query($sql);
     if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $id = $row["id"];
          $image = $row["image"];
          $type = $row["category"];
          $title = maxTitleChars(htmlspecialchars($row["title"]),50);
          $rating = (int)$row["rating"];
          $content = maxContentChars(htmlspecialchars($row["content"]),100);
          $author = $row["author"];
          $profile = $row["profile"];
          $posted_time = time() - $row["posted_time"];
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
 echo "</div></div></div>";
}
$category = urlencode($category);
//page jumper
echo "
  <div class='container-fluid mb-2'>
  <div class='d-flex justify-content-between align-items-center'>";
  if ($count > $limit) {
    echo "<a class='btn btn-outline-secondary opacity-100' href='home.php?category=$category&page=$previous'><i class='fa-solid fa-chevron-left'></i> Previous</a>";
  } else {
    echo "<div></div>";
  }
  if ($count >= $total) {
     echo "<div></div>";
  } else {
     echo "<a class='btn btn-outline-secondary opacity-100' href='home.php?category=$category&page=$next'>Next <i class='fa-solid fa-chevron-right'></i></a>";
  }
echo "</div></div>";
?>
<?php include_once('includes/footer.inc.php'); ?>
</body>
</html>
