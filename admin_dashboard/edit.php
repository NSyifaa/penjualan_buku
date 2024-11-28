<html>
<head>

</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

//triger tambah data pada halaman sebelumnya
if(isset($koneksi, $_POST['edit'])){


$id    = trim(mysqli_real_escape_string($koneksi, $_POST['id']));
$jumlah     = trim(mysqli_real_escape_string($koneksi, $_POST['jumlah']));



$querycek= mysqli_query($koneksi,"UPDATE tbl_peringatan_stok SET jumlah= '$jumlah' WHERE id='$id' ") or die (mysqli_error($koneksi));

?>

<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
<script>
	swal("Success", "Data Berhasil Diedit", "success");

	setTimeout(function(){
		window.location.href = "../admin_dashboard";
	}, 2000);
</script>

<?php
}
?>


</body>
</html>