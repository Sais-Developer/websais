<?php
require "../../konek/koneksi.php"; 
require "../../vendor/autoload.php";
require "../../konek/function.php";

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$file_mimes = [
    'application/vnd.ms-excel',
    'text/csv',
    'application/csv',
    'application/excel',
    'application/vnd.msexcel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

if (isset($_FILES['file']['name']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

    $ext = ['xls', 'xlsx'];
    $arr_file = explode('.', $_FILES['file']['name']);
    $extension = strtolower(end($arr_file));

    if (in_array($extension, $ext)) {

        $reader = ($extension === 'xls') ? new Xls() : new Xlsx();
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $sukses = 0;
        $tahun = date('Y');

        $pdo->exec("UPDATE pdb SET jumlah = 0");

        for ($i = 4; $i < count($sheetData); $i++) {
            $ids   = $sheetData[$i][0] ?? '';
            $nisn  = $sheetData[$i][1] ?? '';
            $nis   = $sheetData[$i][2] ?? '';
            $level = $sheetData[$i][3] ?? '';
            $kelas = $sheetData[$i][4] ?? '';
            $nama  = $sheetData[$i][5] ?? '';
            $jk    = $sheetData[$i][6] ?? '';
            $agama = $sheetData[$i][7] ?? '';
            $nowa  = $sheetData[$i][8] ?? '';

            if (!empty($kelas)) {
                $stmtKelas = $pdo->prepare("SELECT kelas FROM m_kelas WHERE kelas = :kelas LIMIT 1");
                $stmtKelas->execute(['kelas' => $kelas]);
                if ($stmtKelas->rowCount() === 0) {
                    $stmtInsertKelas = $pdo->prepare("INSERT INTO m_kelas (level, kelas) VALUES (:level, :kelas)");
                    $stmtInsertKelas->execute(['level' => $level, 'kelas' => $kelas]);
                }
            }

            if (!empty($nis)) {
                $stmtSiswa = $pdo->prepare("SELECT nis FROM siswa WHERE nis = :nis LIMIT 1");
                $stmtSiswa->execute(['nis' => $nis]);

                if ($stmtSiswa->rowCount() === 0) {
                    $stmtInsertSiswa = $pdo->prepare("INSERT INTO siswa 
                        (nis, nisn, nama, level, kelas, jk, agama, nowa) 
                        VALUES (:nis, :nisn, :nama, :level, :kelas, :jk, :agama, :nowa)");
                    $stmtInsertSiswa->execute([
                        'nis'   => $nis,
                        'nisn'  => $nisn,
                        'nama'  => $nama,
                        'level' => $level,
                        'kelas' => $kelas,
                        'jk'    => $jk,
                        'agama' => $agama,
                        'nowa'  => $nowa
                    ]);
                    $sukses++;
                }
            }
        }

        $stmtPdb = $pdo->prepare("UPDATE pdb SET jumlah = :jumlah, tahun = :tahun");
        $stmtPdb->execute(['jumlah' => $sukses, 'tahun' => $tahun]);

        echo $sukses;

    } else {
        echo "0"; 
    }

} else {
    echo "0";
}
?>
