<!-- navbar -->
<?php include_once('session_check.inc.php'); ?>
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
      <a class="nav-link" href="index.php"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="add_post.php"><i class="fa-solid fa-pen-to-square"></i> Add Post</a>
    </li>
   </ul>
   <hr/>
   <ul class="navbar-nav">
   <li class="nav-item">
    <div class="d-flex justify-content-between align-items-center">
      <?php
        $profile = $_SESSION["profile"];
        $author = $_SESSION["author"];
      ?>
      <div class="d-flex align-items-center">
        <a class="text-decoration-none" href='profile.php'>
        <img class='profile img-thumbnail' src='../assets/images/profile/<?php echo $profile; ?>'/>
        <span class="ms-2 text-dark text"><?php echo $author; ?></span>
        </a>
      </div>
      <a class="nav-link" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
    </li>
  </ul>
</div>
</div>
</nav>