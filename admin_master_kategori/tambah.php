<html>
<head>

</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

//triger tambah data pada halaman sebelumnya
if(isset($koneksi, $_POST['tambah'])){


$kategori = trim(mysqli_real_escape_string($koneksi, $_POST['kategori']));

$querycek= mysqli_query($koneksi, "SELECT kategori FROM tbl_kategori WHERE  kategori= '$kategori'") or die (mysqli_error($koneksi));

if(mysqli_num_rows($querycek)>0)
{ 
	?>
	<script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
</script>
<script>
swal("Duplikat Data", "Data Kategori sudah Terdapat Pada database", "warning");

setTimeout(function(){
window.location.href = "../admin_master_kategori";

},2000);
</script>
<?php
}
else
{
	$tambahdata = mysqli_query($koneksi,"INSERT INTO tbl_kategori (kategori) VALUES ('$kategori')") 
	or die (mysqli_error($koneksi));
?>
	<script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
</script>
<script>
swal("Berhasil", "Data Kategori sudah Berhasil ditambah", "success");

setTimeout(function(){
window.location.href = "../admin_master_kategori";

},2000);
</script>
<?php
}
}

?>


</body>
</html>