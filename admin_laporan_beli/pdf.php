<?php
require_once '../database/koneksi.php';
require_once '../assets_adminlte/dist/fpdf/fpdf.php';

// Ambil data dari GET request
$tanggal_mulai = $_GET['tanggal_mulai'];
$tanggal_akhir = $_GET['tanggal_akhir'];
$kode_supplier = $_GET['kode_supplier'];

// Query untuk mendapatkan data pembelian berdasarkan tanggal dan supplier
$query_po = mysqli_query($koneksi, "SELECT * FROM tbl_po WHERE kode_sup = '$kode_supplier' AND tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'") or die(mysqli_error($koneksi));
$query_supplier = mysqli_query($koneksi, "SELECT nama_suplier FROM tbl_supplier WHERE kode_sup = '$kode_supplier'") or die(mysqli_error($koneksi));
$supplier_data = mysqli_fetch_assoc($query_supplier);

// Menampilkan nama supplier
$nama_supplier = $supplier_data['nama_suplier'];

// Membuat instance dari FPDF
class PDF extends FPDF
{
    // Header
    function Header()
    {
        // Logo pada posisi kiri
        $this->Image("../auth/assets/img/logobk.png", 90, 15, 30);

        // Judul Toko dan informasi lainnya di tengah
        $this->SetFont('Times', 'B', 14);
        $this->Ln(30);
        $this->Cell(0, 6, 'TOKO BUKU MAYANG', 0, 1, 'C');
        $this->SetFont('Times', '', 7);
        $this->Cell(0, 4, "Jl. Raya Ajibarang, Blok Rokan 17", 0, 1, 'C');
        $this->Cell(0, 4, "Kab. Banyumas, WA(081227404040)", 0, 1, 'C');
        $this->Cell(0, 4, "NPWP : 091290.209.09-11.0012", 0, 1, 'C');
        $this->line(3, 60, 200, 60);  // Garis pembatas
        $this->Ln(5);
    }

    // Footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Mengubah ukuran kertas menjadi A4
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 11);  // Menggunakan ukuran font yang lebih besar agar lebih mudah dibaca

// Menyesuaikan margin dan spasi
$pdf->Cell(4);  // Memberikan spasi pada posisi horizontal
$pdf->Cell(30, 6, "Tanggal Periode", 0, 0, 'L');
$pdf->Cell(3, 6, ":", 0, 0, 'L');
$pdf->Cell(55, 6, $tanggal_mulai . " s/d " . $tanggal_akhir, 0, 1, 'L');

$pdf->Cell(4);  // Memberikan spasi pada posisi horizontal
$pdf->Cell(30, 6, "Supplier", 0, 0, 'L');
$pdf->Cell(3, 6, ":", 0, 0, 'L');
$pdf->Cell(55, 6, $nama_supplier, 0, 1, 'L');

$pdf->Ln(5);

// Kolom header untuk detail produk
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(-8);
$pdf->Cell(10, 6, "No", 1, 0, 'C');
$pdf->Cell(70, 6, "No PO", 1, 0, 'C');
$pdf->Cell(20, 6, "Tanggal", 1, 0, 'C');
$pdf->Cell(30, 6, "Total Pembelian", 1, 1, 'C');

$pdf->SetFont('Times', '', 7);
$no = 1;

// Loop untuk menampilkan data PO
while ($po = mysqli_fetch_array($query_po)) {
    $id_po = $po['id_po'];
    $tanggal = $po['tanggal'];
    $total_pembelian = $po['total'];

    // Menambahkan baris item pada tabel
    $pdf->Cell(-8);
    $pdf->Cell(10, 6, $no++, 1, 0, 'C');
    $pdf->Cell(70, 6, $id_po, 1, 0, 'L');
    $pdf->Cell(20, 6, $tanggal, 1, 0, 'C');
    $pdf->Cell(30, 6, "Rp " . number_format($total_pembelian), 1, 1, 'C');
}

// Set header untuk download file PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Laporan_Pembelian_' . date('Ymd_His') . '.pdf"');

// Output PDF
$pdf->Output('I');  // Menggunakan 'I' agar output ditampilkan langsung di browser dan didownload secara otomatis
?>
