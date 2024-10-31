<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  require_once '../database/koneksi.php';
  $konstruktor ='admin_master_buku';
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
  <aside class="main-sidebar sidebar-dark-warning elevation-4" style="background-color: #024CAA;">
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
        <div class="row-mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Master Data Buku</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
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
                <h3 class="card-title" style="color: white"><i class="nav-icon fas fa-book"></i> Data Buku</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="nav-icon fas fa-plus"></i> Tambah Data</button>

              <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-import"><i class="nav-icon fas fa-file-excel"></i> Import Data
              </button>

                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th>Kategori Buku</th>
                    <th>Nomor ISBN</th>
                    
                    <th width="15%"><center>Aksi</center></th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no=1;
                    $sql_panggilbuku = mysqli_query($koneksi, "SELECT * FROM tbl_buku") or die(mysqli_error($koneksi));


                    if(mysqli_num_rows($sql_panggilbuku) > 0)
                    {
                      while($data=mysqli_fetch_array($sql_panggilbuku))
                      {
                        ?>
                        <tr>
                          <td>
                            <?=$no++;?>
                          </td>
                          <td>
                            <?=$data['kd_buku'];?>
                          </td>
                          <td>
                            <?=$data['judul_buku'];?>
                          </td>
                          <td>
                            <?php
                            $idkategori = $data['id_kategori'];

                            $ambilnamakategori = mysqli_query($koneksi, "SELECT kategori FROM tbl_kategori WHERE id_kategori='$idkategori'") or die (mysqli_error($koneksi));

                            $data_kategori = mysqli_fetch_assoc($ambilnamakategori);
                            $kategori = $data_kategori['kategori'];
                            ?>

                            <?=$kategori;?>
                      
                          </td>
                          <td>
                            <?=$data['isbn'];?>
                          </td>
                          
                          <td>
                            <center>
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default" data-kd_buku="<?=$data['kd_buku'];?>"><i class="nav-icon fas fa-trash"></i> Hapus</button>

                          <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-edit" data-kd_buku="<?=$data['kd_buku'];?>" 
                          data-judul_buku="<?=$data['judul_buku'];?>" 
                          data-id_kategori="<?=$data['id_kategori'];?>" 
                          data-isbn="<?=$data['isbn'];?>" 
                          data-penerbit="<?=$data['penerbit'];?>" 
                          data-tahun="<?=$data['tahun'];?>" 
                          data-jml="<?=$data['jml_hal'];?>" 
                          data-cetakan="<?=$data['cetakan'];?>"> 
                          <i class="nav-icon fas fa-edit"></i> Edit
                            </button>
                            </center>
                          </td>
                        </tr>

                        <?php

                      }
                    }
                    else
                    {
                      echo "<tr><td colspan=\"9\" align=\"center\"><h6>Tidak ditemukan Data periode pada database</h6></td></tr>";

                    }

                    ?>
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            
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
              <input type="text" name="kodebuku" id="kodebuku" hidden>
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
              <label for="kode">Kode Buku</label>
              <input type="text" class="form-control" id="kodebuku" name="kodebuku" placeholder="input kode buku" required>
             </div>

             <div class="form-group">
              <label for="judul">Judul Buku</label>
              <input type="text" class="form-control" id="judul" name="judul" placeholder="input nama judul buku" required>
             </div>

             <div class="form-group">
              <label for="kategori">Nama Kategori Buku</label>
              <select class="form-control" name="kategori" required>
                <option value=""> -- Pilih Kategori Buku --</option>
                <?php
                $pglkategori = mysqli_query($koneksi, "SELECT * FROM tbl_kategori") or die(mysqli_error($koneksi));

                $rvkategori = mysqli_num_rows($pglkategori);

                if($rvkategori>0){
                  while($dt_kategori=mysqli_fetch_array($pglkategori)){
                    ?>
                    <option value ="<?=$dt_kategori['id_kategori'];?>">
                      <?=$dt_kategori['id_kategori'];?> -
                      <?=$dt_kategori['kategori'];?>
                    </option>
                    <?php
                  }
                }
                else{

                }
                ?>
              </select>
             </div>

             <div class="form-group">
              <label for="isbn">Nomor ISBN</label>
              <input type="text" class="form-control" id="isbn" name="isbn" placeholder="input nomor isbn buku" required>
             </div>

             <div class="form-group">
              <label for="tahun">Tahun</label>
              <input type="text" class="form-control" id="tahun" name="tahun" placeholder="input tahun terbit" required>
             </div>

             <div class="form-group">
              <label for="penerbit">Penerbit</label>
              <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="input nama penerbit buku" required>
             </div>

             <div class="form-group">
              <label for="jml">Jumlah halaman</label>
              <input type="number" class="form-control" id="jml" name="jml" placeholder="input jumlah halaman" required>
             </div>

             <div class="form-group">
              <label for="jml">Cetakan Ke</label>
              <input type="number" class="form-control" id="cetakan" name="cetakan" placeholder="input cetakan buku ke berapa" required>
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

      <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background-color:#091057;">
              <h4 class="modal-title" style="color:white">Edit Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="edit.php"  role="form" class="form-layout" method="post" enctype="multipart/form-data">
              
              <div class="form-group">
              <label for="kode">Kode Buku</label>
              <input type="text" class="form-control" id="kodebukuterpilih" name="kodebukuterpilih" disabled>
              <input type="text" class="form-control" id="kodebukuterpilih2" name="kodebukuterpilih2" hidden>
             </div>

             <div class="form-group">
              <label for="judul">Judul Buku</label>
              <input type="text" class="form-control" id="judulbukuterpilih" name="judulbukuterpilih" required>
             </div>

             <div class="form-group">
              <label for="kategori">Nama Kategori Buku</label>
              <select class="form-control" name="kategoriterpilih" required>
                <option value=""> -- Pilih Kategori Buku --</option>
                <?php
                $pglkategori = mysqli_query($koneksi, "SELECT * FROM tbl_kategori") or die(mysqli_error($koneksi));

                $rvkategori = mysqli_num_rows($pglkategori);

                if($rvkategori>0){
                  while($dt_kategori=mysqli_fetch_array($pglkategori)){
                    ?>
                    <option value ="<?=$dt_kategori['id_kategori'];?>">
                      <?=$dt_kategori['id_kategori'];?> -
                      <?=$dt_kategori['kategori'];?>
                    </option>
                    <?php
                  }
                }
                else{

                }
                ?>
              </select>
             </div>

             <div class="form-group">
              <label for="isbn">Nomor ISBN</label>
              <input type="text" class="form-control" id="isbnterpilih" name="isbnterpilih" required>
             </div>

             <div class="form-group">
              <label for="tahun">Tahun</label>
              <input type="text" class="form-control" id="tahun" name="tahun" required>
             </div>

             <div class="form-group">
              <label for="penerbit">Penerbit</label>
              <input type="text" class="form-control" id="penerbitterpilih" name="penerbitterpilih" required>
             </div>

             <div class="form-group">
              <label for="jml">Jumlah Halaman</label>
              <input type="number" class="form-control" id="jumlahterpilih" name="jumlahterpilih" required>
             </div>

             <div class="form-group">
              <label for="jml">Cetakan</label>
              <input type="number" class="form-control" id="cetakanterpilih" name="cetakanterpilih" required>
             </div>

            </div>
            <div class="modal-footer justify-content-between-right">
              <button type="submit" name="edit" class="btn btn-primary"><i class="nav-icon fas fa-edit"></i>Edit Data</button>
            </form>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <div class="modal fade" id="modal-import">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Modal Import</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <a href="download.php?filename=template_buku.xls" class="btn btn-sm btn-secondary"><i class="nav-icon fas fa-file"></i> Download Template Import Excel </a>
              <br>
              <br>
              <form action="import.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="import"> Import File Excel </label>
                  <input type="file" id="import" name="file" placeholder="Ambil file excel" accept="application/vnd.ms.excel" class="form-control">
              
            </div>
            <div class="modal-footer pull-right">
              
              <button type="submit" class="btn btn-success" name="importbuku"><i class="nav-icon fas fa-download"></i>Import file dosen</button>
            </div>
          </form>
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
          var kd_buku = $(e.relatedTarget).data('kd_buku');
          

          $(e.currentTarget).find('input[name="kodebuku"]').val(kd_buku);

        });
</script>

<script type="text/javascript">
        $('#modal-edit').on('show.bs.modal', function(e){
          
          //get data
          var kd_buku        = $(e.relatedTarget).data('kd_buku');
          var judul_buku     = $(e.relatedTarget).data('judul_buku');
          var id_kategori    = $(e.relatedTarget).data('id_kategori');
          var isbn           = $(e.relatedTarget).data('isbn');
          var tahun          = $(e.relatedTarget).data('tahun');
          var penerbit       = $(e.relatedTarget).data('penerbit');
          var jml            = $(e.relatedTarget).data('jml');
          var cetakan        = $(e.relatedTarget).data('cetakan');

          $(e.currentTarget).find('input[name="kodebukuterpilih"]').val(kd_buku);
          $(e.currentTarget).find('input[name="kodebukuterpilih2"]').val(kd_buku);
          $(e.currentTarget).find('input[name="judulbukuterpilih"]').val(judul_buku);
          $(e.currentTarget).find('select[name="kategoriterpilih"]').val(id_kategori);    
          $(e.currentTarget).find('input[name="isbnterpilih"]').val(isbn);
          $(e.currentTarget).find('input[name="tahun"]').val(tahun);
          $(e.currentTarget).find('input[name="penerbitterpilih"]').val(penerbit);
          $(e.currentTarget).find('input[name="jumlahterpilih"]').val(jml);
          $(e.currentTarget).find('input[name="cetakanterpilih"]').val(cetakan);

        });
</script>

</body>
</html>
