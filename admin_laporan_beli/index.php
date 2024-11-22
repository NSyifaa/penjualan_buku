<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  $konstruktor ='admin_laporan_beli';
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
            <div class="col lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                    <h5><i class="nav-icon fas fa-file-alt"></i> Laporan Pembelian </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                            <label for="suplier">Nama Supplier:</label>
                            <form action="" method="post">
                                    <select class="form-control" name="suplier" required>
                                        <option value="">--Pilih Supplier--</option>
                                        <?php
                                        $pgl = mysqli_query($koneksi, "SELECT * FROM tbl_supplier") or die(mysqli_error($koneksi));
                                        if (mysqli_num_rows($pgl) > 0) {
                                            while ($dt_sup = mysqli_fetch_array($pgl)) {
                                                ?>
                                                <option value="<?= $dt_sup['kode_sup']; ?>">
                                                    <?= $dt_sup['kode_sup']; ?> - <?= $dt_sup['nama_suplier']; ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                            </div>
                            
                            <div class="col-lg-3">
                            <label for="tanggal_mulai">Tanggal Mulai:</label>
                            <input type="date" class="form-control" name="tanggal_mulai" required>
                            </div>
                            
                            <div class="col-lg-3">
                            <label for="tanggal_akhir">Tanggal Akhir:</label>
                            <input type="date" class="form-control" name="tanggal_akhir" required>
                            </div>

                            <div class="col-lg-3 d-flex align-items-end">
                            <button class="btn btn-info btn-block" type="submit" name="cari">
                                 <i class="nav-icon fas fa-search"></i> Cari Data
                             </button>
                             
                            </div>

                        </div>
                        </form>
                        
                        <?php
                        
                             if (isset($_POST['cari'])) {
                                $tanggal_mulai = mysqli_real_escape_string($koneksi, $_POST['tanggal_mulai']);
                                $tanggal_akhir = mysqli_real_escape_string($koneksi, $_POST['tanggal_akhir']);
                                $kode_supplier = mysqli_real_escape_string($koneksi, $_POST['suplier']);

                                if ($tanggal_mulai > $tanggal_akhir) {
                                  echo "<script>alert('Tanggal Mulai tidak boleh lebih dari Tanggal Akhir!');</script>";
                              } else {
                                  // Kueri untuk mengambil data berdasarkan tanggal dan kode supplier
                                  $ambil = mysqli_query($koneksi, 
                                      "SELECT * FROM tbl_po 
                                       WHERE kode_sup='$kode_supplier' 
                                       AND tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'") 
                                       or die(mysqli_error($koneksi));
                                
                                       
                             ?>
                             <br>
                             <br>
                             <?php if (mysqli_num_rows($ambil) > 0): ?>
                            <div class="mt-3 mb-3">
                                <a href="excel.php?tanggal_mulai=<?= $tanggal_mulai ?>&tanggal_akhir=<?= $tanggal_akhir ?>&kode_supplier=<?= $kode_supplier ?>" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i> Export Excel
                                </a>
                                <a href="pdf.php?tanggal_mulai=<?= $tanggal_mulai ?>&tanggal_akhir=<?= $tanggal_akhir ?>&kode_supplier=<?= $kode_supplier ?>" class="btn btn-danger">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            </div>
                        <?php endif; ?>
                        <table id="example1" class="table table-bordered table-striped table-sm mt-4">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tanggal PO</th>
                                    <th>Nomor PO</th>
                                    <th>Supplier</th>
                                    <th>Total Pembelian</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no =1;
                                
                                if (mysqli_num_rows($ambil) > 0) {
                                  while ($data = mysqli_fetch_array($ambil)) {
                                 ?>
                                   
                                <tr>
                                    <td><?=$no++;?></td>
                                    <td><?=$data['tanggal'];?></td>
                                    <td> <?=$data['id_po'];?></td>
                                    <td> 
                                    <?php
                                    $idsupplier = $data['kode_sup'];

                                    $ambilnamasupp = mysqli_query($koneksi, "SELECT nama_suplier FROM tbl_supplier WHERE kode_sup='$idsupplier'") or die (mysqli_error($koneksi));

                                    $data_supp = mysqli_fetch_assoc($ambilnamasupp);
                                    $supp = $data_supp['nama_suplier'];
                                    ?>

                                    <?=$supp;?>
                                    </td>
                                    <td>
                                    <?php 
                                      $total = $data['total'];
                                      echo "Rp. " . number_format($total, 0, ',', '.');
                                  ?>

                                    </td>
                                </tr>
                                 <?php
                                    }
                                }else {
                                      echo "<tr><td colspan='5'>Tidak ada data yang ditemukan!</td></tr>";
                                  }

                                ?>
                            </tbody>
                        </table>
                            <?php
                             }
                            }
                            ?>
                    </div>

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
