<?php
require("../../konek/koneksi.php"); // pastikan ini menghasilkan $pdo

$pg = $_GET['pg'] ?? '';

// ---------------------
// HAPUS KATEGORI
// ---------------------
if ($pg == 'hapus') {
    $id = $_POST['id'];

    // Hapus kategori
    $stmt = $pdo->prepare("DELETE FROM kategori_pelanggaran WHERE id_kategori = :id");
    $stmt->execute(['id' => $id]);

    // Hapus pelanggaran yg terkait kategori
    $stmt2 = $pdo->prepare("DELETE FROM pelanggaran WHERE id_kategori = :id");
    $stmt2->execute(['id' => $id]);

    exit("ok");
}



// ---------------------
// TAMBAH / EDIT KATEGORI
// ---------------------
if ($pg == 'tambah') {

    $idk  = $_POST['idk'];
    $nama = $_POST['kate'];
    $ket  = $_POST['ket']; 
    $cek = $pdo->prepare("SELECT COUNT(*) FROM kategori_pelanggaran WHERE nama_kategori = :nama");
    $cek->execute(['nama' => $nama]);
    $count = $cek->fetchColumn();
    if ($ket === 'tambah') {

        if ($count > 0) {
            exit("gagal");
        }

        $stmt = $pdo->prepare("
            INSERT INTO kategori_pelanggaran (nama_kategori)
            VALUES (:nama)
        ");
        $stmt->execute(['nama' => $nama]);

        exit("ok");
    }
    else {

        $stmt = $pdo->prepare("
            UPDATE kategori_pelanggaran 
            SET nama_kategori = :nama 
            WHERE id_kategori = :id
        ");

        $stmt->execute([
            'nama' => $nama,
            'id'   => $idk
        ]);

        exit("ok");
    }
}
?>
