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
        if ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $check_stmt = $pdo->prepare("SELECT 1 FROM nilai_skl WHERE idsiswa = ? AND mapel = ? AND jurusan = ? AND kode = ?");
        $insert_stmt = $pdo->prepare("INSERT INTO nilai_skl (idsiswa, mapel, kelas, jurusan, nilai, kode, ket) VALUES (?, ?, ?, ?, ?, ?, 'SMT')");
        $update_stmt = $pdo->prepare("UPDATE nilai_skl SET nilai = ? WHERE idsiswa = ? AND mapel = ? AND jurusan = ? AND kode = ?");

        for ($a = 8; $a < 14; $a++) {
            $kode = $sheetData[3][$a];

            for ($i = 4; $i < count($sheetData); $i++) {
                $idm   = $sheetData[$i][1];
                $idj   = $sheetData[$i][2];
                $ids   = $sheetData[$i][3];
                $kelas = $sheetData[$i][5];
                $nilai = $sheetData[$i][$a];

                $check_stmt->execute([$ids, $idm, $idj, $kode]);
                $cek = $check_stmt->fetchColumn();

                if (!$cek) {
                    $insert_stmt->execute([$ids, $idm, $kelas, $idj, $nilai, $kode]);
                } else {
                    $update_stmt->execute([$nilai, $ids, $idm, $idj, $kode]);
                }
            }
        }

        echo "Data berhasil diproses dengan PDO prepared statement.";
    } else {
        echo "Format file tidak didukung.";
    }
}
?>
