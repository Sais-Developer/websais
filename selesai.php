<?php
require("konek/koneksi.php");
require("konek/function.php");
require("konek/crud.php");

$idm = (int)$_POST['id_bank'];
$ids = (int)$_POST['id_siswa'];
$waktumu = date('Y-m-d H:i:s');

$totalsoal = $pdo->prepare("SELECT COUNT(*) FROM soal WHERE id_bank = ?");
$totalsoal->execute([$idm]);
$totalsoal = $totalsoal->fetchColumn();

$totaljawaban = $pdo->prepare("SELECT COUNT(*) FROM jawaban WHERE id_bank = ? AND id_siswa = ?");
$totaljawaban->execute([$idm, $ids]);
$totaljawaban = $totaljawaban->fetchColumn();

$total_skor = $pdo->prepare("SELECT SUM(skor) FROM jawaban WHERE id_bank = ? AND id_siswa = ?");
$total_skor->execute([$idm, $ids]);
$total_skor = $total_skor->fetchColumn() ?? 0;

$total_max = $pdo->prepare("SELECT SUM(max_skor) FROM soal WHERE id_bank = ?");
$total_max->execute([$idm]);
$total_max = $total_max->fetchColumn() ?? 0;

$nilai_akhir = ($total_max > 0) ? ($total_skor / $total_max) * 100 : 0;
if ($nilai_akhir > 100) {
    $nilai_akhir = 100;
}

$hapus_flag = ($totalsoal === $totaljawaban) ? 0 : 1;
$update = $pdo->prepare("
    UPDATE nilai 
    SET ujian_selesai = ?, nilai = ?, skor = ?, online = 0, hapus = ?
    WHERE id_bank = ? AND id_siswa = ?
");
$update->execute([$waktumu, $nilai_akhir, $total_skor, $hapus_flag, $idm, $ids]);

if ($totalsoal === $totaljawaban) {
    
    $copy = $pdo->prepare("
        INSERT INTO arsip_jawaban (id_siswa, id_bank, id_soal, jawaban, jenis, warna, skor)
        SELECT id_siswa, id_bank, id_soal, jawaban, jenis, warna, skor
        FROM jawaban
        WHERE id_bank = ? AND id_siswa = ?
    ");
    $copy->execute([$idm, $ids]);

    $delete = $pdo->prepare("DELETE FROM jawaban WHERE id_bank = ? AND id_siswa = ?");
    $delete->execute([$idm, $ids]);

    $aktivitas = "Selesai Ujian";
} else {
    $aktivitas = "Pelanggaran Ujian";
}

$log = $pdo->prepare("INSERT INTO log_ujian (id_siswa, id_bank, aktivitas, waktu) VALUES (?, ?, ?)");
$log->execute([$ids, $idm, $aktivitas, $waktumu]);

echo "OK";
?>
