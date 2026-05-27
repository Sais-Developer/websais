<?php
require("../../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';

if ($pg == 'hapus') {

    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM pelanggaran WHERE id = :id");
    $stmt->execute(['id' => $id]);

    exit("ok");
}

if ($pg == 'tambah') {

    $id     = $_POST['id'] ?? '';
    $idkate = $_POST['idkate'];
    $nama   = $_POST['pelanggaran'];
    $poin   = $_POST['poin'];
    $ket    = $_POST['ket'];   

    if ($ket == 'tambah') {

        $cek = $pdo->prepare("SELECT COUNT(*) FROM pelanggaran WHERE nama_pelanggaran = :nama");
        $cek->execute(['nama' => $nama]);
        $count = $cek->fetchColumn();

        if ($count > 0) {
            exit("gagal");
        }
        $stmt = $pdo->prepare("
            INSERT INTO pelanggaran (nama_pelanggaran, poin, id_kategori)
            VALUES (:nama, :poin, :idkate)
        ");

        $sukses = $stmt->execute([
            'nama'   => $nama,
            'poin'   => $poin,
            'idkate' => $idkate
        ]);

        exit($sukses ? "sukses" : "gagal");
    }
    elseif ($ket == 'ubah') {

        $stmt = $pdo->prepare("
            UPDATE pelanggaran
            SET nama_pelanggaran = :nama, 
                poin = :poin, 
                id_kategori = :idkate
            WHERE id = :id
        ");

        $sukses = $stmt->execute([
            'nama'   => $nama,
            'poin'   => $poin,
            'idkate' => $idkate,
            'id'     => $id
        ]);

        exit($sukses ? "sukses" : "gagal");
    }

    else {
        exit("aksi tidak dikenali");
    }
}
?>
