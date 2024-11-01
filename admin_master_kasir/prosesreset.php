<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Proses Reset Kasir</title>
</head>
<body>
	<?php
	require_once '../database/koneksi.php';
	session_start();

	if(isset($_POST['reset'])){

	$id = trim(mysqli_real_escape_string($koneksi, $_POST['id']));
	$pass = "kasir1234";
	$pass2 = sha1($pass);

	
	$queryresetpw = mysqli_query($koneksi, "UPDATE tbl_pengguna SET password='$pass2' WHERE id='$id'") or die (mysqli_error($koneksi));

		?>
	 <script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
</script>
<script>
swal("Berhasil", "Password Berhasil direset", "success");

setTimeout(function(){
window.location.href = "../auth/logout.php";

},2000);
</script>
	 <?php

}
?>
</body>
</html>