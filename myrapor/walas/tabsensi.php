<?php
require("../../konek/koneksi.php");

$semester = $setting['semester'];
$tapel    = $setting['tp'];

$idsiswa  = $_POST['ids']   ?? '';
$nis  = $_POST['nis']   ?? '';
$sakit    = $_POST['sakit'] ?? 0;
$izin     = $_POST['izin']  ?? 0;
$alpha    = $_POST['alpha'] ?? 0;
$ket      = $_POST['ket'] ?? '';

if (!empty($idsiswa)) {

    $sql = "
        INSERT INTO absen_rapor (idsiswa, nis, tapel, semester, sakit, izin, alpha, ket)
        VALUES (:idsiswa, :nis, :tapel, :semester, :sakit, :izin, :alpha, :ket)
        ON DUPLICATE KEY UPDATE
            sakit = VALUES(sakit),
            izin = VALUES(izin),
            alpha = VALUES(alpha),
            ket = VALUES(ket)
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':idsiswa' => $idsiswa,
		':nis' => $nis,
        ':tapel'   => $tapel,
        ':semester'=> $semester,
        ':sakit'   => $sakit,
        ':izin'    => $izin,
        ':alpha'   => $alpha,
        ':ket'     => $ket
    ]);

} else {
    echo "ID siswa tidak boleh kosong.";
}
?>
