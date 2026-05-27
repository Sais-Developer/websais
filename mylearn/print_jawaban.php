<?php
require("../konek/koneksi.php"); 

$id_tugas = $_GET['id'] ?? 0;

$query = "SELECT t.*, g.nama AS guru_nama, g.nip, p.nama_mapel 
          FROM tugas t
          LEFT JOIN guru g ON g.id_guru = t.guru
          LEFT JOIN mapel p ON p.id = t.mapel
          WHERE t.id_tugas = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id_tugas]);
$tugas = $stmt->fetch(PDO::FETCH_ASSOC);

$que = "SELECT j.*, s.nis, s.nama AS siswa_nama, s.kelas 
        FROM jawaban_tugas j
        LEFT JOIN siswa s ON s.id_siswa = j.id_siswa
        WHERE j.id_tugas = ?";
$stmt2 = $pdo->prepare($que);
$stmt2->execute([$id_tugas]);
$jawaban_list = $stmt2->fetchAll(PDO::FETCH_ASSOC);

$bulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$bulane = $bulan[intval(date('m'))];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Nilai Tugas</title>
    <style>
	@page { 
		margin-top: 1cm; 
		margin-right: 2cm; 
		margin-bottom: 1cm; 
		margin-left: 2cm; 
		}
	 body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background-color: #f0f0f0; }
        .header-table td { border: none; text-align: left; padding: 2px; }
        .text-center { text-align: center; }
		</style>
</head>
<body>
     <table class="header-table">
        <tr>
            <td width='70'><img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" width='70'></td>
            <td style="text-align:center">
                <strong><?= strtoupper($setting['header'] ?? '') ?><br>
                <?= strtoupper($setting['sekolah'] ?? '') ?></strong><br>
                <small>Alamat: <?= ($setting['alamat'] ?? '') ?> Desa <?= ($setting['desa'] ?? '') ?> Kecamatan <?= ($setting['kecamatan'] ?? '') ?> Kabupaten <?= ($setting['kabupaten'] ?? '') ?></small>
            </td>
        </tr>
    </table>
    <hr>

    <div align='center' style="margin-top:5px">
        <h6>LAPORAN TUGAS TERSTRUKTUR<br/>
        MATA PELAJARAN <?= strtoupper($tugas['nama_mapel']) ?><br/>
        SEMESTER <?= $setting['semester'] ?>  TAHUN AJARAN  <?= $setting['tp'] ?></h6>
    </div>

    <table  style="font-size: 12px">
        <thead>
            <tr>
                <th width='5%'>No</th>
                <th width="25%">NIS</th>
                <th>Nama</th>
                <th width="10%">Kelas</th>
                <th width="15%">Nilai</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $no = 1;
        foreach($jawaban_list as $jtugas): ?>
            <tr>
                <td align='center'><?= $no ?></td>
                <td align='center'><?= htmlspecialchars($jtugas['nis']) ?></td>
                <td><?= htmlspecialchars($jtugas['siswa_nama']) ?></td>
                <td><?= htmlspecialchars($jtugas['kelas']) ?></td>
                <td><?= htmlspecialchars($jtugas['nilai']) ?></td>
            </tr>
        <?php 
        $no++;
        endforeach; ?>
        </tbody>
    </table>

    <br/>
    <table class="header-table"' style="margin-left:50px; margin-right:5px;">
        <tr>
            <td>
                Mengetahui, <br/>
                Kepala Sekolah <br/><br/><br/><br/>
                <u><?= htmlspecialchars($setting['kepsek']) ?></u><br/>
                NIP. <?= htmlspecialchars($setting['nip']) ?>
            </td>
            <td width='300px'></td>
            <td>
                <?= htmlspecialchars($setting['kecamatan']) ?>, <?= date('d') ?> <?= $bulane ?> <?= date('Y') ?><br/>
                Guru Pengampu<br/><br/><br/><br/>
                <u><?= htmlspecialchars($tugas['guru_nama']) ?></u><br/>
                NIP. <?= htmlspecialchars($tugas['nip']) ?>
            </td>
        </tr>
    </table>
</body>
</html>
