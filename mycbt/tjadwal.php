<?php
require("../konek/koneksi.php"); // pastikan $pdo tersedia

$pg = $_GET['pg'] ?? '';

if ($pg === 'ubah') {
    $id          = $_POST['idu']         ?? 0;
    $lama_ujian  = $_POST['lama_ujian']  ?? '';
    $tgl_ujian   = $_POST['tgl_ujian']   ?? '';
    $tgl_selesai = $_POST['tgl_selesai'] ?? '';
    $sesi        = $_POST['sesi']        ?? '';
    $kkm         = $_POST['kkm']         ?? '';
    $langgar     = $_POST['langgar']     ?? '';

    if (!$id) exit("ID ujian tidak valid");

    $stmt = $pdo->prepare("
        UPDATE ujian 
        SET lama_ujian = ?, tgl_ujian = ?, tgl_selesai = ?, sesi = ?, kkm = ?, pelanggaran = ?
        WHERE id_jadwal = ?
    ");
    $stmt->execute([$lama_ujian, $tgl_ujian, $tgl_selesai, $sesi, $kkm, $langgar, $id]);
    echo "Data ujian berhasil diperbarui.";
}

if ($pg === 'tambah') {
    $idbank      = $_POST['idbank']      ?? '';
    $lama_ujian  = $_POST['lama_ujian']  ?? '';
    $tgl_ujian   = $_POST['tgl_ujian']   ?? '';
    $tgl_selesai = $_POST['tgl_selesai'] ?? '';
    $sesi        = $_POST['sesi']        ?? '';
    $kkm         = $_POST['kkm']         ?? '';
    $langgar     = $_POST['langgar']     ?? '';

    if (!$idbank || !$tgl_ujian || !$tgl_selesai) exit("Data tidak lengkap");

    $stmt = $pdo->prepare("SELECT tingkat, jurusan, soal_agama FROM banksoal WHERE id_bank = ?");
    $stmt->execute([$idbank]);
    $bank = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$bank) exit("Data bank soal tidak ditemukan");

    $stmt = $pdo->prepare("SELECT COUNT(*) AS jml FROM ujian WHERE idbank = ? AND sesi = ?");
    $stmt->execute([$idbank, $sesi]);
    if ($stmt->fetchColumn() > 0) exit("Jadwal sudah ada");

    $stmt = $pdo->prepare("
        INSERT INTO ujian (idbank, lama_ujian, tgl_ujian, tgl_selesai, tingkat, jurusan, sesi, kkm, status, pelanggaran, soal_agama)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1, ?, ?)
    ");
    $stmt->execute([$idbank, $lama_ujian, $tgl_ujian, $tgl_selesai, $bank['tingkat'], $bank['jurusan'], $sesi, $kkm, $langgar, $bank['soal_agama']]);
    echo "Jadwal berhasil ditambahkan";
}
?>
