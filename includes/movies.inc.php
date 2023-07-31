<?php
$sql = "select count(*) as count from posts";
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
echo '
<div class="d-flex mb-2 '.$display.' justify-content-between align-items-center mark-heading">
  <span class="ms-1">Recently Added</span> <a class="btn btn-sm btn-danger" href="home.php?category=All">Sell All <span class="badge rounded-pill bg-white text-dark">'.$count.'</span></a>
</div>
<!-- post -->
<div class="container-fluid">
   <div class="row">';
$sql = "select * from posts order by id desc limit $column";
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
echo "</div></div>";
?>