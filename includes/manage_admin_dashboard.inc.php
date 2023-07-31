<?php 
include_once('session_check.inc.php');
include_once('../includes/administrator_header.inc.php');
include_once('../includes/conn.inc.php');
include_once('../includes/alert.inc.php');
include_once('../includes/time.inc.php');
include_once('../includes/person_delete.inc.php');
//select all or none 
if (empty($_SESSION["select"])) {
   $_SESSION["select"] = "None";
}
if (isset($_GET["select"])) {
   $_SESSION["select"] = $_GET["select"];
}
$select = $_SESSION["select"];
//sort
if (empty($_SESSION["sort"])) {
   $_SESSION["sort"] = "desc";
}
if (isset($_GET["sort"])) {
   $_SESSION["sort"] = $_GET["sort"];
}
if ($_SESSION["sort"] == "desc") {
   $newest = "selected";
   $oldest = "";
} else {
   $oldest = "selected";
   $newest = "";
}
$sort = $_SESSION["sort"];
//max data 
if (empty($_SESSION["column"])) {
   $_SESSION["column"] = 5;
}
if (isset($_GET["column"])) {
   $_SESSION["column"] = $_GET["column"];
}
$limit = $_SESSION["column"];
//page 
$selected_page = 1;
if (isset($_GET["page"])) {
   $page = (int)$_GET['page'];
   $selected_page = $page;
   $start = ($page - 1) * $limit;
   $page = $page + 1;
   $end = $start + $limit;
} else {
   $page = 2;
   $start = 0;
   $end = $start + $limit;
}
$previous = $page - 2;
$next = $page;
//query 
//check permission
$uid = $_SESSION["uid"];
$role = $_SESSION["role"];
$username = $_SESSION["username"];
//total
$sql = "select count(*) as total from admin";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
   while ($row = $result->fetch_assoc()) {
     $total = $row["total"];
   }
} else {
    $total = 0;
}
//max page 
if ($total > $limit) {
   $max_page = ceil($total / $limit);
} else {
   $max_page = 1;
}
//return count
$sql = "select * from admin limit 0,$end";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
   $count = $result->num_rows;
} else {
   $count = 0;
}
?>

<div class="container-fluid shadow rounded">
<h5 class="text-center mt-2 mb-2 title">Manage Admins</h5>
<div class="row" id="category">
<div class="col-md-3 d-flex justify-content-between align-items-center mb-2">
   <select id="date_sort" class="form-select" onchange="sort(this.value)">
     <option  value="desc" <?php echo $newest; ?>>Newest</option>
     <option value="asc" <?php echo $oldest; ?>>Oldest</option>
   </select>
</div>

<div class="col-md-3 d-flex justify-content-between align-items-center mb-2">
   <span class="badge bg-danger rounded-pill me-3">Max Data</span>
    <select class="form-select" onchange="column(this.value)">
    <?php
    $columns = array(5,10,20,30,40,50);
    foreach ($columns as $val) {
       if ($limit == $val) {
          echo "<option value='$val' selected>$val</option>";
       } else {
          echo "<option value='$val'>$val</option>";
       }
    }
    ?>
    </select>
</div>

<div class="col-md-3 d-flex justify-content-between align-items-center mb-2">
  <span class="badge bg-danger rounded-pill me-3">Rows</span>
    <select class="form-select" onchange="row(this.value)">
    <?php 
    for ($i=1; $i <= $max_page; $i++) {
        if ($selected_page == $i) {
           echo "<option value='$i' selected>$i</option>";
        } else {
           echo "<option value='$i'>$i</option>";
        }
    }
    ?>
    </select>
</div>

<div class="col-md-3 d-flex justify-content-between align-items-center mb-2">
  <span class="badge bg-danger rounded-pill">Select</span>
  <div class="d-flex justify-content-between align-items-center">
     <select class="form-select me-3" onchange='select(this.value);'>
       <?php
       if ($select == "None") {
          echo "
          <option>All</option>
          <option selected>None</option>";
       } else {
          echo "
          <option selected>All</option>
          <option>None</option>";
       }
       ?>
     </select>
     <i class="fa-solid fa-trash" onclick='del_items()'></i>
  </div>
</div>
<div class="d-flex justify-content-end mb-2">
<span class="badge bg-danger rounded-pill"><?php echo $count." / ".$total; ?></span>
</div>

</div>

<div class="table-responsive">
<form id="form" action="" method="POST">
<input type="hidden" name="del"/>
<table class="table table-hover table-bordered text">
<thead class="table-dark">
  <tr>
    <th>Select</th>
    <th>ID</th>
    <th>Userame</th>
    <th>Email</th>
    <th>Password</th>
    <th>Full_Name</th>
    <th>Profile</th>
    <th>last_login</th>
    <th>Action</th>
  </tr>
</thead>
<tbody id="result">
<?php 
include_once('../includes/manage_admin_table.inc.php');
?>
</tbody>
</table>
</div>
</form>
</div>
<?php 
//page jumper
echo "
  <div id='jumper' class='container-fluid mt-2 mb-2'>
  <div class='d-flex justify-content-between align-items-center'>";
  if ($count > $limit) {
    echo "<a class='btn btn-outline-secondary opacity-100' href='index.php?page=$previous'><i class='fa-solid fa-chevron-left'></i> Previous</a>";
  } else {
    echo "<div></div>";
  }
  if ($count >= $total) {
     echo "<div></div>";
  } else {
     echo "<a class='btn btn-outline-secondary opacity-100' href='index.php?page=$next'>Next <i class='fa-solid fa-chevron-right'></i></a>";
  }
echo "</div></div>";
//single delete row jumper
if ($return_rows <= 1) {
   if (isset($_GET["page"])) {
      if ($_GET["page"] == 1) {
         $page = 1;
      } else {
         $page = (int)$_GET["page"] - 1;
      }
   } else {
      $page = 1;
   }
} else {
   $page = isset($_GET["page"]) ? $_GET["page"] : 1;
}
?>
<?php 
include_once('../includes/selected_persons_delete.inc.php');
include_once('../includes/footer.inc.php');
if (isset($_GET["page"])) {
   $p = $_GET["page"];
   echo "<script>
   function select(opt) {
      window.location.href = 'manage_admin.php?select=' + opt + '&page=$p';
   }
   </script>";
} else {
   echo "<script>
   function select(opt) {
      window.location.href = 'manage_admin.php?select=' + opt;
   }
   </script>";
}
?>
<script>
function sort(opt) {
   window.location.href = "manage_admin.php?sort=" + opt;
}
function row(opt) {
   window.location.href = "manage_admin.php?page=" + opt;
}
function column(opt) {
   window.location.href = "manage_admin.php?column=" + opt;
} 

function del_items(){
 swal({
  text: 'Are you sure you want to delete selected persons?',
  icon: 'warning',
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) { 
     var form = document.querySelector("#form");
     form.submit();
  }})
};
//
function del(id){
 swal({
  text: 'Are you sure you want to delete id=' + id + ' ?',
  icon: 'warning',
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
     var page = '<?php echo $page; ?>';
     window.location.href = "manage_admin.php?page=" + page + "&delete=" + id;
  }
})
}
</script>