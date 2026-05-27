<?php
require("../../konek/koneksi.php");
require("../../konek/function.php");

$pg = $_GET['pg'] ?? '';

if ($pg == 'tambah') {
    $id_jadwal = $_POST['id_ujian'] ?? '';

    $stmtUjian = $pdo->prepare("SELECT * FROM ujian WHERE id_jadwal = :id_jadwal");
    $stmtUjian->bindParam(':id_jadwal', $id_jadwal, PDO::PARAM_STR);
    $stmtUjian->execute();
    $ujian = $stmtUjian->fetch(PDO::FETCH_ASSOC);

    if (!$ujian) {
        echo "Ujian tidak ditemukan.";
        exit;
    }

    $id_bank       = $ujian['idbank'];
    $kode_ujian    = $setting['kode_ujian'];
    $sesi          = $_POST['sesi'] ?? '';
    $ruang         = $_POST['ruang'] ?? '';
    $mulai         = $_POST['mulai'] ?? '';
    $selesai       = $_POST['selesai'] ?? '';
    $nama_proktor  = $_POST['nama_proktor'] ?? '';
    $nip_proktor   = $_POST['nip_proktor'] ?? '';
    $nama_pengawas = $_POST['nama_pengawas'] ?? '';
    $nip_pengawas  = $_POST['nip_pengawas'] ?? '';
    $catatan       = $_POST['catatan'] ?? '';
    $tgl_ujian     = $_POST['tgl_ujian'] ?? '';
    $nosusulan     = serialize($_POST['nosusulan'] ?? []);
    $hadir         = $_POST['hadir'] ?? 0;
    $tidakhadir    = $_POST['tidakhadir'] ?? 0;

    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM berita WHERE id_bank = :id_bank AND sesi = :sesi AND ruang = :ruang");
    $stmtCheck->bindParam(':id_bank', $id_bank, PDO::PARAM_INT);
    $stmtCheck->bindParam(':sesi', $sesi, PDO::PARAM_STR);
    $stmtCheck->bindParam(':ruang', $ruang, PDO::PARAM_STR);
    $stmtCheck->execute();
    $count = $stmtCheck->fetchColumn();

    if ($count == 0) {
        $stmtInsert = $pdo->prepare("
            INSERT INTO berita (
                id_bank, sesi, ruang, jenis, mulai, selesai, 
                nama_proktor, nip_proktor, nama_pengawas, nip_pengawas, 
                catatan, tgl_ujian, no_susulan, ikut, susulan
            ) VALUES (
                :id_bank, :sesi, :ruang, :jenis, :mulai, :selesai,
                :nama_proktor, :nip_proktor, :nama_pengawas, :nip_pengawas,
                :catatan, :tgl_ujian, :no_susulan, :ikut, :susulan
            )
        ");

        $stmtInsert->execute([
            ':id_bank'       => $id_bank,
            ':sesi'          => $sesi,
            ':ruang'         => $ruang,
            ':jenis'         => $kode_ujian,
            ':mulai'         => $mulai,
            ':selesai'       => $selesai,
            ':nama_proktor'  => $nama_proktor,
            ':nip_proktor'   => $nip_proktor,
            ':nama_pengawas' => $nama_pengawas,
            ':nip_pengawas'  => $nip_pengawas,
            ':catatan'       => $catatan,
            ':tgl_ujian'     => $tgl_ujian,
            ':no_susulan'    => $nosusulan,
            ':ikut'          => $hadir,
            ':susulan'       => $tidakhadir
        ]);

        if ($stmtInsert->rowCount() > 0) {
            echo "OK";
        } else {
            echo "GAGAL";
        }
    } else {
        echo "berita acara gagal dibuat";
    }
}

if ($pg == 'hapus') {
    $kode = $_POST['id'] ?? '';
    $stmtDelete = $pdo->prepare("DELETE FROM berita WHERE id_berita = :id_berita");
    $stmtDelete->bindParam(':id_berita', $kode, PDO::PARAM_STR);
    $stmtDelete->execute();
}

if ($pg == 'list_siswa') {
    $iduji = $_POST['iduji'] ?? '';
    $sesi  = $_POST['sesi'] ?? '';
    $ruang = $_POST['ruang'] ?? '';

    $stmtUji = $pdo->prepare("SELECT tingkat FROM ujian WHERE id_jadwal = :id_jadwal");
    $stmtUji->bindParam(':id_jadwal', $iduji, PDO::PARAM_STR);
    $stmtUji->execute();
    $uji = $stmtUji->fetch(PDO::FETCH_ASSOC);
    $tingkat = $uji['tingkat'] ?? '';

    $stmtSiswa = $pdo->prepare("SELECT nopes, nama FROM siswa WHERE ruang = :ruang AND sesi = :sesi AND level = :level");
    $stmtSiswa->execute([
        ':ruang' => $ruang,
        ':sesi'  => $sesi,
        ':level' => $tingkat
    ]);

    echo "<option value=''>Pilih Siswa</option>";
    while ($siswa = $stmtSiswa->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . htmlspecialchars($siswa['nopes']) . "'>" . htmlspecialchars($siswa['nopes']) . " - " . htmlspecialchars($siswa['nama']) . "</option>";
    }
}

if ($pg == 'header') {
    $jawab = $_POST['jawab'] ?? '';
    $stmtHeader = $pdo->prepare("UPDATE pengaturan SET header_kartu = :header_kartu WHERE id_aplikasi = 1");
    $stmtHeader->bindParam(':header_kartu', $jawab, PDO::PARAM_STR);
    $stmtHeader->execute();
}
?>
