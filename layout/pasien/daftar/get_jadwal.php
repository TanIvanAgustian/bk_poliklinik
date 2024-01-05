<?php
include_once("../../../koneksi.php");

$poliId = isset($_GET['id_poli']) ? $_GET['id_poli'] : null;

$dataJadwal = mysqli_query($con, "SELECT dokter.nama, jadwal_periksa.hari, jadwal_periksa.id, jadwal_periksa.jam_mulai,jadwal_periksa.jam_selesai FROM dokter INNER JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter WHERE dokter.id_poli = $poliId");

while ($data = mysqli_fetch_array($dataJadwal)) {
    if ($data['id'] == $id_jadwal) {
        $selected = 'selected="selected"';
    } else {
        $selected = '';
    }?>
    <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?> || <?php echo $data['hari']?> || <?php echo $data['jam_mulai']?> - <?php echo $data['jam_selesai'] ?></option>
    <?php
    }
?>
?>