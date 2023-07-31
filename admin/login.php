<?php 
ob_start();
session_start();
if (isset($_SESSION['login']) and $_SESSION['login'] == true) {
  header("location: index.php");
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
<body class="d-flex flex-column min-vh-100">
<?php 
include_once('../includes/alert.inc.php');
include_once('../includes/conn.inc.php');
include_once('../includes/login_check.inc.php');
?>  
<div class="row align-items-center login-frame-height">
  <div class="mx-auto col-10 col-md-8 login-frame p-3 shadow-lg">
  <h4 class="text-center title">CinemaSense Admin</h4>
  <img class="login-img img-thumbnail d-block mx-auto mb-2" src="../assets/images/logo/logo.jpg"/>
  <form action="" method="POST">
    <input class="form-control mt-2" type="text" name="username" placeholder="Username or email address"/>
    <input class="form-control mt-2 mb-2" type="password" name="password" placeholder="Password"/>
    <input class="btn btn-outline-danger d-block mx-auto" type="submit" name="login" value="Login"/>
  </form>
  </div>
</div>
<?php include_once('../includes/footer.inc.php'); ?>
</body>
</html>
