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
$jual = trim(mysqli_real_escape_string($koneksi, $_POST['id']));

mysqli_query($koneksi, "DELETE FROM tbl_penjualan WHERE id='$jual'") or die(mysqli_error($koneksi));
?>
<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
<script>
	swal("Success", "Data Berhasil Dihapus", "success");

	setTimeout(function(){
		window.location.href = "../kasir_penjualan";
	}, 2000);
</script>
</body>
</html>