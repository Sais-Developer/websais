<?php
require "../../konek/koneksi.php"; // $db = PDO
require "../../vendor/autoload.php";
require "../../konek/crud.php";

$mapel = $_POST['mapel'];
$tingkat = $_POST['level'];
$guru = $_POST['guru'];
$semester = $_POST['smt'];

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (!empty($_FILES['file']['tmp_name'])) {

    $allowed_ext = ['xls','xlsx'];
    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        echo "0"; 
        exit;
    }

    try {
        $reader = ($ext === 'xls') ? new Xls() : new Xlsx();
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();
       
        for ($i = 3; $i < count($sheetData); $i++) {
            $lingkup = trim($sheetData[$i][1] ?? '');
            $tujuan = trim($sheetData[$i][2] ?? '');

            if ($lingkup !== '' && $tujuan !== '') {
                insert("adm_tp", [
				    "tingkat" => $tingkat,
                    "lingkup" => $lingkup,
                    "tujuan" => $tujuan,
					"mapel" => $mapel,
					"guru" => $guru,
					"semester" => $semester
                ]);
            }
        }

        echo "1"; 
    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        error_log("Import Error: " . $e->getMessage());
        echo "0"; 
    }
} else {
    echo "0"; 
}
