<?php
require "../../konek/koneksi.php";
require "../../vendor/autoload.php";
require "../../konek/function.php";

$kuri = $_POST['kuri'];

// Validasi file
$file_mimes = [
    'application/vnd.ms-excel',
    'text/csv',
    'application/csv',
    'application/excel',
    'application/vnd.msexcel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

if (isset($_FILES['file']['name'])) {
    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, ['xls', 'xlsx'])) {
       
        $reader = ($ext == 'xls')
            ? new \PhpOffice\PhpSpreadsheet\Reader\Xls()
            : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        if ($kuri == '1') {
            $insert_stmt = $pdo->prepare("
                INSERT INTO nilai_skl (idsiswa, mapel, kelas, jurusan, nilai, kode, ket, ki)
                VALUES (?, ?, ?, ?, ?, ?, 'US', 'KI3')
            ");
        } else {
            $insert_stmt = $pdo->prepare("
                INSERT INTO nilai_skl (idsiswa, mapel, kelas, jurusan, nilai, kode, ket)
                VALUES (?, ?, ?, ?, ?, ?, 'US')
            ");
        }

        $update_stmt = $pdo->prepare("
            UPDATE nilai_skl 
            SET nilai = ? 
            WHERE idsiswa = ? AND mapel = ? AND jurusan = ? AND kode = ? AND ket = 'US'
        ");

        for ($a = 8; $a < 10; $a++) {
            $kode = $sheetData[3][$a]; 

            for ($i = 4; $i < count($sheetData); $i++) {
                $idm   = $sheetData[$i][1]; 
                $idj   = $sheetData[$i][2]; 
                $ids   = $sheetData[$i][3]; 
                $kelas = $sheetData[$i][5]; 
                $nilai = $sheetData[$i][$a]; 

                if (empty($ids) || empty($idm) || empty($idj)) continue;

                $cek_stmt = $pdo->prepare("
                    SELECT 1 FROM nilai_skl 
                    WHERE idsiswa = ? AND mapel = ? AND jurusan = ? AND kode = ? AND ket = 'US'
                    LIMIT 1
                ");
                $cek_stmt->execute([$ids, $idm, $idj, $kode]);
                $exists = $cek_stmt->fetchColumn();

                if (!$exists) {
                    $insert_stmt->execute([$ids, $idm, $kelas, $idj, $nilai, $kode]);
                } else {
                    $update_stmt->execute([$nilai, $ids, $idm, $idj, $kode]);
                }
            }
        }

        echo "Import data berhasil diproses.";
    } else {
        echo "Format file tidak didukung.";
    }
}
?>
