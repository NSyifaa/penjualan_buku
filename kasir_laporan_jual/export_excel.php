<?php
require_once "../database/koneksi.php";
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Aktifkan output buffering untuk mencegah header error
ob_start();

// Ambil parameter tanggal_mulai dan tanggal_akhir dari URL
$tanggal_mulai = $_GET['tanggal_mulai'];
$tanggal_akhir = $_GET['tanggal_akhir'];

// Nama file Excel
$namaexcel = "Laporan-Penjualan-" . $tanggal_mulai . "-to-" . $tanggal_akhir;

// Query untuk mengambil data penjualan berdasarkan tanggal
$query_penjualan = "
  SELECT 
    tgl, nomor
  FROM 
    tbl_penjualan 
  WHERE 
    tgl BETWEEN '$tanggal_mulai' AND '$tanggal_akhir'
";

$ambil_penjualan = mysqli_query($koneksi, $query_penjualan) or die(mysqli_error($koneksi));

if (mysqli_num_rows($ambil_penjualan) == 0) {
    die("Tidak ada data yang ditemukan.");
}

// Buat file spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Laporan Penjualan');

// Set header cells
$sheet->setCellValue('A1', 'Tanggal Mulai:');
$sheet->setCellValue('B1', $tanggal_mulai);
$sheet->setCellValue('A2', 'Tanggal Akhir:');
$sheet->setCellValue('B2', $tanggal_akhir);

// Set header kolom tabel
$sheet->setCellValue('A4', 'No');
$sheet->setCellValue('B4', 'Tanggal');
$sheet->setCellValue('C4', 'Nomor Penjualan');
$sheet->setCellValue('D4', 'Qty');
$sheet->setCellValue('E4', 'Harga Beli');
$sheet->setCellValue('F4', 'Harga Jual');
$sheet->setCellValue('G4', 'Selisih (Bruto)'); // Menambahkan kolom selisih

// Styling header
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A4:G4')->applyFromArray($styleArray);
$sheet->getStyle('A4:G4')->getFont()->setBold(true);

// Atur lebar kolom secara otomatis
foreach (range('A', 'G') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Isi data dari hasil query penjualan
$no = 1;
$rowNumber = 5;

while ($data_penjualan = mysqli_fetch_array($ambil_penjualan)) {
    $nomor_penjualan = $data_penjualan['nomor'];
    
    // Ambil detail penjualan
    $query_po = "
      SELECT 
        qty,
        harga_beli,
        harga
      FROM 
        tbl_detail_penjualan 
      WHERE 
        nomor = '$nomor_penjualan'
    ";

    $ambil_po = mysqli_query($koneksi, $query_po) or die(mysqli_error($koneksi));
    $data_po = mysqli_fetch_array($ambil_po);

    if ($data_po) {
        $qty = $data_po['qty'];
        $harga_beli = $data_po['harga_beli'];
        $harga_jual = $data_po['harga'];
        $selisih = $harga_jual - $harga_beli;
    } else {
        // Jika tidak ada data, set nilai default
        $qty = 0;
        $harga_beli = 0;
        $harga_jual = 0;
        $selisih = 0;
    }

    // Menambahkan data hanya jika nilai qty, harga_beli, dan harga_jual lebih dari 0
    if ($qty > 0 && $harga_beli > 0 && $harga_jual > 0 && $selisih > 0) {
        // Menambahkan data ke sheet
        $sheet->setCellValue("A" . $rowNumber, $no);
        $sheet->setCellValue("B" . $rowNumber, $data_penjualan['tgl']);
        $sheet->setCellValue("C" . $rowNumber, $data_penjualan['nomor']);
        $sheet->setCellValue("D" . $rowNumber, $qty);
        $sheet->setCellValue("E" . $rowNumber, number_format($harga_beli, 0, ',', '.'));
        $sheet->setCellValue("F" . $rowNumber, number_format($harga_jual, 0, ',', '.'));
        $sheet->setCellValue("G" . $rowNumber, number_format($selisih, 0, ',', '.'));

        $rowNumber++;
        $no++;
    }
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
