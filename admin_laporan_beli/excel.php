<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

// Ambil parameter filter dari URL
$tanggal_mulai = $_GET['tanggal_mulai'];
$tanggal_akhir = $_GET['tanggal_akhir'];
$kode_supplier = $_GET['kode_supplier'];

// Nama file Excel
$namaexcel = "Laporan-Pembelian-" . date('Y-m-d');

// Query berdasarkan filter
$sql = "SELECT * 
        FROM tbl_po 
        WHERE kode_sup = '$kode_supplier' 
        AND tanggal BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'";

$result = mysqli_query($koneksi, $sql) or die(mysqli_error($koneksi));

// Buat file spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Laporan Pembelian');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'TANGGAL');
$sheet->setCellValue('C1', 'NOMOR PO');
$sheet->setCellValue('D1', 'SUPPLIER');
$sheet->setCellValue('E1', 'TOTAL PEMBELIAN');

// Styling header
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:E1')->applyFromArray($styleArray);
$sheet->getStyle('A1:E1')->getFont()->setBold(true);

// Atur lebar kolom secara otomatis
foreach (range('B', 'E') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Isi data dari hasil query
$no = 1;
$rowNumber = 2;

while ($row = mysqli_fetch_assoc($result)) {
    // Ambil nama supplier berdasarkan kode supplier
    $kode_sup = $row['kode_sup'];
    $supplier_query = mysqli_query($koneksi, "SELECT nama_suplier FROM tbl_supplier WHERE kode_sup = '$kode_sup'") or die(mysqli_error($koneksi));
    $supplier_data = mysqli_fetch_assoc($supplier_query);
    $nama_supplier = $supplier_data['nama_suplier'] ?? 'Tidak Ditemukan';

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $row['tanggal']);
    $sheet->setCellValue("C" . $rowNumber, $row['id_po']);
    $sheet->setCellValue("D" . $rowNumber, $nama_supplier);
    $sheet->setCellValue("E" . $rowNumber, $row['total']);
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

$writer->save('php://output');
exit();
?>
