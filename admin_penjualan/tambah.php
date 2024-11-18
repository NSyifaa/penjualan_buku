<html>
<head>
</head>
<body>

<?php
require_once '../database/koneksi.php';
session_start();

// Trigger tambah data pada halaman sebelumnya
if (isset($koneksi, $_POST['tambah'])) {

    function generateUUIDv4() {
        // Membuat 16 bytes dari data acak
        $data = openssl_random_pseudo_bytes(16);
        
        // Menetapkan versi (4) dan varian (2) dari UUID v4
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // Versi 4
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // Varian 2
    
        // Mengonversi data byte ke format UUID
        return sprintf(
            '%08s-%04s-%04s-%04s-%12s',
            bin2hex(substr($data, 0, 4)),
            bin2hex(substr($data, 4, 2)),
            bin2hex(substr($data, 6, 2)),
            bin2hex(substr($data, 8, 2)),
            bin2hex(substr($data, 10, 6))
        );
    }
    
    // Menghasilkan UUID
    $uuid = generateUUIDv4();
    // Ambil data dari form
    $tanggal = date("Y-m-d H:i:s"); // Ambil tanggal saat ini
    $tgl = date("Y-m-d"); // Ambil tanggal saat ini
    $tanggal_format = date("dmY"); // Format tanggal untuk no_po
    $kode = "MYG"; // Kode tetap untuk penanda PO
    $nama = trim(mysqli_real_escape_string($koneksi, $_POST['nama'])); // Ambil kode supplier dari form
    $total='0';
    $bukti='0';

    $status = 0; // Status otomatis "1" untuk PO

    // Query untuk mendapatkan nomor urut terakhir di tanggal yang sama
    $query_urut = mysqli_query($koneksi, "SELECT nomor FROM tbl_penjualan  WHERE DATE(tgl) = '$tgl' ORDER BY nomor DESC LIMIT 1") 
        or die(mysqli_error($koneksi));
    
    // Atur nomor urut awal
    $no_urut = 1;

    // Jika ada nomor PO di tanggal tersebut, tingkatkan urutan terakhir
    if (mysqli_num_rows($query_urut) > 0) {
        $data_po = mysqli_fetch_assoc($query_urut);
        
        // Ambil bagian urutan dari no_po sebelumnya, misalnya: 100424-PO-MYG-1
        $no_po_terakhir = explode('-', $data_po['nomor']);
        
        // Ambil nomor urut terakhir dan tambahkan 1
        $no_urut = intval(end($no_po_terakhir)) + 1;
    }

    // Gabungkan semua bagian untuk membentuk nomor PO
    $no_po_baru = "$tanggal_format-$kode-$no_urut";

    // Eksekusi query untuk menambahkan data PO
    $tambahdata = mysqli_query($koneksi, "INSERT INTO tbl_penjualan (id, tgl,nomor, nama_pel, total, bukti, status) VALUES ('$uuid','$tanggal','$no_po_baru',  '$nama', '$total', '$bukti', '$status')") 
        or die(mysqli_error($koneksi));

    ?>
    <script src="../assets_adminLTE/dist/js/sweetalert.min.js"></script>
    <script>
    swal("Berhasil", "Data PO sudah Berhasil ditambah", "success");

    setTimeout(function(){
        window.location.href = "../admin_penjualan";
    }, 2000);
    </script>
    <?php
}
?>

</body>
</html>