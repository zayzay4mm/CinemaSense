<?php
$hostname = "127.0.0.1";
$user = "";
$password = "";
$database = "";
$conn = new mysqli($hostname,$user,$password,$database);
if ($conn->connect_error) {
   echo "Can't connect to the database!";
}
?>
