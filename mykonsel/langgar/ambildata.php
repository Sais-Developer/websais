<?php
require("../../konek/koneksi.php");

$pg = isset($_GET['pg']) ? $_GET['pg'] : '';

if ($pg == 'langgar') {
    $idkate = $_POST['idkate'];

    $sql = "SELECT * FROM pelanggaran WHERE id_kategori = :idkate";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['idkate' => $idkate]);
    $pelanggaranList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<option value=''>Pilih Pelanggaran</option>";
    foreach ($pelanggaranList as $data) {
        echo "<option value='" . htmlspecialchars($data['id']) . "'>" . 
             htmlspecialchars($data['nama_pelanggaran']) . "</option>";
    }
    $stmt = null;
}

if ($pg == 'siswa') {
    $kelas = $_POST['kelas'];

    $sql = "SELECT id_siswa, nama FROM siswa WHERE kelas = :kelas";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['kelas' => $kelas]);
    $siswaList = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<option value=''>Pilih Siswa</option>";
    foreach ($siswaList as $data) {
        echo "<option value='" . htmlspecialchars($data['id_siswa']) . "'>" . 
             htmlspecialchars($data['nama']) . "</option>";
    }
    $stmt = null;
}
?>
