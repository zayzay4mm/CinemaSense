<!DOCTYPE html>
<html lang="en">
<head>
  <title> CinemaSense </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php include_once('includes/head.inc.php'); ?>
</head>
<body class="d-flex flex-column min-vh-100 mt-8">
<?php include_once('includes/conn.inc.php'); ?>  
<?php include_once('includes/header.inc.php'); ?>
<?php 
if (isset($_GET['id']) and is_numeric($_GET['id'])) {
   $id = mysqli_real_escape_string($conn,$_GET['id']);
   $sql = "select * from posts where id='$id'";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         $image = $row["image"];
         $title = htmlspecialchars($row["title"]);
         $rating = (int)$row["rating"];
         $content = htmlspecialchars($row["content"]);
         $album = unserialize($row["album"]);
         $author = $row["author"];
         $profile = $row["profile"];
      }
   }
   echo "
   <div class='container-fluid'>
   <div class='row'>
     <div class='container col-md-8 text-dark shadow-lg p-2 rounded'>
       <div class='d-flex justify-content-between align-items-center'>
         <div class='d-flex align-items-center'>
           <img class='profile' src='assets/images/profile/$profile'/> <span class='ms-3 post-author-page'>$author</span>
         </div>
         <div class=''>";
          for ($i=0; $i < 5; $i++) {
             if ($i >= $rating) {
                echo "<i class='fa-regular fa-star'></i>";
             } else {
                echo "<i class='fa-solid fa-star'></i>";
             }
          }
         echo"</div>
       </div>
       <img class='page-img mt-2 mb-2' src='assets/images/uploads/$image'/>
       <div class='p-1'>
         <h5 class='page-title ps-2'>$title</h5>
         <div class='page-content'>$content</div>
       </div>
     </div>";
   echo "<!-- carousel -->
   <div class='container-fluid col-md-8 mt-2'>
   <div class='row'>  
   <div class='carousel slide ms-auto me-auto' id='image-slide' data-bs-ride='carousel'>
      <div class='carousel-indicators'>";
         $loop = 0;
         foreach ($album as $key) {
           if ($loop > 0) {
              echo "<button type='button' data-bs-target='#image-slide' data-bs-slide-to='$loop'></button>";
           } else {
              echo "<button type='button' class='active' data-bs-target='#image-slide' data-bs-slide-to='$loop'></button>";
           }
           $loop = $loop + 1;
         }
   echo"</div>
     <div class='carousel-inner image-slide mb-2'>";
   $loop = 0;
   foreach ($album as $image) {
      $loop = $loop + 1;
      if ($loop > 1) {
         echo "<div class='carousel-item'><img class='d-block w-100' src='assets/images/uploads/$image'/></div>";
      } else {
         echo "<div class='carousel-item active'><img class='d-block w-100' src='assets/images/uploads/$image'/></div>";
      }
   }
   echo "</div>
   </div>
   </div>
   </div>";
   echo "
   <div>
   </div>";
}
?>

<?php include_once('includes/footer.inc.php'); ?>
</body>
</html>
