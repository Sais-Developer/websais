<?php
require("../../konek/koneksi.php"); 

$kelas = $_POST['kelas'] ?? '';
if($kelas != '') {
    $stmt = $pdo->prepare("UPDATE siswa SET ket = NULL WHERE kelas = :kelas");
    $stmt->execute([':kelas' => $kelas]);

    echo "Data berhasil diupdate.";
} else {
    echo "Kelas tidak boleh kosong.";
}
?>
