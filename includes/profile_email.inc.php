<div class="container mt-2">
<div class="row mx-auto form-frame">
  <h5 class="text-center title mt-2">Profile</h5>
  <div class="col-sm-12">
     <div class="d-flex justify-content-center">
       <img class="img-thumbnail profile-img" src="../assets/images/profile/<?php echo $profile; ?>"/>
     </div>
  </div>
  <div class="col-sm-12">
    <form action="" method="POST" enctype="multipart/form-data">
      <label class="form-label profile-text">Email</label>
      <input class="form-control profile-text" type="text" name="email" value="<?php echo $email; ?>"/>
      <label class="form-label profile-text">Password</label>
      <input class="form-control" type="password" name="password"/>
      <input class="btn btn-outline-info d-block mx-auto mt-2 mb-2 profile-text" type="submit" name="update" value="Update"/>
    </form>
  </div>
</div>
</div>