<?php
require("konek/koneksi.php");
require("konek/function.php");
require("konek/crud.php");

$id_bank  = $_POST['id_bank'];
$id_siswa = $_POST['id_siswa'];
$id_ujian = $_POST['id_ujian'];

$stmt = $pdo->prepare("SELECT COUNT(*) FROM soal WHERE id_bank = ?");
$stmt->execute([$id_bank]);
$jumsoal = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM jawaban WHERE id_bank = ? AND id_siswa = ?");
$stmt->execute([$id_bank, $id_siswa]);
$jumjawab = $stmt->fetchColumn();

$stmt = $pdo->prepare("SELECT COUNT(*) FROM jawaban WHERE id_bank = ? AND id_siswa = ? AND ragu = 1");
$stmt->execute([$id_bank, $id_siswa]);
$cekragu = $stmt->fetchColumn();

if ($jumsoal == $jumjawab) {
    if ($cekragu == 0) {
        echo "ok"; 
    } else {
        echo "ragu"; 
    }
} else {
    echo "belum"; 
}
?>
