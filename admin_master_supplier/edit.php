<html>
<head>

</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

//triger tambah data pada halaman sebelumnya
if(isset($koneksi, $_POST['edit'])){


$kode_sup     = trim(mysqli_real_escape_string($koneksi, $_POST['kode_supterpilih2']));
$namasup      = trim(mysqli_real_escape_string($koneksi, $_POST['namasup2']));
$alamat       = trim(mysqli_real_escape_string($koneksi, $_POST['alamat']));
$kontaksup    = trim(mysqli_real_escape_string($koneksi, $_POST['kontaksup']));
$namasales    = trim(mysqli_real_escape_string($koneksi, $_POST['namasales']));
$kontaksales   = trim(mysqli_real_escape_string($koneksi, $_POST['kontaksales']));


$querycek= mysqli_query($koneksi,"UPDATE tbl_supplier SET nama_suplier= '$namasup', alamat= '$alamat', kontak_sup='$kontaksup',nama_sales='$namasales', kontak_sales='$kontaksales' WHERE kode_Sup ='$kode_sup'") or die (mysqli_error($koneksi));

?>

<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
<script>
	swal("Success", "Data Berhasil Diedit", "success");

	setTimeout(function(){
		window.location.href = "../admin_master_supplier";
	}, 2000);
</script>

<?php
}
?>


</body>
</html>