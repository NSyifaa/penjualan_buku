<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  require_once '../database/koneksi.php';
  $konstruktor ='admin_pembelian';
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
            <h1 class="m-0">Data Pembelian</h1>
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
                <h3 class="card-title" style="color: white"><i class="nav-icon fas fa-shopping-cart"></i> Purchase Order</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah"><i class="nav-icon fas fa-plus"></i> Tambah Data</button>

              

                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor PO</th>
                    <th>Tanggal</th>
                    <th>Nama Supplier</th>
                    <th>Status</th>
                    <th width="30%"><center>Aksi</center></th>
                    
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no=1;
                    $sql_panggilpo = mysqli_query($koneksi, "SELECT * FROM tbl_po") or die(mysqli_error($koneksi));


                    if(mysqli_num_rows($sql_panggilpo) > 0)
                    {
                      while($data=mysqli_fetch_array($sql_panggilpo))
                      {
                        ?>
                        <tr>
                          <td>
                            <?=$no++;?>
                          </td>
                          <td>
                            <?=$data['id_po'];?>
                          </td>
                          <td>
                            <?=$data['tanggal'];?>
                          </td>
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
                             $st_po = $data['status'];
                             if($st_po=='1'){
                              ?>
                              <center>
                                <button class="btn btn-sm btn-success">PO
                                </button>
                              </center>
                              <?php
                             }elseif($st_po=='2'){
                                ?>
                              <center>
                                <button class="btn btn-sm btn-warning">Sedang dicek
                                </button>
                              </center>
                                <?php
                             }elseif($st_po=='3'){
                                ?>
                                 <center>
                                <button class="btn btn-sm btn-primary">Sedang dikirim
                                </button>
                              </center>
                                <?php

                             }
                             else{
                              ?>
                              <center>
                                <button class="btn btn-sm btn-danger">Selesai</button>
                              </center>
                              <?php

                             }


                             ?>
                          </td>
                          
                          <td>
                            <center>
                               <?php 
                             $st_po = $data['status'];
                            
                            
                             if($st_po=='1'){
                              ?>
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-default" data-id_po="<?=$data['id_po'];?>"><i class="nav-icon fas fa-trash"></i> Hapus</button>
                              
                              <?php
                             }else {
                                ?>
                            <a href="detail.php?id_po=<?=$data['id_po'];?>" target="_blank" class= "btn btn-sm btn-warning"><i class="nav-icon fas fa-file"></i> Download SP</a>
                              
                              <?php

                             }?>

                            <a href="detail.php?id_po=<?=$data['id_po'];?>" 
                            class= "btn btn-sm btn-info"><i class="nav-icon fas fa-edit"></i> Detail </a>

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
              <input type="text" name="id_po" id="id_po" hidden >
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
              <label for="sup">Nama Supplier</label>
              <select class="form-control" name="supplier" required>
                <option value=""> -- Pilih Nama Supplier --</option>
                <?php
                $pglsupplier = mysqli_query($koneksi, "SELECT * FROM tbl_supplier") or die(mysqli_error($koneksi));

                $rv = mysqli_num_rows($pglsupplier);

                if($rv>0){
                  while($dt_supplier=mysqli_fetch_array($pglsupplier)){
                    ?>
                    <option value ="<?=$dt_supplier['kode_sup'];?>">
                      <?=$dt_supplier['kode_sup'];?> -
                      <?=$dt_supplier['nama_suplier'];?>
                    </option>
                    <?php
                  }
                }
                else{

                }
                ?>
              </select>
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
          var id_po = $(e.relatedTarget).data('id_po');
          

          $(e.currentTarget).find('input[name="id_po"]').val(id_po);

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
