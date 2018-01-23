<?php

$status = '';

//koneksi ke database, username,password  dan namadatabase menyesuaikan
require 'system/connection.php';

//memanggil file excel_reader
require "vendor/excel_reader.php";

//jika tombol import ditekan
if(isset($_POST['submit'])){

    $target = basename($_FILES['file_import']['name']) ;
    move_uploaded_file($_FILES['file_import']['tmp_name'], $target);

// tambahkan baris berikut untuk mencegah error is not readable
    chmod($_FILES['file_import']['name'],0777);

    $data = new Spreadsheet_Excel_Reader($_FILES['file_import']['name'],false);

//    menghitung jumlah baris file xls
    $baris = $data->rowcount($sheet_index=0);

//    jika kosongkan data dicentang jalankan kode berikut
    $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
    if($drop == 1){
//   kosongkan tabel tbl_undian
      $truncate ="TRUNCATE TABLE tbl_undian";
      mysqli_query($connection,$truncate);
    };

//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)
    for ($i=2; $i<=$baris; $i++)
    {
//       membaca data (kolom ke-1 sd terakhir)
      $nomor   = $data->val($i, 1);
      $nama_penerima = $data->val($i, 2);

//      setelah data dibaca, masukkan ke tabel tbl_undian sql
      $query = "INSERT into tbl_undian (nomor,nama_penerima)values('$nomor','$nama_penerima')";
      $hasil = mysqli_query($connection,$query);
    }

    if(!$hasil){
//          jika import gagal
          $status = '<div class="alert alert-danger" role="alert"><b>Gagal!</b> Data gagal diimport!</div>';
      }else{
//          jika impor berhasil
          $status = '<div class="alert alert-success" role="alert"><b>Sukses!</b> Data berhasil diimport!</div>';
    }

//    hapus file xls yang udah dibaca
    unlink($_FILES['file_import']['name']);
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
    <div class="content" style="width:500px; margin:auto; margin-top:200px;">
      <div class="col-lg-12 text-center">
        <form name="myForm" id="myForm" onSubmit="return validateForm()" action="import.php" method="post" enctype="multipart/form-data">
          <div class="panel panel-default" style="background:white; padding:20px;">
            <div class="panel-heading">
              <h3 class="panel-title">Import Data Excel</h3>
            </div>
            <div class="panel-body">
              <br>
              <input class="form-control" type="file" id="file_import" name="file_import" />
              <br>
              <label style="color:black;"><input type="checkbox" name="drop" value="1" /> <b>Kosongkan tabel sql terlebih dahulu.</b></label>
            </div>
            <div class="panel-footer">
              <button name="submit" class="btn btn-primary" type="submit"><i class="fa fa-upload"></i> Import</button>
            </div>
          </div>
        </form>
        <?php echo $status; ?>
      </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>

</html>

<script type="text/javascript">
//    validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }

        if(!hasExtension('file_import', ['.xls'])){
            alert("Hanya file XLS (Excel 2003) yang diijinkan.");
            return false;
        }
    }
</script>
