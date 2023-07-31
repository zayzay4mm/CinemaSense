<?php 
ob_start();
session_start();
if (!isset($_SESSION["login"])) {
   header("location: login.php");
   exit();
}
?>