<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Aktifkan output buffering untuk mencegah header error
ob_start();

// Ambil parameter ID PO dari URL
$id_po = $_GET['id_po'];

// Nama file Excel
$namaexcel = "Detail-Pembelian-PO-" . $id_po;

// Query untuk mengambil data detail PO
$queryPO = mysqli_query($koneksi, "SELECT * FROM tbl_po WHERE id_po = '$id_po'") or die(mysqli_error($koneksi));
$poData = mysqli_fetch_assoc($queryPO);

if (!$poData) {
    die("Data PO tidak ditemukan.");
}

// Ambil nama supplier
$kode_sup = $poData['kode_sup'];
$querySupplier = mysqli_query($koneksi, "SELECT nama_suplier FROM tbl_supplier WHERE kode_sup = '$kode_sup'") or die(mysqli_error($koneksi));
$supplierData = mysqli_fetch_assoc($querySupplier);
$nama_supplier = $supplierData['nama_suplier'] ?? 'Tidak Ditemukan';

// Ambil detail barang berdasarkan ID PO
$queryDetail = mysqli_query($koneksi, "SELECT * FROM tbl_po_detail WHERE id_po = '$id_po'") or die(mysqli_error($koneksi));

// Buat file spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Detail Pembelian');

// Set header cells
$sheet->setCellValue('A1', 'Nomor PO:');
$sheet->setCellValue('B1', $id_po);
$sheet->setCellValue('A2', 'Tanggal:');
$sheet->setCellValue('B2', $poData['tanggal']);
$sheet->setCellValue('A3', 'Supplier:');
$sheet->setCellValue('B3', $nama_supplier);

$sheet->setCellValue('A5', 'NO');
$sheet->setCellValue('B5', 'NAMA BARANG');
$sheet->setCellValue('C5', 'JUMLAH');
$sheet->setCellValue('D5', 'HARGA');
$sheet->setCellValue('E5', 'QTY DATANG');
$sheet->setCellValue('F5', 'HARGA DATANG');

// Styling header
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A5:F5')->applyFromArray($styleArray);
$sheet->getStyle('A5:F5')->getFont()->setBold(true);

// Atur lebar kolom secara otomatis
foreach (range('A', 'F') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Isi data dari hasil query
$no = 1;
$rowNumber = 6;

while ($detail = mysqli_fetch_assoc($queryDetail)) {
    // Ambil nama barang
    $kd_buku = $detail['kd_buku'];
    $queryBuku = mysqli_query($koneksi, "SELECT judul_buku FROM tbl_buku WHERE kd_buku = '$kd_buku'") or die(mysqli_error($koneksi));
    $bukuData = mysqli_fetch_assoc($queryBuku);
    $nama_buku = $bukuData['judul_buku'] ?? 'Tidak Ditemukan';

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $nama_buku);
    $sheet->setCellValue("C" . $rowNumber, $detail['jumlah']);
    $sheet->setCellValue("D" . $rowNumber, number_format($detail['harga'], 2, ',', '.'));
    $sheet->setCellValue("E" . $rowNumber, $detail['qty_dtg']);
    $sheet->setCellValue("F" . $rowNumber, number_format($detail['harga_dtg'], 2, ',', '.'));

    $rowNumber++;
    $no++;
}

// Buat file Excel
$filename = $namaexcel . ".xlsx";
$writer = new Xlsx($spreadsheet);

ob_end_clean(); // Bersihkan output buffer

// Atur header untuk pengunduhan file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Simpan dan unduh file
$writer->save('php://output');
exit();
?>
