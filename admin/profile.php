<?php 
include_once('session.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> Blog </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php include_once('../includes/head.inc.php'); ?>
</head>
<body class="d-flex flex-column min-vh-100 mt-8">
<?php
$role = $_SESSION["role"];
if ($role == "administrator") {
   include_once('../includes/administrator_header.inc.php'); 
} else {
   include_once('../includes/admin_header.inc.php'); 
}
include_once('../includes/conn.inc.php');
include_once('../includes/alert.inc.php'); 
$username = $_SESSION["username"];
$email = $_SESSION["email"];
$author = $_SESSION["author"];
$profile = $_SESSION["profile"];
//data handler
include_once('../includes/profile_update.inc.php'); 
//template
if (isset($_GET["profile"]) and $_GET["profile"] != "") {
   $page = $_GET["profile"];
   if ($page == "username") {
      include_once('../includes/profile_username.inc.php'); 
   } elseif ($page == "name") {
      include_once('../includes/profile_name.inc.php'); 
   } elseif ($page == "email") {
      include_once('../includes/profile_email.inc.php'); 
   } elseif ($page == "password") {
      include_once('../includes/profile_password.inc.php'); 
   } elseif ($page == "image") {
      include_once('../includes/profile_image.inc.php'); 
   } elseif ($page == "delete") {
      include_once('../includes/profile_delete.inc.php'); 
   }
} else {
  include_once('../includes/profile.inc.php'); 
}
?>
<?php 
include_once('../includes/footer.inc.php');
?>
</body>
<script>
function del() {
swal({
  text: 'Are you sure you want to delete this account?',
  icon: 'warning',
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
     window.location.href = 'profile.php?profile=delete';
  }
})  
}
</script>
</html>