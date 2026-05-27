<?php
require("../../konek/koneksi.php");

$idsiswa  = $_POST['ids'] ?? '';
$nis  = $_POST['nis'] ?? '';
$eskul    = $_POST['eskul'] ?? '';
$semester = $setting['semester'];
$tapel    = $setting['tp'];
$nilai    = $_POST['nilai'] ?? '';
$ket      = $_POST['ket'] ?? '';

switch ($nilai) {
    case 'A':
        $deskrip = 'sangat baik dalam menunjukkan antusiasme tinggi dan tanggung jawab dalam mengikuti kegiatan ekstrakurikuler. Aktif berpartisipasi, bekerja sama dengan baik, serta mampu menampilkan sikap disiplin, kemandirian, dan kepemimpinan.';
        break;
    case 'B':
        $deskrip = 'baik dalam berpartisipasi aktif dalam kegiatan ekstrakurikuler. Menunjukkan sikap tanggung jawab, kerja sama, dan semangat untuk mengembangkan kemampuan diri sesuai bidang yang diikuti';
        break;
    case 'C':
        $deskrip = 'cukup dalam mengikuti kegiatan ekstrakurikuler dengan semangat yang baik, namun masih perlu meningkatkan konsistensi kehadiran dan keterlibatan agar potensi dirinya dapat berkembang lebih optimal';
        break;
    case 'D':
        $deskrip = 'telah berusaha mengikuti kegiatan ekstrakurikuler, namun perlu meningkatkan kedisiplinan, tanggung jawab, dan partisipasi aktif dalam kegiatan agar tujuan pembinaan dapat tercapai dengan lebih baik';
        break;
    default:
        $deskrip = '';
        break;
}

try {
    
    $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM peskul WHERE idsiswa = :idsiswa AND eskul = :eskul AND ket = :ket AND semester = :semester AND tapel = :tapel");
    $check_stmt->execute([
        ':idsiswa' => $idsiswa,
        ':eskul'   => $eskul,
        ':ket'     => $ket,
        ':semester'=> $semester,
        ':tapel'   => $tapel
    ]);
    $count = $check_stmt->fetchColumn();

    if ($count > 0) {
        echo "SD"; 
    } else {
       
        $insert_stmt = $pdo->prepare("
            INSERT INTO peskul (idsiswa, nis, eskul, semester, tapel, nilai, ket, deskripsi) 
            VALUES (:idsiswa, :nis, :eskul, :semester, :tapel, :nilai, :ket, :deskrip)
        ");
        $insert_stmt->execute([
            ':idsiswa' => $idsiswa,
			 ':nis' => $nis,
            ':eskul'   => $eskul,
            ':semester'=> $semester,
            ':tapel'   => $tapel,
            ':nilai'   => $nilai,
            ':ket'     => $ket,
            ':deskrip' => $deskrip
        ]);

        echo "OK";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
