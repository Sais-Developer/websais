<?php
require("../../konek/koneksi.php");

$idj  = $_POST['idj'] ?? '';
$skor = $_POST['skor'] ?? '';

if (empty($idj) || !is_numeric($skor)) {
    echo "GAGAL: Input tidak valid";
    exit;
}

$sql = "
    SELECT s.max_skor, a.id_siswa, a.id_bank 
    FROM arsip_jawaban a
    JOIN soal s ON s.id_bank = a.id_bank AND a.id_soal = s.id_soal
    WHERE a.id_jawaban = :idj
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['idj' => $idj]);
$jawab = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$jawab) {
    echo "GAGAL: Data tidak ditemukan";
    exit;
}

$max_skor = floatval($jawab['max_skor']);
$skor     = floatval($skor);

if ($skor > $max_skor) {
    echo "GAGAL: Skor lebih dari $max_skor";
    exit;
}

$id_siswa = (int)$jawab['id_siswa'];
$id_bank  = (int)$jawab['id_bank'];

$stmtUpdate = $pdo->prepare("UPDATE arsip_jawaban SET skor = :skor WHERE id_jawaban = :idj");
$success = $stmtUpdate->execute([
    'skor' => $skor,
    'idj'  => $idj
]);

if (!$success) {
    echo "GAGAL: Tidak dapat menyimpan skor";
    exit;
}

$stmtSkor = $pdo->prepare("
    SELECT SUM(skor) AS total_skor
    FROM arsip_jawaban
    WHERE id_bank = :id_bank AND id_siswa = :id_siswa
");
$stmtSkor->execute([
    'id_bank'  => $id_bank,
    'id_siswa' => $id_siswa
]);
$total_skor = (float)$stmtSkor->fetchColumn();

$stmtMax = $pdo->prepare("
    SELECT SUM(max_skor) AS total_max
    FROM soal
    WHERE id_bank = :id_bank
");
$stmtMax->execute(['id_bank' => $id_bank]);
$total_max = (float)$stmtMax->fetchColumn();

$nilai_akhir = ($total_max > 0) ? ($total_skor / $total_max) * 100 : 0;
$nilai_akhir = min(100, $nilai_akhir);

$stmtUpdateNilai = $pdo->prepare("
    UPDATE nilai
    SET nilai = :nilai, skor = :total_skor
    WHERE id_bank = :id_bank AND id_siswa = :id_siswa
");
$stmtUpdateNilai->execute([
    'nilai'      => $nilai_akhir,
    'total_skor' => $total_skor,
    'id_bank'    => $id_bank,
    'id_siswa'   => $id_siswa
]);

echo "OK";
?>
