<?php
require "../../konek/koneksi.php";
require "../../vendor/autoload.php";
require("../../konek/function.php");

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
    $extension = end($arr_file);

    if (in_array($extension, $ext)) {
        $reader = ($extension === 'xls') 
            ? new \PhpOffice\PhpSpreadsheet\Reader\Xls() 
            : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $semester = $setting['semester'];
        $tapel    = $setting['tp'];
        $ket      = 'PTS';

        for ($a = 7; $a < 9; $a++) {
            $kode = $sheetData[3][$a]; // kolom kode nilai

            for ($i = 4; $i < count($sheetData); $i++) {
                $ids    = $sheetData[$i][1];
                $guru   = $sheetData[$i][2];
                $idm    = $sheetData[$i][3];
				$nis    = $sheetData[$i][4];
                $kelas  = $sheetData[$i][6];
                $nilai  = $sheetData[$i][$a];

                $stmt = $pdo->prepare("
                    SELECT COUNT(*) 
                    FROM nilai_rapor 
                    WHERE idsiswa = ? AND idmapel = ? AND kodenilai = ? AND ket = ? AND semester = ? AND tapel = ?
                ");
                $stmt->execute([$ids, $idm, $kode, $ket, $semester, $tapel]);
                $cek = $stmt->fetchColumn();

                if ($cek == 0) {
                   
                    $stmt = $pdo->prepare("
                        INSERT INTO nilai_rapor (idsiswa, nis, idmapel, kelas, nilai, kodenilai, ket, semester, tapel, guru)
                        VALUES (?, ?, ?, ?, ?, ?, 'PTS', ?, ?, ?)
                    ");
                    $success = $stmt->execute([$ids, $nis, $idm, $kelas, $nilai, $kode, $semester, $tapel, $guru]);
                    if (!$success) {
                        $errorInfo = $stmt->errorInfo();
                        echo "Insert Error: " . $errorInfo[2] . "<br>";
                    }
                } else {
                   
                    $stmt = $pdo->prepare("
                        UPDATE nilai_rapor 
                        SET nilai = ? 
                        WHERE idsiswa = ? AND idmapel = ? AND kodenilai = ? AND semester = ? AND tapel = ?
                    ");
                    $success = $stmt->execute([$nilai, $ids, $idm, $kode, $semester, $tapel]);
                    if (!$success) {
                        $errorInfo = $stmt->errorInfo();
                        echo "Update Error: " . $errorInfo[2] . "<br>";
                    }
                }
            }
        }
        echo "1";
    } else {
        echo "0";
    }
}
