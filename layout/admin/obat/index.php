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

if($_SESSION['akses'] != 'admin'){
  echo '<meta http-equiv="refresh" content="0; url=../../..">';
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
            <h1 class="m-0">Daftar Obat</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">obat</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="m-3 p-3">
        <form  method="POST" action="" name="myForm" onsubmit="return(validate());">
        <?php
                $nama_obat = '';
                $kemasan = '';
                $harga = '';
                if (isset($_GET['id'])) {
                    $ambil = mysqli_query($con, "SELECT * FROM obat 
                    WHERE id='" . $_GET['id'] . "'");
                    while ($row = mysqli_fetch_array($ambil)) {
                        $nama_obat = $row['nama_obat'];
                        $kemasan = $row['kemasan'];
                        $harga = $row['harga'];
                    }
            ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
            }
        ?>
            <div class="form-group">
                <label for="exampleFormControlInput1">Nama Obat</label>
                <input type="text" name="nama_obat" id="nama_obat" class="form-control" value="<?php echo $nama_obat ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Kemasan</label>
                <input type="text" name="kemasan" id="kemasan" class="form-control" value="<?php echo $kemasan ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control" value="<?php echo $harga ?>">
            </div>
            <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
        </form>
    </div>

    <div class="bg-white m-3 p-3 align-item-center">
        <div class="row w-100 user-panel">
            <h5>Daftar Obat</h5>

            <!-- table -->
            <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Obat</th>
                    <th scope="col">Kemasan</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php
                $result = mysqli_query($con, "SELECT * FROM obat");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama_obat'] ?></td>
                    <td><?php echo $data['kemasan'] ?></td>
                    <td><?php echo $data['harga'] ?></td>
                    <td>
                        <a class="btn btn-primary rounded px-3" href="?id=<?php echo $data['id'] ?>" ><i class="fas fa-pen"> Edit</i></a>
                        <a class="btn btn-danger rounded px-3" href="?id=<?php echo $data['id'] ?>&aksi=hapus"><i class="fas fa-trash"> Hapus</i></a>
                    </td>
                </tr>
            <?php
                }
            ?>
            </tbody>
        </table>

        <!-- Button trigger modal -->

</div>
</div>

<?php
if (isset($_POST['simpan'])) {
  if (isset($_POST['id'])) {
      $ubah = mysqli_query($con, "UPDATE obat SET 
                                      nama_obat = '" . $_POST['nama_obat'] . "',
                                      kemasan = '" . $_POST['kemasan'] . "',
                                      harga = '" . $_POST['harga'] . "'
                                      WHERE
                                      id = '" . $_POST['id'] . "'");
  } else {
      $tambah = mysqli_query($con, "INSERT INTO obat(nama_obat,kemasan,harga) 
                                      VALUES ( 
                                          '" . $_POST['nama_obat'] . "',
                                          '" . $_POST['kemasan'] . "',
                                          '" . $_POST['harga'] . "'
                                          )");
  }

  echo "<script> 
          document.location='index.php';
          </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($con, "DELETE FROM obat WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
            document.location='index.php';
            </script>";
}
?>

</body>
</html>
