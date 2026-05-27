<?php
require("../../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';

if ($pg === 'hapus') {
    $id = $_POST['id'] ?? '';

    $stmt = $pdo->prepare("DELETE FROM pkl_kompetensi WHERE id_kompetensi = :id");
    $stmt->execute(['id' => $id]);
}

if ($pg === 'tambah') {
    $pk       = $_POST['pk'] ?? '';
    $kompeten = $_POST['kompeten'] ?? '';
    $deskrip  = $_POST['deskrip'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO pkl_kompetensi (jurusan, kompeten, deskrip) VALUES (:jurusan, :kompeten, :deskrip)");
    $stmt->execute([
        'jurusan'  => $pk,
        'kompeten' => $kompeten,
        'deskrip'  => $deskrip
    ]);
}

if ($pg === 'edit') {
    $idk      = $_POST['idk'] ?? '';
    $pk       = $_POST['pk'] ?? '';
    $kompeten = $_POST['kompeten'] ?? '';
    $deskrip  = $_POST['deskrip'] ?? '';

    $stmt = $pdo->prepare("
        UPDATE pkl_kompetensi 
        SET jurusan = :jurusan, kompeten = :kompeten, deskrip = :deskrip
        WHERE id_kompetensi = :id
    ");

    if ($stmt->execute([
        'jurusan'  => $pk,
        'kompeten' => $kompeten,
        'deskrip'  => $deskrip,
        'id'       => $idk
    ])) {
        echo "<script>alert('Data berhasil diperbarui!');</script>";
    } else {
        $error = $stmt->errorInfo();
        echo "<script>alert('Gagal memperbarui data: " . $error[2] . "');</script>";
    }
}
?>
