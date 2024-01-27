<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <title>Aplikasi Poliklinik UDINUS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../../plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <?php
  session_start();

  if ($_SESSION['akses'] != 'dokter') {
    echo '<meta http-equiv="refresh" content="0; url=../..">';
    die();
  }
  ?>

  <?php
  require("../../../koneksi.php")
  ?>

  <div class="wrapper">

    <?php
    require('../../header.php')
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Jadwal Periksa</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="./">Home</a></li>
                <li class="breadcrumb-item active">Jadwal Periksa</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->


      <div class="m-3 p-3">
        <form method="POST" action="" name="myForm" onsubmit="return(validate());">
          <?php
          $hari = '';
          $jam_mulai = '';
          $jam_selesai = '';
          $checked = '';
          if (isset($_GET['id'])) {
            $ambil = mysqli_query($con, "SELECT * FROM jadwal_periksa
                    WHERE id='" . $_GET['id'] . "'");
            while ($row = mysqli_fetch_array($ambil)) {
              $hari = $row['hari'];
              $jam_mulai = $row['jam_mulai'];
              $jam_selesai = $row['jam_selesai'];
              $status = $row['status'];
              if ($row['status'] == 1) {
                $checked = "checked";
              } else {
                $checked = '';
              }
            }
          ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
          <?php
          }
          ?>


          <div class="form-group">
            <?php if (isset($_GET['id'])) { ?>
              <h5>Edit Jadwal Periksa</h5>
              <label for="exampleFormControlSelect1">Hari</label>
              <select name="hari" id="hari" class="form-control" disabled>
                <?php
                $arr = [];
                $query = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                                WHERE TABLE_NAME = 'jadwal_periksa' AND COLUMN_NAME = 'hari'";
                $dataHari = mysqli_query($con, $query);
                if ($dataHari) {
                  $row = mysqli_fetch_assoc($dataHari);
                  $columnType = $row['COLUMN_TYPE'];
                  $result = str_replace(array("enum('", "')", "''"), array('', '', "'"), $columnType);
                  $arr = explode("','", $result);

                  for ($i = 0; $i < count($arr); $i++) {
                    if ($arr[$i] == $hari) {
                      $selected = 'selected';
                    } else {
                      $selected = '';
                    }
                ?>
                    <option value="<?php echo $arr[$i] ?>" <?php echo $selected ?>><?php echo $arr[$i] ?></option>
                <?php
                  }
                }
                ?>
              </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlInput1">Jam Mulai Periksa</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="<?php echo $jam_mulai ?>" disabled>
          </div>
          <div class="form-group">
            <label for="exampleFormControlInput1">Jam Selesai Periksa</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="<?php echo $jam_selesai ?>" disabled>
          </div>

          <div class="custom-control custom-switch mb-3">
            <input type="checkbox" class="custom-control-input" id="status" name="status" <?php echo $checked ?>>
            <label class="custom-control-label" for="status">Status</label>
          </div>
          <div class="form-group">
          <?php
            } else {
          ?>
            <h5>Tambah Jadwal Periksa</h5>
            <label for="exampleFormControlSelect1">Hari</label>
            <select name="hari" id="hari" class="form-control">
              <?php
              $arr = [];
              $query = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                                WHERE TABLE_NAME = 'jadwal_periksa' AND COLUMN_NAME = 'hari'";
              $dataHari = mysqli_query($con, $query);
              if ($dataHari) {
                $row = mysqli_fetch_assoc($dataHari);
                $columnType = $row['COLUMN_TYPE'];
                $result = str_replace(array("enum('", "')", "''"), array('', '', "'"), $columnType);
                $arr = explode("','", $result);

                for ($i = 0; $i < count($arr); $i++) {
              ?>
                  <option value="<?php echo $arr[$i] ?>"><?php echo $arr[$i] ?></option>
              <?php
                }
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleFormControlInput1">Jam Mulai Periksa</label>
            <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="<?php echo $jam_mulai ?>">
          </div>
          <div class="form-group">
            <label for="exampleFormControlInput1">Jam Selesai Periksa</label>
            <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="<?php echo $jam_selesai ?>">
          </div>
        <?php
            }
        ?>
        <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
        </form>
      </div>
      <?php
      if (isset($_POST['simpan'])) {

        if (isset($_POST['status'])) {
          $status = '1';
        } else {
          $status = '0';
        }


        if (isset($_POST['id'])) {

          $ubah = mysqli_query($con, "UPDATE jadwal_periksa SET
                                        status = '" . $status . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
        } else {
          $tambah = mysqli_query($con, "INSERT INTO jadwal_periksa(id_dokter,hari,jam_mulai,jam_selesai,status)
                                        VALUES (
                                            '" . $_SESSION['id'] . "',
                                            '" . $_POST['hari'] . "',
                                            '" . $_POST['jam_mulai'] . "',
                                            '" . $_POST['jam_selesai'] . "',
                                            '" . $status . "'
                                            )");
        }

        echo "<script>
            document.location='index.php';
            </script>";
      }
      ?>

</body>

</html>