<html>
<head>

</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

//triger tambah data pada halaman sebelumnya
if(isset($koneksi, $_POST['edit'])){

$idkategori = trim(mysqli_real_escape_string($koneksi, $_POST['id_kategoriterpilih2']));
$kategoribuku = trim(mysqli_real_escape_string($koneksi, $_POST['kategoribuku']));

$queryupdate = mysqli_query($koneksi, "UPDATE tbl_kategori SET kategori= '$kategoribuku' WHERE id_kategori ='$idkategori' ") or die (mysqli_error($koneksi));

?>
<script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
</script>
<script>
swal("Berhasil", "Data Kategori sudah Berhasil di Edit", "success");

setTimeout(function(){
window.location.href = "../admin_master_kategori";

},2000);
</script>
<?php
}

?>


</body>
</html>