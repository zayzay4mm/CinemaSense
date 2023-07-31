<?php 
include_once('session_check.inc.php');
include_once('../includes/max_chars.inc.php'); 
if (isset($_GET["page"])) {
   $p = $_GET["page"];
} else {
   $p = 1;
}
//var from admin dashboard
$sql = "select * from admin order by id $sort limit $start,$limit";
$result = $conn->query($sql);
function table($row) {
   global $p,$select;
   $id = $row["id"];
   $username = $row["username"];
   $email = $row["email"];
   $password = $row["password"];
   $full_name = $row["full_name"];
   $profile = $row["profile"];
   $role = $row["role"];
   $last_login = $row["last_login"];
   echo "<tr><td class='text-center'>";
   if ($select == "All") {
      if ($role == "administrator") {
         echo "<i class='fa-solid fa-user-lock'></i>";
      } else {
         echo "<input class='form-check-input' type='checkbox'name='ids[]' value='$id' checked>";
      }
    } else {
       if ($role == "administrator"){
          echo "<i class='fa-solid fa-user-lock'></i>";
       } else {
          echo "<input class='form-check-input' type='checkbox'name='ids[]' value='$id'>";
       }
    }
    echo "</td>
        <td>$id</td>
        <td>$username</td>
        <td>$email</td>
        <td>$password</td>
        <td>$full_name</td>
        <td><img class='image' src='../assets/images/profile/$profile'></td>       
        <td>$last_login</td>
        <td class='text-center'>";
    if ($role != "administrator"){
        echo "<span class='action-icon' onclick='del($id)'><i class='fa-solid fa-trash text-dark'></i></span>";
    }
    echo "</td></tr>";  
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