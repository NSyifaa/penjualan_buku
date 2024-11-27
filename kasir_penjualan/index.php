<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  $konstruktor ='kasir_penjualan';
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
         <div class="col-lg-12">
            <div class="card">
                <div class="card-header" style="background-color: #091057;">
                <h3 class="card-title" style="color: white"><i class="nav-icon fas fa-money-bill-wave" style="color: white"></i> Penjualan </h3>
                </div>
                <div class="card-body">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="nav-icon fas fa-plus"></i> Tambah Data</button>

                        <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nomor Nota</th>
                            <th>Nama Pelanggan</th>
                            <th>Jumlah Bayar</th>
                            <th>Kembali</th>
                            <th><center>Status</center></th>
                            <th width="30%"><center>Aksi</center></th>
                            
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no=1;
                            $sql_panggil = mysqli_query($koneksi, "SELECT * FROM tbl_penjualan ORDER BY  nomor DESC") or die(mysqli_error($koneksi));


                                if(mysqli_num_rows($sql_panggil) > 0)
                                {
                                while($data=mysqli_fetch_array($sql_panggil))
                                {
                                ?>
                                <tr>
                                <td>
                                   <?=$no++;?>
                                </td>
                               
                                <td>
                                   <?=$data['tgl'];?>
                                </td>
                                <td>
                                   <?=$data['nomor'];?>
                                </td>
                                <td>
                                <?=$data['nama_pel'];?>
                                </td>
                                <td>
                                <?php 
                                      $jml = $data['jml_byr'];
                                      echo "Rp. " . number_format($jml, 0, ',', '.');
                                  ?>
                                
                                </td>
                                <td>
                                <?php 
                                      $kembali = $data['kembali'];
                                      echo "Rp. " . number_format($kembali, 0, ',', '.');
                                  ?>
                                <td>
                                <?php
                                    // Mengubah nilai status menjadi deskripsi
                                    if ($data['status'] == 0) {
                                      ?>
                                      <center>
                                        <button class="btn btn-sm btn-warning">Barang Kosong
                                        </button>
                                      </center>
                                        <?php
                                    } elseif ($data['status'] == 1) {
                                      ?>
                                      <center>
                                        <button class="btn btn-sm btn-danger">Belum dibayar
                                        </button>
                                      </center>
                                        <?php
                                    } elseif ($data['status'] == 2) {
                                      ?>
                                      <center>
                                        <button class="btn btn-sm btn-success">Lunas
                                        </button>
                                      </center>
                                        <?php
                                    } else {
                                        echo "Status Tidak Diketahui"; // Jaga-jaga jika ada nilai status selain 0, 1, atau 2
                                    }
                                    ?>
                                </td>
                                <td> 
                                    <center>
                                    <div class="d-flex justify-content-center gap-2">
                                   <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default" data-id="<?=$data['id'];?>"><i class="nav-icon fas fa-trash"></i> Hapus</button>

                                   <a href="detail.php?id=<?=$data['id'];?>" 
                                   class= "btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i> Detail </a>
                                    
                                    <?php if ($data['status'] === '2'): ?>
                                      <!-- Tombol Cetak Nota -->
                                      <a href="cetak.php?id=<?= $data['id']; ?>" target="_blank" class="btn btn-sm btn-success">
                                          <i class="nav-icon fas fa-print"></i> Cetak Nota
                                      </a>
                                  <?php endif; ?>
                                  </center>
                                    </div>
                                </td>
                                </tr>  
                                <?php

                                }
                                }
                                else
                                {
                                echo "<tr><td colspan=\"8\" align=\"center\"><h6>Tidak ditemukan Data periode pada database</h6></td></tr>";

                                }

                                ?>   
                        </tbody>
                        </table>
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
<div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <form role="form" class="form-layout" action="proseshapus.php" method="post">
              <p><b> Anda akan menghapus data? </b></p>
              <input type="text" name="id" id="id" hidden >
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Tutup</button>
              <button type="submit" class="btn btn-danger btn-sm"><i class="nav-icon fas fa-trash"></i> Ya, Hapus Data</button>
            </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

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
              <form action="tambah.php"  role="form" class="form-layout" method="post" enctype="multipart/form-data">

              <div class="form-group">
              <label for="tgl">Tanggal</label>
              <input type="date" class="form-control" id="tgl" name="tgl" required>
             </div>

             <div class="form-group">
              <label for="nama">Nama Pelanggan</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="input nama pelanggan" required>
             </div>


            
            </div>
            <div class="modal-footer justify-content-between-right">
              <button type="submit" name="tambah" class="btn btn-primary"><i class="nav-icon fas fa-download"></i> Tambah Data</button>
            </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<?php
  include '../script.php';
  ?>
  <script type="text/javascript">
        $('#modal-default').on('show.bs.modal', function(e){
          
          //get data
          var id = $(e.relatedTarget).data('id');
          

          $(e.currentTarget).find('input[name="id"]').val(id);

        });
</script>
</body>
</html>
