<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");
require "../../vendor/autoload.php";
session_start();
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$style_col = [
    'font' => ['bold' => true], 
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
    ]
];


$style_row = [
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ],
    'borders' => [
        'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
        'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
        'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
        'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
    ]
];

$kelas = $_GET['k'];
$dudi = $_GET['d'];


$sheet->setCellValue('A1', "INPUT NILAI PRAKERIN"); 
$sheet->mergeCells('A1:O1'); 
$sheet->getStyle('A1')->getFont()->setBold(true); 
$sheet->getStyle('A1')->getFont()->setSize(15); 
$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); 
 
$sheet->setCellValue('A2', 'Rentang Nilai 0 - 100'); 
$sheet->mergeCells('A2:O2'); 
$sheet->getStyle('A2')->getFont()->setBold(true); 
$sheet->getStyle('A2')->getFont()->setSize(12); 
$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); 

$sheet->setCellValue('A3', ''); 
$sheet->mergeCells('A3:O3'); 
$sheet->getStyle('A3')->getFont()->setBold(true); 
$sheet->getStyle('A3')->getFont()->setSize(13); 
$sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); 
 
 
$sheet->setCellValue('A4', "NO");
$sheet->setCellValue('B4', "IDS"); 
$sheet->setCellValue('C4', "IDK"); 
$sheet->setCellValue('D4', "DUDI");
$sheet->setCellValue('E4', "NAMA SISWA");
$sheet->setCellValue('F4', "KELAS");
$sheet->setCellValue('G4', "A1");
$sheet->setCellValue('H4', "A2");
$sheet->setCellValue('I4', "A3");
$sheet->setCellValue('J4', "A4");
$sheet->setCellValue('K4', "B1");
$sheet->setCellValue('L4', "B2");
$sheet->setCellValue('M4', "B3");
$sheet->setCellValue('N4', "C1");
$sheet->setCellValue('O4', "D1");

$sheet->getStyle('A4')->applyFromArray($style_col);
$sheet->getStyle('B4')->applyFromArray($style_col);
$sheet->getStyle('C4')->applyFromArray($style_col);
$sheet->getStyle('D4')->applyFromArray($style_col);
$sheet->getStyle('E4')->applyFromArray($style_col);
$sheet->getStyle('F4')->applyFromArray($style_col);
$sheet->getStyle('G4')->applyFromArray($style_col);
$sheet->getStyle('H4')->applyFromArray($style_col);
$sheet->getStyle('I4')->applyFromArray($style_col);
$sheet->getStyle('J4')->applyFromArray($style_col);
$sheet->getStyle('K4')->applyFromArray($style_col);
$sheet->getStyle('L4')->applyFromArray($style_col);
$sheet->getStyle('M4')->applyFromArray($style_col);
$sheet->getStyle('N4')->applyFromArray($style_col);
$sheet->getStyle('O4')->applyFromArray($style_col);

$sheet->getRowDimension('1')->setRowHeight(20);
$sheet->getRowDimension('2')->setRowHeight(20);
$sheet->getRowDimension('3')->setRowHeight(20);


$i=5; 
$no=1; 
$sql = "
    SELECT p.*, s.nama, s.kelas
    FROM pkl_siswa p
    LEFT JOIN siswa s ON s.id_siswa = p.idsiswa
    WHERE p.kelas = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$kelas]); 
while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    $sheet->setCellValue('A' . $i, $no);
    $sheet->setCellValue('B' . $i, $data['idsiswa']);   
	$sheet->setCellValue('C' . $i, '');
	$sheet->setCellValue('D' . $i, $dudi);
	$sheet->setCellValue('E' . $i, $data['nama']);   
	$sheet->setCellValue('F' . $i, $data['kelas']);
	$sheet->setCellValue('G' . $i, '');
    $sheet->setCellValue('H' . $i, '');
	$sheet->setCellValue('I' . $i, '');
	$sheet->setCellValue('J' . $i, '');
	$sheet->setCellValue('K' . $i, '');
	$sheet->setCellValue('L' . $i, '');
	$sheet->setCellValue('M' . $i, '');
	$sheet->setCellValue('N' . $i, '');
	$sheet->setCellValue('O' . $i, '');
	
	 $sheet->getStyle('A' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('E' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT); 
    $sheet->getStyle('F' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER); 
	$sheet->getStyle('G' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('H' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('I' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('J' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('K' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('L' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('M' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	$sheet->getStyle('N' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('O' . $i)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
	
	
   $sheet->getRowDimension($i)->setRowHeight(20); 

   $i++; $no++;
}

$sheet->getColumnDimension('A')->setAutoSize(true); 
$sheet->getColumnDimension('B')->setWidth(0);
$sheet->getColumnDimension('C')->setWidth(0);
$sheet->getColumnDimension('D')->setWidth(0);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getColumnDimension('I')->setAutoSize(true);
$sheet->getColumnDimension('J')->setAutoSize(true);
$sheet->getColumnDimension('K')->setAutoSize(true);
$sheet->getColumnDimension('L')->setAutoSize(true);
$sheet->getColumnDimension('M')->setAutoSize(true);
$sheet->getColumnDimension('N')->setAutoSize(true);
$sheet->getColumnDimension('O')->setAutoSize(true);

$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
$sheet->setTitle("DATA SISWA");

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=FORMAT_NILAI_PRAKERIN $kelas.xlsx");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
?>