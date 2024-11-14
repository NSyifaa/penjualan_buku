<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  $konstruktor ='admin_stok';
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
  <aside class="main-sidebar sidebar-dark-warning elevation-4"  style="background-color: #024CAA">
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
       
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12">

        <div class="card">
          <div class="card-header" style="background-color: #091057;">
            <h3 class="card-title" style="color: white"><i class="nav-icon fas fa-book"></i> Stok Buku</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
          

            <table id="example2" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Data Buku</th>
                <th>Qty</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
               
                
              </tr>
              </thead>
              <tbody>
              <?php
                    $no=1;
                    $sql_panggilstok = mysqli_query($koneksi, "SELECT * FROM tbl_stok") or die(mysqli_error($koneksi));

                    if (mysqli_num_rows($sql_panggilstok) > 0) {
                      while ($data_stok = mysqli_fetch_array($sql_panggilstok)) {
                        ?>
                        <tr>
                          <td><?= $no++ ; ?></td>
                          <td>
                            <?php 
                              $kd_buku = $data_stok['kd_buku']; 
                              $pgl_buku = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku='$kd_buku'")or die(mysqli_error($koneksi));
                              $data_buku = mysqli_fetch_array($pgl_buku);
                              echo $nama_buku = $data_buku['judul_buku'];
                            ?>
                          </td>
                          <td><?= $data_stok['qty']; ?></td>
                          <td>Rp <?= number_format($data_stok['harga_beli'], 0, ',', '.'); ?></td>
                          <td>Rp <?= number_format($data_stok['harga_jual'], 0, ',', '.'); ?></td>
                        </tr>
                        <?php
                      }
                    }
              ?>
              
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

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
