<?php
require("../../konek/koneksi.php");

$semester = $setting['semester'];
$tapel    = $setting['tp'];

$idsiswa  = $_POST['ids']     ?? '';
$nis  = $_POST['nis']     ?? '';
$catatan  = $_POST['catatan'] ?? '';
$ket      = $_POST['ket']     ?? '';

if (!empty($idsiswa)) {

    $sql = "
        INSERT INTO catatan_rapor (idsiswa, nis, tapel, semester, catatan, ket)
        VALUES (:idsiswa, :nis, :tapel, :semester, :catatan, :ket)
        ON DUPLICATE KEY UPDATE
            catatan = VALUES(catatan),
            ket     = VALUES(ket)
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':idsiswa'  => $idsiswa,
		':nis'  => $nis,
        ':tapel'    => $tapel,
        ':semester' => $semester,
        ':catatan'  => $catatan,
        ':ket'      => $ket
    ]);

} else {
    echo "ID siswa tidak boleh kosong.";
}
?>
