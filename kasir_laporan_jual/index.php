<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Penjualan</title>
  <?php
  session_start();
  $konstruktor = 'kasir_laporan_jual';
  require_once '../database/koneksi.php';

  if (isset($_SESSION['status'])) {
    $status = $_SESSION['status'];
    if ($status != 1) {
      echo '<script>window.location = "../auth/logout.php"</script>';
    }
  } else {
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

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-warning elevation-4" style="background-color: #024CAA">
    <a href="index3.html" class="brand-link">
      <img src="../auth/assets/img/logobk.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Toko Buku Mayang</span>
    </a>

    <div class="sidebar">
      <?php
      include '../kasir_sidebar.php';
      ?>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
      </div>
    </div>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon fas fa-file-alt"></i> Laporan Penjualan</h5>
              </div>
              <div class="card-body">
                <form action="" method="post">
                  <div class="row">
                    <div class="col-lg-4">
                      <label for="tanggal_mulai">Tanggal Mulai:</label>
                      <input type="date" class="form-control" name="tanggal_mulai" required>
                    </div>
                    <div class="col-lg-4">
                      <label for="tanggal_akhir">Tanggal Akhir:</label>
                      <input type="date" class="form-control" name="tanggal_akhir" required>
                    </div>
                    <div class="col-lg-4 d-flex align-items-end">
                      <button class="btn btn-info btn-block" type="submit" name="cari">
                        <i class="nav-icon fas fa-search"></i> Cari Data
                      </button>
                    </div>
                  </div>
                </form>

                <?php
                if (isset($_POST['cari'])) {
                  $tanggal_mulai = $_POST['tanggal_mulai'];
                  $tanggal_akhir = $_POST['tanggal_akhir'];

                  if ($tanggal_mulai > $tanggal_akhir) {
                    echo "<script>alert('Tanggal Mulai tidak boleh lebih dari Tanggal Akhir!');</script>";
                  } else {
                    // Query untuk mengambil data penjualan berdasarkan tanggal
                    $query_penjualan = "
                      SELECT 
                      tgl, nomor 
                      FROM 
                      tbl_penjualan 
                      WHERE tgl BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'
                    ";

                    $ambil_penjualan = mysqli_query($koneksi, $query_penjualan) or die(mysqli_error($koneksi));
                    ?>

                    <br>

                    <div class="mb-3">
                      <a href="export_excel.php?tanggal_mulai=<?= urlencode($tanggal_mulai); ?>&tanggal_akhir=<?= urlencode($tanggal_akhir); ?>" class="btn btn-success btn-sm">Ekspor ke Excel</a>
                      <a href="export_pdf.php?tanggal_mulai=<?= urlencode($tanggal_mulai); ?>&tanggal_akhir=<?= urlencode($tanggal_akhir); ?>" class="btn btn-danger btn-sm">Ekspor ke PDF</a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped table-sm mt-4">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th>Tanggal</th>
                          <th>Nomor Penjualan</th>
                          <th>Qty</th>
                          <th>Harga Beli</th>
                          <th>Harga Jual</th>
                          <th>Selisih (Bruto)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        $total_selisih = 0;

                        if (mysqli_num_rows($ambil_penjualan) > 0) {
                          while ($data_penjualan = mysqli_fetch_array($ambil_penjualan)) {
                            // Ambil data qty dan harga beli dari tbl_detail_penjualan
                            $nomor_penjualan = $data_penjualan['nomor'];
                            $query_po = "
                              SELECT 
                                  qty,
                                  harga_beli,
                                  harga
                              FROM 
                                  tbl_detail_penjualan 
                              WHERE 
                                  nomor = '$nomor_penjualan'
                            ";

                            $ambil_po = mysqli_query($koneksi, $query_po) or die(mysqli_error($koneksi));
                            $data_po = mysqli_fetch_array($ambil_po);

                            // Cek apakah data di tbl_detail_penjualan ada
                            if ($data_po) {
                                $harga_jual = $data_po['harga'];
                                $harga_beli = $data_po['harga_beli'];
                                $qty = $data_po['qty'];

                                $selisih = $harga_jual - $harga_beli;
                                $total_selisih_per_item = $selisih * $qty;

                                // Akumulasi total selisih
                                $total_selisih += $total_selisih_per_item;
                                if ($qty > 0 && $harga_beli > 0 && $harga_jual > 0 && $selisih > 0) {
                            ?>
                            <tr>
                              <td><?= $no++; ?></td>
                              <td><?= $data_penjualan['tgl']; ?></td>
                              <td><?= $data_penjualan['nomor']; ?></td>
                              <td><?= $qty; ?></td>
                              <td>Rp. <?= number_format($harga_beli, 0, ',', '.'); ?></td>
                             
                              <td>Rp. <?= number_format($harga_jual, 0, ',', '.'); ?></td>
                              <td>Rp. <?= number_format($selisih, 0, ',', '.'); ?></td>
                            </tr>
                            <?php
                                }
                            } else {
                              // Jika data kosong, atur nilai default
                              $qty = 0;
                              $harga_beli = 0;
                              $harga_jual = 0;
                              $selisih = 0;
                          }
                          }
                        } else {
                          echo "<tr><td colspan='7'>Tidak ada data yang ditemukan!</td></tr>";
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th colspan="4" style="text-align: right;">Total Selisih (Bruto):</th>
                          <th colspan="2" style="text-align: right;"></th>

                          <th colspan="" class="text-center">Rp. <?= number_format($total_selisih, 0, ',', '.'); ?></th> <!-- Menampilkan total selisih di tengah -->
                        </tr>
                      </tfoot>
                    </table>
                    <!-- Tombol Ekspor muncul setelah data ditampilkan -->
                    

                    <?php
                  }
                }
                ?>
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
