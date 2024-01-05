<?php
session_start();
require "../koneksi.php";
$email = "";
$name = "";
$errors = array();

// [ANOTHER OPTION] REGULAR EXPRESSION FOR EMAIL VALIDATION
// PREREQUISITE MATA KULIAH OTOMATA & TEORI BAHASA
$pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';

// DIGUNAKAN UNTUK PEMBUATAN AKUN PERTAMA KALI [SIGNUP-USER.PHP]
// PROSES PENGIRIMAN DATA [SIGNUP BUTTON]
if (isset($_POST['signup'])) {
    try{
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_ktp = $_POST['no_ktp'];
        $no_hp = $_POST['no_hp'];

        // DIGUNAKAN APABILA ALAMAT EMAIL BELUM TERDAFTAR
        // MENGECEK EMAIL DARI DATABASE
        $check_user = "SELECT * FROM pasien WHERE no_ktp = '".$no_ktp."'";
        $res = mysqli_query($con, $check_user);

        // #1 - APAKAH EMAIL SUDAH TERDAFTAR?
        if (mysqli_num_rows($res) > 1) {

            $row = mysqli_fetch_assoc($res);

            if($row['nama'] != $nama){
                echo '<script>alert("User Sudah Ada!!!!")</script>';
                echo '<meta http-equiv="refresh" content="0; url=register.php">';
            } else {
                while($data = mysqli_fetch_array($res)){
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['username'] = $data['nama'];
                }
                $_SESSION['login'] = true;
                $_SESSION['akses'] = "pasien";
                $_SESSION['no_rm'] = $row['no_rm'];

                echo '<meta http-equiv="refresh" content="0; url=../layout/pasien">';
                die();
            }
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

            $query = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm')";
            
            if(mysqli_query($con, $query)){
                $_SESSION['login'] = true;
                $_SESSION['akses'] = "pasien";
                $_SESSION['no_rm'] = $no_rm;
                $_SESSION['id'] = mysqli_insert_id($con);
                $_SESSION['username'] = $nama;

                echo '<meta http-equiv="refresh" content="0; url=../layout/pasien">';
                die();
            }


        }
    } catch (PDOException $e) {
        $_SESSION['error'] = $e->getMassage();
        echo '<meta http-equiv="refresh" content="0">';
        die();
    }
}

// APABILA USER AKAN LOGIN [LOGIN BUTTON]
// MASUK KE DALAM SISTEM [LOGIN-USER.PHP]
if (isset($_POST['loginuser'])) {
    
    if($_POST['nama'] == 'admin' && $_POST['password'] == 'admin'){
        $_SESSION['login'] = true;
        $_SESSION['id'] = null;
        $_SESSION['username'] = 'admin';
        $_SESSION['akses'] = 'admin';
        echo '<meta http-equiv="refresh" content="0; url=../layout/admin">';
        die();

    } else {
        try{
            $nama = $_POST['nama'];
            $password = $_POST['password'];

            // DIGUNAKAN APABILA ALAMAT EMAIL BELUM TERDAFTAR
            // MENGECEK EMAIL DARI DATABASE
            $check_user = "SELECT * FROM pasien WHERE nama = '$nama' AND alamat = '$password'";
            $res = mysqli_query($con, $check_user);

            // #1 - APAKAH EMAIL SUDAH TERDAFTAR?
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['nama'];
                $_SESSION['login'] = true;
                $_SESSION['akses'] = "pasien";
                $_SESSION['no_rm'] = $row['no_rm'];
                echo '<meta http-equiv="refresh" content="0; url=../layout/pasien">';
                die();
            } else {
                $_SESSION['error'] = "Sepertinya Anda belum terdaftar sebagai member! Daftar melalui link di bawah ini.";
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMassage();
            echo '<meta http-equiv="refresh" content="0">';
            die();
        }
    }
}

if (isset($_POST['logindokter'])) {
    
    if($_POST['nama'] == 'admin' && $_POST['password'] == 'admin'){
        $_SESSION['login'] = true;
        $_SESSION['id'] = null;
        $_SESSION['username'] = 'admin';
        $_SESSION['akses'] = 'admin';
        echo '<meta http-equiv="refresh" content="0; url=../layout/admin">';
        die();

    } else {
        try{
            $nama = $_POST['nama'];
            $password = $_POST['password'];

            // DIGUNAKAN APABILA ALAMAT EMAIL BELUM TERDAFTAR
            // MENGECEK EMAIL DARI DATABASE
            $check_user = "SELECT * FROM dokter WHERE nama = '$nama' AND alamat = '$password'";
            $res = mysqli_query($con, $check_user);

            // #1 - APAKAH EMAIL SUDAH TERDAFTAR?
            if (mysqli_num_rows($res) > 0) {
                while($data = mysqli_fetch_array($res)){
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['username'] = $data['nama'];
                }
                $_SESSION['login'] = true;
                $_SESSION['akses'] = "dokter";
                echo '<meta http-equiv="refresh" content="0; url=../layout/dokter">';
                die();
            } else {
                $_SESSION['error'] = "Sepertinya Anda belum terdaftar sebagai dokter! Hubungi Admin untuk lebih lanjutnya.";
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMassage();
            echo '<meta http-equiv="refresh" content="0">';
            die();
        }
    }
}