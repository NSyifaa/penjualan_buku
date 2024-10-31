<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
<?php
require_once "../database/koneksi.php";
$kategori = trim(mysqli_real_escape_string($koneksi, $_POST['id_kategoribuku']));

mysqli_query($koneksi, "DELETE FROM tbl_kategori WHERE id_kategori='$kategori'") or die(mysqli_error($koneksi));
?>
<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
<script>
	swal("Success", "Data Berhasil Dihapus", "success");

	setTimeout(function(){
		window.location.href = "../admin_master_kategori";
	}, 2000);
</script>
</body>
</html>