<?php
require_once '../database/koneksi.php';
require_once '../assets_adminlte/dist/fpdf/fpdf.php';

// Ambil data id_po dari GET request
$id_po = $_GET['id_po'];

// Query untuk mendapatkan detail PO
$query_po = mysqli_query($koneksi, "SELECT * FROM tbl_po_detail WHERE id_po='$id_po'") or die(mysqli_error($koneksi));
$query_ambil = mysqli_query($koneksi, "SELECT * FROM tbl_po WHERE id_po='$id_po'") or die(mysqli_error($koneksi));
$po = mysqli_fetch_assoc($query_ambil);

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
$pdf->Cell(30, 6, "Tanggal PO", 0, 0, 'L');  // Memperbesar lebar kolom
$pdf->Cell(3, 6, ":", 0, 0, 'L');
$pdf->Cell(55, 6, $po['tanggal'], 0, 1, 'L');  // Memperbesar lebar kolom

$pdf->Cell(4);  // Memberikan spasi pada posisi horizontal
$pdf->Cell(30, 6, "No PO", 0, 0, 'L');  // Memperbesar lebar kolom
$pdf->Cell(3, 6, ":", 0, 0, 'L');
$pdf->Cell(55, 6, $id_po, 0, 1, 'L');

$pdf->Cell(4);  // Memberikan spasi pada posisi horizontal
$pdf->Cell(30, 6, "Supplier", 0, 0, 'L');  // Memperbesar lebar kolom
$pdf->Cell(3, 6, ":", 0, 0, 'L');
$pdf->Cell(55, 6, $po['kode_sup'], 0, 1, 'L');



$pdf->Ln(5);

// Kolom header untuk detail produk
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(-8);
$pdf->Cell(10, 6, "No", 1, 0, 'C');
$pdf->Cell(70, 6, "Nama Item", 1, 0, 'C');
$pdf->Cell(20, 6, "Qty", 1, 0, 'C');
$pdf->Cell(30, 6, "Harga", 1, 0, 'C');
$pdf->Cell(30, 6, "Subtotal", 1, 1, 'C');

$pdf->SetFont('Times', '', 7);
$no = 1;
$total = 0;

while ($data = mysqli_fetch_array($query_po)) {
    $kd_buku = $data['kd_buku'];
    $jumlah = $data['jumlah'];
    $harga = $data['harga'];
    $subtotal = $jumlah * $harga;
    $total += $subtotal;

    // Ambil nama buku
    $query_buku = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku='$kd_buku'") or die(mysqli_error($koneksi));
    $buku = mysqli_fetch_assoc($query_buku)['judul_buku'];

    // Menambahkan baris item pada tabel
    $pdf->Cell(-8);
    $pdf->Cell(10, 6, $no++, 1, 0, 'C');
    $pdf->Cell(70, 6, $buku, 1, 0, 'L');
    $pdf->Cell(20, 6, $jumlah, 1, 0, 'C');
    $pdf->Cell(30, 6, "Rp " . number_format($harga), 1, 0, 'C');
    $pdf->Cell(30, 6, "Rp " . number_format($subtotal), 1, 1, 'C');
}

// Menambahkan baris total di dalam tabel
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(-8);
$pdf->Cell(10, 6, "", 1, 0, 'C');  // Kosongkan kolom nomor
$pdf->Cell(70, 6, "TOTAL", 1, 0, 'R');  // Teks TOTAL di kolom nama item
$pdf->Cell(20, 6, "", 1, 0, 'C');  // Kolom qty kosong
$pdf->Cell(30, 6, "", 1, 0, 'C');  // Kolom harga kosong
$pdf->Cell(30, 6, "Rp " . number_format($total), 1, 1, 'C'); 

// Output PDF
$pdf->Output();
?>
