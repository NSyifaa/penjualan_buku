<html>
<head>

</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

//triger tambah data pada halaman sebelumnya
if(isset($koneksi, $_POST['edit'])){


$kd_buku        = trim(mysqli_real_escape_string($koneksi, $_POST['kodebukuterpilih2']));
$judul_buku     = trim(mysqli_real_escape_string($koneksi, $_POST['judulbukuterpilih']));
$id_kategori    = trim(mysqli_real_escape_string($koneksi, $_POST['kategoriterpilih']));
$isbn           = trim(mysqli_real_escape_string($koneksi, $_POST['isbnterpilih']));
$tahun          = trim(mysqli_real_escape_string($koneksi, $_POST['tahun']));
$penerbit       = trim(mysqli_real_escape_string($koneksi, $_POST['penerbitterpilih']));
$jml_hal        = trim(mysqli_real_escape_string($koneksi, $_POST['jumlahterpilih']));
$cetakan        = trim(mysqli_real_escape_string($koneksi, $_POST['cetakanterpilih']));

$querycek= mysqli_query($koneksi,"UPDATE tbl_buku SET judul_buku= '$judul_buku', id_kategori= '$id_kategori', isbn='$isbn', tahun='$tahun', penerbit='$penerbit', jml_hal='$jml_hal', cetakan='$cetakan' WHERE kd_buku ='$kd_buku'") or die (mysqli_error($koneksi));

?>

<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
<script>
	swal("Success", "Data Berhasil Diedit", "success");

	setTimeout(function(){
		window.location.href = "../admin_master_buku";
	}, 2000);
</script>

<?php
}
?>


</body>
</html>