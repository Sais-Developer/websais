<?php
require "../../konek/koneksi.php";
require "../../vendor/autoload.php";
require("../../konek/function.php");

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;

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
        $reader = ($extension == 'xls') ? new Xls() : new Xlsx();
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $pdo->beginTransaction(); 

        $check_sql = "SELECT 1 FROM nilai_skl WHERE idsiswa = :ids AND mapel = :mapel AND ki = :ki AND kode = :kode";
        $insert_sql = "INSERT INTO nilai_skl (idsiswa, mapel, kelas, ki, nilai, kode, ket) 
                       VALUES (:ids, :mapel, :kelas, :ki, :nilai, :kode, 'SMT')";
        $update_sql = "UPDATE nilai_skl SET nilai = :nilai WHERE idsiswa = :ids AND mapel = :mapel AND ki = :ki AND kode = :kode";

        $check_stmt = $pdo->prepare($check_sql);
        $insert_stmt = $pdo->prepare($insert_sql);
        $update_stmt = $pdo->prepare($update_sql);

        for ($a = 8; $a < 14; $a++) {
            $kode = $sheetData[3][$a];

            for ($i = 4; $i < count($sheetData); $i++) {
                $idm   = $sheetData[$i][1];
                $idj   = $sheetData[$i][2];
                $ids   = $sheetData[$i][3];
                $kelas = $sheetData[$i][5];
                $nilai = $sheetData[$i][$a];

                if (empty($ids) || empty($idm) || empty($idj)) continue;

                $check_stmt->execute([
                    ':ids' => $ids,
                    ':mapel' => $idm,
                    ':ki' => $idj,
                    ':kode' => $kode
                ]);

                if ($check_stmt->fetch()) {
                    
                    $update_stmt->execute([
                        ':nilai' => $nilai,
                        ':ids' => $ids,
                        ':mapel' => $idm,
                        ':ki' => $idj,
                        ':kode' => $kode
                    ]);
                } else {
                    
                    $insert_stmt->execute([
                        ':ids' => $ids,
                        ':mapel' => $idm,
                        ':kelas' => $kelas,
                        ':ki' => $idj,
                        ':nilai' => $nilai,
                        ':kode' => $kode
                    ]);
                }
            }
        }

        $pdo->commit();
        echo "Data berhasil diproses dengan PDO.";
    } else {
        echo "Format file tidak didukung.";
    }
}
?>
