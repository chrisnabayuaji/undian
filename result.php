<?php
  require_once '/system/connection.php';
  $query_result = mysqli_query($connection,"SELECT * FROM tbl_undian WHERE status='1'");
  $rows_result = mysqli_fetch_assoc($query_result);
  $total_result = mysqli_num_rows($query_result);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sistem Informasi Undian</title>
    <link rel="shortcut icon" href="img/logo.png">
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/full.css" rel="stylesheet">
  </head>
  <body>
    <!-- Navigation -->
    <?php include('system/menu.php') ?>

    <!-- Page Content -->
    <div class="content" style="width:800px; margin:auto; margin-top:100px;">
      <div class="col-lg-12 text-center">
        <h2 style="color:white">Nomor Undian Sudah Terpilih</h2>
        <br>
        <table class="table table-bordered table-striped" style="background:white">
          <thead>
            <tr>
              <td>No</td>
              <td>Nomor Undian</td>
              <td>Nama Penerima</td>
            </tr>
          </thead>
          <tbody>
            <?php if ($total_result == 0){ ?>
              <tr>
                <td colspan="3">Data tidak ada!</td>
              </tr>
            <?php }else{; ?>
              <?php $i=1; do { ?>
                <tr>
                  <td><?php echo $i++;?></td>
                  <td><?php echo $rows_result['nomor'];?></td>
                  <td><?php echo $rows_result['nama_penerima'];?></td>
                </tr>
              <?php } while ($rows_result = mysqli_fetch_assoc($query_result)); ?>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>

</html>
