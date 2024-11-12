<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Buku Mayang</title>
  <?php
  session_start();
  require_once '../database/koneksi.php';
  $konstruktor ='admin_master_margin';

  if(isset($_SESSION['status'])){
    $status = $_SESSION['status'];
    if($status != 0){
      echo '<script>window.location = "../auth/logout.php"</script>';
    }
  }else{
    echo '<script>window.location = "../auth/logout.php"</script>';
  }

  $margin = 0; 
$cek = mysqli_query($koneksi, "SELECT margin FROM tbl_margin LIMIT 1");
if ($cek && mysqli_num_rows($cek) > 0) {
    $tampilin = mysqli_fetch_assoc($cek);
    $margin = $tampilin['margin'];
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
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0"> Ganti Margin</h1>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">

            <div class="card">
              <div class="card-header" style="background-color: #091057;">
                <h3 class="card-title" style="color: white;"><i class="nav-icon fas fa-book"></i> Margin</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

             
                <div class="card-body">
                <form role="form" class="form-layout" action="marginedit.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputEmail1">Margin %</label>
                    <input type="number" class="form-control" id="margin" name="margin" value="<?php echo $margin; ?>" disabled>
                 </div>

                 <div class="form-group">
                    <label for="exampleInputEmail1"> Update Margin %</label>
                    <input type="number" class="form-control" id="margin" name="margin">
                 </div>

               
                <button type="submit" class="btn-sm-md btn-primary btn-block" style="background-color: #091057;" name="updatemargin" > 
                        <i class="nav-icon fas fa-edit"></i> Ubah Margin
                 </button>
               
                 
                 </div>
                 </form>
              
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

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<?php
  include '../script.php';
  ?>
</body>
</html>
