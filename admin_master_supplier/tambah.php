<html>
<head>

</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

//triger tambah data pada halaman sebelumnya
if(isset($koneksi, $_POST['tambah'])){


$kode_sup       = trim(mysqli_real_escape_string($koneksi, $_POST['kodesup']));
$nama_sup       = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
$alamat         = trim(mysqli_real_escape_string($koneksi, $_POST['alamat']));
$kontak         = trim(mysqli_real_escape_string($koneksi, $_POST['kontak']));
$nama_sales     = trim(mysqli_real_escape_string($koneksi, $_POST['namasales']));
$kontak_sales   = trim(mysqli_real_escape_string($koneksi, $_POST['kontaksales']));


$querycek= mysqli_query($koneksi, "SELECT kode_sup FROM tbl_supplier WHERE kode_sup= '$kode_sup'") or die (mysqli_error($koneksi));

if(mysqli_num_rows($querycek)>0)
{ 
	?>
	<script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
</script>
<script>
swal("Duplikat Data", "Data supplier sudah Terdapat Pada database", "warning");

setTimeout(function(){
window.location.href = "../admin_master_supplier";

},2000);
</script>
<?php
}
else
{
	$tambahdata = mysqli_query($koneksi,"INSERT INTO tbl_supplier VALUES ('$kode_sup','$nama_sup','$alamat','$kontak','$nama_sales','$kontak_sales')") 
	or die (mysqli_error($koneksi));
?>
	<script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
</script>
<script>
swal("Berhasil", "Data Supplier sudah Berhasil ditambah", "success");

setTimeout(function(){
window.location.href = "../admin_master_supplier";

},2000);
</script>
<?php
}
}

?>


</body>
</html>