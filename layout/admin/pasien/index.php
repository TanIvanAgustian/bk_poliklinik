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
            <h1 class="m-0">Daftar Pasien</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">pasien</li>
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
                $no_ktp = '';
                $no_hp = '';
                $no_rm = '';
                if (isset($_GET['id'])) {
                    $ambil = mysqli_query($con, "SELECT * FROM pasien 
                    WHERE id='" . $_GET['id'] . "'");
                    while ($row = mysqli_fetch_array($ambil)) {
                        $nama = $row['nama'];
                        $alamat = $row['alamat'];
                        $no_ktp = $row['no_ktp'];
                        $no_hp = $row['no_hp'];
                        $no_rm = $row['no_rm'];
                    }
            ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
            } else {
                $queryGetRm = "SELECT MAX(SUBSTRING(no_rm, 8)) as last_queue_number FROM pasien";
                $resultRm = mysqli_query($con, $queryGetRm);

                if(!$resultRm){
                    die("Query gagal: ". mysqli_error($conn));
                }

                $rowRm = mysqli_fetch_assoc($resultRm);
                $lastQueueNumber = $rowRm['last_queue_number'];

                $lastQueueNumber = $lastQueueNumber ? $lastQueueNumber : 0;


                $tahun_bulan = date("Ym");

                $newQueueNumber = $lastQueueNumber + 1;

                $no_rm = $tahun_bulan . "-" . str_pad($newQueueNumber, 3, '0', STR_PAD_LEFT);
            }
        ?>
            <div class="form-group">
                <label for="exampleFormControlInput1">Nama Pasien</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Alamat</label>
                <input type="text" name="alamat" id="alamat" class="form-control" value="<?php echo $alamat ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Nomor KTP</label>
                <input type="text" name="no_ktp" id="no_ktp" class="form-control" value="<?php echo $no_ktp ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Nomor Telepon</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?php echo $no_hp ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Nomor Rekam Medis</label>
                <input type="text" name="no_rm" id="no_rm" class="form-control" value="<?php echo $no_rm ?>">
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
                    <th scope="col">Nomor KTP</th>
                    <th scope="col">Nomor Telepon</th>
                    <th scope="col">Nomor RM</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php
                $result = mysqli_query($con, "SELECT * FROM pasien");
                $no = 1;
                while ($data = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $data['nama'] ?></td>
                    <td><?php echo $data['alamat'] ?></td>
                    <td><?php echo $data['no_ktp'] ?></td>
                    <td><?php echo $data['no_hp'] ?></td>
                    <td><?php echo $data['no_rm'] ?></td>
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
      $ubah = mysqli_query($con, "UPDATE pasien SET 
                                      nama = '" . $_POST['nama'] . "',
                                      alamat = '" . $_POST['alamat'] . "',
                                      no_ktp = '" . $_POST['no_ktp'] . "',
                                      no_hp = '" . $_POST['no_hp'] . "'
                                      WHERE
                                      id = '" . $_POST['id'] . "'");
  } else {
      $tambah = mysqli_query($con, "INSERT INTO pasien(nama,alamat,no_ktp,no_hp,no_rm) 
                                      VALUES ( 
                                          '" . $_POST['nama'] . "',
                                          '" . $_POST['alamat'] . "',
                                          '" . $_POST['no_ktp'] . "',
                                          '" . $_POST['no_hp'] . "',
                                          '" . $_POST['no_rm'] . "'
                                          )");
  }

  echo "<script> 
          document.location='index.php';
          </script>";
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($con, "DELETE FROM pasien WHERE id = '" . $_GET['id'] . "'");
    }

    echo "<script> 
            document.location='index.php';
            </script>";
}
?>

</body>
</html>
