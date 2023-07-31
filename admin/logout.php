<?php
ob_start();
session_start();
unset($_SESSION["author"]);
unset($_SESSION["profile"]);
unset($_SESSION["role"]);
unset($_SESSION["login"]);
header("location: login.php");
?>