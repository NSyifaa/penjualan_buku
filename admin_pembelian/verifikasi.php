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
$id 		= @$_GET['id'];
$idpo		= @$_GET['id_po'];
$kd_buku	= @$_GET['kd_buku'];
$qty_datang = @$_GET['qty_datang'];

if ($qty_datang == NULL || $qty_datang == '') {
	echo '<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
			<script>
				swal("Peringatan", "Jumlah Barang datang harus diisi ! ", "warning");

				setTimeout(function(){
					window.location.href = "../admin_pembelian/cekpo.php?id_po='.$idpo.'";
				}, 4000);
			</script>';
}else{
	$harga_beli = @$_GET['harga_beli'];
	
	$sql_margin = mysqli_query($koneksi, "SELECT margin FROM tbl_margin") or die(mysqli_error($koneksi));
	$dt_margin  = mysqli_fetch_assoc($sql_margin);
	$margin 	= $dt_margin['margin'];
	
	$harga_jual = ($harga_beli * $margin/100 ) + $harga_beli;

	$stat =1;
	$statpo =3;

	$update 	 = mysqli_query($koneksi, "UPDATE tbl_po_detail SET stat='$stat' WHERE id='$id'") or die(mysqli_error($koneksi));
	$tambah_stok = mysqli_query($koneksi, "INSERT INTO tbl_stok VALUES ('$idpo','$kd_buku','$qty_datang','$harga_beli','$harga_jual')") or die(mysqli_error($koneksi));

	$query_cek =  mysqli_query($koneksi, "SELECT stat FROM tbl_po_detail WHERE stat='0' AND id_po='$idpo'")or die(mysqli_error($koneksi));

	if (mysqli_num_rows($query_cek) == 0) {
	    mysqli_query($koneksi, "UPDATE tbl_po SET status='$statpo' WHERE id_po='$idpo'") or die(mysqli_error($koneksi));
	}
	?>
	<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
	<script>
		swal("Success", "Data Berhasil diverifikasi", "success");

		setTimeout(function(){
			window.location.href = "../admin_pembelian/cekpo.php?id_po=<?= $idpo;?>";
		}, 2000);
	</script>
	<?php
}

?>
</body>
</html>