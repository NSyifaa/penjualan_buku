<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Import Buku</title>
</head>
<body>
	<?php
	require_once '../database/koneksi.php';
	require '../assets_adminLTE/dist/phpexcel-xls-library/vendor/phpoffice/phpexcel/Classes/PHPExcel.php';
	session_start();
    error_reporting(0);
	//ambil triger tomb
	if(isset($koneksi, $_POST['importbuku'])){

		//buat varial untuk menampung value nma file dari elemen file pada index
		$file = $_FILES['file']['name'];

		//memisahkan ekstensi file dengan nama file nya
		$ekstensi = explode(".", $file);

		//buat variabel untuk merename file dengan nama bru
		$file_name = "file".round(microtime(true)).".".end($ekstensi);

		// buat variabel untuk menampung file temporary dari file yang diuplod
		$sumber =$_FILES['file']['tmp_name'];

		//deklarasikan variabel direktori untuk mengupload file
		$target_dir = "template/";

		//buat variabel untuk mearahkan file ke target direktori
		$target_file = $target_dir.$file_name;

		//buat variabel yang berisikan perintah utk mengupload file ke target direktori
		$upload = move_uploaded_file($sumber,$target_file);

		//identifikasi file excel yang akan digunakan sebagai referenasi import
		$file_excel = PHPExcel_IOFactory::load($target_file);

		//Buat variabel utk mengidentifikasi sheet pada excel yang sedang aktif
		$data_excel = $file_excel->getActiveSheet()->toArray(null,true,true,true);

		for ($i=2; $i<= count($data_excel); $i++){
			//deklarasi perulangan

			$kode_buku      = $data_excel[$i]['B'];
			$judul_buku     = addslashes($data_excel[$i]['C']);
			$kategori_buku  = $data_excel[$i]['D'];
			$isbn           = $data_excel[$i]['E'];
			$tahun          = $data_excel[$i]['F'];
			$penerbit       = $data_excel[$i]['G'];
			$jumlah_hal     = $data_excel[$i]['H'];
            $cetakan_ke     = $data_excel[$i]['I'];
			

			$cek = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku='$kode_buku'") or die (mysqli_error($con));

			$rvb = mysqli_num_rows($cek);

			if($rvb>0){

			}
			else{

				$kosong ="";
				$tambahbuku = mysqli_query($koneksi, "INSERT INTO tbl_buku VALUES (
					'$kode_buku',
					'$judul_buku',
					'$kategori_buku',
					'$isbn',
					'$tahun',
					'$penerbit',
                    '$jumlah_hal',
                    '$cetakan_ke')") or die (mysqli_error($koneksi));

				$delkosong = mysqli_query($koneksi, "DELETE FROM tbl_buku WHERE kd_buku='$kosong'") or die (mysqli_error($koneksi));

				
				

			}
		}
		unlink($target_file);
		
		?>
    
    <?php



	}




	?>
<script src="../assets_adminLTE/dist/js/sweetalert.min.js"> 
</script>
<script>
swal("Import Data", "Data Buku Berhasil diImport", "success");

setTimeout(function(){
window.location.href = "../admin_master_buku";

},2000);
</script>
</body>
</html>