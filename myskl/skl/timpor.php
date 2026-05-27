<?php
require "../../konek/koneksi.php";
require "../../vendor/autoload.php";
require "../../konek/function.php";

$file_mimes = [
    'application/vnd.ms-excel',
    'text/csv',
    'application/csv',
    'application/excel',
    'application/vnd.msexcel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

if (isset($_FILES['file']['name'])) {
    $ext = ['xls', 'xlsx'];
    $arr_file = explode('.', $_FILES['file']['name']);
    $extension = strtolower(end($arr_file));

    if (in_array($extension, $ext)) {
        $reader = ($extension === 'xls') 
            ? new \PhpOffice\PhpSpreadsheet\Reader\Xls() 
            : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $update_stmt = $pdo->prepare("UPDATE siswa SET ket = ? WHERE id_siswa = ?");

        for ($i = 4; $i < count($sheetData); $i++) {
            $ids = $sheetData[$i][1];  // kolom 1
            $ket = $sheetData[$i][7];  // kolom 7

            if (!empty($ids)) {
                $update_stmt->execute([$ket, $ids]);
            }
        }

        echo "1"; 
    } else {
        echo "0"; 
    }
}
?>
