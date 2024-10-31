<html>
<head>

</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

//triger tambah data pada halaman sebelumnya
if(isset($koneksi, $_POST['tambah'])){

  
    function generateUUIDv4() {
        // Membuat 16 bytes dari data acak
        $data = openssl_random_pseudo_bytes(16);
        
        // Menetapkan versi (4) dan varian (2) dari UUID v4
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Versi 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Varian 2
    
        // Mengonversi data byte ke format UUID
        return sprintf(
            '%08s-%04s-%04s-%04s-%12s',
            bin2hex(substr($data, 0, 4)),
            bin2hex(substr($data, 4, 2)),
            bin2hex(substr($data, 6, 2)),
            bin2hex(substr($data, 8, 2)),
            bin2hex(substr($data, 10, 6))
        );
    }
    
    // Menghasilkan UUID
    $uuid = generateUUIDv4();
    
  
  
$username = trim(mysqli_real_escape_string($koneksi, $_POST['username']));
$namapengguna = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
$pass = "pass".$username;
$pass2 = sha1($pass);
$status = 0;
$alamat = trim(mysqli_real_escape_string($koneksi, $_POST['alamat']));
$kontak = trim(mysqli_real_escape_string($koneksi, $_POST['kontak']));

 $querycek= mysqli_query($koneksi, "SELECT username FROM tbl_pengguna WHERE username= '$username' AND id= '$uuid'") or die (mysqli_error($koneksi));

 if(mysqli_num_rows($querycek)>0)
 { 
?>
 <script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
 </script>
 <script>
 swal("Duplikat Data", "Data Admin sudah Terdapat Pada database", "warning");

 setTimeout(function(){
 window.location.href = "../admin_master_administrator";

 },2000);
 </script>
 <?php
 }
 else
{
	$tambahdata = mysqli_query($koneksi,"INSERT INTO tbl_pengguna VALUES ('$uuid','$username','$pass2','$namapengguna','$status', '$alamat','$kontak')") 
	or die (mysqli_error($koneksi));
?>
 	<script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
 </script>
 <script>
 swal("Berhasil", "Data Admin sudah Berhasil ditambah", "success");

 setTimeout(function(){
 window.location.href = "../admin_master_administrator";

 },2000);
 </script>
 <?php
 }
 }

?>


</body>
</html>