<?php
require("../konek/koneksi.php"); 

$kartu = $_GET['nokartu'] ?? '';
$bulan = date('m');  
$tahun = date('Y');

$stmt = $pdo->prepare("SELECT * FROM datareg WHERE nokartu = :nokartu LIMIT 1");
$stmt->execute([':nokartu' => $kartu]);
$datareg = $stmt->fetch(PDO::FETCH_ASSOC);

if ($datareg) {

    if ($datareg['level'] == 'siswa') {
       
        $stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = :id_siswa LIMIT 1");
        $stmt->execute([':id_siswa' => $datareg['idsiswa']]);
        $siswa = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$siswa) {
            echo "GAGAL";
        } else {
           
            $stmt = $pdo->prepare("SELECT ket, COUNT(*) as jumlah 
                                   FROM absensi 
                                   WHERE idsiswa = :id_siswa AND bulan = :bulan AND tahun = :tahun 
                                   GROUP BY ket");
            $stmt->execute([
                ':id_siswa' => $siswa['id_siswa'],
                ':bulan'    => $bulan,
                ':tahun'    => $tahun
            ]);

            $absensi = ['H'=>0, 'S'=>0, 'I'=>0, 'A'=>0];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $absensi[$row['ket']] = $row['jumlah'];
            }

            echo "H:{$absensi['H']} S:{$absensi['S']} I:{$absensi['I']} A:{$absensi['A']}";
        }
    }

    if ($datareg['level'] == 'pegawai') {
       
        $stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = :id_guru LIMIT 1");
        $stmt->execute([':id_guru' => $datareg['idpeg']]);
        $peg = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$peg) {
            echo "GAGAL";
        } else {
           
            $stmt = $pdo->prepare("SELECT ket, COUNT(*) as jumlah 
                                   FROM absensi 
                                   WHERE idpeg = :id_peg AND bulan = :bulan AND tahun = :tahun 
                                   GROUP BY ket");
            $stmt->execute([
                ':id_peg' => $peg['id_guru'],
                ':bulan'  => $bulan,
                ':tahun'  => $tahun
            ]);

            $absensi = ['H'=>0, 'S'=>0, 'I'=>0, 'A'=>0];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $absensi[$row['ket']] = $row['jumlah'];
            }

            echo "H:{$absensi['H']} S:{$absensi['S']} I:{$absensi['I']} A:{$absensi['A']}";
        }
    }

} else {
    echo "GAGAL";
}

$pdo = null;
?>
