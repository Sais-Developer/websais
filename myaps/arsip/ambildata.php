<?php
require("../../konek/koneksi.php");
require("../../konek/crud.php");

$pg = $_GET['pg'] ?? '';
if ($pg === 'siswa') {
    $kelas = $_POST['sekarang'] ?? '';

    $stmt = $pdo->prepare("SELECT nis, nama FROM siswa WHERE kelas = :kelas");
    $stmt->bindParam(':kelas', $kelas, PDO::PARAM_STR);
    $stmt->execute();

    echo "<option value=''>Pilih Siswa</option>";

    while ($kls = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value=".$kls['nis'].">".$kls['nama']."</option>";
    }
}
