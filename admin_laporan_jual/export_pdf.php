<?php
require_once '../database/koneksi.php';
require_once '../assets_adminlte/dist/fpdf/fpdf.php';

// Ambil data tanggal dari GET request
$tanggal_mulai = $_GET['tanggal_mulai'];
$tanggal_akhir = $_GET['tanggal_akhir'];

// Query untuk mengambil data penjualan berdasarkan tanggal
$query_penjualan = "
  SELECT tgl, nomor
  FROM tbl_penjualan
  WHERE tgl BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'
";
$ambil_penjualan = mysqli_query($koneksi, $query_penjualan) or die(mysqli_error($koneksi));

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

// Membuat PDF
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 11);

// Menampilkan Rentang Tanggal
$pdf->Cell(4);
$pdf->Cell(30, 6, "Periode Tanggal", 0, 0, 'L');
$pdf->Cell(3, 6, ":", 0, 0, 'L');
$pdf->Cell(55, 6, $tanggal_mulai . ' s/d ' . $tanggal_akhir, 0, 1, 'L');

// Kolom header untuk detail penjualan
$pdf->Ln(5);
$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(-8);
$pdf->Cell(10, 6, "No", 1, 0, 'C');
$pdf->Cell(30, 6, "Tanggal", 1, 0, 'C');
$pdf->Cell(40, 6, "Nomor Penjualan", 1, 0, 'C');
$pdf->Cell(20, 6, "Qty", 1, 0, 'C');
$pdf->Cell(30, 6, "Harga Beli", 1, 0, 'C');
$pdf->Cell(30, 6, "Harga Jual", 1, 1, 'C');

$pdf->SetFont('Times', '', 7);
$no = 1;
$total_selisih = 0;

// Loop untuk menampilkan data detail penjualan
while ($data_penjualan = mysqli_fetch_array($ambil_penjualan)) {
    $nomor_penjualan = $data_penjualan['nomor'];
    
    // Query untuk mendapatkan detail penjualan
    $query_po = "
      SELECT qty, harga_beli, harga
      FROM tbl_detail_penjualan
      WHERE nomor = '$nomor_penjualan'
    ";

    $ambil_po = mysqli_query($koneksi, $query_po) or die(mysqli_error($koneksi));
    $data_po = mysqli_fetch_array($ambil_po);

    // Cek apakah data di tbl_detail_penjualan ada
    if ($data_po) {
        $harga_jual = $data_po['harga'];
        $harga_beli = $data_po['harga_beli'];
        $qty = $data_po['qty'];

        // Hitung selisih
        $selisih = $harga_jual - $harga_beli;
        $total_selisih_per_item = $selisih * $qty;

        // Akumulasi total selisih
        $total_selisih += $total_selisih_per_item;
    } else {
        $qty = 0;
        $harga_beli = 0;
        $harga_jual = 0;
    }

    // Menampilkan data penjualan dalam tabel
    $pdf->Cell(-8);
    $pdf->Cell(10, 6, $no++, 1, 0, 'C');
    $pdf->Cell(30, 6, $data_penjualan['tgl'], 1, 0, 'C');
    $pdf->Cell(40, 6, $data_penjualan['nomor'], 1, 0, 'C');
    $pdf->Cell(20, 6, $qty, 1, 0, 'C');
    $pdf->Cell(30, 6, "Rp " . number_format($harga_beli, 0, ',', '.'), 1, 0, 'R');
    $pdf->Cell(30, 6, "Rp " . number_format($harga_jual, 0, ',', '.'), 1, 1, 'R');
}

$pdf->SetFont('Times', 'B', 8);
$pdf->Cell(-8); // Menyesuaikan margin kiri
$pdf->Cell(10, 6, "", 1, 0, 'C'); // Kosongkan kolom No
$pdf->Cell(30, 6, "", 1, 0, 'C'); // Kosongkan kolom Tanggal (tetap kosong)
$pdf->Cell(40, 6, "Total Selisih", 1, 0, 'C'); // Gabungkan sebagian kolom Nomor Penjualan
$pdf->Cell(20, 6, "-", 1, 0, 'C'); // Kosongkan kolom Qty
$pdf->Cell(30, 6, "-", 1, 0, 'R'); // Kosongkan kolom Harga Beli
$pdf->Cell(30, 6, "Rp " . number_format($total_selisih, 0, ',', '.'), 1, 1, 'R'); // Isi Total Selisih di kolom Harga Jual

// Output PDF
$pdf->Output('I', 'Laporan_Penjualan_' . $tanggal_mulai . '_sampai_' . $tanggal_akhir . '.pdf');
?>
