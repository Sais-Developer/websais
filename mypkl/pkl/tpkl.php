<?php
require("../../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';

if ($pg === 'hapus') {
    $id = $_POST['id'] ?? '';

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM pkl_siswa WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}

if ($pg === 'tambah') {
    $kelas = $_POST['kelas'] ?? '';
    $guru  = $_POST['guru'] ?? '';
    $dudi  = $_POST['dudi'] ?? '';
    $ids   = $_POST['idsiswa'] ?? [];

    if (!empty($ids)) {
        $stmt = $pdo->prepare("INSERT INTO pkl_siswa (idsiswa, kelas, dudi, idguru) VALUES (:idsiswa, :kelas, :dudi, :idguru)");

        foreach ($ids as $idsiswa) {
            $stmt->execute([
                ':idsiswa' => $idsiswa,
                ':kelas'   => $kelas,
                ':dudi'    => $dudi,
                ':idguru'  => $guru
            ]);
        }
    }
}
?>
