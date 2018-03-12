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
    <div class="content">
      <div class="col-lg-12 text-center">
        <div id="info">CLICK START TO BEGIN</div>
        <div id="nomor">
          <?php for ($i=0; $i < $row_count; $i++) {
            echo '<h3 id="row_'.$i.'">--</h3>';
            echo '<input id="id_'.$i.'" type="hidden">';
          } ?>
        </div>
        <input id="id" type="hidden">
        <div id="button">
          <button id="start" class="btn btn-lg btn-success" type="button" name="button"><i class="fa fa-play"></i> Start</button>
          <button id="stop" class="btn btn-lg btn-danger" type="button" name="button"><i class="fa fa-stop"></i> Stop</button>
          <button id="reset" class="btn btn-lg btn-default" type="button" name="button"><i class="fa fa-refresh"></i> Reset</button>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

      var i,j,temp,pop,col,chunk = <?=$row_count?>;
      var rand;
      var idx = [];
      var chosen = [];
      var res = [];

      function getCol(matrix, col){
         var column = [];

         for(var i=0; i<matrix.length; i++){
            column.push(matrix[i][col]);
         }

         return column;
      }

      function chunkArray(myArray, chunk_size){
          var index = 0;
          var arrayLength = myArray.length;
          var tempArray = [];
          var col = [];
          var res = new Array();

          for (index = 0; index < arrayLength; index += chunk_size) {
              myChunk = myArray.slice(index, index+chunk_size);
              // Do something if you want with the group
              tempArray.push(myChunk);
          }

          for (var i = 0; i < chunk_size; i++) {
            col[i] = getCol(tempArray,i);
          }

          return col;
      }

      function get_random(i){
        return setInterval(function () {
          var id = Math.floor(Math.random()*pop[i].length);
          $("#row_"+i).html(pop[i][id]['nomor']+' ('+pop[i][id]['nama_penerima']+')');
          $("#id_"+i).val(pop[i][id]['id']);
        }, 10);
      }

      //initial hide
      $("#stop").hide();
      $("#reset").hide();

      //starting
      $("#start").click(function () {
        $("#start").hide();
        $("#stop").show();
        $("#info").html("PROCESSING ...");
        $.ajax({
          type : 'post',
          url : 'system/get_nomor.php',
          dataType : 'json',
          async : 'false',
          success : function (data) {
            temp = data;
            if(temp.length == 0){
              $("#stop").hide();
              $("#start").show();
              for (var i = 0; i < chunk; i++) {
                $("#row_"+i).html('--');
                $("#id_"+i).val('');
              }
              $("#info").html("CLICK START TO BEGIN");
              alert('All data have been chosen!');
            }else{
              pop = chunkArray(temp, chunk);
              for (var i = 0; i < chunk; i++) {
                res[i] = get_random(i);
              }
            }
          }
        })
      })

      //stopping
      $("#stop").click(function () {
        $("#stop").hide();
        $("#reset").show();

        var ids = new Array();

        for (var i = 0; i < chunk; i++) {
          clearInterval(res[i]);
          ids.push($("#id_"+i).val());
        }

        $.ajax({
          type : 'post',
          url : 'system/update_nomor.php',
          data : 'id='+ids,
          success : function () {

          }
        })

        $("#info").html("THE CHOSEN IS");
      })

      $("#reset").click(function () {
        $("#start").show();
        $("#reset").hide();
        for (var i = 0; i < chunk; i++) {
          $("#row_"+i).html('--');
          $("#id_"+i).val('');
        }
        $("#info").html("CLICK START TO BEGIN");
      })

      //ini perubahan
    </script>
  </body>

</html>
