<?php
require("../../konek/koneksi.php"); // pastikan $pdo sudah tersedia

$idbank  = $_POST['idb'] ?? '';
$kelas   = $_POST['kelas'] ?? '';
$rendah  = $_POST['rendah'] ?? 0;
$tinggi  = $_POST['tinggi'] ?? 0;

$stmt = $pdo->prepare("SELECT MIN(nilai) AS kecil, MAX(nilai) AS besar FROM nilai WHERE id_bank = :id_bank");
$stmt->execute(['id_bank' => $idbank]);
$sql = $stmt->fetch(PDO::FETCH_ASSOC);

$kecil = floatval($sql['kecil']);
$besar = floatval($sql['besar']);

$stmtSiswa = $pdo->prepare("SELECT id_siswa FROM siswa WHERE kelas = :kelas");
$stmtSiswa->execute(['kelas' => $kelas]);
$siswaList = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);

$stmtUpdate = $pdo->prepare("UPDATE nilai SET katrol = :katrol WHERE id_siswa = :id_siswa AND id_bank = :id_bank");

foreach ($siswaList as $data) {
    $id_siswa = $data['id_siswa'];
    $stmtNilai = $pdo->prepare("SELECT nilai FROM nilai WHERE id_bank = :id_bank AND id_siswa = :id_siswa");
    $stmtNilai->execute(['id_bank' => $idbank, 'id_siswa' => $id_siswa]);
    $dataxx = $stmtNilai->fetch(PDO::FETCH_ASSOC);

    if ($dataxx) {
        $nilai = floatval($dataxx['nilai']);

        if (($besar - $kecil) != 0) {
            $katrol = $rendah + (($nilai - $kecil) / ($besar - $kecil)) * ($tinggi - $rendah);
        } else {
            $katrol = $nilai;
        }
        $katrol = round($katrol);
        $stmtUpdate->execute([
            'katrol'   => $katrol,
            'id_siswa' => $id_siswa,
            'id_bank'  => $idbank
        ]);
    }
}

echo "OK";
?>
