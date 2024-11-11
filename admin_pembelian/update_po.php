<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Update Data</title>
</head>
<body>

<?php
require_once '../database/koneksi.php';

if (isset($_POST['tambah'])) {
    $idpo = $_POST['idpo'];
    $item = $_POST['item'];
    $qty = $_POST['qty']; 
    $qty_dtg = $_POST['qtydtg']; 
    $sub = $_POST['sub']; 

    if ($qty_dtg > $qty) {
    echo '
    <script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
    <script>
    swal("Peringatan !", "Jumlah Datang melebihi jumlah PO", "warning");

    setTimeout(function(){
        window.location.href = "cekpo.php?id_po='.$idpo.'";
    }, 2000);
    </script>
    ';
    }else {
      $harga_datang = ($sub / $qty) * $qty_dtg; 

   
      $update_query = "UPDATE tbl_po_detail SET qty_dtg = '$qty_dtg', harga_dtg = '$harga_datang' WHERE id_po = '$idpo' AND kd_buku = (SELECT kd_buku FROM tbl_buku WHERE judul_buku = '$item')";
  
      if (mysqli_query($koneksi, $update_query)) {
          echo '<script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
                <script>
                swal("Berhasil", "Data PO telah diperbarui", "success");

                setTimeout(function(){
                    window.location.href = "cekpo.php?id_po='.$idpo.'";
                }, 2000);
                </script>';
      } else {
          echo "<script>
                  alert('Gagal memperbarui data. Kesalahan: " . mysqli_error($koneksi) . "');
                </script>";
      }
    }
    
}
?>
</body>
</html>