<?php
require(__DIR__ . "/../konek/koneksi.php");

header('Content-Type: application/json; charset=utf-8');

$kartu  = $_GET['nokartu'] ?? '';
$result = ['status' => 'error', 'message' => 'Data tidak ditemukan'];

if ($kartu === '') {
    echo json_encode($result, JSON_PRETTY_PRINT);
    exit;
}

$bulan = date('m');
$tahun = date('Y');

/* ambil data registrasi */
$stmt = $pdo->prepare("SELECT * FROM datareg WHERE nokartu = :nokartu");
$stmt->execute([':nokartu' => $kartu]);
$datareg = $stmt->fetch(PDO::FETCH_ASSOC);

if ($datareg) {

    if ($datareg['level'] === 'siswa') {

        $ids = $datareg['idsiswa'];

        $stmt = $pdo->prepare("
            SELECT ket, COUNT(*) AS jumlah
            FROM absensi
            WHERE idsiswa = :idsiswa
              AND bulan = :bulan
              AND tahun = :tahun
            GROUP BY ket
        ");
        $stmt->execute([
            ':idsiswa' => $ids,
            ':bulan'   => $bulan,
            ':tahun'   => $tahun
        ]);

        $absensi = ['H'=>0, 'S'=>0, 'I'=>0, 'A'=>0];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $absensi[$row['ket']] = (int) $row['jumlah'];
        }

        $result = [
            'status'   => 'success',
            'level'    => 'siswa',
            'nama'     => $datareg['nama'],
            'absensi'  => $absensi
        ];

    } elseif ($datareg['level'] === 'pegawai') {

        $idpeg = $datareg['idpeg'];

        $stmt = $pdo->prepare("
            SELECT ket, COUNT(*) AS jumlah
            FROM absensi
            WHERE idpeg = :idpeg
              AND bulan = :bulan
              AND tahun = :tahun
            GROUP BY ket
        ");
        $stmt->execute([
            ':idpeg' => $idpeg,
            ':bulan' => $bulan,
            ':tahun' => $tahun
        ]);

        $absensi = ['H'=>0, 'S'=>0, 'I'=>0, 'A'=>0];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $absensi[$row['ket']] = (int) $row['jumlah'];
        }

        $result = [
            'status'   => 'success',
            'level'    => 'pegawai',
            'nama'     => $datareg['nama'],
            'absensi'  => $absensi
        ];
    }
}

echo json_encode($result, JSON_PRETTY_PRINT);
