<?php
require "../../konek/koneksi.php"; // $db = PDO
require "../../vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (!empty($_FILES['file']['tmp_name'])) {
    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['xls','xlsx'])) { echo "0"; exit; }

    $reader = ($ext === 'xls') ? new Xls() : new Xlsx();
    $spreadsheet = $reader->load($_FILES['file']['tmp_name']);

    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    // Kosongkan tabel
    $db->exec("TRUNCATE TABLE guru");

    // Prepare insert
    $stmt = $db->prepare("INSERT INTO guru (nip, nama, jabatan, username, password, nowa) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($sheetData as $i => $row) {
        if ($i < 4) continue; // skip header

        $nip      = trim($row['B'] ?? '');
        $nama     = trim($row['C'] ?? '');
        $jabatan  = trim($row['D'] ?? '');
        $username = trim($row['E'] ?? '');
        $password = trim($row['F'] ?? '');
        $nowa     = trim($row['G'] ?? '');

        // skip baris kosong
        if ($nip === '' && $nama === '') continue;

        $stmt->execute([$nip, $nama, $jabatan, $username, $password, $nowa]);
    }

    echo "1"; // sukses
}
?>
