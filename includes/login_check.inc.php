<?php 
if (isset($_POST["login"])) {
   $username = mysqli_real_escape_string($conn,$_POST["username"]);
   $password = mysqli_real_escape_string($conn,md5($_POST["password"]));
   $sql = "select * from admin where username='$username' or email='$username' and password='$password'";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      $sql = "select * from admin where username='$username' or email='$username' and password='$password'";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
         $sql = "update admin set last_login=curdate() where username='$username' and password='$password'";
         $conn->query($sql);
         while ($row = $result->fetch_assoc()) {
            $uid = $row["id"];
            $username = $row["username"];
            $email = $row["email"];
            $author = $row["full_name"];
            $profile = $row["profile"];
            $role = $row["role"];
         }
      }
      $_SESSION["uid"] = $uid;
      $_SESSION["username"] = $username;
      $_SESSION["email"] = $email;
      $_SESSION["author"] = $author;
      $_SESSION["profile"] = $profile;
      $_SESSION["role"] = $role;
      $_SESSION["login"] = true;
      alert_redirect("Login Success","success","index.php");
   } else {
      alert_redirect("Incorrect Username or Password","error","login.php");
   }
}
?>