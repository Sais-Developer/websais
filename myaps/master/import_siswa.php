<?php
require "../../konek/koneksi.php";
require "../../vendor/autoload.php";
require "../../konek/function.php";

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if (!empty($_FILES['file']['name'])) {

    $allowed_ext = ['xls', 'xlsx'];
    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        echo "0";
        exit;
    }
    $reader = ($ext === "xls") ? new Xls() : new Xlsx();

    try {
        $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheet       = $spreadsheet->getActiveSheet()->toArray();
        $db->exec("SET FOREIGN_KEY_CHECKS = 0");
        $db->exec("TRUNCATE siswa");
        $db->exec("TRUNCATE m_kelas");
        $db->exec("SET FOREIGN_KEY_CHECKS = 1");

        $sqlKelas = $db->prepare("INSERT INTO m_kelas (level, kelas, jurusan, fase) VALUES (?, ?, ?, ?)");
        $sqlSiswa = $db->prepare("INSERT INTO siswa (nis, nisn, nama, level, fase, kelas, jurusan, jk, agama, nowa)
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $kelasList = [];

        for ($i = 4; $i < count($sheet); $i++) {

            $nisn   = trim($sheet[$i][1] ?? '');
            $nis    = trim($sheet[$i][2] ?? '');
            $level  = trim($sheet[$i][3] ?? '');
            $kelas  = trim($sheet[$i][4] ?? '');
            $jurusan = trim($sheet[$i][5] ?? '') ?: 'semua';
            $nama   = trim($sheet[$i][6] ?? '');
            $jk     = trim($sheet[$i][7] ?? '');
            $agama  = trim($sheet[$i][8] ?? '');
            $nowa   = trim($sheet[$i][9] ?? '');

            if ($nis == "") continue;
            if (in_array($level, ["1","2"])) $fase="A";
            elseif (in_array($level, ["3","4"])) $fase="B";
            elseif (in_array($level, ["5","6"])) $fase="C";
            elseif (in_array($level, ["7","8","9"])) $fase="D";
            elseif ($level == "10") $fase="E";
            elseif (in_array($level, ["11","12"])) $fase="F";
            else $fase="";

            if ($kelas != "") {
                $key = $kelas . "_" . $jurusan;

                if (!isset($kelasList[$key])) {
                    $kelasList[$key] = true;
                    $sqlKelas->execute([$level, $kelas, $jurusan, $fase]);
                }
            }

            $sqlSiswa->execute([
                $nis, $nisn, $nama, $level, $fase, $kelas, $jurusan, $jk, $agama, $nowa
            ]);
        }

        echo "1";

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
