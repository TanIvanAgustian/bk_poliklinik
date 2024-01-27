<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Login Form</title>
</head>

<body class="bg-info">
  <?php require_once "controllerUserData.php"; ?>
  <?php
  if (isset($_SESSION['akses'])) {
    if ($_SESSION['akses'] == 'dokter') {
      echo '<meta http-equiv="refresh" content="0; url=../layout/dokter">';
      die();
    } else if ($_SESSION['akses'] == 'admin') {
      echo '<meta http-equiv="refresh" content="0; url=../layout/admin">';
      die();
    } else if ($_SESSION['akses'] == 'pasien') {
      echo '<meta http-equiv="refresh" content="0; url=../layout/pasien">';
      die();
    }
  }
  ?>
  <div style="height:600px" class="d-flex align-items-center justify-content-center">
    <div class="container col-4 bg-white p-3 rounded ">
      <h3 class="text-center">Register Form</h3>
      <h6 class="mb-3 text-center">Masuk dengan Email dan Password Anda</h6>
      <form method="POST" action="" name="myForm" onsubmit="return(validate());">
        <div class="form-group">
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="email" name="nama" id="nama" placeholder="Username">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="alamat" name="alamat" id="alamat" placeholder="Alamat">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="no_ktp" name="no_ktp" id="no_ktp" placeholder="Nomor KTP">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="no_hp" name="no_hp" id="no_hp" placeholder="Nomor Telepon">
        </div>
        <button type="submit" class="btn btn-primary w-100 my-3" name="signup" id="signup">Register</button>
      </form>
    </div>
  </div>
</body>

</html>