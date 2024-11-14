<?php
require_once '../database/koneksi.php';
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Informasi Penjualan Buku</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets_adminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../assets_adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets_adminLTE/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b> Sistem Informasi Penjualan Buku</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user-circle"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <a href="#" class="btn btn-block btn-danger">
          <i class="nav-icon fas fa-question-circle"></i> Lupa Password
        </a>
            
          </div>
          <!-- /.col -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block" name="masuk">Log In <i class="nav-icon fas fa-sign-out-alt"></i></button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <?php
        if(isset($koneksi, $_POST['masuk'])){
            $isianusername = trim(mysqli_escape_string($koneksi, $_POST['username']));
            $isianpw = sha1(trim(mysqli_escape_string($koneksi, $_POST['password'])));
            $cekdatabase = mysqli_query($koneksi, "SELECT * FROM tbl_pengguna WHERE username= '$isianusername' AND password= '$isianpw'") or die(mysqli_error($koneksi));

            $returnvalue = mysqli_num_rows($cekdatabase);

           if($returnvalue==1){
            $array = mysqli_fetch_assoc($cekdatabase);
            $st_user = $array['status'];

            //buat percabngan login
            session_start();
            if($st_user==0){
              $_SESSION['username'] = $isianusername;
              $_SESSION['nama_user'] = $array['nama_user'];
              $_SESSION['status'] = $st_user;

              echo '<script>
              window.location="../admin_dashboard"</script>';
            }
            else if($st_user==1){

              $_SESSION['username'] = $isianusername;
              $_SESSION['nama_user'] = $array['nama_user'];
              $_SESSION['status'] = $st_user;

              echo '<script>
              window.location="../kasir_dashboard"</script>';
            }
           }
           else{
            //jika hasil $rv = 0 ( tidak ada user yang dimaksud)
            session_destroy();
            echo '<script>
              window.location="../gagal_login"</script>';


          }

            
           }

      ?>
          <br>
          <center><font color="#000000"><small><em> Copyright &copy; Toko Buku Mayang </a></em></</small></font>
          <br/> 
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
