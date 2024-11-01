<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

$namaexcel = "Data-Kategori-" . date('Y-m-d');
$sql = "SELECT * FROM tbl_kategori";
$result = mysqli_query($koneksi, $sql) or die (mysqli_error($koneksi));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Kategori');

// Set header cells
$sheet->setCellValue('A1', 'NO');
$sheet->setCellValue('B1', 'ID KATEGORI');
$sheet->setCellValue('C1', 'NAMA KATEGORI');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:C1')->applyFromArray($styleArray);
$sheet->getStyle('A1:C1')->getFont()->setBold(true);

foreach (array('B', 'C') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

$no = 1;
$rowNumber = 2;
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id_kategori'];
    $nama = $row['kategori'];

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $id);
    $sheet->setCellValue("C" . $rowNumber, $nama);
    $rowNumber++;
    $no++;
}

// Buat file excel
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