<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  $konstruktor ='admin_penjualan';
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
                <h3 class="card-title" style="color: white"><i class="nav-icon fas fa-money-bill-wave" style="color: white"></i> Penjualan </h3>
                </div>
                <div class="card-body">
                <a href="../admin_penjualan" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-chevron-left"></i> Kembali</a>
                <div class="row">
                    <div class="col-lg-6">
                    <table id="example1" class="table table-bordered table-striped table-sm">
                    <thead>
                      <tr>
                      <th>No</th>
                      <th>Data Buku</th>
                      <th>Qty</th>
                      <th>Harga Jual</th>
                      <th><center>Aksi</center></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no=1;
                    $sql_panggilstok = mysqli_query($koneksi, "SELECT * FROM tbl_stok ") or die(mysqli_error($koneksi));

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
                         
                          <td>Rp <?= number_format($data_stok['harga_jual'], 0, ',', '.'); ?></td>
                          <td>
                            <center>
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-tambah">
                                <i class="nav-icon fas fa-plus"></i> Tambah
                            </button>
                            </center>

                            
                          </td>
                        </tr>
                        <?php
                      }
                     }
                     ?>

                      
                    </tbody>
                    </table>
                    </div>
                        <?php
                        if (!isset($_GET['id'])) {
                          die("Parameter 'id' tidak ditemukan.");
                      }
                      
                      // Ambil ID dari parameter
                      $id = $_GET['id'];
                      
                      // Query untuk mendapatkan data berdasarkan ID
                      $qweri = mysqli_query($koneksi, "SELECT nomor, tgl, nama_pel FROM tbl_penjualan WHERE id='$id'") 
                          or die(mysqli_error($koneksi));
                      
                      // Periksa apakah data ditemukan
                      if (mysqli_num_rows($qweri) === 0) {
                          die("Data dengan ID '$id' tidak ditemukan.");
                      }
                      
                      // Ambil data dari hasil query
                      $data = mysqli_fetch_assoc($qweri);
                      $nomor = $data['nomor'];
                      $tanggal = $data['tgl'];
                      $nama_pel = $data['nama_pel'];
                      ?>  
                    
                    <div class="col-lg-6">
                    <table class="table table-bordered table-striped">
                            <tr>
                                <td width="35%">Nomor Nota</td>
                                <td><b><?= $nomor; ?></b></td>
                            </tr>
                            <tr>
                                <td  width="35%">Tanggal</td>
                                <td><b><?= $tanggal; ?></b></td>
                            </tr>
                            <tr>
                                <td  width="35%">Nama Pelanggan</td>
                                <td><b><?= $nama_pel; ?></b></td>
                            </tr>
                        </table>
                        <table id="example11" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Nota</th>
                                <th>Nama Buku</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                                <th>Diskon</th>
                            </tr>
                        </thead>
                          <tbody>
                              <?php
                              $no = 1;
                              // Ambil detail penjualan berdasarkan ID
                              $sql_panggilpj = mysqli_query($koneksi, "SELECT * FROM tbl_detail_penjualan WHERE id='$id'") or die(mysqli_error($koneksi));

                              if (mysqli_num_rows($sql_panggilpj) > 0) {
                                  while ($data = mysqli_fetch_array($sql_panggilpj)) {
                                      $kd_buku = $data['kd_buku'];
                                      $ambilnomor = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku='$kd_buku'") or die(mysqli_error($koneksi));
                                      $data_buku = mysqli_fetch_assoc($ambilnomor);
                                      $buku = $data_buku['judul_buku'];
                               ?>
                              <tr>
                                  <td><?= $no++; ?></td>
                                  <td><?= $nomor; ?></td>
                                  <td><?= $buku; ?></td>
                                  <td>
                                  <?php
                                  $qty = $data['qty'];
                                  echo $qty;
                                  ?>
                                  </td>
                                  <td>
                                  <?php 
                                      $harga = $data['harga'];
                                      echo "Rp. " . number_format($harga, 0, ',', '.');
                                  ?>
                                  </td>
                                  <td>
                                  <?php
                                      $subtotal = $jml * $harga;
                                      echo "Rp. " . number_format($subtotal, 0, ',', '.');
                                    
                                      $total += $subtotal;
                                      ?>
                                  </td>
                                  <td><?= $data['diskon']; ?></td>
                              </tr>
                              <?php
                                  }
                              } else {
                                  echo "<tr><td colspan='7' align='center'><h6>Tidak ditemukan Data detail penjualan</h6></td></tr>";
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
<div class="modal fade" id="modal-tambah">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#091057;">
        <h5 class="modal-title" style="color: white"><i class="nav-icon fas fa-plus"></i> Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" role="form" class="form-layout" enctype="multipart/form-data">
        
        <div class="form-group">
          <label for="nota">Nomor Nota</label>
          <input type="text" class="form-control" id="id" name="id" value="<?php echo $nomor_baru; ?>" readonly>
          <input type="text" class="form-control" id="id2" name="id2" hidden>
      </div>

          <div class="form-group">
            <label for="buku">Data Buku</label>
            <input type="text" class="form-control" id="buku" name="buku" readonly>
          </div>
            
          <div class="form-group">
            <label for="jumlah">stok</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="input jumlah buku" required>
          </div>

          <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" class="form-control" id="hrg" name="hrg" readonly>
        </div>

          <div class="form-group">
            <label for="kode">Nama Buku</label>
            <input type="text" class="form-control" id="nama" name="nama"  placeholder="input nama buku" required>
          
          </div>

          <div class="form-group">
            <label for="jml">QTY</label>
            <input type="number" class="form-control" id="qty" name="qty"  placeholder="input jumlah buku" required>    
          </div>

          <div class="form-group">
            <label for="jml">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga"  placeholder="input Harga buku" required>
          </div>
 
        
          <div class="form-group">
            <label for="diskon">Diskon (%)</label>
            <input type="number" class="form-control" id="diskon" name="diskon" placeholder="input diskon jika ada" min="0" max="100" value="0">
          </div>

        
        </form>
      </div>
      <div class="modal-footer justify-content-between-right">
        <button type="submit" name="tambah" class="btn btn-primary" id="btnTambah"><i class="nav-icon fas fa-download"></i> Tambah Data</button>
      </div>
    </div>
  </div>
</div>

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<?php
  include '../script.php';
  ?>
  <!-- <script type="text/javascript">
       $('#modal-tambah').on('show.bs.modal', function(e) {
    // Mendapatkan data dari tombol yang diklik (menggunakan data-atribut)
    var buku = $(e.relatedTarget).data('buku');
    var jumlah = $(e.relatedTarget).data('jumlah');
    var harga = $(e.relatedTarget).data('harga');
    var id = $(e.relatedTarget).data('id');

    // Mengisi data ke dalam form modal
    $(e.currentTarget).find('input[name="buku"]').val(buku);
    $(e.currentTarget).find('input[name="jumlah"]').val(jumlah);
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="hrg"]').val(harga);
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="id2"]').val(id);
});
</script> -->
</body>
</html>
