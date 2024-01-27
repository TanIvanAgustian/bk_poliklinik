<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Official Website Poliklinik UDINUS</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
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

<body>
  <?php
  session_start();

  if (isset($_SESSION['akses'])) {
    if ($_SESSION['akses'] == 'dokter') {
      echo '<meta http-equiv="refresh" content="0; url=./layout/dokter">';
      die();
    } else if ($_SESSION['akses'] == 'admin') {
      echo '<meta http-equiv="refresh" content="0; url=./layout/admin">';
      die();
    } else if ($_SESSION['akses'] == 'pasien') {
      echo '<meta http-equiv="refresh" content="0; url=./layout/pasien">';
      die();
    }
  }
  ?>
  <div style="height:500px" class="bg-primary text-center text-white d-flex align-items-center justify-content-center">
    <div>
      <h1>Sistem Temu Janji</h1>
      <h1>Pasien - Dokter</h1>
      <h5>Bimbingan Karier 2023 bidang website</h5>
    </div>
  </div>

  <div class="container mt-3 mb-3">
    <div class="row">
      <div class="card-deck">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Login Sebagai Pasien</h5>
              <p class="card-text">jika anda seorang pasien yang menginginkan untuk memperoleh pemeriksaan dapat menghubungi kami dengan masuk sebagai pasien</p>
              <a class="btn btn-primary" href="auth/login.php"> <i class="fas fa-user"></i> klik link berikut</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Login Sebagai Dokter</h5>
              <p class="card-text">Jika Anda Seorang Dokter maka anda dapaet mengakses semua informasi mengenai pasien dan lain sebagainya dengan masuk sebagai dokter</p>
              <a class="btn btn-primary" href="auth/login_dokter.php"> <i class="fas fa-user"></i> klik link berikut</a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</body>

</html>