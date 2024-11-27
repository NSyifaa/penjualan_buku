<?php
require_once '../database/koneksi.php';
require_once '../assets_adminlte/dist/fpdf/fpdf.php';

// Ambil data dari GET request
$id_po = $_GET['id_po'];

// Query untuk mendapatkan informasi PO
$query_po = mysqli_query($koneksi, "SELECT * FROM tbl_po WHERE id_po = '$id_po'") or die(mysqli_error($koneksi));
$po_data = mysqli_fetch_assoc($query_po);

// Cek apakah data PO ditemukan
if (!$po_data) {
    die("Data PO tidak ditemukan.");
}

// Query untuk mendapatkan detail barang
$query_detail = mysqli_query($koneksi, "SELECT * FROM tbl_po_detail WHERE id_po = '$id_po'") or die(mysqli_error($koneksi));

// Ambil nama supplier
$kode_sup = $po_data['kode_sup'];
$query_supplier = mysqli_query($koneksi, "SELECT nama_suplier FROM tbl_supplier WHERE kode_sup = '$kode_sup'") or die(mysqli_error($koneksi));
$supplier_data = mysqli_fetch_assoc($query_supplier);
$nama_supplier = $supplier_data['nama_suplier'] ?? 'Tidak Ditemukan';

// Membuat instance dari FPDF
class PDF extends FPDF
{
    // Header
    function Header()
    {
        $this->Image("../auth/assets/img/logobk.png", 90, 15, 30);
        $this->SetFont('Times', 'B', 14);
        $this->Ln(30);
        $this->Cell(0, 6, 'TOKO BUKU MAYANG', 0, 1, 'C');
        $this->SetFont('Times', '', 7);
        $this->Cell(0, 4, "Jl. Raya Ajibarang, Blok Rokan 17", 0, 1, 'C');
        $this->Cell(0, 4, "Kab. Banyumas, WA(081227404040)", 0, 1, 'C');
        $this->Cell(0, 4, "NPWP : 091290.209.09-11.0012", 0, 1, 'C');
        $this->Line(3, 60, 200, 60);
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
$pdf->SetFont('Times', '', 11);

// Informasi utama PO
$pdf->Cell(4);
$pdf->Cell(30, 6, "Nomor PO", 0, 0, 'L');
$pdf->Cell(3, 6, ":", 0, 0, 'L');
$pdf->Cell(55, 6, $po_data['id_po'], 0, 1, 'L');

$pdf->Cell(4);
$pdf->Cell(30, 6, "Tanggal", 0, 0, 'L');
$pdf->Cell(3, 6, ":", 0, 0, 'L');
$pdf->Cell(55, 6, $po_data['tanggal'], 0, 1, 'L');

$pdf->Cell(4);
$pdf->Cell(30, 6, "Supplier", 0, 0, 'L');
$pdf->Cell(3, 6, ":", 0, 0, 'L');
$pdf->Cell(55, 6, $nama_supplier, 0, 1, 'L');

$pdf->Ln(5);

// Kolom header untuk detail barang
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(-8);
$pdf->Cell(10, 6, "No", 1, 0, 'C');
$pdf->Cell(70, 6, "Nama Barang", 1, 0, 'C');
$pdf->Cell(20, 6, "Jumlah", 1, 0, 'C');
$pdf->Cell(30, 6, "Harga", 1, 0, 'C');
$pdf->Cell(20, 6, "Qty Datang", 1, 0, 'C');
$pdf->Cell(30, 6, "Harga Datang", 1, 1, 'C');

$pdf->SetFont('Times', '', 7);
$no = 1;

// Loop untuk menampilkan data detail barang
while ($detail = mysqli_fetch_array($query_detail)) {
    $kd_buku = $detail['kd_buku'];
    $query_buku = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku = '$kd_buku'") or die(mysqli_error($koneksi));
    $buku_data = mysqli_fetch_assoc($query_buku);
    $nama_buku = $buku_data['judul_buku'] ?? 'Tidak Ditemukan';

    $pdf->Cell(-8);
    $pdf->Cell(10, 6, $no++, 1, 0, 'C');
    $pdf->Cell(70, 6, $nama_buku, 1, 0, 'L');
    $pdf->Cell(20, 6, $detail['jumlah'], 1, 0, 'C');
    $pdf->Cell(30, 6, "Rp " . number_format($detail['harga'], 2, ',', '.'), 1, 0, 'R');
    $pdf->Cell(20, 6, $detail['qty_dtg'], 1, 0, 'C');
    $pdf->Cell(30, 6, "Rp " . number_format($detail['harga_dtg'], 2, ',', '.'), 1, 1, 'R');
}

// Output PDF
$pdf->Output('I', 'Detail_PO_' . $id_po . '.pdf');
?>
