<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  $konstruktor ='admin_dashboard';
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
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <?php
    include '../navbar.php';
    ?>
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-warning elevation-4"  style="background-color: #024CAA">
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
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid"></div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">

        <!-- Total Penjualan -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-primary">
            <div class="inner">
              <h3>
                <?php
                // Query untuk menghitung total penjualan
                $queryTotalPenjualan = mysqli_query($koneksi, "
                  SELECT SUM(d.harga * d.qty) AS total_penjualan
                  FROM tbl_detail_penjualan d
                  JOIN tbl_penjualan p ON d.nomor = p.nomor
                ") or die(mysqli_error($koneksi));

                // Ambil hasil query
                $resultTotalPenjualan = mysqli_fetch_assoc($queryTotalPenjualan);

                // Jika tidak ada hasil, set nilai total penjualan menjadi 0
                $totalPenjualan = $resultTotalPenjualan['total_penjualan'] ?? 0;

                // Tampilkan total penjualan dengan format Rupiah
                echo 'Rp. ' . number_format($totalPenjualan, 0, ',', '.');
                ?>
              </h3>
              <p>Total Penjualan</p>
                Tahun (<?php echo date(' Y'); ?>)
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="../admin_penjualan" class="small-box-footer">Info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Penjualan Bulan Ini -->
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

        <!-- Total Bruto -->
        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>
                <?php
                // Query untuk menghitung total bruto bulan ini
                $queryBruto = mysqli_query($koneksi, "
                  SELECT SUM((d.harga - d.harga_beli) * d.qty) AS total_bruto
                  FROM tbl_detail_penjualan d
                  JOIN tbl_penjualan p ON d.nomor = p.nomor
                ") or die(mysqli_error($koneksi));

                // Ambil hasil query
                $bruto = mysqli_fetch_assoc($queryBruto);

                // Jika tidak ada hasil, set nilai total bruto menjadi 0
                $totalBruto = $bruto['total_bruto'] ?? 0;

                // Tampilkan total bruto dengan format Rupiah
                echo 'Rp. ' . number_format($totalBruto, 0, ',', '.');
                ?>
              </h3>
              <p>Total Bruto</p>
              Tahun (<?php echo date(' Y'); ?>)
            </div>
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
            <a href="../admin_laporan_jual" class="small-box-footer">Info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- Bruto Bulan Ini -->
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

        <div class="row">
        <div class="col lg-12">
         <div class="card card-primary">
          <div class="card-header">
          <h5><i class="nav-icon fas fa-info-circle"></i> Info </h5>
          </div>
        <div class="card-body">
          <div class="row">
                <div class="col lg-5">
              jbdjbsjd
                </div>
                <div class="col-lg-7">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Summary Pembelian dan Penjualan</h3>
                </div>
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Bulan</th>
                        <th>Pembelian</th>
                        <th>Penjualan</th>
                        <th>Bruto</th>
                        <th>Selisih</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Query untuk mengambil data per bulan
                    $sql = "
                      SELECT 
                        MONTH(p.tgl) AS bulan,
                        YEAR(p.tgl) AS tahun,
                        SUM(d.harga_beli * d.qty) AS pembelian,
                        SUM(d.harga * d.qty) AS penjualan,
                        SUM((d.harga - d.harga_beli) * d.qty) AS bruto
                      FROM tbl_detail_penjualan d
                      JOIN tbl_penjualan p ON d.nomor = p.nomor
                      GROUP BY YEAR(p.tgl), MONTH(p.tgl)
                      ORDER BY tahun DESC, bulan DESC
                    ";

                    $ambil = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

                    // Menampilkan hasil query dalam tabel
                    while ($row = mysqli_fetch_assoc($ambil)) {
                      $bulan = date("F", mktime(0, 0, 0, $row['bulan'], 10)); // Mengubah angka bulan menjadi nama bulan
                      $pembelian = $row['pembelian'] ?? 0;
                      $penjualan = $row['penjualan'] ?? 0;
                      $bruto = $row['bruto'] ?? 0;
                      $selisih = $penjualan - $bruto;

                      // Format angka sebagai Rupiah
                      $beli = 'Rp. ' . number_format($pembelian, 0, ',', '.');
                      $jual = 'Rp. ' . number_format($penjualan, 0, ',', '.');
                      $brutoaja = 'Rp. ' . number_format($bruto, 0, ',', '.');
                      $selisihaja = 'Rp. ' . number_format($selisih, 0, ',', '.');

                      echo "<tr>
                              <td>{$bulan} {$row['tahun']}</td>
                              <td>{$beli}</td>
                              <td>{$jual}</td>
                              <td>{$brutoaja}</td>
                              <td>{$selisihaja}</td>
                            </tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          </div>

            
        </div>
        </div>
        </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  include '../footer.php';
  ?>

</div>

<?php
  include '../script.php';
  ?>
</body>
</html>
