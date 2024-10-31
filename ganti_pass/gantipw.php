<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  $konstruktor ='ganti_pass';
  require_once '../database/koneksi.php';

  if(isset($_SESSION['status'])){
    $status = $_SESSION['status'];
    if($status != 0){
      echo '<script>window.location = "../auth/logout.php"</script>';
    }
  }else{
    echo '<script>window.location = "../auth/logout.php"</script>';
  }
  ?>

  <?php
  include '../listlink.php';
  ?>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <?php
    include '../navbar.php';
    ?>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #024CAA;">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../auth/assets/img/logobk.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Toko Buku Mayang</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <?php
      include '../sidebar.php';
      ?>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0"> Ganti Password</h1>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">

            <?php
            if(isset($_POST['updatepw']))
            {
                $username = $_SESSION['username'];
                $pwbaru = trim(mysqli_real_escape_string($koneksi, $_POST['passbaru']));
                $pwbaru2 = trim(mysqli_real_escape_string($koneksi, $_POST['passbaru2']));

                if ($pwbaru!=$pwbaru2) {
                    echo '
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"> 
                </script>
                <script>
                swal("Peringatan", "Password tidak sama", "warning");

                setTimeout(function(){
                window.location.href = "../ganti_pass";

                },2000);
                </script>
                    ';
                }else{
                    $pwbaru = sha1(trim(mysqli_real_escape_string($koneksi, $_POST['passbaru'])));
                    mysqli_query($koneksi, "UPDATE tbl_pengguna SET password='$pwbaru' WHERE username='$username'") or die (mysqli_error($koneksi));

                    echo '
                     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"> 
                        </script>
                        <script>
                        swal("success", "Password telah di Update", "success");

                        setTimeout(function(){
                        window.location.href = "../auth/logout.php";

                        },2000);
                        </script>
                    
                    ';


                }

               
                
            }

            ?>

            </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <?php
  include '../footer.php';
  ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<?php
  include '../script.php';
  ?>
</body>
</html>
