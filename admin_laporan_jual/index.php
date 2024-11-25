<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Penjualan</title>
  <?php
  session_start();
  $konstruktor = 'admin_laporan_jual';
  require_once '../database/koneksi.php';

  if (isset($_SESSION['status'])) {
    $status = $_SESSION['status'];
    if ($status != 0) {
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
      include '../sidebar.php';
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
                $tanggal_mulai = '2024-11-15';
                $tanggal_akhir = '2024-11-25';
                 $query_penjualan = "
                 SELECT 
                  p.tgl AS tanggal,
                  p.nomor AS nomor_penjualan FROM 
                  tbl_penjualan p
                  WHERE 
                  p.tgl BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'
                 ";

                 $ambil_penjualan = mysqli_query($koneksi, $query_penjualan) or die(mysqli_error($koneksi));
                
                   ?>
                <br><br>
                <table id="example1" class="table table-bordered table-striped table-sm mt-4">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>Tanggal</th>
                      <th>Nomor Penjualan</th>
                      <th>Qty</th>
                      <th>Harga Beli</th>
                      <th>Harga Jual</th>
                      <th>Selisih</th>
                      <th>Total Selisih</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $total_selisih = 0;

                    if (mysqli_num_rows($ambil_penjualan) > 0) {
                      while ($data_penjualan = mysqli_fetch_array($ambil_penjualan)) {
                        // Ambil data qty dan harga beli dari tbl_po
                        $nomor_penjualan = $data_penjualan['id_po'];
                        $query_po = "
                        SELECT 
                            qty,
                            harga_beli,
                            harga_jual
                        FROM 
                            tbl_stok 
                        WHERE 
                            no_po = '$nomor_penjualan'
                        ";

                        $ambil_po = mysqli_query($koneksi, $query_po) or die(mysqli_error($koneksi));
                        $data_po = mysqli_fetch_array($ambil_po);

                        // Hitung selisih dan total selisih
                        $harga_jual = $data_penjualan['harga_jual'];
                        $harga_beli = $data_po['harga_beli'];
                        $qty = $data_po['qty'];

                        $selisih = $harga_jual - $harga_beli;
                        $total_selisih_per_item = $selisih * $qty;

                        // Akumulasi total selisih
                        $total_selisih += $total_selisih_per_item;
                    ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $data_penjualan['tanggal']; ?></td>
                      <td><?= $data_penjualan['id_po']; ?></td>
                      <td><?= $qty; ?></td>
                      <td>Rp. <?= number_format($harga_beli, 0, ',', '.'); ?></td>
                      <td>Rp. <?= number_format($harga_jual, 0, ',', '.'); ?></td>
                      <td>Rp. <?= number_format($selisih, 0, ',', '.'); ?></td>
                      <td>Rp. <?= number_format($total_selisih_per_item, 0, ',', '.'); ?></td>
                    </tr>
                    <?php
                      }
                    } else {
                      echo "<tr><td colspan='8'>Tidak ada data yang ditemukan!</td></tr>";
                    }
                    ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="7" style="text-align: right;">Total Selisih:</th>
                      <th>Rp. <?= number_format($total_selisih, 0, ',', '.'); ?></th>
                    </tr>
                  </tfoot>
                </table>
                <?php
                if (isset($_POST['cari'])) {
                  

                  if ($tanggal_mulai > $tanggal_akhir) {
                    echo "<script>alert('Tanggal Mulai tidak boleh lebih dari Tanggal Akhir!');</script>";
                  } else {
                    // Query untuk mengambil data penjualan
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
