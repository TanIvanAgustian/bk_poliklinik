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
            <h1 class="m-0">Daftar Poli</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active">Poli</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="m-3 p-3">
        <div class="row">
            <div class="col-3">
                <form  method="POST" class="bg-white rounded p-3" action="" name="myForm" onsubmit="return(validate());">
                <?php
                $id = $_SESSION['no_rm'];
                $id_poli = '';
                $id_jadwal = '';
                $keluhan = '';
                $no_antrian = '';
                if (isset($_GET['id'])) {
                    $ambil = mysqli_query($con, "SELECT * FROM daftar_poli 
                    WHERE id='" . $_GET['id'] . "'");
                    while ($row = mysqli_fetch_array($ambil)) {
                        $id = $row['id'];
                        $id_poli = $row['id_poli'];
                        $id_jadwal = $row['id_jadwal'];
                        $keluhan = $row['keluhan'];
                        $no_antrian = $row['no_antrian'];
                    }
            ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
            }
        ?>
                
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Nomor Rekam Medis</label>
                        <input type="text" name="id" id="id" class="form-control" value="<?php echo $id ?>">
                    </div>
                    <div class="form-group">
                        <label for="id_poli" class="font-weight-bold">Pilih Poli</label>
                        <select class="form-control" name="id_poli" id="id_poli">
                            <option value="0">Pilih Poli anda</option>
                            <?php
                            $selected = '';
                            $pasien = mysqli_query($con, "SELECT * FROM poli");
                            while ($data = mysqli_fetch_array($pasien)) {
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
                    <div class="form-group">
                        <label for="id_jadwal" class="font-weight-bold">Pilih Jadwal</label>
                        <select class="form-control" name="id_jadwal" id="id_jadwal">
                            <option value="0">Tak Ada Data</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keluhan" class="font-weight-bold">keluhan</label>
                        <input type="text" class="form-control" name="keluhan" id="keluhan"></input>
                    </div>
                    <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Daftar</button>
                </form>
            </div>

            <div class="col-9">
            <div class="bg-white p-3 align-item-center">
            <div class="row w-100 user-panel">
                <h5>Daftar Poli</h5>

                <!-- table -->
                <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Poli</th>
                        <th scope="col">Dokter</th>
                        <th scope="col">Hari</th>
                        <th scope="col">Mulai</th>
                        <th scope="col">Selesai</th>
                        <th scope="col">Antrian</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php
                    $result = mysqli_query($con, "SELECT daftar_poli.*, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai, dokter.nama, poli.nama_poli FROM daftar_poli INNER JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id INNER JOIN dokter ON jadwal_periksa.id_dokter = dokter.id INNER JOIN poli ON dokter.id_poli = poli.id WHERE 1");
                    $no = 1;
                    while ($data = mysqli_fetch_array($result)) {
                ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $data['nama_poli'] ?></td>
                        <td><?php echo $data['nama'] ?></td>
                        <td><?php echo $data['hari'] ?></td>
                        <td><?php echo $data['jam_mulai'] ?></td>
                        <td><?php echo $data['jam_selesai'] ?></td>
                        <td><?php echo $data['no_antrian'] ?></td>
                        <td>
                            <a class="btn btn-success rounded px-3" href="./detail.php?id=<?php echo $data['id'] ?>" >Detail</a>
                        </td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
            </div>
            </div>
            </div>
        </div>

        
    </div>

    

<?php
if (isset($_POST['simpan'])) {
        $antrian = mysqli_query($con, "SELECT MAX(no_antrian) AS antrian FROM daftar_poli WHERE id_jadwal = '". $_POST['id_jadwal'] ."'"); 
        $rowantrian = mysqli_fetch_assoc($antrian);
        $antrianterakhir = $rowantrian['antrian'];
        $antrianterakhir = $antrianterakhir ? $antrianterakhir : 0;

        $tambah = mysqli_query($con, "INSERT INTO daftar_poli(id_pasien,id_jadwal,keluhan,no_antrian) 
                                        VALUES ( 
                                            '" . $_SESSION['id'] . "',
                                            '" . $_POST['id_jadwal'] . "',
                                            '" . $_POST['keluhan'] . "',
                                            '" . $antrianterakhir + 1 . "'
                                            )");

    echo "<script> 
            document.location='index.php';
            </script>";
}
?>

<script>
    document.getElementById('id_poli').addEventListener('change', function() {
        var id_poli = this.value;
        loadJadwal(id_poli);
    })
    

    function loadJadwal(poliId) {
        var xhr = new XMLHttpRequest();

        xhr.open('GET', 'http://localhost/bk-poliklinik/layout/pasien/daftar/get_jadwal.php?id_poli=' + poliId, true);

        xhr.setRequestHeader('Content-Type', 'text/html');

        xhr.onload = function(){
            if(xhr.status === 200){
                document.getElementById('id_jadwal').innerHTML = xhr.responseText;
                console.log("masuk")
            }
        };

        xhr.send();
    }
</script>


</body>
</html>
