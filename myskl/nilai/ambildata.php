<?php
require("../../konek/koneksi.php"); 
require("../../konek/crud.php"); 
$pg = $_GET['pg'] ?? '';

if ($pg == 'pk') {

    $kelas = $_POST['kelas'];

    $sql = "SELECT jurusan FROM m_kelas WHERE kelas = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$kelas]);

    echo "<option value=''>Pilih Jurusan</option>";
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$data['jurusan']}'>{$data['jurusan']}</option>";
    }
}

if ($pg == 'mapel') {

    $kelas = $_POST['kelas'];
    $pk    = $_POST['pk'];

    $lvl = fetch('m_kelas', ['kelas' => $kelas]); 
    $level = $lvl['level'];

    $sql = "SELECT p.id, p.nama_mapel, m.idmapel 
            FROM mapel_rapor m
            LEFT JOIN mapel p ON p.id = m.idmapel
            WHERE m.tingkat = ? AND m.jurusan = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$level, $pk]);

    echo "<option value=''>Pilih Mapel</option>";
    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$data['idmapel']}'>{$data['nama_mapel']}</option>";
    }
}

?>
