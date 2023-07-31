<?php 
include_once('../includes/max_chars.inc.php'); 
if (isset($_GET["page"])) {
   $p = $_GET["page"];
} else {
   $p = 1;
}
if (isset($_SESSION["category"])) {
   $c = $_SESSION["category"];
} else {
   $c = "All";
}
//var from admin dashboard
if ($cate == "All") {
   $sql = "select * from posts order by id $sort limit $start,$limit";
} else {
   $sql = "select * from posts where category='$cate' order by id $sort limit $start,$limit";
}
$result = $conn->query($sql);
function table($row) {
   global $c,$p,$select;
   $id = $row["id"];
   $image = $row["image"];
   $title = maxTitleChars(htmlspecialchars($row["title"]),50);
   $content = maxContentChars(htmlspecialchars($row["content"]),100);
   $category = $row["category"];
   $rating = $row["rating"];
   $album = unserialize($row["album"]);
   $album_length = count($album);
   $author = $row["author"];
   $username =  $row["username"];
   $profile = $row["profile"];
   $posted_time = time() - $row["posted_time"]; 
   $posted_on = timeAgo($posted_time);
   echo "<tr><td class='text-center'>";
   if ($select == "All") {
      echo "<input class='form-check-input' type='checkbox'name='ids[]' value='$id' checked>";
    } else {
       echo "<input class='form-check-input' type='checkbox'name='ids[]' value='$id'>";
    }
    echo "</td>
        <td>$id</td>
        <td><img class='image' src='../assets/images/uploads/$image'></td>
        <td>$title</td>
        <td>$content</td>
        <td>$category</td>
        <td>$rating</td>
        <td>$album_length</td>
        <td><img class='image' src='../assets/images/profile/$profile'></td>        
        <td>$username</td>
        <td>$author</td>
        <td>$posted_on</td>
        <td class='text-center'><span class='action-icon' onclick='del($id)'><i class='fa-solid fa-trash text-dark'></i></span>
        </td>
      </tr>";  
}
if ($result->num_rows > 0) {
   // for delete
   $return_rows = $result->num_rows;
   while ($row = $result->fetch_assoc()) {
     table($row);
   }
} else {
  $return_rows = 0;
}
?>