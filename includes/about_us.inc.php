<div class='container-fluid'>
  <h5>About CinemaSense</h5>
  <p>Welcome to CinemaSense, where we are dedicated to sharing our passion for movies with the world. Our team of movie enthusiasts is committed to providing you with honest and insightful reviews that cover various genres and cinematic experiences.</p>
  <p>At CinemaSense, we believe that films have the power to inspire, entertain, and provoke thought. Our mission is to celebrate the art of storytelling and foster a community of movie lovers who appreciate the magic of cinema.</p>
  <p>Contact us at help@cinemasense.com</p>
  <h5>Meet the Team</h5>
  <div class='container-fluid'>
  <div class='row'>
<?php
$sql = "select * from admin";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
   while ($row = $result->fetch_assoc()) {
      $username = $row["username"];
      $email = $row["email"];
      $full_name = $row["full_name"];
      $profile = $row["profile"];
      $role = $row["role"];
      if ($role == "administrator") {
         $role = "Admin";
      } else {
         $role = "Content Writer";
      }
      echo "
      <div class='col-6 col-md-3 p-1'>
      <div class='card overflow-hidden shadow-lg'>
         <img class='team-profile' src='../assets/images/profile/$profile' class='img-top'/>
         <div class='card-body text-center'>
            <h5 class='card-title'>$full_name</h5>
            <p class='card-text'>$role</p>
         </div>
      </div>
      </div>
      ";
   }
}
?>
  </div>
  </div>
</div>