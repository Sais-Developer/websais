<?php
require "../konek/koneksi.php";      
require "../vendor/autoload.php";
require("../konek/function.php");

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

        if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $stmt = $pdo->prepare("
            UPDATE siswa
            SET alamat = ?, 
                desa = ?, 
                kec = ?, 
                kab = ?, 
                ayah = ?, 
                ibu = ?, 
                pek_ayah = ?, 
                pek_ibu = ?, 
                t_lahir = ?, 
                tgl_lahir = ?
            WHERE id_siswa = ?
        ");

        for ($i = 4; $i < count($sheetData); $i++) {

            $ids     = $sheetData[$i][1];
            $tempat  = $sheetData[$i][7];
            $tgl     = $sheetData[$i][8];
            $alamat  = $sheetData[$i][9];
            $desa    = $sheetData[$i][10];
            $kec     = $sheetData[$i][11];
            $kab     = $sheetData[$i][12];
            $ayah    = $sheetData[$i][13];
            $ibu     = $sheetData[$i][14];
            $pek     = $sheetData[$i][15];
            $pekibu  = $sheetData[$i][16];
            $stmt->execute([
                $alamat, 
                $desa,
                $kec,
                $kab,
                $ayah,
                $ibu,
                $pek,
                $pekibu,
                $tempat,
                $tgl,
                $ids
            ]);
        }

        echo "1";   
    } else {
        echo "0";   
    }
}
