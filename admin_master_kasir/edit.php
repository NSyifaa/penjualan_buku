<html>
<head>

</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

//triger tambah data pada halaman sebelumnya
if(isset($koneksi, $_POST['edit'])){


$id_kasir        = trim(mysqli_real_escape_string($koneksi, $_POST['id_kasirterpilih2']));
$username        = trim(mysqli_real_escape_string($koneksi, $_POST['username']));
$namapengguna    = trim(mysqli_real_escape_string($koneksi, $_POST['nama']));
$alamat          = trim(mysqli_real_escape_string($koneksi, $_POST['alamat']));
$kontak          = trim(mysqli_real_escape_string($koneksi, $_POST['kontak']));


$querycek= mysqli_query($koneksi,"UPDATE tbl_pengguna SET username= '$username', nama_user= '$namapengguna', alamat='$alamat',kontak='$kontak' WHERE id ='$id_kasir'") or die (mysqli_error($koneksi));

?>

<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
<script>
	swal("Success", "Data Berhasil Diedit", "success");

	setTimeout(function(){
		window.location.href = "../admin_master_kasir";
	}, 2000);
</script>

<?php
}
?>


</body>
</html>