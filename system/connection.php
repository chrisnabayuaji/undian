<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "undian_db";

  $connection = mysqli_connect($servername,$username,$password);
  mysqli_select_db($connection,$database);
?>
