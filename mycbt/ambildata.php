<?php
require("../konek/koneksi.php"); 

$pg = $_GET['pg'] ?? '';

if ($pg === 'jurusan') {
    $level = $_POST['level'] ?? '';
    $stmt = $pdo->prepare("SELECT jurusan FROM m_kelas WHERE level = :level GROUP BY jurusan");
    $stmt->bindParam(':level', $level, PDO::PARAM_STR);
    $stmt->execute();

    echo "<option value=''>Pilih Jurusan</option>";
    echo "<option value='semua'>semua</option>";
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $data) {
        $jurusan = htmlspecialchars($data['jurusan']);
        echo "<option value='{$jurusan}'>{$jurusan}</option>";
    }
}
?>
