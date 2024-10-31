<html>
<head>

</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

//triger tambah data pada halaman sebelumnya
if(isset($koneksi, $_POST['tambah'])){


$kd_buku        = trim(mysqli_real_escape_string($koneksi, $_POST['kodebuku']));
$judul_buku     = trim(mysqli_real_escape_string($koneksi, $_POST['judul']));
$id_kategori    = trim(mysqli_real_escape_string($koneksi, $_POST['kategori']));
$isbn           = trim(mysqli_real_escape_string($koneksi, $_POST['isbn']));
$tahun          = trim(mysqli_real_escape_string($koneksi, $_POST['tahun']));
$penerbit       = trim(mysqli_real_escape_string($koneksi, $_POST['penerbit']));
$jml_hal        = trim(mysqli_real_escape_string($koneksi, $_POST['jml']));
$cetakan        = trim(mysqli_real_escape_string($koneksi, $_POST['cetakan']));

$querycek= mysqli_query($koneksi, "SELECT kd_buku FROM tbl_buku WHERE kd_buku= '$kd_buku'") or die (mysqli_error($koneksi));

if(mysqli_num_rows($querycek)>0)
{ 
	?>
	<script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
</script>
<script>
swal("Duplikat Data", "Data Kategori sudah Terdapat Pada database", "warning");

setTimeout(function(){
window.location.href = "../admin_master_buku";

},2000);
</script>
<?php
}
else
{
	$tambahdata = mysqli_query($koneksi,"INSERT INTO tbl_buku VALUES ('$kd_buku','$judul_buku','$id_kategori','$isbn','$tahun','$penerbit', '$jml_hal','$cetakan')") 
	or die (mysqli_error($koneksi));
?>
	<script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
</script>
<script>
swal("Berhasil", "Data Kategori sudah Berhasil ditambah", "success");

setTimeout(function(){
window.location.href = "../admin_master_buku";

},2000);
</script>
<?php
}
}

?>


</body>
</html>