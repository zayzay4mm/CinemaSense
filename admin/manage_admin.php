<?php 
include_once('session.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title> CinemaSense - Admin </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <?php 
  include_once('../includes/head.inc.php'); 
  ?>
</head>
</head>
<body class="d-flex flex-column min-vh-100 mt-8">
<?php 
$role = $_SESSION["role"];
if ($role == "administrator") {
   include_once('../includes/manage_admin_dashboard.inc.php');
} else {
  exit();
}
?>
</body>
</html>
