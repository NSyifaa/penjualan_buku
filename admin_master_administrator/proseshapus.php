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
$id_admin= trim(mysqli_real_escape_string($koneksi, $_POST['id_admin']));

mysqli_query($koneksi, "DELETE FROM tbl_pengguna WHERE id='$id_admin'") or die(mysqli_error($koneksi));
?>
<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
<script>
	swal("Success", "Data Berhasil Dihapus", "success");

	setTimeout(function(){
		window.location.href = "../admin_master_administrator";
	}, 2000);
</script>
</body>
</html>