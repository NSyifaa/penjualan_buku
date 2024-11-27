<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  $konstruktor = 'admin_laporan_detail';
  require_once '../database/koneksi.php';

  if (isset($_SESSION['status'])) {
      $status = $_SESSION['status'];
      if ($status != 0) {
          echo '<script>window.location = "../auth/logout.php"</script>';
      }
  } else {
      echo '<script>window.location = "../auth/logout.php"</script>';
  }

  $queryPO = mysqli_query($koneksi, "SELECT * FROM tbl_po") or die(mysqli_error($koneksi));
  $poList = [];
  while ($po = mysqli_fetch_assoc($queryPO)) {
      $supplierQuery = mysqli_query($koneksi, "SELECT nama_suplier FROM tbl_supplier WHERE kode_sup = '{$po['kode_sup']}'") or die(mysqli_error($koneksi));
      $supplier = mysqli_fetch_assoc($supplierQuery);
      $poList[] = [
          'id_po' => $po['id_po'],
          'tanggal' => $po['tanggal'],
          'supplier' => $supplier['nama_suplier']
      ];
  }

  $poDetails = [];
  $selectedPO = '';
  if (isset($_POST['modalPO'])) {
      $selectedPO = $_POST['modalPO'];
      $queryDetail = mysqli_query($koneksi, "SELECT * FROM tbl_po_detail WHERE id_po = '$selectedPO'") or die(mysqli_error($koneksi));
      while ($row = mysqli_fetch_assoc($queryDetail)) {
          $poDetails[] = $row;
      }
  }
  ?>
  <?php include '../listlink.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <?php include '../navbar.php'; ?>
  </nav>

  <aside class="main-sidebar sidebar-dark-warning elevation-4" style="background-color: #024CAA">
    <a href="index3.html" class="brand-link">
      <img src="../auth/assets/img/logobk.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Toko Buku Mayang</span>
    </a>
    <div class="sidebar">
      <?php include '../sidebar.php'; ?>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid"></div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon fas fa-file-alt"></i> Laporan Detail Pembelian</h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#poModal">Cari Nomor PO</button>
                </div>

                <?php if (!empty($poDetails)) : ?>
                  <br><br>
                  <div class="col-lg-6">
                    <table class="table table-sm table-borderless table-striped">
                      <tr>
                        <td width="35%">Nomor PO</td>
                        <td width="2%">:</td>
                        <td><b><?= $selectedPO; ?></b></td>
                      </tr>
                      <tr>
                        <td width="35%">Tanggal PO</td>
                        <td width="2%">:</td>
                        <td><b><?= $poList[array_search($selectedPO, array_column($poList, 'id_po'))]['tanggal']; ?></b></td>
                      </tr>
                    </table>
                  </div>

                  <!-- Tombol Ekspor -->
                  <div class="mb-3">
                    <a href="export_excel.php?id_po=<?= urlencode($selectedPO); ?>" class="btn btn-success btn-sm">Ekspor ke Excel</a>
                    <a href="export_pdf.php?id_po=<?= urlencode($selectedPO); ?>" class="btn btn-danger btn-sm">Ekspor ke PDF</a>
                  </div>
                  <table id="example1" class="table table-bordered table-striped table-sm mt-4">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Qty Datang</th>
                        <th>Harga Datang</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; ?>
                      <?php foreach ($poDetails as $detail) : ?>
                        <tr>
                          <td><?= $no++; ?></td>
                          <td>
                            <?php
                            $kd_buku = $detail['kd_buku'];
                            $ambilnomor = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku='$kd_buku'") or die(mysqli_error($koneksi));
                            $data_buku = mysqli_fetch_assoc($ambilnomor);
                            $buku = $data_buku['judul_buku'];
                            ?>
                            <?= $buku; ?>
                          </td>
                          <td><?= $detail['jumlah']; ?></td>
                          <td><?= number_format($detail['harga'], 2, ',', '.'); ?></td>
                          <td><?= $detail['qty_dtg']; ?></td>
                          <td><?= number_format($detail['harga_dtg'], 2, ',', '.'); ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="poModal" tabindex="-1" role="dialog" aria-labelledby="poModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #091057;">
          <h5 class="modal-title" style="color: white" id="poModalLabel">Pilih Nomor PO</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="">
          <table id="example1" class="table table-bordered table-striped table-sm mt-4">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Nomor PO</th>
                  <th>Supplier</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                <?php foreach ($poList as $po) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $po['tanggal']; ?></td>
                    <td><?= $po['id_po']; ?></td>
                    <td><?= $po['supplier']; ?></td>
                    <td>
                      <button type="submit" name="modalPO" value="<?= $po['id_po']; ?>" class="btn btn-sm btn-primary">Tampilkan</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include '../footer.php'; ?>
</div>

<?php include '../script.php'; ?>
</body>
</html> 