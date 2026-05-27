<?php
require("../../konek/koneksi.php");

$pg = $_GET['pg'] ?? '';
if ($pg === 'siswa') {
    $kelas = $_POST['kelas'] ?? '';

    $stmt = $pdo->prepare("SELECT nowa, nama FROM siswa WHERE kelas = :kelas AND nowa <> ''");
    $stmt->execute(['kelas' => $kelas]);

    echo "<option value=''>Pilih Siswa</option>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . htmlspecialchars($row['nowa']) . "'>" . htmlspecialchars($row['nama']) . "</option>";
    }
}
?>
