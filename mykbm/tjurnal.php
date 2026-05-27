<?php
require("../konek/koneksi.php"); 
$pg = $_GET['pg'] ?? '';

if ($pg == 'tambah') {
    $tanggal = $_POST['tanggal'];
    $guru = $_POST['guru'];
    $kelas = $_POST['kelas'];
    $mapel = $_POST['mapel'];
    $materi = $_POST['materi'];
    $aktivitas = $_POST['aktivitas'];
    $metode = $_POST['metode'];
    $media = $_POST['media'];
    $kendala = $_POST['kendala'];
    $rencana = $_POST['rencana_lanjutan'];
    $ketercapaian = $_POST['ketercapaian'];
    $catatan = $_POST['catatan'];

    $sql = "INSERT INTO jurnal 
            (tanggal, guru, kelas, mapel, materi, aktivitas, metode, media, kendala, rencana_lanjutan, ketercapaian, catatan)
            VALUES 
            (:tanggal, :guru, :kelas, :mapel, :materi, :aktivitas, :metode, :media, :kendala, :rencana, :ketercapaian, :catatan)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':tanggal' => $tanggal,
        ':guru' => $guru,
        ':kelas' => $kelas,
        ':mapel' => $mapel,
        ':materi' => $materi,
        ':aktivitas' => $aktivitas,
        ':metode' => $metode,
        ':media' => $media,
        ':kendala' => $kendala,
        ':rencana' => $rencana,
        ':ketercapaian' => $ketercapaian,
        ':catatan' => $catatan
    ]);

}
if ($pg == 'edit') {
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $materi = $_POST['materi'];
    $aktivitas = $_POST['aktivitas'];
    $metode = $_POST['metode'];
    $media = $_POST['media'];
    $kendala = $_POST['kendala'];
    $rencana = $_POST['rencana_lanjutan'];
    $ketercapaian = $_POST['ketercapaian'];
    $catatan = $_POST['catatan'];

    $sql = "UPDATE jurnal SET 
                tanggal = :tanggal,
                materi = :materi,
                aktivitas = :aktivitas,
                metode = :metode,
                media = :media,
                kendala = :kendala,
                rencana_lanjutan = :rencana_lanjutan,
                ketercapaian = :ketercapaian,
                catatan = :catatan
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $update = $stmt->execute([
        ':tanggal' => $tanggal,
        ':materi' => $materi,
        ':aktivitas' => $aktivitas,
        ':metode' => $metode,
        ':media' => $media,
        ':kendala' => $kendala,
        ':rencana_lanjutan' => $rencana,
        ':ketercapaian' => $ketercapaian,
        ':catatan' => $catatan,
        ':id' => $id
    ]);

    if ($update) {
        echo "<script>alert('Jurnal berhasil diperbarui!');window.location='?pg=jurnal';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui jurnal!');</script>";
    }
}
if ($pg == 'hapus') {
    $id = $_POST['id'];
    $sql = "DELETE FROM jurnal WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $delete = $stmt->execute([':id' => $id]);

    
}

?>
