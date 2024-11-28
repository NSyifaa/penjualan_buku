<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  $konstruktor ='kasir_dashboard';
  require_once '../database/koneksi.php';

  if(isset($_SESSION['status'])){
    $status = $_SESSION['status'];
    if($status != 1){
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
      include '../kasir_sidebar.php';
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
        <div class="col-lg-3 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3>
                <?php
                // Ambil bulan dan tahun saat ini
                $currentMonth = date('m');
                $currentYear = date('Y');

                // Query untuk menghitung total penjualan bulan ini
                $queryTotalPenjualanBulanIni = mysqli_query($koneksi, "
                  SELECT SUM(d.harga * d.qty) AS total_penjualan
                  FROM tbl_detail_penjualan d
                  JOIN tbl_penjualan p ON d.nomor = p.nomor
                  WHERE MONTH(p.tgl) = '$currentMonth' AND YEAR(p.tgl) = '$currentYear'
                ") or die(mysqli_error($koneksi));

                // Ambil hasil query
                $resultTotalPenjualanBulanIni = mysqli_fetch_assoc($queryTotalPenjualanBulanIni);

                // Jika tidak ada hasil, set nilai total penjualan bulan ini menjadi 0
                $totalPenjualanBulanIni = $resultTotalPenjualanBulanIni['total_penjualan'] ?? 0;

                // Tampilkan total penjualan bulan ini dengan format Rupiah
                echo 'Rp. ' . number_format($totalPenjualanBulanIni, 0, ',', '.');
                ?>
              </h3>
              <p>Penjualan Bulan Ini  </p> 
              (<?php echo date('F Y'); ?>)
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="../admin_penjualan" class="small-box-footer">Info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>
                <?php
                // Query untuk menghitung total bruto bulan ini
                $queryBrutoBulanIni = mysqli_query($koneksi, "
                  SELECT SUM((d.harga - d.harga_beli) * d.qty) AS total_bruto
                  FROM tbl_detail_penjualan d
                  JOIN tbl_penjualan p ON d.nomor = p.nomor
                  WHERE MONTH(p.tgl) = '$currentMonth' AND YEAR(p.tgl) = '$currentYear'
                ") or die(mysqli_error($koneksi));

                // Ambil hasil query
                $brutoBulanIni = mysqli_fetch_assoc($queryBrutoBulanIni);

                // Jika tidak ada hasil, set nilai total bruto bulan ini menjadi 0
                $totalBrutoBulanIni = $brutoBulanIni['total_bruto'] ?? 0;

                // Tampilkan total bruto bulan ini dengan format Rupiah
                echo 'Rp. ' . number_format($totalBrutoBulanIni, 0, ',', '.');
                ?>
              </h3>
              <p>Total Bruto Bulan Ini </p>
              (<?php echo date('F Y'); ?>)
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
            <a href="../admin_laporan_jual" class="small-box-footer">Info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
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
