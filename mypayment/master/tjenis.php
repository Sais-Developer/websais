<?php
require("../../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';

if ($pg == 'hapus') {
    $id = $_POST['id'];

    // Hapus data
    $stmt = $pdo->prepare("DELETE FROM m_bayar WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $stmt = $pdo->query("SELECT id FROM m_bayar ORDER BY id");
    $rows = $stmt->fetchAll();

    $no = 1;
    foreach ($rows as $row) {
        $update = $pdo->prepare("UPDATE m_bayar SET id = :no WHERE id = :id");
        $update->execute([
            ':no' => $no,
            ':id' => $row['id']
        ]);
        $no++;
    }
    $pdo->exec("ALTER TABLE m_bayar AUTO_INCREMENT = $no");

    echo "OK";
}

if ($pg == 'tambah') {

    $besar  = $_POST['total'];
    $duit   = filter_var($besar, FILTER_SANITIZE_NUMBER_INT);
    $jumlah = $_POST['jumlah'];
    $angsur = $duit / $jumlah;

    $cek = $pdo->prepare("SELECT COUNT(*) FROM m_bayar WHERE kode = :kode");
    $cek->execute([':kode' => $_POST['kode']]);
    $count = $cek->fetchColumn();

    if ($count > 0) {
        echo "gagal";
        exit;
    }
    $stmt = $pdo->prepare("
        INSERT INTO m_bayar (kode, nama, model, total, jumlah, angsuran)
        VALUES (:kode, :nama, :model, :total, :jumlah, :angsuran)
    ");

    $ok = $stmt->execute([
        ':kode'     => $_POST['kode'],
        ':nama'     => $_POST['nama'],
        ':model'    => $_POST['model'],
        ':total'    => $duit,
        ':jumlah'   => $jumlah,
        ':angsuran' => $angsur
    ]);

    echo $ok ? "OK" : "Error";
}

if ($pg == 'edit') {

    $id     = $_POST['id'];
    $besar  = $_POST['total'];
    $duit   = filter_var($besar, FILTER_SANITIZE_NUMBER_INT);
    $jumlah = $_POST['jumlah'];
    $angsur = $duit / $jumlah;

    $stmt = $pdo->prepare("
        UPDATE m_bayar SET 
            kode = :kode,
            nama = :nama,
            model = :model,
            total = :total,
            jumlah = :jumlah,
            angsuran = :angsuran
        WHERE id = :id
    ");

    $ok = $stmt->execute([
        ':kode'     => $_POST['kode'],
        ':nama'     => $_POST['nama'],
        ':model'    => $_POST['model'],
        ':total'    => $duit,
        ':jumlah'   => $jumlah,
        ':angsuran' => $angsur,
        ':id'       => $id
    ]);

    echo $ok ? "OK" : "Error";
}
if ($pg == 'bayar') {

    $stmt = $pdo->prepare("
        UPDATE k_bayar SET 
            kelas = :kelas,
            idb   = :idb
    ");

    $ok = $stmt->execute([
        ':kelas' => $_POST['kelas'],
        ':idb'   => $_POST['idb']
    ]);

    echo $ok ? "OK" : "Error";
}
?>
