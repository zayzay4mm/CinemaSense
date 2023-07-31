 <?php 
 if (isset($_POST["del"]) and isset($_POST["ids"]) and count($_POST["ids"]) > 0) {
    $ids = $_POST["ids"];
    $count = count($_POST["ids"]);
    function deletePosts($id) {
       global $conn,$role,$limit,$return_rows;
       if ($role == "administrator") {
          $sql = "select * from posts where id='$id'";
       } else {
          $sql = "select * from posts where username='$username' and id='$id'";
       }
       $result = $conn->query($sql);
       if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
             $image = $row["image"];
             $album = unserialize($row["album"]);
             unlink("../assets/images/uploads/$image");
             foreach ($album as $img) {
               unlink("../assets/images/uploads/$img");
             }
          }
       } else {
          exit();
       }       
       $sql = "delete from posts where id='$id'";
       $result = $conn->query($sql);
       if ($result === TRUE) {
          return true;
       } else {
          return false;
       }
    }
    $success = true;
    foreach ($ids as $id) {
       if (!deletePosts($id)) {
          $success = false;
          break;
       }
    }
    if ($success == true) {
       if ($count < $return_rows) {
          if (isset($_GET["page"])) {
             $page = $_GET["page"];
          } else {
             $page = 1;
          }
       } elseif ($count == $return_rows) {
          if (isset($_GET["page"])) {
             if ($_GET["page"] == 1) {
                $page = 1;
             } else {
                $page = (int)$_GET["page"] - 1;
             }
          } else {
             $page = 1;
          }   
       }
     alert_redirect("Success","success","index.php?page=$page");
    } else {
       alert("Something went wrong !","error","index.php?page=$page");
    }
 }
 ?>