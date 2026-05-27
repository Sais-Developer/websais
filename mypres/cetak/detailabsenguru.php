<?php 
ob_start();
error_reporting(E_ALL);

require("../../konek/koneksi.php"); // sudah menggunakan $pdo
require("../../konek/function.php");

$ids = $_GET['idg'] ?? '';
$bl  = $_GET['bln'] ?? '';

// --- Ambil Data Bulan ---
$stmt = $pdo->prepare("SELECT * FROM bulan WHERE bln = ?");
$stmt->execute([$bl]);
$bulane = $stmt->fetch();

// --- Ambil Data Guru ---
$stmt = $pdo->prepare("SELECT * FROM guru WHERE id_guru = ?");
$stmt->execute([$ids]);
$user = $stmt->fetch();

// Hitung jumlah hari dalam bulan
$day = cal_days_in_month(CAL_GREGORIAN, $bl, $tahun);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Detail Absen Pegawai</title>
<style>
@page { 
    margin-top: 1cm; 
    margin-right: 1cm; 
    margin-bottom: 1cm; 
    margin-left: 2cm; 
}
body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; }
table { border-collapse: collapse; width: 100%; }
th, td { border: 1px solid #000; padding: 4px; }
th { background-color: #f0f0f0; }
.header-table {
    width: 100%;
    border-collapse: collapse;
}
.header-table td {
    border: none;
    vertical-align: middle;
}
.header-table h3 {
    margin: 0;
    line-height: 1.2;
    font-size: 18px; 
    text-transform: uppercase;
}
.header-table p {
    margin: 2px 0 0 0;
    font-size: 12px;
    line-height: 1.3;
}
.double-hr {
    border: none;
    border-top: 1px solid #000; 
    margin: 5px 0 0 0;
    position: relative;
}
.double-hr::after {
    content: "";
    display: block;
    border-top: 1px solid #000; 
    margin-top: 2px;
}
.text-center { text-align: center; }
strong { font-size: 18px; }
</style>

</head>
<body>
 <table class="header-table">
    <tr>
        <td width="70">
            <img src="<?= $baseurl ?>/images/<?= $setting['logo'] ?>" width="70" alt="Logo">
        </td>
        <td class="text-center">
            <h3>
                <?= $setting['header'] ?? '' ?><br>
                <?= $setting['sekolah'] ?? '' ?>
            </h3>
            <p>
                Alamat: <?= $setting['alamat'] ?? '' ?> Desa <?= $setting['desa'] ?? '' ?> 
                Kecamatan <?= $setting['kecamatan'] ?? '' ?> Kabupaten <?= $setting['kabupaten'] ?? '' ?>
            </p>
        </td>
    </tr>
</table>

<hr class="double-hr">
<center><h4>RINCIAN ABSENSI PEGAWAI</h4></center><br>

<table class="header-table">
<tr>
	<td width="100px">Nama</td><td>:</td><td><?= $user['nama'] ?></td>
	<td width="100px"></td>
	<td width="150px">Bulan</td><td>:</td><td><?= $bulane['ket'] ?> <?= date('Y') ?></td>
</tr>

<tr>
	<td>Semester</td><td>:</td><td><?= $setting['semester'] ?></td>
	<td></td>
	<td>Tahun Pelajaran</td><td>:</td><td><?= $setting['tp'] ?></td>
</tr>
</table>

<br>
<table>
<tr height="40px">
	<th>No</th>
	<th>Tanggal</th>
	<th colspan="2">Jam Absen</th>
	<th>Kehadiran</th>
	<th>Keterangan</th>
	<th>Paraf</th>
</tr>

<?php
$bulan = $bl;
$tahun = date('Y');
$jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
$no = 1;

for ($i = 1; $i <= $jumlahHari; $i++): 

	$tgl = date('Y-m-d', mktime(0,0,0,$bulan,$i,$tahun));
	$hari = date("D", strtotime($tgl));

	// Ambil absen hari itu
	$stmt = $pdo->prepare("SELECT * FROM absensi WHERE tanggal = ? AND idpeg = ?");
	$stmt->execute([$tgl, $ids]);
	$absen = $stmt->fetch();
?>
<tr>
	<td align="center"><?= $no++ ?></td>
	<td align="center">
		<?php if($hari=='Sun'): ?>
			<b style="color:red"><?= $tgl ?></b>
		<?php else: ?>
			<?= $tgl ?>
		<?php endif; ?>
	</td>

	<?php if ($absen): ?>
		<td align="center">Masuk <?= $absen['masuk'] ?></td>
		<td align="center">Pulang <?= $absen['pulang'] ?></td>
		<td align="center"><?= $absen['ket'] ?></td>
		<td><?= $absen['keterangan'] ?></td>
		<td></td>
	<?php else: ?>
		<td></td><td></td>
		<td align="center" style="color:red"></td>
		<td></td><td></td>
	<?php endif; ?>

</tr>
<?php endfor; ?>
</table>
<br>
<table class="header-table">
<tr>
	<td width="60%"></td>
	<td>
		<?= $setting['kabupaten'] ?>, <?= $day ?> <?= $bulane['ket'] ?> <?= date('Y') ?><br>
		Kepala Sekolah<br><br><br><br>
		<u><?= $setting['kepsek'] ?></u><br>
		NIP. <?= $setting['nip'] ?>
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
$dompdf->setPaper('A4', 'Portrait');
$dompdf->render();
$dompdf->stream("Absen_Pegawai_Bulan_".$bl.".pdf", ["Attachment" => false]);
exit;
?>
