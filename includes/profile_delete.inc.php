<?php include_once('session_check.inc.php'); ?>
<div class="container mt-2">
<div class="row mx-auto form-frame">
  <h5 class="text-center title mt-2">Profile</h5>
  <div class="col-sm-12">
     <div class="d-flex justify-content-center">
       <img class="img-thumbnail profile-img" src="../assets/images/profile/<?php echo $profile; ?>"/>
     </div>
  </div>
  <div class="col-sm-12">
    <form action="" method="POST">
      <div>
        <p><span class="badge bg-danger">NOTICE!</span> <span class="text">If you delete this account,you'll lose all your data including all the posts you've been uploaded.Make sure your decision !</span></p>
      </div>
      <label class="form-label profile-text">Password</label>
      <input class="form-control" type="hidden" name="account_delete"/>
      <input class="form-control" type="password" name="password"/>
      <input class="btn btn-outline-danger d-block mx-auto mt-2 mb-2 profile-text" type="submit" name="update" value="Delete"/>
    </form>
  </div>
</div>
</div>