<?php
  require_once 'connection.php';
  $query_undian = mysqli_query($connection,"SELECT * FROM tbl_undian WHERE status = '0'");

  $data = array();
  $i = 0;
  foreach ($query_undian as $row) {
    $data[$i]['id'] = $row['id'];
    $data[$i]['nomor'] = $row['nomor'];
    $data[$i]['nama_penerima'] = $row['nama_penerima'];
    $data[$i]['status'] = $row['status'];
    $i++;
  }

  echo json_encode($data);
?>
