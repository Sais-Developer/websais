<?php
require "../../konek/koneksi.php"; 
require "../../vendor/autoload.php";
require("../../konek/function.php");

use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $reader = ($extension === 'xls') ? new \PhpOffice\PhpSpreadsheet\Reader\Xls() 
                                        : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        for ($a = 7; $a < 10; $a++) {
            $kode = $sheetData[3][$a]; 

            for ($i = 4; $i < count($sheetData); $i++) {
                $ids     = $sheetData[$i][1];
                $guru    = $sheetData[$i][2];
                $idm     = $sheetData[$i][3];
				$nis     = $sheetData[$i][4];
                $kelas   = $sheetData[$i][6];
                $nilai   = $sheetData[$i][$a];
                $semester= $setting['semester'];
                $tapel   = $setting['tp'];
                $ket     = 'PAT';

                $stmt = $pdo->prepare("SELECT COUNT(*) FROM nilai_rapor 
                                       WHERE idsiswa=:ids AND idmapel=:idm AND kodenilai=:kode 
                                         AND ket=:ket AND semester=:semester AND tapel=:tapel");
                $stmt->execute([
                    ':ids' => $ids,
                    ':idm' => $idm,
                    ':kode'=> $kode,
                    ':ket' => $ket,
                    ':semester' => $semester,
                    ':tapel' => $tapel
                ]);
                $cek = $stmt->fetchColumn();

                if ($cek == 0) {
                    $stmt = $pdo->prepare("INSERT INTO nilai_rapor 
                        (idsiswa, nis, idmapel, kelas, nilai, kodenilai, ket, semester, tapel, guru)
                        VALUES (:ids, :nis, :idm, :kelas, :nilai, :kode, :ket, :semester, :tapel, :guru)");
                    $stmt->execute([
                        ':ids' => $ids,
						':nis' => $nis,
                        ':idm' => $idm,
                        ':kelas' => $kelas,
                        ':nilai' => $nilai,
                        ':kode' => $kode,
                        ':ket' => $ket,
                        ':semester' => $semester,
                        ':tapel' => $tapel,
                        ':guru' => $guru
                    ]);
                } else {
                    $stmt = $pdo->prepare("UPDATE nilai_rapor 
                                           SET nilai=:nilai 
                                           WHERE idsiswa=:ids AND idmapel=:idm AND kodenilai=:kode 
                                             AND semester=:semester AND tapel=:tapel");
                    $stmt->execute([
                        ':nilai' => $nilai,
                        ':ids' => $ids,
                        ':idm' => $idm,
                        ':kode'=> $kode,
                        ':semester' => $semester,
                        ':tapel' => $tapel
                    ]);
                }
            }
        }
        echo "1";
    } else {
        echo "0";
    }
}
?>
