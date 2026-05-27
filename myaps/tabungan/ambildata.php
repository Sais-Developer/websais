<?php
require("../../konek/koneksi.php");

$pg = isset($_GET['pg']) ? $_GET['pg'] : '';

if ($pg == 'siswa') {
    $kelas = $_POST['kelas'];
    $sql = "SELECT id_siswa, nama FROM siswa WHERE kelas = :kelas";  
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':kelas', $kelas, PDO::PARAM_STR);
    $stmt->execute();
    echo "<option value=''>Pilih Siswa</option>";
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$data['id_siswa']}'>{$data['nama']}</option>";
    }

    $stmt->closeCursor();  
}

if ($pg == 'saldo') {
    $ids = $_POST['siswa'];

    $sql = "SELECT id_siswa, saldo, nama FROM siswa WHERE id_siswa = :id_siswa";  
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_siswa', $ids, PDO::PARAM_INT);

    $stmt->execute();
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $formatted_saldo = number_format($data['saldo'], 0, ',', '.');
        echo "<option value='{$data['saldo']}'> Rp {$formatted_saldo}</option>";
    }

    $stmt->closeCursor();  
}
?>
