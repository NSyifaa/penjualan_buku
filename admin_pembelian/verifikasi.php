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
$id = @$_GET['id'];
$idpo = @$_GET['id_po'];
$stat =1;
$statpo =3;

$update = mysqli_query($koneksi, "UPDATE tbl_po_detail SET stat='$stat' WHERE id='$id'") or die(mysqli_error($koneksi));

$query_cek =  mysqli_query($koneksi, "SELECT stat FROM tbl_po_detail WHERE stat=0")or die(mysqli_error($koneksi));
if (mysqli_num_rows($query_cek) == 0) {
    mysqli_query($koneksi, "UPDATE tbl_po SET status='$statpo' WHERE id_po='$idpo'") or die(mysqli_error($koneksi));
} else {
    # code...
}

?>
<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
<script>
	swal("Success", "Data Berhasil Dihapus", "success");

	setTimeout(function(){
		window.location.href = "../admin_pembelian/cekpo.php?id_po=<?= $idpo;?>";
	}, 2000);
</script>
</body>
</html>