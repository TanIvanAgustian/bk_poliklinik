<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Aplikasi Poliklinik UDINUS</title>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>

<?php
session_start();

if($_SESSION['akses'] != 'dokter'){
  echo '<meta http-equiv="refresh" content="0; url=../..">';
  die();
}
?>

<?php
    require("../../../koneksi.php");
    $obat = mysqli_query($con, "SELECT * FROM obat");
    $biaya_periksa = 150000;
    $total_biaya_obat = 0;
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
            <h1 class="m-0">Periksa Pasien</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item"><a href="../">Daftar Jadwal</a></li>
              <li class="breadcrumb-item"><a href="../">Daftar Periksa</a></li>
              <li class="breadcrumb-item active">Periksa Pasien</li>
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
            $tgl_periksa = '';
            $catatan = '';
            $id_obat = [];
            $Biaya_periksa_lama = '';
            if (isset($_GET['id'])) {
                $ambil = mysqli_query($con, "SELECT periksa.*, pasien.nama, detail_periksa.id_obat  FROM `periksa` INNER JOIN daftar_poli ON periksa.id_daftar_poli = daftar_poli.id INNER JOIN pasien ON daftar_poli.id_pasien = pasien.id INNER JOIN detail_periksa ON periksa.id = detail_periksa.id_periksa WHERE periksa.id='" . $_GET['id'] . "'");
                
                while ($row = mysqli_fetch_array($ambil)) {
                    $nama = $row['nama'];
                    $tgl_periksa = $row['tgl_periksa'];
                    $catatan = $row['catatan'];
                    $id_obat[] = $row['id_obat'];
                    $Biaya_periksa_lama = $row['biaya_periksa'];
                }
        ?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
        <?php
            }
        ?>

            <div class="form-group">
                <label for="exampleFormControlInput1">Nama Pasien</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $nama ?>" disabled>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Tanggal Periksa</label>
                <input type="date" name="tgl_periksa" id="tgl_periksa" class="form-control" value="<?php echo $tgl_periksa ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Catatan</label>
                <input type="text" name="catatan" id="catatan" class="form-control" value="<?php echo $catatan ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Obat</label>
                <select class="form-control js-example-basic-multiple" name="obat[]" multiple id="id_obat">
                <?php
                            $selected = '';
                            while ($data = mysqli_fetch_array($obat)) {
                                for ( $i = 0; $i < count($id_obat); $i++ ){
                                    if ($data['id'] == $id_obat[$i]) {
                                        $selected = 'selected="selected"';
                                        break;
                                    } else {
                                        $selected = '';
                                    }
                                }
                                ?>
                                <option value="<?= $data['id']; ?>|<?= $data['harga']?>" <?php echo $selected ?> ><?=  $data['nama_obat'] ?> - <?=  $data['kemasan'] ?> - <?=  $data['harga'] ?></option>
                            <?php
                            };
                            ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Total Harga</label>
                <input type="text" name="harga" id="harga" class="form-control" value="<?php echo $Biaya_periksa_lama ?>" readonly>
            </div>
            <button type="submit" class="btn btn-warning" id="simpan" name="simpan">Edit</button>
        </form>

        <?php
        if(isset($_POST['simpan'])) {
            $tgl_periksa = $_POST['tgl_periksa'];
            $catatan = $_POST['catatan'];
            $obat = $_POST['obat'];
            $id = $_GET['id'];
            $id_obat = [];
            for ($i = 0; $i < count($obat); $i++){
                $data_obat = explode("|", $obat[$i]);
                $id_obat[] = $data_obat[0];
                $total_biaya_obat += $data_obat[1];
            }
            $total_biaya = $biaya_periksa + $total_biaya_obat;

            $query = "UPDATE periksa SET tgl_periksa = '$tgl_periksa',catatan = '$catatan', biaya_periksa =  '$total_biaya' WHERE id= $id";
            $result = mysqli_query($con, $query);

            $query2 = "DELETE FROM detail_periksa WHERE id_periksa = $id";
            $result2 = mysqli_query($con, $query2);

            $query3 = "INSERT INTO detail_periksa (id_obat, id_periksa) VALUES ";
            for ($i = 0; $i < count($id_obat); $i++){
                $query3 .= "($id_obat[$i], $id),";
            }
            $query3 = substr($query3, 0, -1);
            $result3 = mysqli_query($con, $query3);

            if($result && $result2 && $result3) {
                echo "<script>alert ('data berhasil Diubah') </script>";
                echo "<script> 
                document.location='index.php';
                </script>";
            }
        }
        ?>
    </div>

<script>
    $(document).ready(function() {
        $('#id_obat').select2();
        $('#id_obat').on('change.select2', function(e) {
            var selectedValuesArray = $(this).val();
            
            var sum = 150000;
            if(selectedValuesArray) {
                for (var i = 0; i < selectedValuesArray.length; i++){
                    var parts = selectedValuesArray[i].split("|");
                    if(parts.length === 2){
                        sum += parseFloat(parts[1]);
                    }
                }
            }
            $('#harga').val(sum);
        });
    });
</script>

</body>
</html>
