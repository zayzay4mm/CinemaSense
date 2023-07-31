<?php include_once('session_check.inc.php'); ?>
<div class="container">
<div class="row mx-auto form-frame shadow-lg">
  <h5 class="text-center title mt-2">Profile</h5>
  <div class="col-sm-12">
     <div class="d-flex justify-content-center align-items-end">
       <img class="img-thumbnail profile-img" src="../assets/images/profile/<?php echo $profile; ?>"/>
       <a href="profile.php?profile=image"><i class="fa-solid fa-pen image-edit profile-edit"></i></a>
     </div>
  </div>
  <div class="col-sm-12">
    <form action="" method="POST" enctype="multipart/form-data">
      <label class="form-label profile-text">Name</label>
        <div class="d-flex justify-content-center align-items-center">
          <input class="form-control me-3 profile-text" type="text" name="name" value="<?php echo $author; ?>" disabled=""/>
          <a href="profile.php?profile=name"><i class="fa-solid fa-pen profile-edit"></i></a>
        </div>     
      <label class="form-label profile-text">Username</label>
        <div class="d-flex justify-content-center align-items-center">
          <input class="form-control me-3 profile-text" type="text" name="username" value="<?php echo $username; ?>" disabled=""/>
          <a href="profile.php?profile=username"><i class="fa-solid fa-pen profile-edit"></i></a>
        </div>
      <label class="form-label profile-text">Email</label>
        <div class="d-flex justify-content-center align-items-center">
          <input class="form-control me-3 profile-text" type="text" name="email" value="<?php echo $email; ?>" disabled=""/>
          <a href="profile.php?profile=email"><i class="fa-solid fa-pen profile-edit"></i></a>
        </div>        
      <label class="form-label profile-text">Password</label>
      <div class="d-flex justify-content-center align-items-center">
         <input class="form-control me-3 profile-password" type="text" name="author" value="aaaaaaaaaaaaa" disabled=""/>
         <a href="profile.php?profile=password"><i class="fa-solid fa-pen profile-edit"></i></a>
       </div>
      <label class="form-label profile-text">User</label>
        <div class="d-flex justify-content-center align-items-center mb-4">
          <input class="form-control profile-text user-text" type="text" name="role" value="<?php echo $role; ?>" disabled=""/>
          <div class="">
          </div>
        </div>
    </form>
   <?php 
   if ($role != "administrator") {
      echo "<button class='btn btn-outline-danger d-block mx-auto mb-3' onclick='del();'>Delete Account</button>";
   }
   ?>
  </div>
</div>
</div>