<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  require_once '../database/koneksi.php';
  $konstruktor ='admin_master_administrator';
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
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th><center>Aksi</center></th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no=1;
                    $sql_panggilpengguna = mysqli_query($koneksi, "SELECT * FROM tbl_pengguna WHERE status=0") or die(mysqli_error($koneksi));


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
                            <?=$data['alamat'];?>
                          </td>
                          <td>
                            <?=$data['kontak'];?>
                          </td>
                          <td>
                            <center>

                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-reset" data-pengguna="<?= $data['username'];?>" data-id="<?=$data['id'];?>"><i class="nav-icon fas fa-sync"></i> Reset Password</button>

                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default" data-id_admin="<?= $data['id'];?>" ><i class="nav-icon fas fa-trash"></i> Hapus</button>

                          <button type="button" class="btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit" data-id_admin="<?=$data['id'];?> " data-username="<?=$data['username'];?>" data-nama_pengguna="<?=$data['nama_user'];?>" data-alamat="<?=$data['alamat'];?>"  data-kontak="<?=$data['kontak'];?>"> 
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
              <input type="text" name="id_admin" id="id_admin" hidden>
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
              <p><b> Anda akan mereset password? </b></p>
              <input type="text" name="id" id="id" hidden>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Tutup</button>
              <button type="submit" class="btn btn-warning btn-sm" name= "reset"><i class="nav-icon fas fa-sync"></i> Ya, Reset Data</button>
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
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="input nama username" required>
             </div>
             <div class="form-group">
              <label for="nama">Nama Pengguna</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="input nama Pengguna" required>
             </div>

             <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="input alamat" required></textarea>
             </div>

             <div class="form-group">
              <label for="kontak">Kontak</label>
              <input type="number" class="form-control" id="kontak" name="kontak" placeholder="input kontak" required>
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
              <label for="id">Id Admin</label>
              <input type="text" class="form-control" id="id_adminterpilih" name="id_adminterpilih" disabled>
              <input type="text" class="form-control" id="id_adminterpilih2" name="id_adminterpilih2" hidden>
             </div>

             <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
             </div>

             <div class="form-group">
              <label for="nama">Nama Pengguna</label>
              <input type="text" class="form-control" id="nama" name="nama" required>
             </div>

             <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" class="form-control" id="alamat" name="alamat" required>
             </div>

             <div class="form-group">
              <label for="kontak">Kontak</label>
              <input type="number" class="form-control" id="kontak" name="kontak" required>
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
          var id_admin = $(e.relatedTarget).data('id_admin');
          

          $(e.currentTarget).find('input[name="id_admin"]').val(id_admin);

        });
</script>

<script type="text/javascript">
        $('#modal-edit').on('show.bs.modal', function(e){
          
          //get data
          var id_admin       = $(e.relatedTarget).data('id_admin');
          var username       = $(e.relatedTarget).data('username');
          var nama_pengguna  = $(e.relatedTarget).data('nama_pengguna');
          var alamat         = $(e.relatedTarget).data('alamat');
          var kontak         = $(e.relatedTarget).data('kontak');

          $(e.currentTarget).find('input[name="id_adminterpilih"]').val(id_admin);
          $(e.currentTarget).find('input[name="id_adminterpilih2"]').val(id_admin);
          $(e.currentTarget).find('input[name="username"]').val(username);
          $(e.currentTarget).find('input[name="nama"]').val(nama_pengguna);
          $(e.currentTarget).find('input[name="alamat"]').val(alamat);
          $(e.currentTarget).find('input[name="kontak"]').val(kontak);
        });
</script>

<script type="text/javascript">
        $('#modal-reset').on('show.bs.modal', function(e){
          
          //get data
          var id_admin = $(e.relatedTarget).data('id');
        

          $(e.currentTarget).find('input[name="id"]').val(id);
          
        });
</script>

</body>
</html>
