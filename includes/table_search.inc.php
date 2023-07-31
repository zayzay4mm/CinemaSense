<?php 
ob_start();
session_start();
$username = $_SESSION["username"];
include_once('../includes/conn.inc.php'); 
include_once('../includes/max_chars.inc.php');
if (isset($_POST["q"])) {
   $title = mysqli_real_escape_string($conn,$_POST["q"]);
   $sql = "select * from posts where title like '$title%' and username='$username' order by id desc";
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
        <td> 
          <a class='action-icon me-2' href='edit_post.php?id=$id'><i class='fa-regular fa-pen-to-square text-dark'></i></a>
          <span class='action-icon' onclick='del($id)'><i class='fa-solid fa-trash text-dark'></i></span>
        </td>
     </tr>";
   }
}
}
?>