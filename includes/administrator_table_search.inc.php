<?php 
include_once('session_check.inc.php');
include_once('../includes/conn.inc.php'); 
include_once('../includes/time.inc.php');
include_once('../includes/max_chars.inc.php');
if (isset($_POST["q"])) {
   $title = mysqli_real_escape_string($conn,$_POST["q"]);
   $sql = "select * from posts where title like '$title%' order by id desc";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
   while ($row = $result->fetch_assoc()) {
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
      echo "<tr>
        <td><input class='form-check-input' type='checkbox'name='ids[]' value='$id' disabled>
        </td>
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
}
}
?>