<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Submit Data</title>
</head>
<body>
	<?php
	require_once '../database/koneksi.php';

	// Periksa apakah parameter id_po ada di URL
	if(isset($_GET['id_po'])) {
        $idpo = $_GET['id_po'];
        $total = $_GET['total'];

        $query_cek =  mysqli_query($koneksi, "SELECT id FROM tbl_po_detail WHERE id_po='$idpo'")or die(mysqli_error($koneksi));
        if (mysqli_num_rows($query_cek) == 0) {
            echo "<script src='../assets_adminLTE/dist/js/sweetalert.min.js'></script>";

            echo "<script>
                swal('Peringatan', 'Barang masih kosong!!!', 'warning');
                setTimeout(function(){
                    window.location.href = '../admin_pembelian/detail.php?id_po=$idpo';
                }, 3000);
              </script>";
        }else {
            $update_status = mysqli_query($koneksi, "UPDATE tbl_po SET total='$total',status = '2' WHERE id_po = '$idpo'");

            // Cek apakah query berhasil
            if($update_status) {
                echo "<script src='../assets_adminLTE/dist/js/sweetalert.min.js'></script>";
                echo "<script>
                        swal('Berhasil', 'Status PO berhasil diperbaharui menjadi sedang dicek', 'success');
                        setTimeout(function(){
                            window.location.href = '../admin_pembelian';
                        }, 2000);
                      </script>";
            } else {
                echo "<script src='../assets_adminLTE/dist/js/sweetalert.min.js'></script>";
                echo "<script>
                        swal('Gagal', 'Gagal memperbarui status PO', 'error');
                      </script>";
            }
        }
      
    } else {
        // Jika id_po tidak ditemukan dalam URL
        echo "<script>
                swal('Error', 'ID PO tidak ditemukan!', 'error');
                setTimeout(function(){
                    window.location.href = 'index.php';
                }, 2000);
              </script>";
    }
	?>
</body>
</html>
