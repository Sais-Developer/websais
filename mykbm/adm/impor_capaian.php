<?php
require "../../konek/koneksi.php"; // $db = PDO
require "../../vendor/autoload.php";
require "../../konek/crud.php";

$idl = $_POST['idl'];
$semester = $setting['smt'];

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
            $elemen = trim($sheetData[$i][1] ?? '');
            $capaian = trim($sheetData[$i][2] ?? '');

            if ($elemen !== '' && $capaian !== '') {
                insert("cp_elemen", [
				    "id_lingkup" => $idl,
                    "elemen" => $elemen,
                    "capaian" => $capaian,
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
