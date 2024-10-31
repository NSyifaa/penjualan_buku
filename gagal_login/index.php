<?php
 
  require_once '../database/koneksi.php';
?>

<!DOCTYPE html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>SIPENBUK</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="styles/app.min.css"/>
  <link rel="shortcut icon" href="assets/img/logom.png">
 
</head>

<body class="page-loading">
  <!-- page loading spinner -->
  <!-- <div class="pageload">
    <div class="pageload-inner">
      <div class="sk-rotating-plane"></div>
    </div>
  </div> -->
  <!-- /page loading spinner -->
  <div class="app signin v2 usersession">
    <div class="session-wrapper">
      <div class="session-carousel slide" data-ride="carousel" data-interval="3000">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox" style="width: 100%; height: 100%;">
          <div class="item active" style="background-image:url(assets/img/images.png);background-size: cover;background-repeat: no-repeat;background-position:center;  width: 100%; height: 100%;">
          </div>
           <div class="item" style="background-image:url(assets/img/book2.png);background-size:cover;background-repeat: no-repeat;background-position: center;  width: 100%; height: 100%;">
          </div>
          <div class="item" style="background-image:url(assets/img/bookstore.png);background-size:cover;background-repeat: no-repeat;background-position: center;  width: 100%; height: 100%;">
          </div>
        </div>
      </div>
      <div class="card bg-white  blue no-border" style="background-color:#FFB6C1;">
        <div class="card-block">
          <form role="form" class="form-layout" action="" method="post">
            <div class="text-center m-b">    

              <img src="assets/img/logobk.png" style='width:100px; height:100px;'/> 
              <h4 class="text-uppercase"><b><font color="#000000">SISTEM INFORMASI PENJUALAN BUKU</font></b></h4>
              <h4 class="text-uppercase"><font color="#000000">TOKO BUKU MAYANG</font></h4>
            </div>
            <div class="form-inputs p-b">
              <label class="text-uppercase"><font color="#000000">Username</font></label>
              <input type="username" class="form-control input-lg" name="username" id="username" placeholder="input username" required>
              <label class="text-uppercase"><font color="#000000">Password</font></label>
              <input type="password" class="form-control input-lg" name="password" id="password"  placeholder="input password" required>
              <!-- <a href="lupapassword.php"><font color="#ffffff">Lupa Password?</font></a>
             --></div>
              
               <button class="btn btn-warning btn-block btn-lg" type="submit" name= "masuk" style="background-color:#D6B70A;"><font color="#000000"><img src="assets/img/personkey-white.png">&nbsp<b>Login</b></font></button>

          <br>
          <center><font color="#000000"><small><em> Copyright &copy; Toko Buku Mayang </a></em></</small></font>
          <br/>  
           <font color="#000000"><?php echo date("Y"); ?></</small></font>
            </center>
          </form>

          <?php
          if(isset($koneksi, $_POST['masuk'])){
            $isianusername = trim(mysqli_escape_string($koneksi, $_POST['username']));
            $isianpw = sha1(trim(mysqli_escape_string($koneksi, $_POST['password'])));
            $cekdatabase = mysqli_query($koneksi, "SELECT * FROM tbl_pengguna WHERE username= '$isianusername' AND password= '$isianpw'") or die(mysqli_error($koneksi));

            $returnvalue = mysqli_num_rows($cekdatabase);
            echo $returnvalue;

           if($returnvalue==1){
            $array = mysqli_fetch_assoc($cekdatabase);
            $st_user = $array['status'];

            //buat percabngan login
            session_start();
            if($st_user==0){
              $_SESSION['username'] = $isianusername;
              $_SESSION['nama_user'] = $array['nama_user'];
              $_SESSION['status'] = $st_user;

              echo '<script>
              window.location="../admin_dashboard"</script>';
            }
            elseif($st_user==1){

              $_SESSION['username'] = $isianusername;
              $_SESSION['nama_user'] = $array['nama_user'];
              $_SESSION['status'] = $st_user;

              echo '<script>
              window.location="../kasir_dashboard"</script>';
            }
           }
           else{
            //jika hasil $rv = 0 ( tidak ada user yang dimaksud)
            session_destroy();
            echo '<script>
              window.location="../gagal_login"</script>';


          }

            
           }

          ?>

        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Terjadi Kesalahan</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p align="justify">Username dan Password yang anda masukkan salah,
              silahkan bisa Login Kembali!</p>
            </div>
            <div class="modal-footer pull right">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Keluar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="scripts/app.min.js"></script>
  <script type="text/javascript">
  $(window).on('load',function(){
    $('#modal-default').modal('show');
  });
</script>
</body>

</html>
