<!-- navbar -->
<nav class="navbar navbar-expand-sm navbar-light bg-light fixed-top shadow-sm">
<div class="container-fluid">
<a href="navbar-brand" href="#">
<i class="fa-solid fa-film logo-icon"></i>
</a>
<a class="navbar-brand ms-3" href="#">CinemaSense</a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
  <span class="navbar-toggler-icon"></span>
</button>
<div id="menu" class="collapse navbar-collapse">
  <ul class="navbar-nav me-auto">
    <li class="nav-item">
      <a class="nav-link" href="index.php"><i class="fa-solid fa-house"></i> Home</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" id="menu-list" data-bs-toggle="dropdown"><i class="fa-solid fa-bars"></i> Menu</a>
      <ul class="dropdown-menu">
<?php
$menu_list = array("Action","War","Comedy", "Drama","Science Fiction (Sci-Fi)","Fantasy","Horror","Thriller","Romance","Adventure","Animation","Mystery","Crime");
$loop = 0;
foreach ($menu_list as $menu) {
   $loop = $loop + 1;
   $sql = "select count(*) as count from posts where category='$menu'";
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
   echo "<li class='$display'><a class='dropdown-item' href='home.php?category=".urlencode($menu)."'>$menu <span class='badge rounded-pill bg-danger'>$count</span></a></li>";
}
?>
      </ul>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="about_us.php"><i class="fa-solid fa-circle-info"></i> About us</a>
    </li>
  </ul>
  <form action="" class="d-flex" method="POST">
    <input class="form-control me-2" type="text" name="text" placeholder="Search here"/>
    <input class="btn btn-outline-info" type="submit" name="search" value="Search"/>
  </form>
  <?php 
  if (isset($_POST["search"])) {
     $title = $_POST["text"];
     $title = urlencode($title);
     echo "<script>window.location.href = 'search.php?q=$title';</script>";
  }
  ?>
</div>
</div>
</nav>