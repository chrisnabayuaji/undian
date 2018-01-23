<?php
  require_once '/system/connection.php';
  $query_count = mysqli_query($connection,"SELECT * FROM tbl_setting");

  $data = array();
  $i = 0;
  foreach ($query_count as $row) {
    $row_count = $row['row_count'];
    $i++;
  }
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
    <div class="content" style="width:300px; margin:auto; margin-top:250px;">
      <div class="col-lg-12 text-center">
        <form class="" action="system/setting_save.php" method="post">
          <div class="form-group" >
            <label>Total Row</label>
            <input class="form-control" type="number" name="row_count" value="<?=$row_count?>" required>
            <br>
            <button id="start" class="btn btn-lg btn-success" type="submit" name="button"><i class="fa fa-save"></i> Save</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>

</html>
