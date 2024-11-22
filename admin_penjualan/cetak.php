<?php
require_once '../database/koneksi.php';
require_once '../assets_adminlte/dist/fpdf/fpdf.php';

// Ambil data id dari GET request
$id = $_GET['id'];

// Query untuk mendapatkan detail penjualan
$query_penjualan = mysqli_query($koneksi, "SELECT * FROM tbl_penjualan WHERE id='$id'") or die(mysqli_error($koneksi));
$query_penjualan_detail = mysqli_query($koneksi, "SELECT * FROM tbl_detail_penjualan WHERE nomor=(SELECT nomor FROM tbl_penjualan WHERE id='$id')") or die(mysqli_error($koneksi));
$penjualan_header = mysqli_fetch_assoc($query_penjualan);

// Menyiapkan Kelas PDF
class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->Image("../auth/assets/img/logobk.png", 14, 6, 30);
        $this->SetFont('Times', 'B', 12);
        $this->Ln(30);
        $this->Cell(4);
        $this->Cell(30, 6, 'TOKO BUKU MAYANG', 0, 1, 'C');
        $this->SetFont('Times', '', 7);
        $this->Cell(4);
        $this->Cell(30, 4, "Jl. Raya Ajibarang, Blok Rokan 17", 0, 1, 'C');
        $this->Cell(4);
        $this->Cell(30, 4, "Kab. Banyumas, WA(081227404040)", 0, 1, 'C');
        $this->Cell(4);
        $this->Cell(30, 4, "NPWP : 091290.209.09-11.0012", 0, 1, 'C');
        $this->line(3, 60, 55, 60);
        $this->Ln(5);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Membuat PDF
$pdf = new PDF('P', 'mm', array(58, 210)); // Ukuran thermal printer 58mm
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 7);

// Header informasi Penjualan
$pdf->Cell(-8);
$pdf->Cell(20, 4, "Tgl Penjualan", 0, 0, 'L');
$pdf->Cell(3, 4, ":", 0, 0, 'L');
$pdf->Cell(20, 4, $penjualan_header['tgl'], 0, 1, 'L');

$pdf->Cell(-8);
$pdf->Cell(20, 4, "No Nota", 0, 0, 'L');
$pdf->Cell(3, 4, ":", 0, 0, 'L');
$pdf->Cell(20, 4, $penjualan_header['nomor'], 0, 1, 'L');

$pdf->Cell(-8);
$pdf->Cell(20, 4, "Pelanggan", 0, 0, 'L');
$pdf->Cell(3, 4, ":", 0, 0, 'L');
$pdf->Cell(20, 4, $penjualan_header['nama_pel'], 0, 1, 'L');

$pdf->line(3, 80, 55, 80);
$pdf->Ln(9);

// Header tabel
$pdf->SetFont('Times', 'B', 7);
$pdf->Cell(-8);
$pdf->Cell(5, 4, "No", 0, 0, 'C');
$pdf->Cell(20, 4, "Nama Buku", 0, 0, 'C');
$pdf->Cell(10, 4, "Qty", 0, 0, 'C');
$pdf->Cell(10, 4, "Harga", 0, 0, 'C');
$pdf->Cell(10, 4, "Subtotal", 0, 1, 'C');

// Isi tabel
$pdf->SetFont('Times', '', 7);
$no = 1;
$total = 0;

while ($data = mysqli_fetch_array($query_penjualan_detail)) {
    $kd_buku = $data['kd_buku'];
    $qty = $data['qty'];
    $harga = $data['harga'];
    $subtotal = $qty * $harga;
    $total += $subtotal;

    // Ambil nama buku
    $query_buku = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku='$kd_buku'") or die(mysqli_error($koneksi));
    $buku = mysqli_fetch_assoc($query_buku)['judul_buku'];

    $pdf->Cell(-8);
    $pdf->Cell(5, 4, $no++, 0, 0, 'C');
    $pdf->Cell(21, 4, $buku, 0, 0, 'L');
    $pdf->Cell(7, 4, $qty, 0, 0, 'C');
    $pdf->Cell(10, 4, number_format($harga), 0, 0, 'C');
    $pdf->Cell(10, 4, number_format($subtotal), 0, 1, 'C');
}

// Total
$pdf->Ln(3);
$pdf->SetFont('Times', 'B', 7);
$pdf->Cell(-8);
$pdf->Cell(40, 4, "TOTAL", 0, 0, 'L');
$pdf->Cell(12, 4, number_format($total), 0, 1, 'R');

$pdf->Output();
?>
