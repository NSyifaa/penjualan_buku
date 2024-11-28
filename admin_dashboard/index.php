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
  $id = 0; 
  $jumlah = 0;
  $cek = mysqli_query($koneksi, "SELECT * FROM tbl_peringatan_stok LIMIT 1");
  if ($cek && mysqli_num_rows($cek) > 0) {
      $tampilin = mysqli_fetch_assoc($cek);
      $id = $tampilin['id'];
      $jumlah = $tampilin['jumlah'];
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
                <div class="row">
               
                  <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-setting"> <i class="nav-icon fas fa-edit"></i>
                    Setting Reminder
                  </button>

                  <table id="example2" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>No</th>
                <th>Data Buku</th>
                <th>Qty</th>
                
               
                
              </tr>
              </thead>
              <tbody>
              <?php
                    $no=1;
                    $sql_panggilstok = mysqli_query($koneksi, "SELECT kd_buku, qty FROM tbl_stok WHERE qty < $jumlah ") or die(mysqli_error($koneksi));

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
                         
                        </tr>
                        <?php
                      }
                    }
              ?>
              
              </tbody>
            </table>
                    </div>

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
<div class="modal fade" id="modal-setting">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background-color:#091057;">
              <h4 class="modal-title" style="color: white"><i class="nav-icon fas fa-edit"></i> Setting Reminder </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="edit.php"  role="form" class="form-layout" method="post" enctype="multipart/form-data">
             <div class="form-group">
              <input type="text" class="form-control" id="id" name="id" value="<?php echo $id; ?> " hidden >
             </div>
             <div class="form-group">
              <label for="id">jumlah</label>
              <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo $jumlah; ?>" >
             </div>
            </div>
            <div class="modal-footer justify-content-between-right">
              <button type="submit" name="edit" class="btn btn-primary"><i class="nav-icon fas fa-download"></i>edit</button>
            </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

<?php
  include '../script.php';
  ?>



</body>
</html>
