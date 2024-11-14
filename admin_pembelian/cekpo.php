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

  // Ambil data PO berdasarkan ID PO yang dikirimkan
  if(isset($_GET['id_po'])){
    $idpo = $_GET['id_po'];
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
  <aside class="main-sidebar sidebar-dark-warning elevation-4" style="background-color: #024CAA;">
    <a href="index3.html" class="brand-link">
      <img src="../auth/assets/img/logobk.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Toko Buku Mayang</span>
    </a>
    <div class="sidebar">
      <?php
      include '../sidebar.php';
      ?>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0">Cek Purchase Order</h1>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header" style="background-color: #091057;">
                <h3 class="card-title" style="color: white"><i class="nav-icon fas fa-shopping-cart"></i> Cek PO</h3>
              </div>

              <div class="card-body">
              <a href="../admin_pembelian" class="btn btn-primary btn-sm"><i class="nav-icon fas fa-chevron-left"></i> Kembali</a>
              <br>
              <br>
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
                
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>No PO</th>
                      <th>Item</th>
                      <th>Qty PO</th>
                      <th>Subtotal</th>
                      <th>Qty Datang</th>
                      <th>Harga Datang</th>
                      <th width="15%"><center>Status</center></th>
                      <th width="15%"><center>Aksi</center></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no=1;
                    
                    $sql_panggilpo_detail = mysqli_query($koneksi, "SELECT * FROM tbl_po_detail WHERE id_po = '$idpo'") or die(mysqli_error($koneksi));

                    if(mysqli_num_rows($sql_panggilpo_detail) > 0) {
                      while($data = mysqli_fetch_array($sql_panggilpo_detail)) {
                       
                        $id = $data['id'];
                        $kd_buku = $data['kd_buku'];
                        $sql_buku = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku = '$kd_buku'") or die(mysqli_error($koneksi));
                        $buku = mysqli_fetch_assoc($sql_buku)['judul_buku'];

                    
                        $subtotal = $data['jumlah'] * $data['harga'];
                        $qty_datang = $data['qty_dtg'];
                        $harga_datang = $data['harga_dtg'];
                        $status = $data['stat'];

                        $qty_datang_display = is_null($qty_datang) || $qty_datang === '' ? '-' : $qty_datang;

                        $harga_datang_display = is_null($harga_datang) || $harga_datang === '' ? '-' : 'Rp. ' . number_format($harga_datang, 0, ',', '.');
                       
                        $disabled = ($status == 1) ? 'disabled' : '';
                        ?>

                        <tr>
                          <td><?=$no++;?></td>
                          <td><?=$idpo;?></td>
                          <td><?=$buku;?></td>
                          <td><?=$data['jumlah'];?></td>
                          <td>Rp. <?=number_format($subtotal, 0, ',', '.');?></td>  
                          <td><center><?=$qty_datang_display;?></center></td>
                          <td><center><?=$harga_datang_display;?></center></td>
                          <td>
                            <center>
                            <?php
                            if ($status == 0) {
                              echo '<button class="btn btn-secondary btn-sm">Belum Verifikasi</button>';
                            } else {
                              echo '<button class="btn btn-success btn-sm">Terverifikasi</button>';
                            }
                            ?>
                            </center>
                          </td>
                          <td>
                          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit" data-idpo="<?=$idpo;?>" data-item="<?=$buku;?>"  data-qty="<?=$data['jumlah'];?>" data-sub="<?=$subtotal;?>" data-qtydtg="<?= $qty_datang_display;?>" <?= $disabled;?>> 
                          <i class="nav-icon fas fa-edit"></i> Edit
                          </button>
                          <a href="verifikasi.php?id=<?= $id; ?>&id_po=<?=$idpo?> &kd_buku=<?=$kd_buku?>&qty_datang=<?=$qty_datang?>&harga_beli=<?= $data['harga'];?>" class="btn btn-sm btn-success">Verifikasi</a>
                          </td>
                        </tr>

                        <?php
                      }
                    } else {
                      echo "<tr><td colspan=\"9\" align=\"center\"><h6>Tidak ada detail PO untuk ID PO ini.</h6></td></tr>";
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
  </div>

  
  <?php
  include '../footer.php';
  ?>
</div>

<div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header" style="background-color:#091057;">
              <h4 class="modal-title" style="color: white"><i class="nav-icon fas fa-plus"></i> Tambah Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="update_po.php"  role="form" class="form-layout" method="post" enctype="multipart/form-data">

              <div class="form-group">
              <label for="idpo"> ID PO</label>
              <input type="text" class="form-control" id="idpo" name="idpo" readonly>
             </div>

             <div class="form-group">
              <label for="item"> Item</label>
              <input type="text" class="form-control" id="item" name="item" readonly>
             </div>

             <div class="form-group">
              <label for="qty"> Qty</label>
              <input type="number" class="form-control" id="qty" name="qty" readonly>
             </div>
              
             <div class="form-group">
              <label for="sub"> Subtotal</label>
              <input type="number" class="form-control" id="sub" name="sub" readonly>
             </div>

             <div class="form-group">
              <label for="qtydtg"> Qty Datang</label>
              <input type="number" class="form-control" id="qtydtg" name="qtydtg" required>
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


<!-- REQUIRED SCRIPTS -->
<?php
  include '../script.php';
  ?>
  <script type="text/javascript">
        $('#modal-edit').on('show.bs.modal', function(e){
          
          //get data
          var item       = $(e.relatedTarget).data('item');
          var qty    = $(e.relatedTarget).data('qty');
          var sub    = $(e.relatedTarget).data('sub');
          var idpo    = $(e.relatedTarget).data('idpo');
          var qty_dtg    = $(e.relatedTarget).data('qtydtg');
          

          $(e.currentTarget).find('input[name="item"]').val(item);
          $(e.currentTarget).find('input[name="qty"]').val(qty);
          $(e.currentTarget).find('input[name="sub"]').val(sub);
          $(e.currentTarget).find('input[name="idpo"]').val(idpo);
          $(e.currentTarget).find('input[name="qtydtg"]').val(qty_dtg);
         
        });
</script>
</body>
</html>
