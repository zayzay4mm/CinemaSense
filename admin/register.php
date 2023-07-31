<?php 
ob_start();
session_start();
if (isset($_SESSION['login']) and $_SESSION['login'] == true) {
  if ($_SESSION["role"] != "administrator") {
     exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> Blog </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php 
  include_once('../includes/head.inc.php'); 
  ?>
</head>
<body>
<?php 
include_once('../includes/alert.inc.php');
include_once('../includes/max_chars.inc.php');
include_once('../includes/conn.inc.php');
include_once('../includes/register.inc.php');
?>  
<div class="row align-items-center login-frame-height">
  <div class="mx-auto col-10 col-md-8 login-frame p-3 shadow-lg">
  <h4 class="text-center title">CinemaSense Admin Register</h4>
  <img class="login-img img-thumbnail d-block mx-auto mb-2" src="../assets/images/logo/logo.jpg"/>
  <form action="" method="POST" enctype="multipart/form-data">
    <input class="form-control mt-2" type="text" name="username" placeholder="Username" required=""/>
    <input class="form-control mt-2" type="text" name="full_name" placeholder="Full Name" required=""/>
    <input class="form-control mt-2" type="email" name="email" placeholder="Email Address" required=""/>
    <input class="form-control mt-2 mb-2" type="password" name="password" placeholder="Password" required=""/>
    <input class="form-control" type="file" name="image"/>
    <input class="btn btn-outline-danger d-block mx-auto mt-4" type="submit" name="register" value="Register"/>
  </form>
  </div>
</div>
</body>
</html>