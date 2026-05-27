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
        if ($extension === 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        for ($a = 6; $a < 15; $a++) {
            $kode = $sheetData[3][$a]; 

            for ($i = 4; $i < count($sheetData); $i++) {
                $ids   = $sheetData[$i][1];
                $idk   = $sheetData[$i][2];
                $dudi  = $sheetData[$i][3];
                $kelas = $sheetData[$i][5];
                $nilai = $sheetData[$i][$a];

                $stmt = $pdo->prepare("SELECT COUNT(*) FROM pkl_nilai WHERE idsiswa = ? AND iddudi = ? AND aspek = ?");
                $stmt->execute([$ids, $dudi, $kode]);
                $cek = $stmt->fetchColumn();

                if ($cek == 0) {
                   
                    $stmt = $pdo->prepare("
                        INSERT INTO pkl_nilai (idsiswa, kelas, iddudi, aspek, nilai)
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    if (!$stmt->execute([$ids, $kelas, $dudi, $kode, $nilai])) {
                        $errorInfo = $stmt->errorInfo();
                        echo "Insert Error: (" . $errorInfo[1] . ") " . $errorInfo[2] . "<br>";
                    }
                } else {
          
                    $stmt = $pdo->prepare("
                        UPDATE pkl_nilai SET nilai = ? 
                        WHERE idsiswa = ? AND iddudi = ? AND aspek = ?
                    ");
                    if (!$stmt->execute([$nilai, $ids, $dudi, $kode])) {
                        $errorInfo = $stmt->errorInfo();
                        echo "Update Error: (" . $errorInfo[1] . ") " . $errorInfo[2] . "<br>";
                    }
                }
            }
        }
        echo "1";
    } else {
        echo "0";
    }
}
?>
