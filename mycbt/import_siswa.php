<?php
require "../konek/koneksi.php"; 
require "../vendor/autoload.php";
require("../konek/function.php");

$file_mimes = ['application/vnd.ms-excel', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

if (isset($_FILES['file']['name'])) {
    $ext = ['xls', 'xlsx'];
    $arr_file = explode('.', $_FILES['file']['name']);
    $extension = end($arr_file);

    if (in_array($extension, $ext)) {
        if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $stmt = $pdo->prepare("UPDATE siswa SET nopes = ?, sesi = ?, ruang = ?, username = ?, password = ? WHERE id_siswa = ?");

        for ($i = 4; $i < count($sheetData); $i++) {
            $ids = $sheetData[$i][1];
            $nopes = $sheetData[$i][4];
            $username = $sheetData[$i][5];
            $password = $sheetData[$i][6];
            $ruang = $sheetData[$i][7];
            $sesi = $sheetData[$i][8];

            $stmt->execute([$nopes, $sesi, $ruang, $username, $password, $ids]);
        }

        echo "1";
    } else {
        echo "0";
    }
}
?>
