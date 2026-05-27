<?php
require("../../konek/koneksi.php");

$pg = $_GET['pg'] ?? '';

if ($pg == 'jadwal') {
    $hari = date('D');
    $kelas = $_POST['kelas'] ?? '';

    echo "<option value=''>Pilih Mapel</option>";

    $sql = "SELECT jm.*, m.kode AS kode_mapel, u.nama AS nama_guru
            FROM jadwal_mengajar jm
            LEFT JOIN mapel m ON m.id = jm.mapel
            LEFT JOIN guru u ON u.id_guru = jm.guru
            WHERE jm.kelas = :kelas AND jm.hari = :hari
            ORDER BY jm.id_jadwal ASC";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':kelas' => $kelas,
        ':hari'  => $hari
    ]);

    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='{$data['id_jadwal']}'>{$data['kode_mapel']} - {$data['nama_guru']}</option>";
    }
}
?>
