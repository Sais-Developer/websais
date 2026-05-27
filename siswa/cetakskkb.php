<?php
ob_start();
error_reporting(E_ALL);
require("../konek/koneksi.php"); 
require("../konek/function.php");
require("../konek/crud.php");

$ids = $_GET['ids'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM siswa WHERE id_siswa = ?");
$stmt->execute([$ids]);
$siswa = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$siswa) {
    die("Data siswa tidak ditemukan.");
}

$jkel = ($siswa['jk'] == 'L') ? 'Laki-laki' : 'Perempuan';

$skl_stmt = $pdo->prepare("SELECT * FROM skl WHERE id_skl = 1");
$skl_stmt->execute();
$skl = $skl_stmt->fetch(PDO::FETCH_ASSOC);

$skb_stmt = $pdo->prepare("SELECT * FROM skkb WHERE id = 1");
$skb_stmt->execute();
$skb = $skb_stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>SKL</title>
<style>
@page { margin: 1cm 2cm; }
body { font-family: Arial, sans-serif; font-size: 14px; margin: 0; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #000; padding: 4px; font-size: 14px; }
th { background-color: #f0f0f0; }
.header-table td { border: none; text-align: left; padding: 2px; }
.text-center { text-align: center; }
.bold { font-weight: bold; }
</style>
</head>
<body>

<?php if(!empty($skl['header'])): ?>
<img src="<?= $baseurl ?>/images/<?= $skl['header'] ?>" style="max-width:670px;">
<br>
<?php else: ?>
<table class="header-table">
<tr>
<td width='70px'><img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" width='70px'></td>
<td style="text-align:center">
<strong><?= strtoupper($setting['header'] ?? '') ?><br>
<?= strtoupper($setting['sekolah'] ?? '') ?></strong><br>
<small>Alamat: <?= $setting['alamat'] ?? '' ?> Desa <?= $setting['desa'] ?? '' ?> Kecamatan <?= $setting['kecamatan'] ?? '' ?> Kabupaten <?= $setting['kabupaten'] ?? '' ?></small>
</td>
</tr>
</table>
<hr style="margin:1px;background-color:black;margin-top:-7px">
<hr style="margin:2px;background-color:black">
<br>
<?php endif; ?>

<center>
<h4><u>SURAT KETERANGAN KELAKUAN BAIK</u></h4>
No. Surat : <?= $skb['nosurat'] ?>
</center>
<br><br>

<div style="padding-left:10px;margin-right:0px;">
<p>Yang bertanda tangan dibawah ini :</p>
</div>

<table style="margin-left:50px;margin-right:10px;" class="header-table">
<tr>
<td width="130px">Nama</td>
<td width="10px">:</td>
<td><?= $setting['kepsek'] ?></td>
</tr>
<tr>
<td>NIP</td>
<td>:</td>
<td><?= $setting['nip'] ?></td>
</tr>
<tr>
<td>Jabatan</td>
<td>:</td>
<td>Kepala <?= $setting['sekolah'] ?></td>
</tr>
</table>
<br/>

<div style="padding-left:10px;margin-right:0px;">
<p>Menerangkan bahwa :</p>
</div>

<table style="margin-left:50px;margin-right:80px" class="header-table">
<tr>
<td width="130px">Nama</td>
<td width="10px">:</td>
<td><?= $siswa['nama'] ?></td>
</tr>
<tr>
<td>NIS / NISN</td>
<td>:</td>
<td><?= $siswa['nis'] ?> / <?= $siswa['nisn'] ?></td>
</tr>
<tr>
<td>Tempat, Tgl Lahir</td>
<td>:</td>
<td><?= $siswa['t_lahir'] ?>, <?= $siswa['tgl_lahir'] ?></td>
</tr>
<tr>
<td>Jenis Kelamin</td>
<td>:</td>
<td><?= $jkel ?></td>
</tr>
<tr>
<td>Agama</td>
<td>:</td>
<td><?= $siswa['agama'] ?></td>
</tr>
<tr>
<td>Alamat</td>
<td>:</td>
<td><?= $siswa['alamat'] ?></td>
</tr>
<tr>
<td>Desa/Kelurahan</td>
<td>:</td>
<td><?= $siswa['desa'] ?></td>
</tr>
<tr>
<td>Kecamatan</td>
<td>:</td>
<td><?= $siswa['kecamatan'] ?></td>
</tr>
<tr>
<td>Kabupaten</td>
<td>:</td>
<td><?= $siswa['kabupaten'] ?></td>
</tr>
</table>
<br>

<table style="margin-left: 10px;margin-right:0px" class="header-table">
<tr>
<td style="text-align:justify" width="100%"><?= $skb['isi'] ?> </td>
</tr>
<tr>
<td style="text-align:justify" width="100%"><?= $skb['foter'] ?> </td>
</tr>
</table>
<br>

<table style="margin-left: 50px;0" class="header-table">
<tr>
<td width='250px'><br/><br/><br/><br/><br/><br/></td>
<td width='150px'></td>
<td>
<?= $setting['kecamatan'] ?>, <?= date('d') ?> <?= bulan_indo($tanggal) ?> <?= date('Y') ?><br/>
Yang Membuat Pernyataan<br/><br/><br/><br/><u><?= $setting['kepsek'] ?></u><br/>
NIP. <?= $setting['nip'] ?>
</td>
</tr>
</table>

</body>
</html>

<?php
$html = ob_get_clean();

require_once __DIR__ . '/../dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('Folio', 'portrait');
$dompdf->render();
$dompdf->stream("SKKB_" . preg_replace("/[^a-zA-Z0-9]/", "", $siswa['nama']) . ".pdf", ["Attachment" => false]);
exit(0);
?>
