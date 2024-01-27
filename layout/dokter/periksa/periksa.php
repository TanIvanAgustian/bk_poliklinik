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
                if (isset($_GET['id'])) {
                    $ambil = mysqli_query($con, "SELECT * FROM daftar_poli WHERE id='" . $_GET['id'] . "'");
                    
                    while ($row = mysqli_fetch_array($ambil)) {
                        // Check if 'id_pasien' key exists in $row array
                        if (isset($row['id_pasien'])) {
                            $id_pasien = $row['id_pasien'];
                
                            // Fetch the name using the retrieved id_pasien
                            $datapasien = mysqli_query($con, "SELECT * FROM pasien WHERE id = $id_pasien");
                            
                            while ($rowname = mysqli_fetch_array($datapasien)) {
                                $nama = $rowname['nama'];  // Assuming 'nama' is the column you want to retrieve
                            }
                        } else {
                            echo "The 'id_pasien' key is not set in the array.";
                        }
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
                <input type="date" name="tgl_periksa" id="tgl_periksa" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Catatan</label>
                <input type="text" name="catatan" id="catatan" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Obat</label>
                <select class="form-control js-example-basic-multiple" name="obat[]" multiple id="id_obat">
                <?php
                            foreach($obat as $obats){
                            ?>
                                <option value="<?= $obats['id']; ?>|<?= $obats['harga']?>"><?=  $obats['nama_obat'] ?> - <?=  $obats['kemasan'] ?> - <?=  $obats['harga'] ?></option>
                            <?php
                            };
                            ?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Total Harga</label>
                <input type="text" name="harga" id="harga" class="form-control" readonly>
            </div>
            <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
        </form>

        <?php
        if(isset($_POST['simpan'])) {
            $tgl_periksa = $_POST['tgl_periksa'];
            $catatan = $_POST['catatan'];
            $obat = $_POST['obat'];
            $id_daftar_poli = $_GET['id'];
            $id_obat = [];
            for ($i = 0; $i < count($obat); $i++){
                $data_obat = explode("|", $obat[$i]);
                $id_obat[] = $data_obat[0];
                $total_biaya_obat += $data_obat[1];
            }
            $total_biaya = $biaya_periksa + $total_biaya_obat;

            $query = "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) VALUES ($id_daftar_poli, '$tgl_periksa', '$catatan', '$total_biaya')";
            $result = mysqli_query($con, $query);

            $query2 = "INSERT INTO detail_periksa (id_obat, id_periksa) VALUES ";
            $periksa_id = mysqli_insert_id($con);
            for ($i = 0; $i < count($id_obat); $i++){
                $query2 .= "($id_obat[$i], $periksa_id),";
            }
            $query2 = substr($query2, 0, -1);
            $result2 = mysqli_query($con, $query2);

            if($result && $result2) {
                echo "<script>alert ('data berhasil ditambahkan') </script>";
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
