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
              <?php
                  $id = $_GET['id'];
                  $sql_stok = mysqli_query($koneksi, "SELECT nomor, tgl, nama_pel FROM tbl_penjualan WHERE id='$id'") 
                  or die(mysqli_error($koneksi));
                  $data = mysqli_fetch_assoc($sql_stok);
                  $nomor = $data['nomor'];
                  $tanggal = $data['tgl'];
                  $nama_pel = $data['nama_pel'];

              ?>
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
                              $no_po = $data_stok['no_po']; 
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
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-tambah" 
                            data-id="<?= $id;?>"
                            data-no_po="<?= $no_po;?>"
                            data-nomor="<?= $nomor;?>"
                            data-nama_buku="<?= $nama_buku;?>"
                            data-kd_buku="<?= $kd_buku;?>"
                            data-stok="<?= $data_stok['qty'];?>"
                            data-harga="<?= $data_stok['harga_jual'];?>"
                            >
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
                       
                      
                      
                      // Query untuk mendapatkan data berdasarkan ID
                      
                      // Ambil data dari hasil query
                      
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                          <tbody>
                              <?php
                              $no = 1;
                              // Ambil detail penjualan berdasarkan ID
                              $sql_panggilpj = mysqli_query($koneksi, "SELECT * FROM tbl_detail_penjualan WHERE nomor='$nomor'") or die(mysqli_error($koneksi));
                              $total = 0;
                              if (mysqli_num_rows($sql_panggilpj) > 0) {
                                  while ($data_pj = mysqli_fetch_array($sql_panggilpj)) {
                                      $kd_buku = $data_pj['kd_buku'];
                                      $ambilnomor = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku='$kd_buku'") or die(mysqli_error($koneksi));
                                      $data_buku = mysqli_fetch_array($ambilnomor);
                                      $buku = $data_buku['judul_buku'];
                               ?>
                              <tr>
                                  <td><?= $no++; ?></td>
                                  <td><?= $nomor; ?></td>
                                  <td><?= $buku; ?></td>
                                  <td>
                                  <?php
                                  $qty = $data_pj['qty'];
                                  echo $qty;
                                  ?>
                                  </td>
                                  <td>
                                  <?php 
                                      $harga = $data_pj['harga'];
                                      echo "Rp. " . number_format($harga, 0, ',', '.');
                                  ?>
                                  </td>
                                  <td>
                                  <?php
                                      $subtotal = $qty * $harga;
                                      echo "Rp. " . number_format($subtotal, 0, ',', '.');
                                    
                                      $total += $subtotal;
                                      ?>
                                  </td>
                                  <td><?= $data_pj['diskon']; ?></td>
                                  <td>
                                  <form action="" method="post" role="form" class="form-layout" enctype="multipart/form-data">

                                  <input type="text" class="form-control" id="id" name="idpj" value="<?= $id;?>" hidden>
                                  <input type="text" class="form-control" id="qty" name="qty" value="<?= $data_pj['qty'];?>" hidden>
                                  <input type="text" class="form-control" id="id" name="id" value="<?= $data_pj['id'];?>" hidden>
                                  <input type="text" class="form-control" id="kd_buku" name="kd_buku" value="<?= $data_pj['kd_buku'];?>" hidden>
                                  <button type="submit" name="hapus" class="btn btn-danger" id="hapus"><i class="nav-icon fas fa-trash"></i> Cancel</button>
                                  </form>

                                  </td>
                              </tr>
                              <?php
                                  }
                              } else {
                                  echo "<tr><td colspan='8' align='center'><h6>Tidak ditemukan Data detail penjualan</h6></td></tr>";
                              }
                              ?>
                          </tbody>
                      </table>
                      <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-bayar" 
                      data-total="<?= $total;?>"
                           
                            >
                      <i class="nav-icon fas fa-plus"></i> Bayar
                      </button>
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
        
        
          <input type="text" class="form-control" id="id" name="id" hidden>
          <input type="text" class="form-control" id="no_po" name="no_po" hidden>
          <input type="text" class="form-control" id="nomor" name="nomor" hidden>
          <input type="text" class="form-control" id="kd_buku" name="kd_buku" hidden>
   

          <div class="form-group">
            <label for="buku">Data Buku</label>
            <input type="text" class="form-control" id="buku" name="buku" readonly>
          </div>
            
          <div class="form-group">
            <label for="jumlah">stok</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" readonly>
          </div>

          <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" class="form-control" id="hrg" name="hrg" readonly>
        </div>

          <div class="form-group">
            <label for="jml">QTY</label>
            <input type="number" class="form-control" id="qty" name="qty"  placeholder="input jumlah buku">    
          </div>
        
      </div>
      <div class="modal-footer justify-content-between-right">
        <button type="submit" name="tambah" class="btn btn-primary" id="btnTambah"><i class="nav-icon fas fa-download"></i> Tambah Data</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-bayar">
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
        
        
          <input type="text" class="form-control" id="id" name="id" hidden>
          <input type="text" class="form-control" id="no_po" name="no_po" hidden>
          <input type="text" class="form-control" id="nomor" name="nomor" hidden>
          <input type="text" class="form-control" id="kd_buku" name="kd_buku" hidden>
   

          <div class="form-group">
            <label for="buku">TOTAL</label>
            <input type="text" class="form-control" id="total" name="total" readonly>
          </div>
            
          <div class="form-group">
            <label for="jml">Bayar</label>
            <input type="number" class="form-control" id="bayat" name="bayat"  placeholder="input uang bayar">    
          </div>
        
      </div>
      <div class="modal-footer justify-content-between-right">
        <button type="submit" name="tambah" class="btn btn-primary" id="btnTambah"><i class="nav-icon fas fa-download"></i> Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- REQUIRED SC[RIPTS -->
<?php
if(isset($koneksi, $_POST['tambah'])){
  //tampung nilai inputan
  
  $id       = trim(mysqli_escape_string($koneksi, $_POST['id']));
  $stok     = trim(mysqli_escape_string($koneksi, $_POST['jumlah']));
  $qty      = trim(mysqli_escape_string($koneksi, $_POST['qty']));
  if ($stok < $qty) {
    echo '
    <script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
    <script>
    swal("Peringatan", "Stok kurang", "warning");

    setTimeout(function(){
        window.location.href ="detail.php?id='.$id.'";
    }, 2000);
    </script>';
  }else{
    $no_po    = trim(mysqli_escape_string($koneksi, $_POST['no_po']));
    $nomor    = trim(mysqli_escape_string($koneksi, $_POST['nomor']));
    $kodebuku = trim(mysqli_escape_string($koneksi, $_POST['kd_buku']));
    $harga    = trim(mysqli_escape_string($koneksi, $_POST['hrg']));
    $subtotal = $qty * $harga;
    $stok2    = $stok - $qty;
    $diskon = 0;
    $querycek = mysqli_query($koneksi, "INSERT INTO tbl_detail_penjualan VALUES (NULL,'$nomor', '$kodebuku', '$qty', '$harga', '$subtotal', '$diskon')") or die(mysqli_error($koneksi));
    $queryup = mysqli_query($koneksi, "UPDATE tbl_stok SET qty='$stok2' WHERE no_po='$no_po' AND kd_buku='$kodebuku'") or die(mysqli_error($koneksi));
    echo '
    <script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
    <script>
    swal("Berhsil", "tambah barang berhasil", "success");

    setTimeout(function(){
        window.location.href ="detail.php?id='.$id.'";
    }, 2000);
    </script>';
    }
  }

  //cancel
if(isset($koneksi, $_POST['hapus'])){
  //tampung nilai inputan
  
  $idpj       = trim(mysqli_escape_string($koneksi, $_POST['idpj']));
  $id       = trim(mysqli_escape_string($koneksi, $_POST['id']));
  $qty       = trim(mysqli_escape_string($koneksi, $_POST['qty']));
  $kodebuku       = trim(mysqli_escape_string($koneksi, $_POST['kd_buku']));
  $querydelete = mysqli_query($koneksi, "DELETE FROM tbl_detail_penjualan WHERE id='$id'") or die(mysqli_error($koneksi));

  $sqlstok = mysqli_query($koneksi, "SELECT qty FROM tbl_stok WHERE kd_buku='$kodebuku'") or die(mysqli_error($koneksi));
  $data_stok = mysqli_fetch_array($sqlstok);
  $stok = $data_stok['qty'];
  $stok2    = $stok + $qty;

  $queryup = mysqli_query($koneksi, "UPDATE tbl_stok SET qty='$stok2' WHERE kd_buku='$kodebuku'") or die(mysqli_error($koneksi));
  echo '
    <script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
    <script>
    swal("Berhsil", "Barang tidak jadi ditambah", "success");

    setTimeout(function(){
        window.location.href ="detail.php?id='.$idpj.'";
    }, 2000);
    </script>';
  }
  
?>
<!-- jQuery -->
<?php
  include '../script.php';
  ?>
  <script type="text/javascript">
    $('#modal-tambah').on('show.bs.modal', function(e) {
    // Mendapatkan data dari tombol yang diklik (menggunakan data-atribut)
    var id = $(e.relatedTarget).data('id');
    var no_po = $(e.relatedTarget).data('no_po');
    var nomor = $(e.relatedTarget).data('nomor');
    var kd_buku = $(e.relatedTarget).data('kd_buku');
    var buku = $(e.relatedTarget).data('nama_buku');
    var jumlah = $(e.relatedTarget).data('stok');
    var harga = $(e.relatedTarget).data('harga');

    // Mengisi data ke dalam form modal
    $(e.currentTarget).find('input[name="id"]').val(id);
    $(e.currentTarget).find('input[name="no_po"]').val(no_po);
    $(e.currentTarget).find('input[name="nomor"]').val(nomor);
    $(e.currentTarget).find('input[name="kd_buku"]').val(kd_buku);
    $(e.currentTarget).find('input[name="buku"]').val(buku);
    $(e.currentTarget).find('input[name="jumlah"]').val(jumlah);
    $(e.currentTarget).find('input[name="hrg"]').val(harga);
});
</script>
  <script type="text/javascript">
    $('#modal-bayar').on('show.bs.modal', function(e) {
    // Mendapatkan data dari tombol yang diklik (menggunakan data-atribut)
   
    var total = $(e.relatedTarget).data('total');

    // Mengisi data ke dalam form modal
    $(e.currentTarget).find('input[name="total"]').val(total);
});
</script>
</body>
</html>
