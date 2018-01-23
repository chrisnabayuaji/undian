<?php
  require_once 'connection.php';
  $row_count = $_POST['row_count'];
  $query_undian = mysqli_query($connection,"UPDATE tbl_setting SET row_count = '$row_count'");

  header('Location: ../index.php');
?>
