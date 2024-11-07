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
$kode_sup= trim(mysqli_real_escape_string($koneksi, $_POST['kode']));

mysqli_query($koneksi, "DELETE FROM tbl_supplier WHERE kode_sup='$kode_sup'") or die(mysqli_error($koneksi));
?>
<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
<script>
	swal("Success", "Data Berhasil Dihapus", "success");

	setTimeout(function(){
		window.location.href = "../admin_master_supplier";
	}, 2000);
</script>
</body>
</html>