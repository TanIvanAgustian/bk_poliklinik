<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Poliklinik UDINUS</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<?php
if(isset($_SESSION['login'])){
  $_SESSION['login'] = true;
} else {
  echo '<meta http-equiv="refresh" content="0; url= http://localhost/bk-poliklinik/auth/login.php">';
  die();
}
?>

<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="" role="button">
          Log Out 
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="http://localhost/bk-poliklinik/" class="brand-link">
      <img src="http://localhost/bk-poliklinik/asset/udinus.png" alt="Poliklinik" class="brand-image img-circle elevation-3 bg-white" style="opacity: .8">
      <span class="brand-text font-weight-light">Poliklinik Udinus</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="http://localhost/bk-poliklinik/asset/avatar2.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['username'] ?></a>
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
          with font-awesome or any other icon font library -->
          <!-- dashboard pasien -->
          <?php if ($_SESSION['akses'] == "pasien") {?>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/pasien" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Dashboard
                  <span class="right badge badge-warning">Pasien</span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/pasien/daftar" class="nav-link">
                <i class="nav-icon fas fa-hospital"></i>
                <p>
                  Daftar Poli
                  <span class="right badge badge-warning">Pasien</span>
                </p>
              </a>
              </li>
          <?php 
          } 
          // dashboard dokter
          if ($_SESSION['akses'] == "dokter") {?>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/dokter" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Dashboard
                  <span class="right badge badge-danger">Dokter</span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/dokter/jadwal_periksa" class="nav-link">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>
                  Jadwal Periksa
                  <span class="right badge badge-danger">Dokter</span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/dokter/periksa" class="nav-link">
                <i class="nav-icon fas fa-stethoscope"></i>
                <p>
                  Memeriksa Pasien
                  <span class="right badge badge-danger">Dokter</span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/dokter/riwayat" class="nav-link">
                <i class="nav-icon fas fa-receipt"></i>
                <p>
                  Riwayat Pasien
                  <span class="right badge badge-danger">Dokter</span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/dokter/profil" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Profil
                  <span class="right badge badge-danger">Dokter</span>
                </p>
              </a>
            </li>
          <?php
          } 
          // dashboard admin
          if ($_SESSION['akses'] == "admin") {?>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/admin" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Dashboard
                  <span class="right badge badge-success">Admin</span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/admin/dokter" class="nav-link">
                <i class="nav-icon fas fa-user-nurse"></i>
                <p>
                  Dokter
                  <span class="right badge badge-success">Admin</span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/admin/pasien" class="nav-link">
                <i class="nav-icon fas fa-hospital-user"></i>
                <p>
                  Pasien
                  <span class="right badge badge-success">Admin</span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/admin/poli" class="nav-link">
                <i class="nav-icon fas fa-hospital"></i>
                <p>
                  Poli
                  <span class="right badge badge-success">Admin</span>
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="http://localhost/bk-poliklinik/layout/admin/obat" class="nav-link">
                <i class="nav-icon fas fa-capsules"></i>
                <p>
                  Obat
                  <span class="right badge badge-success">Admin</span>
                </p>
              </a>
            </li>
          <?php
          }?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</div>
<!-- ./wrapper -->
</body>
</html>
