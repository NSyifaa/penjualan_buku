<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  require_once '../database/koneksi.php';
  $konstruktor ='admin_master_kasir';
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
  <aside class="main-sidebar sidebar-dark-warning elevation-4" style="background-color: #024CAA">
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
            <h1 class="m-0">Data Administrator</h1>
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
                <h3 class="card-title" style="color: white"><i class="nav-icon fas fa-file"></i> Data Admin</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="nav-icon fas fa-plus"></i> Tambah Data</button>
             

                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Username</th>
                    <th><center>Aksi</center></th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no=1;
                    $sql_panggilpengguna = mysqli_query($koneksi, "SELECT * FROM tbl_pengguna WHERE status=1") or die(mysqli_error($koneksi));


                    if(mysqli_num_rows($sql_panggilpengguna) > 0)
                    {
                      while($data=mysqli_fetch_array($sql_panggilpengguna))
                      {
                        ?>
                        <tr>
                          <td>
                            <?=$no++;?>
                          </td>
                          <td>
                            <?=$data['username'];?>
                          </td>
                          <td>
                            <?=$data['nama_user'];?>
                          </td>
                          <td>
                            <center>
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default" data-pengguna="<?= $data['username'];?>" ><i class="nav-icon fas fa-trash"></i> Hapus</button>

                          <button type="button" class="btn-sm btn-warning" data-toggle="modal" data-target="#modal-edit" > 
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
                      echo "<tr><td colspan=\"4\" align=\"center\"><h6>Tidak ditemukan Data periode pada database</h6></td></tr>";

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
              <input type="text" name="username" id="username" hidden>
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

      <div class="modal fade" id="modal-reset">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <form role="form" class="form-layout" action="prosesreset.php" method="post">
              <p><b> Anda akan mereset semua data? </b></p>
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
              <h4 class="modal-title" style="color: white"><i class="nav-icon fas fa-plus"></i> Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="tambah.php"  role="form" class="form-layout" method="post" enctype="multipart/form-data">
             <div class="form-group">
              <label for="kategori">Nama Kategori Buku</label>
              <input type="text" class="form-control" id="kategori" name="kategori" placeholder="input nama kategori" required>
             </div>
            </div>
            <div class="modal-footer justify-content-between-right">
              <button type="submit" name="tambah" class="btn btn-primary"><i class="nav-icon fas fa-download"></i>Tambah</button>
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
              <h4 class="modal-title" style="color: white">Edit Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="edit.php"  role="form" class="form-layout" method="post" enctype="multipart/form-data">
              
              <div class="form-group">
              <label for="id">ID Kategori</label>
              <input type="text" class="form-control" id="id_kategoriterpilih" name="id_kategoriterpilih" disabled>
              <input type="text" class="form-control" id="id_kategoriterpilih2" name="id_kategoriterpilih2" hidden>
             </div>

             <div class="form-group">
              <label for="kategori">Nama Kategori Buku</label>
              <input type="text" class="form-control" id="kategori" name="kategoribuku" required>
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

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<?php
  include '../script.php';
  ?>
<script type="text/javascript">
        $('#modal-default').on('show.bs.modal', function(e){
          
          //get data
          var id_kategori = $(e.relatedTarget).data('id_kategori');
          

          $(e.currentTarget).find('input[name="id_kategoribuku"]').val(id_kategori);

        });
</script>

<script type="text/javascript">
        $('#modal-edit').on('show.bs.modal', function(e){
          
          //get data
          var id_kategori = $(e.relatedTarget).data('id_kategori');
          var kategori = $(e.relatedTarget).data('kategori');

          $(e.currentTarget).find('input[name="id_kategoriterpilih"]').val(id_kategori);
          $(e.currentTarget).find('input[name="id_kategoriterpilih2"]').val(id_kategori);
          $(e.currentTarget).find('input[name="kategoribuku"]').val(kategori);
        });
</script>

</body>
</html>
