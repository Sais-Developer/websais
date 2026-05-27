<?php
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php");
require("../../konek/function.php");

$tanggal = date('Y-m-d');
$level   = $_GET['tkt'] ?? '';
$kelas   = $_GET['kls'] ?? '';

$stmtMapel = $pdo->prepare("
    SELECT b.id_bank, m.kode 
    FROM banksoal b 
    LEFT JOIN mapel m ON m.id = b.idmapel
    WHERE b.tingkat = :level
    ORDER BY m.kode ASC
");
$stmtMapel->execute(['level' => $level]);
$mapelList = $stmtMapel->fetchAll(PDO::FETCH_ASSOC);

$stmtSiswa = $pdo->prepare("SELECT id_siswa, nama FROM siswa WHERE kelas = :kelas ORDER BY nama ASC");
$stmtSiswa->execute(['kelas' => $kelas]);
$siswaList = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);

$nilaiList = [];
if ($mapelList && $siswaList) {
    $mapelIds = array_column($mapelList, 'id_bank');
    $placeholders = implode(',', array_fill(0, count($mapelIds), '?'));
    $stmtNilai = $pdo->prepare("
        SELECT id_siswa, id_bank, nilai 
        FROM nilai 
        WHERE id_bank IN ($placeholders)
    ");
    $stmtNilai->execute($mapelIds);
    foreach ($stmtNilai->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $nilaiList[$row['id_siswa']][$row['id_bank']] = $row['nilai'];
    }
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Nilai Kelas <?= htmlspecialchars($kelas) ?></title>
<style>
@page { margin: 1cm 1cm 1cm 2cm; }
body { font-family: Arial,sans-serif; font-size:13px; margin:0; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #000; padding:4px; }
th { background-color: #f0f0f0; }
.header-table td { border:none; padding:2px; }
.text-center { text-align:center; }
</style>
</head>
<body>
<div>
<table class="header-table">
<tr>
    <td width="70px">
        <?php if(!empty($baseurl) && !empty($setting['logo'])): ?>
        <img src="<?= htmlspecialchars($baseurl.'/images/'.$setting['logo']) ?>" width="70px" alt="Logo">
        <?php endif; ?>
    </td>
    <td style="text-align:center;">
        <strong><?= strtoupper($setting['header'] ?? '') ?><br><?= strtoupper($setting['sekolah'] ?? '') ?></strong><br>
        <small>Alamat: <?= $setting['alamat'] ?? '' ?> Desa <?= $setting['desa'] ?? '' ?> 
        Kecamatan <?= $setting['kecamatan'] ?? '' ?> Kabupaten <?= $setting['kabupaten'] ?? '' ?></small>
    </td>
</tr>
</table>
<hr>
<center><h4>REKAPITULASI NILAI ASESMEN</h4></center>
<br>

<table class="header-table">
<tr>
    <td width='100px'>Mata Pelajaran</td>
    <td width='10px'>:</td>
    <td>Semua Mapel</td>
    <td width='20px'></td>
    <td width='150px'>Semester</td>
    <td width='10px'>:</td>
    <td><?= $setting['semester'] ?? '' ?></td>
</tr>
<tr>
    <td>Asesmen</td>
    <td>:</td>
    <td><?= $setting['jenis_ujian'] ?? '' ?></td>
    <td></td>
    <td>Tahun Pelajaran</td>
    <td>:</td>
    <td><?= $setting['tp'] ?? '' ?></td>
</tr>
</table>
<br>

<table>
<tr>
<th width="3%">NO</th>
<th>NAMA SISWA</th>
<?php foreach($mapelList as $mapel): ?>
    <th width="5%"><?= htmlspecialchars($mapel['kode']) ?></th>
<?php endforeach; ?>
</tr>

<?php $no=0; foreach($siswaList as $siswa): $no++; ?>
<tr>
<td class="text-center"><?= $no ?></td>
<td><?= htmlspecialchars($siswa['nama']) ?></td>
<?php foreach($mapelList as $mapel): ?>
    <td class="text-center">
        <?= number_format($nilaiList[$siswa['id_siswa']][$mapel['id_bank']] ?? 0, 2, '.', '') ?>
    </td>
<?php endforeach; ?>
</tr>
<?php endforeach; ?>
</table>
<br>

<table class="header-table">
<tr>
    <td width="5%"></td>
    <td width='50px'></td>
    <td><br><br><br><br></td>
    <td width='30%'></td>
    <td width="5%"></td>
    <td>
        <?= $setting['kabupaten'] ?? '' ?>, <?= date('d') ?> <?= bulan_indo($tanggal) ?> <?= date('Y') ?><br/>
        Kepala Sekolah<br><br><br><br>
        <u><?= $setting['kepsek'] ?? '' ?></u><br/>
        NIP. <?= $setting['nip'] ?? '' ?>
    </td>
</tr>
</table>
</div>
</body>
</html>

<?php
$html = ob_get_clean();
require_once __DIR__ . '/../../dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'Landscape');

try {
    $dompdf->render();
    $dompdf->stream("Rekap_Nilai_Kelas_".$kelas.".pdf", ["Attachment"=>false]);
} catch (\Exception $e) {
    echo "Terjadi kesalahan saat generate PDF: ".$e->getMessage();
}
exit;
?>
