<?php
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php"); // harus ada $pdo
require("../../konek/function.php");
require("../../konek/crud.php");
include "../../vendor/phpqrcode/qrlib.php";

$id_skl = 1;
$stmt = $pdo->prepare("SELECT * FROM skl WHERE id_skl = ?");
$stmt->execute([$id_skl]);
$skl = $stmt->fetch(PDO::FETCH_ASSOC);
$kuri = $skl['kuri'] ?? 1;

$ids = $_GET['ids'] ?? 0;
$siswa = fetch('siswa', ['id_siswa' => $ids]);

$bidang = fetch('m_kelas', ['kelas' => $siswa['kelas']]);
$pk = $bidang['pk'] ?? '';
$bk = $bidang['bk'] ?? '';
$kk = $bidang['kk'] ?? '';

$tempdir = "../../temp/";
if (!file_exists($tempdir)) mkdir($tempdir);
$codeContents = $ids . '-' . $siswa['nama'];
QRcode::png($codeContents, $tempdir . $siswa['id_siswa'] . '.png', QR_ECLEVEL_M, 4);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>SKL</title>
<style>
@page { margin: 1cm 2cm; }
body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #000; padding: 4px;font-size: 12px; }
th { background-color: #f0f0f0; }
.header-table td { border: none; text-align: left; padding: 2px; }
.text-center { text-align: center; }
.bold { font-weight:bold; }
</style>
</head>
<body>

<?php if(!empty($skl['header'])): ?>
<img src="<?= $baseurl ?>/images/<?= htmlspecialchars($skl['header']) ?>" style="max-width:670px;"><br>
<?php else: ?>
<table class="header-table">
<tr>
<td width='70'><img src="<?= $baseurl ?>/images/<?= htmlspecialchars($setting['logo']) ?>" width='70'></td>
<td style="text-align:center">
<strong><?= strtoupper($setting['header'] ?? '') ?><br>
<?= strtoupper($setting['sekolah'] ?? '') ?></strong><br>
<small>Alamat: <?= htmlspecialchars($setting['alamat'] ?? '') ?> Desa <?= htmlspecialchars($setting['desa'] ?? '') ?> Kecamatan <?= htmlspecialchars($setting['kecamatan'] ?? '') ?> Kabupaten <?= htmlspecialchars($setting['kabupaten'] ?? '') ?></small>
</td>
</tr>
</table>
<hr style="margin:1px;background-color:black;margin-top:-7px">
<hr style="margin:2px;background-color:black">
<?php endif; ?>

<br>
<center>
<h3 style="margin-top:-15px"><u><?= htmlspecialchars($skl['nama_surat']) ?></u></h3>
No. Surat : <?= htmlspecialchars($skl['no_surat']) ?>
</center>

<div style='width:100%;text-align:justify'>
<?= $skl['pembuka'] ?>
</div>

<table style="width:80%;margin:0 60px" class="header-table">
<tr><td style="width:200px">&nbsp;Nama</td><td>&nbsp;: <?= htmlspecialchars($siswa['nama']) ?></td></tr>
<tr><td>&nbsp;Tempat, Tgl Lahir</td><td>&nbsp;: <?= htmlspecialchars($siswa['t_lahir']) ?>, <?= htmlspecialchars($siswa['tgl_lahir']) ?></td></tr>
<tr><td>&nbsp;Nomor Induk Peserta Didik</td><td>&nbsp;: <?= htmlspecialchars($siswa['nis']) ?></td></tr>
<tr><td>&nbsp;Nomor Induk Siswa Nasional</td><td>&nbsp;: <?= htmlspecialchars($siswa['nisn']) ?></td></tr>

<?php if($setting['jenjang']=='SMK'): ?>
<tr><td>&nbsp;Bidang Keahlian</td><td>&nbsp;: <?= htmlspecialchars($bk) ?></td></tr>
<tr><td>&nbsp;Program Keahlian</td><td>&nbsp;: <?= htmlspecialchars($pk) ?></td></tr>
<tr><td>&nbsp;Kompetensi Keahlian</td><td>&nbsp;: <?= htmlspecialchars($kk) ?></td></tr>
<?php endif; ?>
</table>

<div style='width:100%;text-align:justify'>
<?= $skl['isi_surat'] ?>
</div>

<center>
<?php
if ($siswa['ket'] == 1) echo '<h3><b>LULUS</b></h3>';
elseif ($siswa['ket'] == 2) echo '<h3><b>LULUS BERSYARAT</b></h3>';
else echo '<h3><b>TIDAK LULUS</b></h3>';
?>
</center>

Dengan hasil sebagai berikut:<br><br>

<table style="width:90%;margin:0 30px">
<tr><td colspan="2" class="text-center">MATA PELAJARAN</td><td width="10%" class="text-center">NILAI</td></tr>

<?php
$stmt = $pdo->prepare("SELECT * FROM mapel_rapor mr
LEFT JOIN kode k ON k.id = mr.kelompok
WHERE mr.tingkat = ? AND mr.jurusan = ?
GROUP BY mr.kelompok
ORDER BY mr.kelompok");
$stmt->execute([$siswa['level'], $siswa['jurusan']]);
$kelompokData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$no = 0;
foreach($kelompokData as $data) {
    if(!empty($data['sub'])) echo "<tr><td colspan='3'>{$data['sub']}</td></tr>";
    echo "<tr><td colspan='3' class='bold'>&nbsp;{$data['ket']}</td></tr>";

    if($kuri == 2){
        $stmtNil = $pdo->prepare("
            SELECT mp.*, m.nama_mapel, AVG(n.nilai) AS nr
            FROM mapel_rapor mp
            LEFT JOIN mapel m ON m.id = mp.idmapel
            LEFT JOIN nilai_skl n ON n.mapel = mp.idmapel
            WHERE mp.tingkat = ? AND mp.jurusan = ? AND mp.kelompok = ? AND n.idsiswa = ?
            GROUP BY n.mapel
            ORDER BY mp.id ASC
        ");
    } else {
        $stmtNil = $pdo->prepare("
            SELECT mp.*, m.nama_mapel, AVG(CASE WHEN n.ki='KI3' THEN n.nilai END) AS nr
            FROM mapel_rapor mp
            LEFT JOIN mapel m ON m.id = mp.idmapel
            LEFT JOIN nilai_skl n ON n.mapel = mp.idmapel
            WHERE mp.tingkat = ? AND mp.jurusan = ? AND mp.kelompok = ? AND n.idsiswa = ?
            GROUP BY n.mapel
            ORDER BY mp.id ASC
        ");
    }
    $stmtNil->execute([$siswa['level'], $siswa['jurusan'], $data['kelompok'], $ids]);
    $nilaiData = $stmtNil->fetchAll(PDO::FETCH_ASSOC);

    foreach($nilaiData as $nilai){
        $no++;
        echo "<tr>
        <td class='text-center' style='vertical-align:middle;width:5%'>{$no}</td>
        <td style='vertical-align:middle'>{$nilai['nama_mapel']}</td>
        <td class='text-center'>".number_format($nilai['nr'],2)."</td>
        </tr>";
    }
}

if($kuri == 2){
    $stmtAvg = $pdo->prepare("
        SELECT AVG(n.nilai) AS rata_total
        FROM nilai_skl n
        LEFT JOIN mapel_rapor mp ON n.mapel = mp.idmapel
        WHERE n.idsiswa = ? AND mp.tingkat = ? AND mp.jurusan = ? AND n.ki IS NULL
    ");
}else{
    $stmtAvg = $pdo->prepare("
        SELECT AVG(n.nilai) AS rata_total
        FROM nilai_skl n
        LEFT JOIN mapel_rapor mp ON n.mapel = mp.idmapel
        WHERE n.idsiswa = ? AND mp.tingkat = ? AND mp.jurusan = ? AND n.ki='KI3'
    ");
}
$stmtAvg->execute([$ids, $siswa['level'], $siswa['jurusan']]);
$dataAvg = $stmtAvg->fetch(PDO::FETCH_ASSOC);
$rataTotal = number_format($dataAvg['rata_total'],2);

echo "<tr>
<td colspan='2' class='text-center bold'>RATA-RATA NILAI</td>
<td class='text-center bold'>{$rataTotal}</td>
</tr>";
?>
</table>

<br>
<div style='width:100%;text-align:justify'><?= $skl['penutup'] ?></div>

<table width="100%" class="header-table">
<tr>
<td style="text-align: center" width="33%">
<img src="<?= $baseurl ?>/temp/<?= $siswa['id_siswa'] ?>.png" width="120px">
</td>
<td style="text-align: center" width="33%">
<br>
<?php if(!empty($siswa['foto'])): ?>
<img src="<?= $baseurl ?>/images/fotosiswa/<?= htmlspecialchars($siswa['foto']) ?>" width="90px">
<?php else: ?>
<img src="<?= $baseurl ?>/images/polos.png" width="90px">
<?php endif; ?>
</td>
<td style="text-align: left">
<?= htmlspecialchars($setting['kecamatan']) ?>, <?= htmlspecialchars($skl['tgl_surat']) ?><br>
Kepala Sekolah,<br><br><br><br><br><br>
<b><u><?= htmlspecialchars($setting['kepsek']) ?></u></b><br>
NIP. <?= htmlspecialchars($setting['nip']) ?><br>
<?php if($skl['sttd']==1): ?>
<img style="z-index:800;position:absolute;margin-top:-74px;margin-left:30px" src="<?= $baseurl ?>/images/<?= htmlspecialchars($skl['ttd']) ?>" width="160">
<?php endif; ?>
<?php if($skl['sstp']==1): ?>
<img style="z-index:900;position:relative;margin-top:-130px;margin-left:-15px;opacity:0.7" src="<?= $baseurl ?>/images/<?= htmlspecialchars($skl['stempel']) ?>" width="140px">
<?php endif; ?>
</td>
</tr>
</table>

</body>
</html>

<?php
$html = ob_get_clean();
require_once __DIR__ . '/../../dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('Folio', 'portrait');
$dompdf->render();
$dompdf->stream("SKL_" . preg_replace("/[^a-zA-Z0-9]/","",$siswa['nama']) . ".pdf", ["Attachment"=>false]);
exit(0);
?>
