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

$querycek= mysqli_query($koneksi, "SELECT id_kategori FROM tbl_kategori") or die (mysqli_error($koneksi));

while($data=mysqli_fetch_assoc($querycek)){
    $idkategori = $data['id_kategori'];
    $querycekbuku = mysqli_query($con, "SELECT kd_buku FROM tbl_buku WHERE id_kategori='$idkategori'") or die (mysqli_error($con));
}


?>
<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
<script>
	swal("Success", "Data Berhasil Direset", "success");

	setTimeout(function(){
		window.location.href = "../admin_master_kategori";
	}, 2000);
</script>
</body>
</html>