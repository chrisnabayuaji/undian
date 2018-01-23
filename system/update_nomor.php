<?php
  require_once 'connection.php';
  $id = $_POST['id'];
  $ids = explode(',', $id);

  for ($i=0; $i < sizeof($ids) ; $i++) {
    $query_undian = mysqli_query($connection,"UPDATE tbl_undian SET status='1' WHERE id='$ids[$i]'");
  }
?>
