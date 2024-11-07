<html>
<head>
</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

// Trigger tambah data pada halaman sebelumnya
if (isset($koneksi, $_POST['tambah'])) {
    // Ambil data dari form
    $tanggal = date("Y-m-d"); // Ambil tanggal saat ini
    $tanggal_format = date("dmY"); // Format tanggal untuk no_po
    $kode_po = "PO"; // Kode tetap untuk penanda PO
    $nama_supplier = trim(mysqli_real_escape_string($koneksi, $_POST['supplier'])); // Ambil kode supplier dari form
    
    $status = 1; // Status otomatis "1" untuk PO

    // Query untuk mendapatkan nomor urut terakhir di tanggal yang sama
    $query_urut = mysqli_query($koneksi, "SELECT id_po FROM tbl_po WHERE DATE(tanggal) = '$tanggal' ORDER BY id_po DESC LIMIT 1") 
        or die(mysqli_error($koneksi));
    
    // Atur nomor urut awal
    $no_urut = 1;

    // Jika ada nomor PO di tanggal tersebut, tingkatkan urutan terakhir
    if (mysqli_num_rows($query_urut) > 0) {
        $data_po = mysqli_fetch_assoc($query_urut);
        
        // Ambil bagian urutan dari no_po sebelumnya, misalnya: 100424-PO-MYG-1
        $no_po_terakhir = explode('-', $data_po['id_po']);
        
        // Ambil nomor urut terakhir dan tambahkan 1
        $no_urut = intval(end($no_po_terakhir)) + 1;
    }

    // Gabungkan semua bagian untuk membentuk nomor PO
    $no_po_baru = "$tanggal_format-$kode_po-$no_urut";

    // Eksekusi query untuk menambahkan data PO
    $tambahdata = mysqli_query($koneksi, "INSERT INTO tbl_po (id_po, tanggal, kode_sup, status) VALUES ('$no_po_baru', '$tanggal', '$nama_supplier', '$status')") 
        or die(mysqli_error($koneksi));

    ?>
    <script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
    <script>
    swal("Berhasil", "Data PO sudah Berhasil ditambah", "success");

    setTimeout(function(){
        window.location.href = "../admin_pembelian";
    }, 2000);
    </script>
    <?php
}
?>

</body>
</html>