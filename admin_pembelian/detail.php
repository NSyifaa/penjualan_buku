<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  $konstruktor = 'admin_pembelian';
  require_once '../database/koneksi.php';
  if (isset($_SESSION['status'])) {
    $status = $_SESSION['status'];
    if ($status != 0) {
      echo '<script>window.location = "../auth/logout.php"</script>';
    }
  } else {
    echo '<script>window.location = "../auth/logout.php"</script>';
  }
  ?>

  <?php
  include '../listlink.php';
  ?>
</head>
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
      </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary">
              <div class="card-header">
                <h5><i class="nav-icon fas fa-shopping-cart"></i>Purchase Order</h5>
              </div>
              <div class="card-body">
                <?php
                  $idpo = @$_GET['id_po'];
                  $qweri = mysqli_query($koneksi, "SELECT * FROM tbl_po WHERE id_po='$idpo'") or die (mysqli_error($koneksi));
                  $arrqweri = mysqli_fetch_assoc($qweri);
              
                  $tanggal = $arrqweri['tanggal'];
                  $namasup = $arrqweri['kode_sup'];
                  $status = $arrqweri['status'];

                  $nama = mysqli_query($koneksi, "SELECT nama_suplier FROM tbl_supplier WHERE kode_sup='$namasup'") or die (mysqli_error($koneksi));
                  $arrqweri = mysqli_fetch_assoc($nama);
                  $nama_sup =  $arrqweri['nama_suplier'];

              ?>
              <a href="../admin_pembelian" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-chevron-left"></i> Kembali</a>
              <br>
              <br>
                <div class="row">
                  <div class="col-lg-6">
                  <table class="table table-sm table-borderless table-striped">
                  <tr>
                        <td width="35%">Nomor PO</td>
                         <td width="2%">:</td>
                          <td>
                            <b><?=$idpo;?></b>
                          </td>
                  </tr>
                  <tr>
                        <td width="35%">Tanggal PO</td>
                         <td width="2%">:</td>
                          <td>
                            <b><?=$tanggal;?></b>
                          </td>
                  </tr>
                  <tr>
                        <td width="35%">Nama Supplier</td>
                         <td width="2%">:</td>
                          <td>
                            <b><?=$nama_sup;?></b>
                          </td>
                  </tr>

                  </table>
                  </div>
                </div>

              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                <div class="col-lg-6">
                  <table id="example1" class="table table-bordered table-striped table-sm">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Kategori</th>
                        <th>Buku</th>
                        <th><center>Aksi</center></th>
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
                        $disabled = ($status == 2) ? 'disabled' : '';
                        ?>
                        <tr>
                          <td>
                            <?=$no++;?>
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
                            <?=$data['judul_buku'];?>
                          </td>
                         
                          
                          <td>
                            <center>
                          <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-tambah"  data-kd_buku="<?=$data['kd_buku'];?>" data-nama="<?=$data['judul_buku'];?>" data-id_po="<?= $idpo;?>" <?=$disabled;?>><i class="nav-icon fas fa-plus"></i> Tambah</button>
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
                <div class="col-lg-6">
                  <table id="example1" class="table table-bordered table-striped table-sm">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Nomor PO</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Sub Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no=1;
                    
                    $total = 0;
                    $sql_panggilpo = mysqli_query($koneksi, "SELECT * FROM tbl_po_detail WHERE id_po='$idpo'") or die(mysqli_error($koneksi));

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
                          <?php

                           echo $idpo;?>
                      
                          </td>
                          <td>
                          <?php
                            $kd_buku = $data['kd_buku'];
                            $ambilnomor = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku='$kd_buku'") or die (mysqli_error($koneksi));
                            $data_buku = mysqli_fetch_assoc($ambilnomor);
                            $buku = $data_buku['judul_buku'];

                            ?>

                            <?=$buku;?>
                           
                          </td>
                          <td>
                          <?php
                          $jml = $data['jumlah'];
                          echo $jml;
                          ?>
                          </td>
                          <td>
                          <?php 
                          $harga = $data['harga'];
                          echo $harga;

                          ?>
                          </td>
                          <td>
                            <?php
                          $subtotal = $jml * $harga;
                          echo "Rp. " . number_format($subtotal, 0, ',', '.');
                         
                          $total += $subtotal;
                          ?>
                          </td>
                        </tr>

                        <?php

                      }
                      echo "
                      <tr>
                      <td colspan=\"5\" align=\"center\" style=\"background-color: #FFD700 ;\"><h6 >Total Harga</h6>
                     
                      </td>
                      <td style=\"background-color: #FFD700 ;\">
                     
                      ".$total."
                      </td>
                      </tr>";
                    }
                    else
                    {
                      echo "<tr><td colspan=\"6\" align=\"center\" ><h6>Tidak ditemukan Data periode pada database</h6></td></tr>";

                    }

                    ?>
                    </tbody>
                  </table>

                  <?php
                  // Tambahkan kondisi untuk menampilkan tombol hanya jika status belum selesai (contoh: status != 2)
                  if ($status != 2) {
                      echo '<a href="submit.php?id_po=' . $idpo . '" name="submit" class="btn btn-sm btn-danger"><i class="nav-icon fas fa-upload"></i> Submit</a>';
                  }
                  ?>
                  <!-- <a href="submit.php?id_po=<?=$idpo;?>" name="submit" class= "btn btn-sm btn-danger"><i class="nav-icon fas fa-upload"></i> Submit</a> -->

                 
                </div>
                </div>

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
              <form action=""  role="form" class="form-layout" method="post" enctype="multipart/form-data">

              <div class="form-group">
              <label for="id">ID PO</label>
              <input type="text" class="form-control" id="idterpilih2" name="idterpilih2"  readonly>
             </div>


              <div class="form-group">
              <label for="kode">Kode Buku</label>
              <input type="text" class="form-control" id="kodeterpilih" name="kodeterpilih" >
              <input type="text" class="form-control" id="kodeterpilih2" name="kodeterpilih2" hidden>
             </div>

             <div class="form-group">
              <label for="nama">Nama Buku</label>
              <input type="text" class="form-control" id="nama" name="nama" disabled>
              
            
             </div>

              <div class="form-group">
              <label for="jumlah">Jumlah</label>
              <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="input jumlah buku" required>
             </div>

             <div class="form-group">
              <label for="harga">Harga Buku</label>
              <input type="number" class="form-control" id="harga" name="harga" placeholder="input harga buku" required>
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

      <?php
      if(isset($koneksi, $_POST['tambah'])){
        //tampung nilai inputan
        $kodebuku = trim(mysqli_escape_string($koneksi, $_POST['kodeterpilih2']));
        $jumlah = trim(mysqli_escape_string($koneksi, $_POST['jumlah']));
        $harga = trim(mysqli_escape_string($koneksi, $_POST['harga']));
        $idpo = trim(mysqli_escape_string($koneksi, $_POST['idterpilih2']));
        
        $querycek = mysqli_query($koneksi, "INSERT INTO tbl_po_detail VALUES (NULL,'$idpo', '$kodebuku', '$jumlah', '$harga')") or die(mysqli_error($koneksi));

     
        

        ?>
         <script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
    <script>
    swal("Berhasil", "Data PO sudah Berhasil ditambah", "success");

    setTimeout(function(){
        window.location.href ="detail.php?id_po=<?=$idpo;?>";
    }, 2000);
    </script>
    <?php

      


      }
      ?>

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<?php
  include '../script.php';
  ?>
  <script type="text/javascript">
        $('#modal-tambah').on('show.bs.modal', function(e){
          
          //get data
          var kd_buku = $(e.relatedTarget).data('kd_buku');
          var nama = $(e.relatedTarget).data('nama');
          var id_po =  $(e.relatedTarget).data('id_po');
           
          $(e.currentTarget).find('input[name="kodeterpilih"]').val(kd_buku);
          $(e.currentTarget).find('input[name="kodeterpilih2"]').val(kd_buku);
          $(e.currentTarget).find('input[name="nama"]').val(nama);
          $(e.currentTarget).find('input[name="idterpilih2"]').val(id_po);

        });
</script>

</body>
</html>
