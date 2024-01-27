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
            <h1 class="m-0">Daftar Dokter</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">Dokter</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="m-3 p-3">
        <form  method="POST" action="" name="myForm" onsubmit="return(validate());">
        <?php
                $nama = '';
                $alamat = '';
                $no_hp = '';
                $id_poli = '';
                if (isset($_GET['id'])) {
                    $ambil = mysqli_query($con, "SELECT * FROM dokter 
                    WHERE id='" . $_GET['id'] . "'");
                    while ($row = mysqli_fetch_array($ambil)) {
                        $nama = $row['nama'];
                        $alamat = $row['alamat'];
                        $no_hp = $row['no_hp'];
                        $id_poli = $row['id_poli'];
                    }
            ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
        }
        ?>
            <div class="form-group">
                <label for="exampleFormControlInput1">Nama Dokter</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $alamat ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Nomor Telepon</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?php echo $no_hp ?>">
            </div>
            <div class="form-group">
                        <label for="id_poli" class="font-weight-bold">Pilih Poli</label>
                        <select class="form-control" name="id_poli" id="id_poli">
                            <option value="0">Pilih Poli untuk dokter anda</option>
                            <?php
                            $selected = '';
                            $dokter = mysqli_query($con, "SELECT * FROM poli");
                            while ($data = mysqli_fetch_array($dokter)) {
                                if ($data['id'] == $id_poli) {
                                    $selected = 'selected="selected"';
                                } else {
                                    $selected = '';
                                }
                            ?>
                                <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama_poli'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
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
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Nomor Telepon</th>
                    <th scope="col">Nama Poli</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php
                $result = mysqli_query($con, "SELECT dokter.*, poli.nama_poli FROM `dokter` INNER JOIN poli ON dokter.id_poli = poli.id WHERE 1");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['nama_poli'] ?></td>
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
        $ubah = mysqli_query($con, "UPDATE dokter SET 
                                        nama = '" . $_POST['nama'] . "',
                                        alamat = '" . $_POST['alamat'] . "',
                                        no_hp = '" . $_POST['no_hp'] . "',
                                        id_poli = '" . $_POST['id_poli'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
    } else {
        $tambah = mysqli_query($con, "INSERT INTO dokter(nama,alamat,no_hp,id_poli) 
                                        VALUES ( 
                                            '" . $_POST['nama'] . "',
                                            '" . $_POST['alamat'] . "',
                                            '" . $_POST['no_hp'] . "',
                                            '" . $_POST['id_poli'] . "'
                                            )");
    }

    echo "<script> 
            document.location='index.php';
            </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($con, "DELETE FROM dokter WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
            document.location='index.php';
            </script>";
}
?>

</body>
</html>
