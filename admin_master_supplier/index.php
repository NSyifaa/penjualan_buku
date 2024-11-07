<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  require_once '../database/koneksi.php';
  $konstruktor ='admin_master_supplier';
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
            <h1 class="m-0">Data Supplier</h1>
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
                <h3 class="card-title" style="color: white"><i class="nav-icon fas fa-user"></i> Data Supplier</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="nav-icon fas fa-plus"></i> Tambah Data</button>
              

                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>Nama Sales</th>
                    <th>Kontak Sales</th>
                    <th><center>Aksi</center></th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no=1;
                    $sql_panggilpengguna = mysqli_query($koneksi, "SELECT * FROM tbl_supplier ") or die(mysqli_error($koneksi));


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
                            <?=$data['nama_suplier'];?>
                          </td>
                          <td>
                            <?=$data['alamat'];?>
                          </td>
                          <td>
                            <?=$data['kontak_sup'];?>
                          </td>
                          <td>
                            <?=$data['nama_sales'];?>
                          </td>
                          <td>
                            <?=$data['kontak_sales'];?>
                          </td>
                          <td>
                            <center>

                            
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default"  data-kode_sup="<?=$data['kode_sup'];?>"><i class="nav-icon fas fa-trash"></i> Hapus</button>

                          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit" 
                          data-kode_sup="<?=$data['kode_sup'];?>"  data-nama_sup="<?=$data['nama_suplier'];?>"  data-alamat="<?=$data['alamat'];?>"  data-kontak_sup="<?=$data['kontak_sup'];?>"  data-nama_sales="<?=$data['nama_sales'];?>"  data-kontak_sales="<?=$data['kontak_sales'];?>"> 
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
                      echo "<tr><td colspan=\"8\" align=\"center\"><h6>Tidak ditemukan Data periode pada database</h6></td></tr>";

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
              <input type="text" name="kode" id="kode" hidden >
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
              <label for="kode">Kode Supplier</label>
              <input type="text" class="form-control" id="kodesup" name="kodesup" placeholder="input kode supplier" required>
             </div>
             <div class="form-group">
              <label for="nama">Nama Supplier</label>
              <input type="text" class="form-control" id="nama" name="nama" placeholder="input nama supplier" required>
             </div>

             <div class="form-group">
              <label for="alamat">Alamat</label>
              <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="input alamat" required></textarea>
             </div>

             <div class="form-group">
              <label for="kontak">Kontak Supplier</label>
              <input type="number" class="form-control" id="kontak" name="kontak" placeholder="input kontak supplier" required>
             </div>
             
             <div class="form-group">
              <label for="nama">Nama Sales</label>
              <input type="nama" class="form-control" id="namasales" name="namasales" placeholder="input nama sales" required>
             </div>
              
             <div class="form-group">
              <label for="kontak">Kontak Sales</label>
              <input type="number" class="form-control" id="kontaksales" name="kontaksales" placeholder="input kontak sales" required>
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
              <label for="kode">Kode Supplier</label>
              <input type="text" class="form-control" id="kode_supterpilih" name="kode_supterpilih" disabled>
              <input type="text" class="form-control" id="kode_supterpilih2" name="kode_supterpilih2" hidden>
             </div>

             <div class="form-group">
              <label for="nama">Nama Supplier</label>
              <input type="text" class="form-control" id="namasup" name="namasup" disabled>
              <input type="text" class="form-control" id="namasup2" name="namasup2" hidden>
             </div>

             <div class="form-group">
              <label for="alamat">Alamat</label>
              <input type="text" class="form-control" id="alamat" name="alamat" required>
             </div>

             <div class="form-group">
              <label for="kontak">Kontak Supplier</label>
              <input type="text" class="form-control" id="kontaksup" name="kontaksup" required>
             </div>

             <div class="form-group">
              <label for="sales">Nama Sales</label>
              <input type="text" class="form-control" id="namasales" name="namasales" required>
             </div>
              
             <div class="form-group">
              <label for="kontak">Kontak Sales</label>
              <input type="text" class="form-control" id="kontaksales" name="kontaksales" required>
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
          var kode_sup = $(e.relatedTarget).data('kode_sup');
          

          $(e.currentTarget).find('input[name="kode"]').val(kode_sup);

        });
</script>

<script type="text/javascript">
        $('#modal-edit').on('show.bs.modal', function(e){
          
          //get data
          var kode_sup      = $(e.relatedTarget).data('kode_sup');
          var nama_sup      = $(e.relatedTarget).data('nama_sup');
          var alamat        = $(e.relatedTarget).data('alamat');
          var kontak_sup      = $(e.relatedTarget).data('kontak_sup');
          var nama_sales      = $(e.relatedTarget).data('nama_sales');
          var kontak_sales      = $(e.relatedTarget).data('kontak_sales');

          $(e.currentTarget).find('input[name="kode_supterpilih"]').val(kode_sup );
          $(e.currentTarget).find('input[name="kode_supterpilih2"]').val(kode_sup );
          $(e.currentTarget).find('input[name="namasup"]').val( nama_sup );
          $(e.currentTarget).find('input[name="namasup2"]').val( nama_sup );
          $(e.currentTarget).find('input[name="alamat"]').val(alamat);
          $(e.currentTarget).find('input[name="kontaksup"]').val(kontak_sup);
          $(e.currentTarget).find('input[name="namasales"]').val(nama_sales );
          $(e.currentTarget).find('input[name="kontaksales"]').val(kontak_sales );
        });
</script>



</body>
</html>
