<?php
ob_start();
error_reporting(E_ALL);
require("../../konek/koneksi.php"); 
require("../../konek/function.php");


$bl    = $_GET['bln'] ?? date('m');
$tahun = date('Y');

/* -------------------------------------
   GET DATA BULAN
--------------------------------------*/
$stmt2 = $pdo->prepare("SELECT * FROM bulan WHERE bln = ?");
$stmt2->execute([$bl]);
$bulane = $stmt2->fetch();

/* Hitung jumlah hari */
$dayCount = cal_days_in_month(CAL_GREGORIAN, $bl, $tahun);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absen Pegawai</title>
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
<center><h4>REKAPITULASI ABSENSI PEGAWAI</h4></center>
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

<table>
<tr>
<th width="2%">No</th>
<th>Nama Pegawai</th>
<th width="8%" class="text-center">Jabatan</th>
<?php
for ($i = 1; $i <= $dayCount; $i++):
    $dayName = date("D", strtotime("$tahun-$bl-$i"));
?>
    <th width="2%"><?= $dayName == 'Sun' ? "<b style='color:red'>$i</b>" : $i ?></th>
<?php endfor; ?>
<th width="1%">H</th>
<th width="1%">S</th>
<th width="1%">I</th>
<th width="1%">A</th>
</tr>

<?php
/* -------------------------------------
   GET LIST PEGAWAI + TOTAL H S I A
--------------------------------------*/
$stmt = $pdo->prepare("
    SELECT 
        g.id_guru,
        g.nama,
        g.jabatan,
        SUM(CASE WHEN a.ket='H' THEN 1 ELSE 0 END) AS hadir,
        SUM(CASE WHEN a.ket='S' THEN 1 ELSE 0 END) AS sakit,
        SUM(CASE WHEN a.ket='I' THEN 1 ELSE 0 END) AS izin,
        SUM(CASE WHEN a.ket='A' THEN 1 ELSE 0 END) AS alpha
    FROM guru g
    LEFT JOIN absensi a 
        ON g.id_guru = a.idpeg 
        AND a.bulan = ?
        AND a.tahun = ?
    GROUP BY g.id_guru
    ORDER BY g.nama ASC
");

$stmt->execute([$bl, $tahun]);
$peglist = $stmt->fetchAll();

$no = 0;
foreach ($peglist as $peg):
    $no++;
?>
<tr>
    <td class="text-center"><?= $no ?></td>
    <td><?= ucwords(strtolower($peg['nama'])) ?></td>
    <td><?= ucwords(strtolower($peg['jabatan'])) ?></td>

    <?php 
    /* -------------------------------------
       LOOP ABSENSI HARIAN
    --------------------------------------*/
    for ($i = 1; $i <= $dayCount; $i++):
        $tanggalbaru = date('Y-m-d', strtotime("$tahun-$bl-$i"));
        $dayName2 = date("D", strtotime($tanggalbaru));

        $stmt2 = $pdo->prepare("SELECT ket FROM absensi WHERE tanggal = ? AND idpeg = ? LIMIT 1");
        $stmt2->execute([$tanggalbaru, $peg['id_guru']]);
        $cekabsen = $stmt2->fetch();
    ?>
        <td class="text-center" 
            <?= !$cekabsen && $dayName2 == 'Sun' ? "style='color:white;background-color:red'" : "" ?>>
            <?= $cekabsen['ket'] ?? ($dayName2 == 'Sun' ? 'X' : '') ?>
        </td>
    <?php endfor; ?>

    <td class="text-center"><?= $peg['hadir'] ?></td>
    <td class="text-center"><?= $peg['sakit'] ?></td>
    <td class="text-center"><?= $peg['izin'] ?></td>
    <td class="text-center"><?= $peg['alpha'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<br>

<table class="header-table">
<tr>
<td width="5%"></td>
<td></td>
<td><br><br><br><br></td>
<td width="40%"></td>
<td width="5%"></td>
<td>
<?= ucwords(strtolower($setting['kabupaten'])) ?>, <?= date('d') ?> <?= $bulane['ket'] ?> <?= date('Y') ?><br>
Kepala Sekolah
<br><br><br><br>
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
$dompdf->setPaper('A4', 'Landscape');
$dompdf->render();
$dompdf->stream("Absen_Pegawai_Bulan_".$bl.".pdf", ["Attachment" => false]);
exit;
?>
