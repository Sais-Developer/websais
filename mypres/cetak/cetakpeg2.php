<?php
ob_start();
error_reporting(E_ALL);

require("../../konek/koneksi.php"); // memakai $db = PDO
require("../../konek/function.php");

$bl = $_GET['bln'] ?? date('m');
$tahun = date('Y');

// --- AMBIL BULAN ---
$stmt2 = $db->prepare("SELECT * FROM bulan WHERE bln = ?");
$stmt2->execute([$bl]);
$bulane = $stmt2->fetch();
$stmt2->closeCursor();

$day = cal_days_in_month(CAL_GREGORIAN, $bl, $tahun);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Rekap Absen Pembina Eskul</title>
<style>
@page { 
    margin-top: 1cm; 
    margin-right: 1cm; 
    margin-bottom: 1cm; 
    margin-left: 1cm; 
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

<center><h4>REKAPITULASI ABSENSI PEMBINA EKSTRAKURIKULER</h4></center>
<br>

<table class="header-table">
    <tr>
        <td>Sekolah</td><td>:</td><td><?= $setting['sekolah'] ?></td>
        <td>Bulan</td><td>:</td><td><?= $bulane['ket'] ?> <?= $tahun ?></td>
    </tr>
    <tr>
        <td>Semester</td><td>:</td><td><?= $setting['semester'] ?></td>
        <td>Tahun Pelajaran</td><td>:</td><td><?= $setting['tp'] ?></td>
    </tr>
</table>

<br>
<?php
$bulan = $bl;
$tahun = date('Y');
$tanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
$sql = "
    SELECT 
        e.id AS id_eskul,
        e.eskul,
        u.id_guru,
        u.nama AS nama_guru,
        SUM(a.ket = 'H') AS hadir,
        SUM(a.ket = 'S') AS sakit,
        SUM(a.ket = 'I') AS izin,
        SUM(a.ket = 'A') AS alpha
    FROM m_eskul e
    LEFT JOIN guru u ON u.id_guru = e.guru
    LEFT JOIN absensi_les a 
        ON a.idpeg = e.guru
        AND a.bulan = ?
        AND a.tahun = ?
    GROUP BY e.id, e.eskul, u.id_guru, u.nama
    ORDER BY e.id ASC
";

$stmt = $db->prepare($sql);
$stmt->execute([$bulan, $tahun]);
$result = $stmt->fetchAll();
?>

<table width="100%">
<tr>
    <th width="2%">No</th>
    <th>Nama Pegawai</th>
    <th width="10%">Eskul</th>

    <?php for ($i = 1; $i <= $tanggal; $i++): ?>
        <?php $dayTxt = date("D", strtotime("$tahun-$bulan-$i")); ?>
        <th width="2%">
            <?= ($dayTxt == 'Sun') ? "<b style='color:red'>$i</b>" : $i ?>
        </th>
    <?php endfor; ?>

    <th width="2%">H</th><th width="2%">S</th><th width="2%">I</th><th width="2%">A</th>
</tr>

<?php
$no = 0;
foreach ($result as $row):
    $no++;
?>
<tr>
    <td class="text-center"><?= $no ?></td>
    <td>&nbsp;&nbsp;<?= ucwords(strtolower($row['nama_guru'] ?? '-')) ?></td>
    <td class="text-center"><?= ucwords(strtolower($row['eskul'])) ?></td>

    <?php
    for ($i = 1; $i <= $tanggal; $i++):
        $tgl = date('Y-m-d', mktime(0,0,0,$bulan,$i,$tahun));
        $hari = date("D", strtotime($tgl));
        $stmt2 = $db->prepare("SELECT ket FROM absensi_les WHERE idpeg = ? AND tanggal = ?");
        $stmt2->execute([$row['id_guru'], $tgl]);
        $cek = $stmt2->fetch();
    ?>
        <?php if ($cek): ?>
            <td class="text-center"><b><?= $cek['ket'] ?></b></td>
        <?php else: ?>
            <?php if ($hari == 'Sun'): ?>
                <td style="color:white;background:red" class="text-center">X</td>
            <?php else: ?>
                <td></td>
            <?php endif; ?>
        <?php endif; ?>

    <?php endfor; ?>

    <td class="text-center"><?= $row['hadir'] ?></td>
    <td class="text-center"><?= $row['sakit'] ?></td>
    <td class="text-center"><?= $row['izin'] ?></td>
    <td class="text-center"><?= $row['alpha'] ?></td>
</tr>
<?php endforeach; ?>
</table>
<br>
<table class="header-table">
<tr>
<td width="60%"></td>
<td>
<?= ucwords(strtolower($setting['kabupaten'])) ?>, <?= date('d') . " " . ($bulane['ket']) . " " . date('Y') ?><br>
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

$pdf = new Dompdf($options);
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'Landscape');
$pdf->render();
$pdf->stream("Absen_Pegawai_Bulan_".$bl.".pdf", ["Attachment" => false]);
exit;
?>
