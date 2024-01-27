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

if($_SESSION['akses'] != 'pasien'){
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
            <h1 class="m-0">Detail Pendaftaran</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">Riwayat Pasien</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="bg-white m-3 p-3 align-item-center">

        <?php
            $id = $_GET['id'];
            $result = mysqli_query($con, "SELECT daftar_poli.*, pasien.nama, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai, dokter.nama AS nama_dokter, dokter.no_hp, poli.nama_poli FROM daftar_poli INNER JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id INNER JOIN dokter ON jadwal_periksa.id_dokter = dokter.id INNER JOIN poli ON dokter.id_poli = poli.id INNER JOIN pasien ON daftar_poli.id_pasien = pasien.id WHERE daftar_poli.id = '".$id."'");
            while ($data = mysqli_fetch_array($result)) {
        ?>
        <div class="row w-100 user-panel mt-3 bg-primary p-3 rounded">
            <h5>Detail Pendaftaran Periksa</h5>
        </div>
        <div class = "row w-100 user-panel mt-3">
                <div class="col-4">nama Pasien</div>
                <div class="col">: <?php echo $data['nama'] ?></div>
        </div>
        <div class = "row w-100 user-panel mt-3">
                <div class="col-4">nama Dokter</div>
                <div class="col">: <?php echo $data['nama_dokter'] ?></div>
        </div>
        <div class = "row w-100 user-panel mt-3">
                <div class="col-4">Nomor Telepon Dokter</div>
                <div class="col">: <?php echo $data['no_hp'] ?></div>
        </div>
        <div class = "row w-100 user-panel mt-3">
                <div class="col-4">Poli</div>
                <div class="col">: <?php echo $data['nama_poli'] ?></div>
        </div>
        <div class = "row w-100 user-panel mt-3">
                <div class="col-4">Hari</div>
                <div class="col">: Hari <?php echo $data['hari'] ?></div>
        </div>
        <div class = "row w-100 user-panel mt-3">
                <div class="col-4">Jam Periksa</div>
                <div class="col">: <?php echo $data['jam_mulai'] ?> - <?php echo $data['jam_selesai'] ?></div>
        </div>
        <div class = "row w-100 user-panel mt-3">
                <div class="col-4">Keluhan</div>
                <div class="col">: <?php echo $data['keluhan'] ?></div>
        </div>
        <div class = "row w-100 user-panel mt-3">
                <div class="col-4">Nomor Antrian</div>
                <div class="col">: <button class="btn btn-danger"><?php echo $data['no_antrian'] ?></button></div>
                
        </div>

        <?php
            }
        ?>
    </div>


</body>
</html>
